<?php
session_start();

require_once(__DIR__.'/src/class/App.php');
require_once(__DIR__.'/src/class/AuthenticationManager.php');
require_once(__DIR__.'/src/class/FileManager.php');
require_once(__DIR__.'/src/class/Logger.php');
require_once(__DIR__.'/src/class/LoginHandler.php');
require_once(__DIR__.'/src/class/PasswordHasher.php');
require_once(__DIR__.'/src/class/RedirectManager.php');
require_once(__DIR__.'/src/class/RegistrationHandler.php');
require_once(__DIR__.'/src/class/RequestHelper.php');
require_once(__DIR__.'/src/class/TemplateHelper.php');
require_once(__DIR__.'/src/class/User.php');

$app = new App('prod');
$authenticationManager = new AuthenticationManager($app);
$templateHelper = new TemplateHelper();
