<?php

/*
 * Usando gli elementi di $color:
 * 1) Stampare la stringa "white, green, red, yellow"
 * 2) Stampare la stringa "white, red, yellow"
 * 3) Stampare la stringa "yellow, red, green, white"
 */


function printColors(array $input): string
{
    $output = '';

    foreach ($input as $index => $color) {
        if (!in_array($color, ['white', 'red', 'yellow'])) {
            continue;
        }

        $output .= $color;

        if ($index >= count($input) - 1) {
            break;
        }

        $output = $output . ', ';
    }

    return $output;
}

$colors = ['white', 'Green', 'red', 'yellow', 'orange', 'red'];
$separator = ', ';
$colorsString = printColors($colors);
?>

<html>
    <body>
        <p>
            <b>
                <?php echo $colorsString; ?>
            </b>
        </p>
        <p>
            <b>
                <?php echo $colorsString; ?>
            </b>
        </p>
    </body>
</html>
