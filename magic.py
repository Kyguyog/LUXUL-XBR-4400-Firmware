import hashlib
import os
import struct
import zlib

filename = "custom_XBR-4400.bin"

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

with open(filename, "r+b") as f:
    trx_offset = 64
    f.seek(trx_offset)
    if f.read(4) != b"HDR0":
        print("[-] TRX Magic 'HDR0' not found at offset 64!")
        exit(1)

    trx_len = file_size - trx_offset

    # Write updated TRX length (Offset 68)
    f.seek(trx_offset + 4)
    f.write(struct.pack("<I", trx_len))

    # FIX: Zero out Partition 2 Offset (Offset 88)
    # This prevents the kernel from truncating our custom rootfs if it's larger than stock
    f.seek(trx_offset + 24)
    f.write(struct.pack("<I", 0))

    # Calculate & write TRX CRC32 (Offset 72)
    f.seek(trx_offset + 12)
    trx_payload = f.read()
    crc = zlib.crc32(trx_payload) & 0xFFFFFFFF

    f.seek(trx_offset + 8)
    f.write(struct.pack("<I", crc))

    print(f"[+] TRX Header updated: Length={trx_len} bytes, CRC32={hex(crc)}")

    # --- 2. Update Outer Luxul MD5 Header ---
    f.seek(64)
    file_payload = f.read()
    new_md5_hex = hashlib.md5(file_payload).hexdigest().encode("ascii")

    f.seek(0)
    f.write(new_md5_hex)

    print(f"[+] Outer Luxul MD5 updated: {new_md5_hex.decode('ascii')}")