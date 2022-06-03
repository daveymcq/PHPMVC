<?php

// Load application configuration

require_once("framework/configuration/application.php");

// Redirect page to {$location}

function redirect_to($location)
{
    $url = APPLICATION_ROOT . '/' . $location;

    if(is_array($location))
    {
        if(!isset($location['controller'])) exit;

        $controller = $location['controller'];
        $url .= "/{$controller}";

        if(isset($location['action']))
        {
            $url .= "/{$location['action']}";

            if(isset($location['id']))
            {
                $url .= "/{$location['id']}";
            }
        }
    }

    header("Location: /{$url}");
    exit;
}