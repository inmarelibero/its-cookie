<?php require_once('../init.php'); ?>

<?php

$scriptName = $_SERVER['SCRIPT_NAME'];

redirectIfNotAuthenticated("login.php?_referer=$scriptName");

?>

<!DOCTYPE html>
<html lang="en">
    <?php printHead(); ?>

    <body>
        <?php require_once('../_menu.php') ?>

        <h1>Contattaci</h1>
    </body>
</html>
