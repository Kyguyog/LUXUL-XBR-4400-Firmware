#!/usr/bin/env bash
# Local replica of the GitHub workflow (.github/workflows/build.yml).
# Ensures prerequisites are installed, runs the build, and reports the image.
#
# build.py itself writes firmware.bin to the repo root so the untouched CI
# workflow keeps working; this script then moves it (and the intermediate
# squashfs) into ./build/ so all build artifacts land there.
#
# Usage:
#   ./tools/build.sh               # build only
#   ./tools/build.sh --install     # also install missing deps (needs sudo)
#
# Output:
#   All build artifacts land under ./build/, including build/firmware.bin

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "${SCRIPT_DIR}/.." && pwd)"
BUILD_DIR="${REPO_ROOT}/build"
ROOT_FIRMWARE="${REPO_ROOT}/firmware.bin"
FIRMWARE="${BUILD_DIR}/firmware.bin"

INSTALL_DEPS=0
for arg in "$@"; do
    case "${arg}" in
        --install) INSTALL_DEPS=1 ;;
        -h|--help)
            echo "Usage: $0 [--install]"
            echo
            echo "  --install  install missing build dependencies (squashfs-tools) via apt"
            echo
            echo "Builds firmware.bin into ${BUILD_DIR}"
            exit 0
            ;;
        *) echo "unknown argument: ${arg}" >&2; exit 2 ;;
    esac
done

check_dep() {
    local name="$1"
    local pkg="$2"
    local cmd="$3"
    if ! command -v "${cmd}" >/dev/null 2>&1; then
        echo "[!] missing dependency: ${name} (${pkg})" >&2
        if [ "${INSTALL_DEPS}" -eq 1 ]; then
            echo "[+] installing ${pkg}..." >&2
            sudo apt-get update
            sudo apt-get install -y --no-install-recommends "${pkg}"
        else
            echo "[+] install it with:" >&2
            echo "    sudo apt-get install -y --no-install-recommends ${pkg}" >&2
            exit 1
        fi
    fi
}

check_dep "mksquashfs" "squashfs-tools" "mksquashfs"
check_dep "python3" "python3" "python3"

echo "[+] Building in ${BUILD_DIR}"
mkdir -p "${BUILD_DIR}"
python3 "${REPO_ROOT}/build.py"

if [ ! -f "${ROOT_FIRMWARE}" ]; then
    echo "[-] build finished but ${ROOT_FIRMWARE} not found" >&2
    exit 1
fi

mv "${ROOT_FIRMWARE}" "${FIRMWARE}"

echo
echo "[+] Done: ${FIRMWARE}"
echo "    size:  $(stat -c %s "${FIRMWARE}") bytes"
echo "    md5:   $(md5sum "${FIRMWARE}" | cut -d' ' -f1)"
echo "    sha256:$(sha256sum "${FIRMWARE}" | cut -d' ' -f1)"
echo
echo "    flash over SSH:  scp ${FIRMWARE} root@192.168.1.1:/tmp/  (then sysupgrade -n /tmp/firmware.bin)"
echo "    flash via CFE:   flash -noheader 192.168.1.100:firmware.bin flash0.trx"