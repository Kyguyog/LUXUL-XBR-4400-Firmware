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

# 2. Calculate correct RootFS offset (Partition 2)
# TRX starts at offset 64. Kernel header size is added to the 28-byte TRX header.
trx_offset = 64
trx_header_size = 28

if os.path.exists(kernel_header_file):
    kernel_size = os.path.getsize(kernel_header_file)
    rootfs_offset = trx_header_size + kernel_size
    print(f"[+] Calculated RootFS offset from '{kernel_header_file}': {hex(rootfs_offset)} ({rootfs_offset} bytes)")
else:
    # Default stock fallback if kernel_header.bin size is unknown
    rootfs_offset = 0x00107800
    print(f"[!] Warning: '{kernel_header_file}' not found. Falling back to stock RootFS offset: {hex(rootfs_offset)}")

with open(filename, "r+b") as f:
    f.seek(trx_offset)
    if f.read(4) != b"HDR0":
        print("[-] TRX Magic 'HDR0' not found at offset 64!")
        exit(1)

    trx_len = file_size - trx_offset

    # Write updated TRX length (Offset 68 / TRX + 4)
    f.seek(trx_offset + 4)
    f.write(struct.pack("<I", trx_len))

    # WRITE CORRECT ROOTFS OFFSET (Offset 88 / TRX + 24)
    f.seek(trx_offset + 24)
    f.write(struct.pack("<I", rootfs_offset))

    # Calculate & write TRX CRC32 (Offset 72 / TRX + 8)
    # CRC32 covers everything in TRX from offset 12 to the end of the file
    f.seek(trx_offset + 12)
    trx_payload = f.read()
    crc = zlib.crc32(trx_payload) & 0xFFFFFFFF

    f.seek(trx_offset + 8)
    f.write(struct.pack("<I", crc))

    print(f"[+] TRX Header updated: Length={trx_len} bytes, RootFS Offset={hex(rootfs_offset)}, CRC32={hex(crc)}")

    # --- 3. Update Outer Luxul MD5 Header ---
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