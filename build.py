#!/usr/bin/env python3
"""Build firmware.bin for the Luxul XBR-4400 from an uncompressed squashfs-root.

Produces a raw TRX image (HDR0 header + kernel + squashfs) suitable for
flashing via CFE:  flash -noheader 192.168.1.100:firmware.bin flash0.trx

Note: the TRX checksum is the RAW CRC32 (no final XOR) of trx[12:len].
This is what the router's otrx/CFE expects; a plain zlib.crc32() will make
the updater reject the image.
"""

import hashlib
import os
import struct
import subprocess
import sys
import zlib

ROOT = os.path.dirname(os.path.abspath(__file__))
SQUASHFS_DIR = os.path.join(ROOT, "squashfs-root")
KERNEL_BIN = os.path.join(ROOT, "kernel.bin")
WORK_DIR = os.path.join(ROOT, "build")
ROOTFS_SQUASHFS = os.path.join(WORK_DIR, "rootfs.squashfs")
OUTPUT = os.path.join(ROOT, "firmware.bin")
MTIMES_FILE = os.path.join(ROOT, "mtimes.tsv")

MKSQUASHFS_OPTS = [
    "-comp", "xz", "-b", "262144", "-no-xattrs", "-noappend", "-all-root",
    "-mkfs-time", "1786544698",
]

REQUIRED_DIRS = [
    "dev", "mnt", "overlay", "proc", "sys", "tmp",
    "etc/crontabs", "lib/firmware", "usr/lib/opkg/lists",
    "etc/ipsec.d/aacerts", "etc/ipsec.d/acerts", "etc/ipsec.d/cacerts",
    "etc/ipsec.d/certs", "etc/ipsec.d/crls", "etc/ipsec.d/ocspcerts",
    "etc/ipsec.d/private", "etc/ipsec.d/reqs",
]


def raw_crc32(data):
    return (zlib.crc32(data) & 0xFFFFFFFF) ^ 0xFFFFFFFF


def restore_mtimes():
    """Apply the committed inode-mtime manifest so builds are byte-identical.

    Git does not preserve file timestamps, so a fresh checkout would otherwise
    stamp wall-clock mtimes and produce a different (and unbootable) image.
    """
    if not os.path.isfile(MTIMES_FILE):
        return
    applied = 0
    with open(MTIMES_FILE, encoding="utf-8") as f:
        for line in f:
            rel, ts = line.rstrip("\n").split("\t")
            path = os.path.join(SQUASHFS_DIR, rel) if rel else SQUASHFS_DIR
            if os.path.lexists(path):
                os.utime(path, (int(ts), int(ts)), follow_symlinks=False)
                applied += 1
    print(f"[+] restored {applied} inode mtimes from {os.path.basename(MTIMES_FILE)}")


def make_squashfs():
    for d in REQUIRED_DIRS:
        os.makedirs(os.path.join(SQUASHFS_DIR, d), exist_ok=True)
    restore_mtimes()
    os.makedirs(WORK_DIR, exist_ok=True)
    cmd = ["mksquashfs", SQUASHFS_DIR, ROOTFS_SQUASHFS] + MKSQUASHFS_OPTS
    print("[+] " + " ".join(cmd))
    subprocess.run(cmd, check=True)
    with open(ROOTFS_SQUASHFS, "rb") as f:
        return f.read()


def assemble(squashfs):
    with open(KERNEL_BIN, "rb") as f:
        kernel = f.read()

    if kernel[:4] != b"HDR0":
        sys.exit("[-] invalid kernel.bin (missing HDR0 magic)")

    _magic, _length, _crc, flag_ver, off1, off2, off3 = struct.unpack("<IIIIIII", kernel[:28])
    if off1 != 28 or off3 != 0x107800:
        sys.exit(f"[-] unexpected TRX offsets in kernel.bin: off1={off1:#x} off3={off3:#x}")

    payload = kernel[28:] + squashfs

    pad = (4096 - (len(payload) + 28) % 4096) % 4096
    payload += b"\x00" * pad
    total_len = 28 + len(payload)

    image = bytearray(28 + len(payload))
    image[0:28] = struct.pack("<4sIIIIII", b"HDR0", total_len, 0, flag_ver, off1, off2, off3)
    image[28:] = payload

    crc = raw_crc32(image[12:total_len])
    struct.pack_into("<I", image, 8, crc)

    with open(OUTPUT, "wb") as f:
        f.write(image)

    print(f"[+] wrote {OUTPUT} ({len(image)} bytes, pad {pad})")
    print(f"    TRX len=0x{total_len:x} crc=0x{crc:08x} flags=0x{flag_ver:08x} "
          f"off1={off1:#x} off2={off2:#x} off3={off3:#x}")
    return image, total_len, crc


def verify(image, total_len, crc, squashfs):
    ok = True

    if image[0:4] != b"HDR0":
        print("[-] bad magic"); ok = False
    if image[total_len:].strip(b"\x00"):
        print("[-] trailing data after image length"); ok = False
    if struct.unpack("<I", image[4:8])[0] != total_len:
        print("[-] length field mismatch"); ok = False
    if struct.unpack("<I", image[8:12])[0] != crc:
        print("[-] crc field not updated"); ok = False
    if raw_crc32(image[12:total_len]) != crc:
        print("[-] raw CRC self-check failed"); ok = False

    sq_off = struct.unpack("<I", image[24:28])[0]
    if image[sq_off:sq_off + 4] != b"hsqs":
        print(f"[-] no hsqs magic at off3={sq_off:#x}"); ok = False

    def bytes_used_at(sq):
        return struct.unpack("<Q", sq[0x28:0x30])[0]

    with open(ROOTFS_SQUASHFS, "rb") as f:
        on_disk = f.read()
    if bytes_used_at(on_disk) > len(on_disk):
        print(f"[-] squashfs bytes_used={bytes_used_at(on_disk)} > file size={len(on_disk)}"); ok = False
    if bytes_used_at(squashfs) != bytes_used_at(on_disk):
        print("[-] embedded squashfs bytes_used mismatch"); ok = False
    if image[sq_off:sq_off + len(squashfs)] != squashfs:
        print("[-] embedded squashfs altered"); ok = False

    if len(image) % 4096 != 0:
        print("[-] image not 4 KiB aligned"); ok = False
    if len(image) >= 8 * 1024 * 1024:
        print("[-] image >= 8 MiB (web updater limit)"); ok = False

    if not ok:
        sys.exit("[-] verification FAILED")

    md5 = hashlib.md5(image).hexdigest()
    sha256 = hashlib.sha256(image).hexdigest()
    print(f"[+] verification OK  md5={md5}")
    print(f"    sha256={sha256}")
    return sha256


def main():
    squashfs = make_squashfs()
    image, total_len, crc = assemble(squashfs)
    verify(image, total_len, crc, squashfs)


if __name__ == "__main__":
    main()