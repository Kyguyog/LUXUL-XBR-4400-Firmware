import hashlib
import os
import struct
import zlib

filename = "custom_XBR-4400.bin"
lxl_filename = "custom_XBR-4400.lxl"

if not os.path.exists(filename):
    print(f"[-] Error: '{filename}' not found.")
    exit(1)

trx_offset = 64
BLOCK_SIZE = 65536  # 64 KB Flash Block Boundary Alignment

with open(filename, "rb") as f:
    header_64 = f.read(trx_offset)
    trx_payload = bytearray(f.read())

# Check HDR0 magic
if trx_payload[:4] != b"HDR0":
    print("[-] TRX Magic 'HDR0' not found at offset 64!")
    exit(1)

# 1. Pad TRX payload to 64 KB (65536 byte) boundary
payload_len = len(trx_payload)
pad_len = (BLOCK_SIZE - (payload_len % BLOCK_SIZE)) % BLOCK_SIZE
if pad_len > 0:
    trx_payload.extend(b"\x00" * pad_len)
    print(
        f"[+] Padded TRX payload by {pad_len} bytes to 64 KB boundary"
        f" ({len(trx_payload)} bytes total)."
    )

trx_len = len(trx_payload)

# 2. Find exact SquashFS offset (Partition 2)
squashfs_magic = b"hsqs"
sqfs_pos = trx_payload.find(squashfs_magic)

if sqfs_pos != -1:
    rootfs_offset = sqfs_pos
    print(
        f"[+] Found SquashFS magic 'hsqs' at TRX offset: {hex(rootfs_offset)}"
        f" ({rootfs_offset} bytes)"
    )
else:
    rootfs_offset = 0x00107800
    print(
        "[!] Warning: 'hsqs' magic not found. Falling back to stock RootFS"
        f" offset: {hex(rootfs_offset)}"
    )

# 3. Update TRX Header Fields
# Offset 4: TRX Length
struct.pack_into("<I", trx_payload, 4, trx_len)

# Offset 24: Partition 2 (RootFS) Offset
struct.pack_into("<I", trx_payload, 24, rootfs_offset)

# 4. Calculate TRX CRC32 (Covers offset 12 to end of padded payload)
crc_data = bytes(trx_payload[12:])
crc = zlib.crc32(crc_data) & 0xFFFFFFFF
struct.pack_into("<I", trx_payload, 8, crc)

print(
    f"[+] TRX Header updated: Length={trx_len} bytes, RootFS"
    f" Offset={hex(rootfs_offset)}, CRC32={hex(crc)}"
)

# 5. Calculate Outer Luxul MD5 ASCII Hash
new_md5_hex = hashlib.md5(trx_payload).hexdigest().encode("ascii")

# 6. Reconstruct final .lxl firmware binary
# [32-byte MD5] + [32-byte Header Padding/Model Tag] + [TRX Payload]
final_lxl_data = new_md5_hex + header_64[32:] + bytes(trx_payload)

with open(lxl_filename, "wb") as f:
    f.write(final_lxl_data)

print(f"[+] Successfully generated 64 KB aligned image: '{lxl_filename}'.")