#!/bin/sh

sleep 5
/etc/init.d/firewall restart

sleep 2
/etc/init.d/multiwan reload

