<?php

/*
 * @author John Snook
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */
echo "\n";

$hexes = str_split('0123456789abcdef');
echo "    ";
foreach ($hexes as $hex) {
    echo $hex . " ";
}
echo "\n";
echo str_repeat('_', 40) . PHP_EOL;
for ($i = 0; $i < 2400; $i++) {
    echo dechex($i);
    #echo dechex($i);
    foreach ($hexes as $hex) {
        echo " ";
        echo html_entity_decode('&#x' . dechex($i) . $hex . ';', ENT_NOQUOTES, 'UTF-8');
    }
    echo "\n\n";
}

