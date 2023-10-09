<?php

require_once('../init.php');

$logger = new Logger();
$logger->writeLogLogout(
    getEmailOfAuthenticatedUser()
);

session_destroy();
redirect();
