<?php

$term = `stty -g`;
$term = substr($term, 0, strlen($term) - 1);
#system("stty -icanon -echo -echoe -echok -echonl clocal echoctl -isig -ixon -ignbrk -brkint -istrip cs8 ");
system("stty -icanon -echo -ixon -isig ");
system("trap 'stty size >&0' WINCH");

#echo `stty -a`;
#mouse listen
system('echo -e "\e[?1000h"');
system('echo -e "\e[?1015h"');
system('echo -e "\e[?1006h"');
/**
 * Main listen loop
 */
echo "input# ";
while (($c = fread(STDIN, 12)) !== 'q') {
    $len = strlen($c);
    file_put_contents('/home/jsnook/w/johnsnook/tui-tui/tests/keylog.txt', $c, FILE_APPEND);
    $bytes = [];
    $byteshex = [];
    for ($i = 0; $i < $len; $i++) {
        $byteshex[$i] = '\x' . dechex(ord(substr($c, $i, 1)));
        $bytes[$i] = ord(substr($c, $i, 1));
    }


    if ($len <= 6) {
        $bytes = [];
        $byteshex = [];
        for ($i = 0; $i < $len; $i++) {
            $byteshex[$i] = '\x' . dechex(ord(substr($c, $i, 1)));
            $bytes[$i] = ord(substr($c, $i, 1));
        }
        echo "($len) [" . implode('][', $bytes) . '] ' . substr($c, 1) . "\t[" . implode('][', $byteshex) . '] ' . $c . PHP_EOL;
    } elseif ($len < 13) {
        if (substr_count($c, ';') === 2) {
            $pos = explode(';', substr($c, 0, $len - 1));
            $pos[0] = (int) substr($pos[0], 3);
            if ($pos[0] <= 18) {
                $event = 'Mouse ' . (substr($c, -1, 1) === 'M' ? 'Down' : 'Up');
            } else {
                $event = 'Scroll ';
            }
            //echo substr($pos[0], 3) . PHP_EOL;
            switch ($pos[0]) {
                case 0:
                    $button = $event . " Left Button";
                    break;
                case 16:
                    $button = $event . " Control Left Button";
                    break;
                case 1:
                    $button = $event . " Middle Button";
                    break;
                case 17:
                    $button = $event . " Control Middle Button";
                    break;
                case 2:
                    $button = $event . " Right Button";
                    break;
                case 18:
                    $button = $event . " Control Right Button";
                    break;
                case 64:
                    $button = $event . "Up";
                    break;
                case 65:
                    $button = $event . "Down";
                    break;
            }
            echo "($len) $button  H: {$pos[1]} V: {$pos[2]}\t[" . implode('][', $bytes) . "] \n";
            echo "ESC " . substr($c, 1) . "\n";
        }
    } else {
        echo "($len) Too big!";
    }
    echo "input# ";
}

/**
 * Restore the terminal settings
 */
system('echo -e "\e[?1000l"');
system("stty '" . $term . "'");


