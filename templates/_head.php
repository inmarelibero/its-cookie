<?php

$scriptName = $_SERVER['SCRIPT_NAME'];

$scriptName = rtrim($scriptName, '.php');
$scriptName = ltrim($scriptName, '/');
$scriptName = ucfirst($scriptName);

$scriptName = str_replace('-', ' ', $scriptName);

if (!isset($metaTitle)) {
    $metaTitle = $scriptName;
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $metaTitle ?></title>

    <?php require_once(__DIR__ . '/_head_assets.php') ?>
</head>