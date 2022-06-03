<?php

require_once("framework/configuration/application.php");

if((isset($_SERVER['HTTPS'])) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) 
{
    define('STYLESHEETS_ASSETS_URL', 'https://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/stylesheets');
    define('JAVASCRIPTS_ASSETS_URL', 'https://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/javascripts');
}

else 
{
    define('STYLESHEETS_ASSETS_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/stylesheets');
    define('JAVASCRIPTS_ASSETS_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/javascripts');
}
