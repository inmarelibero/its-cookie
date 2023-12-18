<?php

/*
 * array che contiene misurazioni di temperature (scala Farenight)
 */
$temperatures = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];
//$temperatures = [78, 60, 3];

/*
 * Note:
 *  - assicurarsi che il vostro codice gestisca anche $temperatures = []
 *
 * 1) Calcolare e stampare:
 *      - la temperatura media
 *      - i 5 valori più bassi e i 5 valori più alti
 *      - i valori più alti della media
 * 2) stampare gli output del punto 1) ma con i valori in °C
 */

/**
 * @param array $temperatures
 * @return float
 */
function calculateMean(array $temperatures): float
{
    return array_sum($temperatures) / count($temperatures);
}

/**
 * @param array $input
 * @param int $length
 * @return array
 */
function getHighest(array $input, int $length): array
{
    rsort($input);
    return getUniqueSlice($input, $length);
}

/**
 * @param array $input
 * @param int $length
 * @return array
 */
function getLowest(array $input, int $length): array
{
    sort($input);
    return getUniqueSlice($input, $length);
}

/**
 * @param array $input
 * @param int $length
 * @return array
 */
function getUniqueSlice(array $input, int $length): array
{
    $input = array_unique($input);

    return array_slice($input, 0, $length);
}

/**
 * @param float $input
 * @return float
 */
function convertToCelsiusFromFahrenheit(float $input): float
{
    return ($input - 32) * 5/9;
}

/**
 * @param float $input
 * @return float
 */
function convertArrayToCelsiusFromFahrenheit(array $input): array
{
    $output = [];

    foreach ($input as $valueInFahrenheit) {
        $output[] = convertToCelsiusFromFahrenheit($valueInFahrenheit);
    }

    return $output;
}

$mean = calculateMean($temperatures);
$highestTemperatures = getHighest($temperatures, 5);
$lowestTemperatures = getLowest($temperatures, 5);
?>

<p>
    La temperatura media è <?php echo $mean ?> (<?php echo convertToCelsiusFromFahrenheit($mean) ?> in C°)
</p>
<p>
    I 5 valori più alti sono: <?php echo implode(', ', $highestTemperatures) ?>
</p>
<p>
    I 5 valori più alti in C° sono: <?php echo implode(', ', convertArrayToCelsiusFromFahrenheit($highestTemperatures)) ?>
</p>
<p>
    I 5 valori più bassi sono: <?php echo implode(', ', $lowestTemperatures) ?>
</p>
