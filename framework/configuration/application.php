<?php

// Enable sessions and output buffer

session_start();
ob_start();

// Get the name of the application root directory

define('APPLICATION_PATH', str_replace("\\", "/", getcwd()));
define('APPLICATION_ROOT', explode('/', APPLICATION_PATH)[count(explode('/', APPLICATION_PATH)) - 1]);

// Import application configuration

require_once('components/assets.php');
require_once('components/database.php');