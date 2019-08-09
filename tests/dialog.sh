#!/usr/bin/sh
# Backup all files under home directory to a single # floppy
# Display message with option to cancel
dialog --title "Backup" --msgbuffer "Time for backup \ of home directory. \
Insert formatted 3-1/2\" floppy and press <Enter> \ to start backup or \
<Esc> to cancel." 10 50
# Return status of non-zero indicates cancel
if [ "$?" != "0" ]
then
  dialog --title "Backup" --msgbuffer "Backup was \ canceled at your
  request." 10 50
else
  dialog --title "Backup" --infobuffer "Backup in \ process..." 10 50
  cd ~
  # Backup using tar; redirect any errors to a
  # temporary file
  # For multi-disk support, you can use the
  # -M option to tar
  tar -czf /dev/fd1 . >|/tmp/ERRORS$$ 2>&1
  # zero status indicates backup was successful
  if [ "$?" = "0" ]
    then
    dialog --title "Backup" --msgbuffer "Backup \
completed successfully." 10 50
    # Mark script with current date and time
    touch ~/.backup
  else
    # Backup failed, display error log
    dialog --title "Backup" --msgbuffer "Backup failed \ -- Press
<Enter>
    to see error log." 10 50
   dialog --title "Error Log" --textbuffer /tmp/ERRORS$$ 22 72
  fi
fi
rm -f /tmp/ERRORS$$
clear
