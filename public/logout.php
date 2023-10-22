<?php

require_once(__DIR__.'/../init.php');

$logger = new Logger($app);
$logger->writeLogLogout(
    $authenticationManager->getEmailOfAuthenticatedUser()
);

session_destroy();

$redirectManager = new RedirectManager($authenticationManager);
$redirectManager->redirect();
