<?php require_once(__DIR__.'/../init.php'); ?>

<?php

$scriptName = $_SERVER['SCRIPT_NAME'];

$redirectManager = new RedirectManager($authenticationManager);
$redirectManager->redirectIfNotAuthenticated("login.php?_referer=$scriptName");

?>

<!DOCTYPE html>
<html lang="en">
    <?php $templateHelper->printHead(); ?>

    <body>
        <?php require_once(__DIR__ . '/../templates/_menu.php') ?>

        <h1>Contattaci</h1>
    </body>
</html>
