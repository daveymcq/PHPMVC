<?php

// Enable sessions and output buffering

session_start();
ob_start();

// Load application configuration

require_once("framework/configuration/application.php");

// Load helper functions

require_once("framework/functions/application.php");
require_once("framework/functions/components/mvc/views.php");
require_once("framework/functions/components/mvc/models.php");
require_once("framework/functions/components/mvc/controllers.php");

// Load ActiveRecord ORM configuration for selected database adapter

if(file_exists("framework/classes/model/". DB_ADAPTER ."/ActiveRecordModel.php"))
{
    require_once("framework/classes/controller/BaseController.php");
    require_once("framework/classes/database/CommonDatabaseActions.php");
    require_once("framework/classes/database/Validation.php");
    require_once("framework/classes/database/Database.php");
    require_once("framework/classes/database/adapters/" . DB_ADAPTER . ".php");
    require_once("framework/classes/routing/Request.php");
    require_once("framework/classes/model/". DB_ADAPTER ."/ActiveRecordModel.php");

    spl_autoload_register(function($class)
    {
        if(file_exists("application/models/{$class}.php"))
        {
            require_once("application/models/{$class}.php");
        }

        else if(file_exists("application/controllers/{$class}.php"))
        {
            require_once("application/controllers/{$class}.php");
        }
    });
} 

