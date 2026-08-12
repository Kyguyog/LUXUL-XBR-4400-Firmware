import hashlib

filename = "custom_XBR-4400.lxl"

with open(filename, "rb") as f:
    data = f.read()

# TRX payload starts at offset 64
header_64 = data[:64]
trx_payload = data[64:]

# Pad payload to 64KB boundary (65536 bytes)
pad_len = (65536 - (len(trx_payload) % 65536)) % 65536
if pad_len > 0:
    trx_payload += b"\x00" * pad_len
    print(f"[+] Padded image by {pad_len} bytes to 64KB boundary.")

# Re-calculate outer Luxul MD5 over padded payload
new_md5 = hashlib.md5(trx_payload).hexdigest().encode("ascii")

# Re-assemble
final_data = new_md5 + header_64[32:] + trx_payload

with open("custom_XBR-4400_padded.lxl", "wb") as f:
    f.write(final_data)

print("[+] Created 'custom_XBR-4400_padded.lxl'")