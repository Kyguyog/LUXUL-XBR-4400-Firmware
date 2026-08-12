# 1. Compare total file sizes
ls -lh custom_XBR-4400.lxl XBR-4400-5.1.1.lxl

# 2. Compare the Luxul Header (First 64 bytes)
echo "=== STOCK LUXUL HEADER ==="
hexdump -C -n 64 XBR-4400-5.1.1.lxl
echo "=== CUSTOM LUXUL HEADER ==="
hexdump -C -n 64 custom_XBR-4400.lxl

# 3. Compare the TRX Header (Bytes 64-96)
echo "=== STOCK TRX HEADER ==="
dd if=XBR-4400-5.1.1.lxl bs=1 skip=64 count=32 2>/dev/null | hexdump -C
echo "=== CUSTOM TRX HEADER ==="
dd if=custom_XBR-4400.lxl bs=1 skip=64 count=32 2>/dev/null | hexdump -C

# 4. Check RootFS offset & SquashFS block parameters
echo "=== SQUASHFS METADATA ==="
unsquashfs -s squashfs-root.sqfs 2>/dev/null || unsquashfs -s *.squashfs 2>/dev/null || echo "Run unsquashfs -s on your generated .sqfs file"