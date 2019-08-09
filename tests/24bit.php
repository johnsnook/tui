<?php

for ($r=0;$r<256;$r+=4){
    for ($g=0;$g<256;$g+=4){
        for ($b=0;$b<256;$b+=4){
            echo "\e[48;2;{$r};{$g};{$b}m[" . dechex($r). dechex($g). dechex($b). ']';
        }
    }
}
echo "\e[0m";
