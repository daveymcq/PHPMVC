<?php

// Get application database configuration settings if exists

if(file_exists('application/configuration/database.php'))
{
    // Use application database configuration

    require_once('application/configuration/database.php');

    // Verify database configuration and inject defaults where necessary

    if(!defined('DB_ADAPTER'))
    {
        define('DB_ADAPTER', 'MySQL');
    }

    if(!defined('DB_HOST'))
    {
        define('DB_HOST', '127.0.0.1');
    }

    if(!defined('DB_NAME'))
    {
        define('DB_NAME', APPLICATION_ROOT);
    }

    if(!defined('DB_USER'))
    {
        define('DB_USER', 'root');
    }

    if(!defined('DB_PASS'))
    {
        define('DB_PASS', '');
    }
}

else
{
    // Set and use default database configuration

    define('DB_ADAPTER', 'MySQL');
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', APPLICATION_ROOT);
    define('DB_USER', 'root');
    define('DB_PASS', '');
}
