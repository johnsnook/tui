#!/bin/bash
DIALOG=${DIALOG=dialog}

$DIALOG --title " My first dialog" --clear \
        --yesno "Hello , this is my first dialog program" 10 30

case $? in
  0)
    echo "Yes chosen.";;
  1)
    echo "No chosen.";;
  255)
    echo "ESC pressed.";;
esac
