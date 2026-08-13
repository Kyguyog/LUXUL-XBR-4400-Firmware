# LUXUL XBR-4400 Firmware Builder

Rebuilds the Luxul XBR-4400 firmware image from an editable, uncompressed root
filesystem and a fixed kernel blob. The output is a raw TRX image
(`firmware.bin`) ready for flashing through the CFE bootloader.

## Layout

| Path                  | Purpose                                                    |
| --------------------- | ---------------------------------------------------------- |
| `squashfs-root/`      | Uncompressed root filesystem — this is what you edit       |
| `kernel.bin`          | TRX header + kernel sections (immutable, do not edit)      |
| `build.py`            | Compiles the image: squashfs -> TRX -> `firmware.bin`      |
| `firmware.bin`        | Generated raw TRX image (not committed)                    |
| `mtimes.tsv`          | Committed inode-mtime manifest used for reproducible builds |
| `CFE.py`              | Helper script to break into the CFE serial console         |

## Editing the firmware

Edit any file under `squashfs-root/`. The root password lives in
`squashfs-root/etc/shadow` and is currently set to `admin`:

```
root:$1$4ce6a0$8327Pr9kC9SH9S4b/oH4M1:...
```

Then rebuild and flash.

## Building locally

Requires Python 3 and `squashfs-tools` (`mksquashfs`):

```sh
sudo apt install squashfs-tools python3   # Debian/Ubuntu
python3 build.py
```

The build is deterministic: `build.py` restores inode mtimes from the committed
`mtimes.tsv` manifest and pins the squashfs superblock time, so the same tree
always produces the same `firmware.bin` bytes (md5 `877bda9c…`).

## How the image is assembled

The router expects a Broadcom-style TRX image:

```
HDR0 | length | raw_crc32 | flag_version | off1 | off2 | off3 | data
```

- `kernel.bin` supplies the header + kernel partitions (`off1`=28,
  `off3`=0x107800). It is byte-for-byte identical to the stock firmware.
- The rootfs is the edited `squashfs-root/` repacked with
  `mksquashfs -comp xz -b 262144 -no-xattrs -noappend -all-root`.
- The TRX checksum is the **raw CRC32** (no final XOR) of `trx[12:len]` — this
  is what the router's `otrx`/CFE validates. A plain `zlib.crc32()` produces
  images the updater rejects.
- `-mkfs-time 1786544698` plus the `mtimes.tsv` manifest pin the squashfs
  superblock and inode timestamps to the values baked into the known-good image,
  so clean rebuilds are byte-identical to it. **Do not use `-all-time 0`** — it
  rewrites every inode mtime to the epoch, which produced a bootable-format but
  non-booting image (hangs in early procd, no login prompt).
- The final image is padded to a 4 KiB boundary.

## Flashing

### Over SSH (recommended)

scp the image to the router, then run `sysupgrade` from its root shell:

```sh
scp firmware.bin root@192.168.1.1:/tmp/
ssh root@192.168.1.1
sysupgrade -n /tmp/firmware.bin
```

`sysupgrade` validates the raw TRX (`otrx check`) and writes it to the
`firmware` partition via `mtd`. The router reboots automatically.

### Via CFE (recovery)

Access the CFE bootloader over the serial console (`CFE.py` can help reach the
prompt), then from the CFE prompt:

```
flash -noheader 192.168.1.100:firmware.bin flash0.trx
```

`firmware.bin` is a raw TRX (no LXL header), so `-noheader` mode of `flash`
with the `flash0.trx` mtd partition is used. A web upload of the LXL image is
also supported by the stock updater if you prefer that route.

## Troubleshooting

### Boot hangs in early userspace after flashing (`procd: Failed to stat /dev/console`)

If the device boots to CFE, loads the kernel, mounts the squashfs rootfs, but
then hangs with preinit errors like `kmod: failed to open /proc/modules` and
`open: No such file or directory` — the image was built with `-all-time 0`.
That flag zeroes every inode mtime (epoch 1970), which the early userspace
does not survive. The `build.py` in this repo pins only `-mkfs-time` and
produces an image byte-identical to a known-good flash.

Verify a rebuild matches the known-good image:

```sh
python3 build.py
md5sum firmware.bin   # expect 877bda9cb3cd5461e58d08125730601f
```

## CI

`.github/workflows/build.yml` compiles `firmware.bin` automatically whenever
files under `squashfs-root/`, `kernel.bin`, or the build script change, and
uploads the artifact. Tagging a release (e.g. `v1.0`) attaches `firmware.bin`
to the GitHub release.