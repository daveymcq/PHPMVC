<?php

// Load application configuration

require_once("framework/configuration/application.php");

// Get the name of the application root directory

define('APPLICATION_PATH', str_replace("\\", "/", getcwd()));
define('APPLICATION_ROOT', strtolower(explode('/', APPLICATION_PATH)[count(explode('/', APPLICATION_PATH)) - 1]));

// Import application configuration

require_once('components/assets.php');
require_once('components/database.php');
