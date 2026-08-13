import time
import serial

SERIAL_PORT = "/dev/ttyACM0"  # Update if needed
BAUD_RATE = 115200

print(f"[+] Opening {SERIAL_PORT}...")
ser = serial.Serial(SERIAL_PORT, BAUD_RATE, timeout=0.1)

print("[!] Power-cycle / reboot the Luxul router NOW.")
print("[+] Spamming Ctrl+C (0x03) to break into CFE bootloader...")

start = time.time()
# Spam Ctrl+C continuously for 15 seconds after power cycle
while time.time() - start < 15:
    ser.write(b"\x03")
    if ser.in_waiting:
        out = ser.read(ser.in_waiting).decode("utf-8", errors="ignore")
        print(out, end="", flush=True)
    time.sleep(0.02)

print("\n\n[+] Switching to interactive terminal mode. Press Enter to see CFE prompt.")

try:
    while True:
        if ser.in_waiting:
            out = ser.read(ser.in_waiting).decode("utf-8", errors="ignore")
            print(out, end="", flush=True)
except KeyboardInterrupt:
    print("\n[+] Exiting.")
finally:
    ser.close()