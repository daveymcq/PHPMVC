<?php

function redirect_to($location)
{
    $url = APPLICATION_ROOT . '/' . $location;

    if(is_array($location))
    {
        $url = APPLICATION_ROOT;

        if(isset($location['controller']))
        {
            $controller = "{$location['controller']}";
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
        else
        {
            return false;
        }
    }

    header("Location: /{$url}");
    
    exit(0);
}