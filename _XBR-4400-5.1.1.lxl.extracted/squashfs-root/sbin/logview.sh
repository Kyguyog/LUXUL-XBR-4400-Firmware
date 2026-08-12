#!/bin/sh
#

usage()
{
   echo "logview.sh - logread format/dump utility"
   echo ""
   echo "Usage: logview.sh MODE
   echo ""
   echo "Modes:"
   echo "    -r dump in raw format with header"
   echo "    -f htmlify output
   echo""
   exit 1
}

format()
{
   logread > /tmp/log1.tmp
   tail -15 /tmp/log1.tmp > /tmp/log.tmp
   echo "<div class="hor"><table>"
   while [[ -s /tmp/log.tmp ]]
   do 
      echo "<tr><td>"
      head -1 /tmp/log.tmp
      echo "</td></tr>"
      sed -i '1d' /tmp/log.tmp
   done
   echo "</table></div>"
   exit 1
}

raw()
{
   MODEL=`uci get luxul.@hardware[0].model`
   FIRMWARE=`uci get luxul.@firmware[0].version`
   echo "Luxul $MODEL v$FIRMWARE Log File"
   logread
   exit 0
}

case "$1" in
   -f) format;;
   -r) raw;;
   *) usage;;
esac
