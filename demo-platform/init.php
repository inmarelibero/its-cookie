<?php
session_start();

require_once(__DIR__."/src/functions.php");
require_once(__DIR__."/src/Logger.php");
require_once(__DIR__."/src/Redirecter.php");
require_once(__DIR__."/src/User.php");

$logger = new Logger();
$redirecter = new Redirecter();
