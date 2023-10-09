<?php

require_once('../init.php');

writeLogLogout(
    getEmailOfAuthenticatedUser()
);

session_destroy();
redirect();
