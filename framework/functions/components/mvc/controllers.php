<?php

// Redirect page to {$location}

function redirect_to($location)
{
    if((isset($_SERVER['HTTPS'])) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) 
    {
        $base_url = 'https://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/';
        $url = $base_url . $location;

        if(explode('/', parse_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $base_url = 'https://' . $_SERVER['SERVER_NAME'] . '/';
            $url = $base_url . $location;
        }
    }

    else 
    {
        $base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/';
        $url = $base_url . $location;

        if(explode('/', parse_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'] . '/';
            $url = $base_url . $location;
        }
    }

    if(is_array($location))
    {
        if(!isset($location['controller'])) exit;

        $controller = $location['controller'];
        $url .= "{$controller}";

        if(isset($location['action']))
        {
            $url .= "{$location['action']}";

            if(isset($location['id']))
            {
                $url .= "{$location['id']}";
            }
        }
    }

    header("Location: {$url}");
    exit;
}
