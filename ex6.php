<?php

$cart = [
    [
        'name' => 'Magazine',
        'price' => 2.54,
    ],
    [
        'name' => 'Shirt',
        'price' => 24.99,
    ],
    [
        'name' => 'Chewing gums',
        'price' => 4.99,
    ],
    [
        'name' => 'Snacks',
        'price' => 8.21,
        'qty' => 1,
    ],
    [
        'name' => 'Watch',
        'price' => 224.99,
        'qty' => 2,
    ],
    [
        'name' => 'Drink',
        'price' => 12,
    ],
];

function calculateTotal(array $input): float
{
    $total = 0;

    foreach ($input as $item) {
        $total  = $total + $item['price'];
    }

    return $total;
}

function findItemWithHighestPrice(array $input): array
{
    // trovo l'indice del prodotto con prezzo più alto
    $indexOfItemWithHighestPrice = null;

    foreach ($input as $index => $item) {
        $price = $item['price'];

        if () {
            $indexOfItemWithHighestPrice = $index;
        }
    }

    // restituisco $input[indice trovato]
}
function findItemWithLowestPrice(array $input): array
{
    //...
}

function getItemsSortedByPriceAsc(array $input): array
{

}

function extractItemsWithMaxPrice(array $input, float $maxPrice): array
{

}



/*
 * Calcolare e mostrare:
 *  - lista degli item in carrello e il prezzo totale
 *  - l'item con prezzo maggiore e quello con prezzo minore
 *  - gli item ordinati per prezzo ascendente
 *  - gli item ordinati per prezzo ascendente, il cui prezzo non supera 46$
 *  - aggiungere la chiave $cart[...]['percentage_weight'] che memorizza il peso percentuale
 *    di ogni item rispetto al totale di spesa, con valori in punti base tra 0 e 10000 (0.01% = 1bp)
 *  - ordinare per peso percentuale
 *  - gestire un campo $cart[...]['qty'] che definisce quanti articoli ci sono in carrello
 *    se $cart[...]['qty'] non è definito, si assuma $cart[...]['qty'] = 1
 */
