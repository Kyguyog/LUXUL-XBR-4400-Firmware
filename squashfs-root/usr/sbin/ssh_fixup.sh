#!/bin/sh
if [ -e /etc/ssh/sshd_config ]; then
        sed -i 's/#Port 22/Port 22/' /etc/ssh/sshd_config
        sed -i 's/#Protocol 2/Protocol 2/' /etc/ssh/sshd_config
        sed -i 's/#PasswordAuthentication yes/PasswordAuthentication yes/' /etc/ssh/sshd_config

        ver=$(opkg list openssh-server | sed 's/openssh-server - //')
        case "$ver" in
                6.7p1-3)
                        sed -i 's/#PermitRootLogin yes/PermitRootLogin yes/' /etc/ssh/sshd_config
                        sed -i 's/UsePrivilegeSeparation sandbox/UsePrivilegeSeparation no/' /etc/ssh/sshd_config
                        ;;
                7.1p2-1)
                        sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
                        ;;
        esac
fi
