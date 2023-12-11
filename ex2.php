<?php

$countries = [
    "Italy" => "Rome",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki",
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid",
    "Sweden" => "Stockholm",
    "United Kingdom" => "London",
    "Cyprus" => "Nicosia",
    "Lithuania" => "Vilnius",
    "Czech Republic" => "Prague",
    "Estonia" => "Tallin",
    "Hungary" => "Budapest",
    "Latvia" => "Riga",
    "Malta" => "Valetta",
    "Austria" => "Vienna",
    "Poland" => "Warsaw",
];

/*
 * 1) Stampare la seguente riga per ogni elemento di $countries:
 *  "The capital of Netherlands is Amsterdam"
 *  "The capital of Greece is Athens"
 *  ...
 *
 * 2) Stampare le stesse righe, ma ordinate (alfabeticamente) per capitale
 * 3) Stampare le stesse righe, ma ordinate (alfabeticamente) per nome del paese
 */

function printCountries(array $input, $sortingType)
{
    /*
     *
     */
    if ($sortingType === 'COUNTRY_ASC') {
        ksort($input);
    } elseif ($sortingType === 'COUNTRY_DESC') {
        krsort($input);
    } elseif ($sortingType === 'CAPITAL_ASC') {
        asort($input);
    } elseif ($sortingType === 'CAPITAL_DESC') {
        arsort($input);
    }

    /*
     *
     */
    $index = 0;

    foreach ($input as $country => $capital) {
        $index = $index + 1;
        echo "The capital of $country is $capital";

        if ($index >= count($input)) {
            break;
        }

        echo '<br>';
    }
}

//printCountries($countries, 'CAPITAL_ASC');
//printCountries($countries, 'CAPITAL_DESC');
//printCountries($countries, 'COUNTRY_ASC');
printCountries($countries, 'COUNTRY_DESC');







