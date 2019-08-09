#!/usr/bin/bash

check_terminal_size () {
    if [[ "$LINES $COLUMNS" != "$previous_lines $previous_columns" ]]; then
        echo -e "\e[winche"
    fi
    previous_lines=$LINES
    previous_columns=$COLUMNS
}

trap 'check_terminal_size' WINCH

