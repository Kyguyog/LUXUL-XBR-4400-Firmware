import hashlib
import os
import struct
import zlib

filename = "custom_XBR-4400.bin"

if not os.path.exists(filename):
    print(f"[-] Error: '{filename}' not found.")
    exit(1)

with open(filename, "r+b") as f:
    # --- 1. Update Inner TRX Header (Offset 64) ---
    trx_offset = 64
    f.seek(trx_offset)
    magic = f.read(4)
    if magic != b"HDR0":
        print("[-] TRX Magic 'HDR0' not found at offset 64!")
        exit(1)

    file_size = os.path.getsize(filename)
    trx_len = file_size - trx_offset

    # Write updated TRX length (Offset 68)
    f.seek(trx_offset + 4)
    f.write(struct.pack("<I", trx_len))

    # Calculate & write TRX CRC32 (Offset 72)
    f.seek(trx_offset + 12)
    trx_payload = f.read()
    crc = zlib.crc32(trx_payload) & 0xFFFFFFFF

    f.seek(trx_offset + 8)
    f.write(struct.pack("<I", crc))

    print(
        f"[+] TRX Header updated: Length={trx_len} bytes, CRC32={hex(crc)}"
    )

    # --- 2. Update Outer Luxul MD5 Header (Bytes 0-31) ---
    # Exact match for: dd if=FILE bs=16 skip=4 | md5sum
    # Skip first 64 bytes (16 * 4) and hash everything from byte 64 onward
    f.seek(64)
    file_payload = f.read()
    new_md5_hex = hashlib.md5(file_payload).hexdigest().encode("ascii")

    # Write the 32-character ASCII hex MD5 string to offset 0
    f.seek(0)
    f.write(new_md5_hex)

    print(f"[+] Outer Luxul MD5 updated: {new_md5_hex.decode('ascii')}")