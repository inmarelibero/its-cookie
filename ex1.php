<?php

/*
 * Usando gli elementi di $color:
 * 1) Stampare la stringa "white, green, red, yellow"
 * 2) Stampare la stringa "white, red, yellow"
 * 3) Stampare la stringa "yellow, red, green, white"
 */

$colors = ['white', 'Green', 'red', 'yellow', 'orange'];
$separator = ', ';
echo printColors($colors, $separator);

function printColors()
{
//    ...
}
