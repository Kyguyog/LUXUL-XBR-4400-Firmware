import hashlib
import os
import struct
import zlib

filename = "custom_XBR-4400.bin"
kernel_header_file = "kernel_header.bin"

if not os.path.exists(filename):
    print(f"[-] Error: '{filename}' not found.")
    exit(1)

# 1. Pad file to 4-byte boundary (Required for MTD/TRX alignment)
file_size = os.path.getsize(filename)
padding = (4 - (file_size % 4)) % 4
if padding > 0:
    with open(filename, "ab") as f:
        f.write(b"\x00" * padding)
    file_size += padding
    print(f"[+] Added {padding} bytes of padding.")

trx_offset = 64

# 2. Find exact SquashFS offset relative to the TRX header
# SquashFS magic bytes in little-endian: hsqs -> 0x73717368 (b"hsqs")
squashfs_magic = b"hsqs"
rootfs_offset = None

with open(filename, "rb") as f:
    f.seek(trx_offset)
    trx_data = f.read()
    sqfs_pos = trx_data.find(squashfs_magic)
    if sqfs_pos != -1:
        rootfs_offset = sqfs_pos
        print(f"[+] Found SquashFS magic 'hsqs' at TRX offset: {hex(rootfs_offset)} ({rootfs_offset} bytes)")

# Fallback offset calculation if magic bytes aren't auto-detected
if rootfs_offset is None:
    if os.path.exists(kernel_header_file):
        # kernel_header.bin ALREADY includes the 28-byte TRX header
        rootfs_offset = os.path.getsize(kernel_header_file)
        print(f"[+] Calculated RootFS offset from '{kernel_header_file}' size: {hex(rootfs_offset)} ({rootfs_offset} bytes)")
    else:
        rootfs_offset = 0x00107800
        print(f"[!] Warning: Falling back to default stock RootFS offset: {hex(rootfs_offset)}")

# 3. Update headers and checksums
with open(filename, "r+b") as f:
    f.seek(trx_offset)
    if f.read(4) != b"HDR0":
        print("[-] TRX Magic 'HDR0' not found at offset 64!")
        exit(1)

    trx_len = file_size - trx_offset

    # Write updated TRX length (TRX + 4)
    f.seek(trx_offset + 4)
    f.write(struct.pack("<I", trx_len))

    # Write correct RootFS offset (Partition 2 / TRX + 24)
    f.seek(trx_offset + 24)
    f.write(struct.pack("<I", rootfs_offset))

    # Calculate & write TRX CRC32 (TRX + 8)
    # CRC32 covers everything in TRX from offset 12 to the end of the file
    f.seek(trx_offset + 12)
    trx_payload = f.read()
    crc = zlib.crc32(trx_payload) & 0xFFFFFFFF

    f.seek(trx_offset + 8)
    f.write(struct.pack("<I", crc))

    print(f"[+] TRX Header updated: Length={trx_len} bytes, RootFS Offset={hex(rootfs_offset)}, CRC32={hex(crc)}")

    # --- 4. Update Outer Luxul MD5 Header ---
    f.seek(64)
    file_payload = f.read()
    new_md5_hex = hashlib.md5(file_payload).hexdigest().encode("ascii")

    f.seek(0)
    f.write(new_md5_hex)

    print(f"[+] Outer Luxul MD5 updated: {new_md5_hex.decode('ascii')}")

# Save output copy as custom_XBR-4400.lxl
lxl_filename = "custom_XBR-4400.lxl"
with open(filename, "rb") as src, open(lxl_filename, "wb") as dst:
    dst.write(src.read())

print(f"[+] Successfully generated '{lxl_filename}'.")