<?php

if(isset($_GET['url']))
{
    $_PARAMS = [];
    $_MESSAGE = [];

    require_once('initialize');

    $url = explode("/", htmlentities($_GET['url']));

    @require_once('application/controllers/' . pluralize($url[0]) . '.php');

    if(file_exists('application/models/' . $url[0] . '.php'))
    {
        @require_once('application/models/' . $url[0] . '.php');
    }

    switch(count($url))
    {
        case 1:

            if(isset($url[0]))
            {
                $url[0] = pluralize($url[0]);
                $controller = new $url[0]($url[0]);
                $params = [];

                if(method_exists($controller, 'index'))
                {
                     $params = $controller->index();
                }

                if(file_exists("application/views/{$url[0]}/index.php"))
                {
                    $_PARAMS[strtolower($url[0])] = $params;
                    $_PARAMS['url'] = ['controller' => $url[0], 'action' => 'index'];

                    @require_once("application/views/{$url[0]}/index.php");
                }
            }
            
        break;

        case 2:

            if(isset($url[0], $url[1]))
            {
                $url[0] = pluralize($url[0]);
                $url[1] = ($url[1] === '') ? 'index' : $url[1];
                $controller = new $url[0]($url[0], $url[1]);
                $params = [];

                if(method_exists($controller, $url[1]))
                {
                     $params = $controller->{$url[1]}();
                }

                if(file_exists("application/views/{$url[0]}/{$url[1]}.php"))
                {
                    $_PARAMS[strtolower($url[0])] = $params;
                    $_PARAMS['url'] = ['controller' => $url[0], 'action' => $url[1]];

                    @require_once("application/views/{$url[0]}/{$url[1]}.php");
                }
            }

        break;

        case 3:

            if(isset($url[0], $url[1], $url[2]))
            {
                $url[0] = pluralize($url[0]);
                $url[1] = ($url[1] === '') ? 'index' : $url[1];
                $controller = new $url[0]($url[0], $url[1], $url[2]);
                $params = [];

                if(method_exists($controller, $url[1]))
                {
                     $params = $controller->{$url[1]}($url[2]);
                }

                if(file_exists("application/views/{$url[0]}/{$url[1]}.php"))
                {
                    $_PARAMS[strtolower($url[0])] = $params;
                    $_PARAMS['url'] = ['controller' => $url[0], 'action' => $url[1], 'id' => $url[2]];

                    @require_once("application/views/{$url[0]}/{$url[1]}.php");
                }
            }

        break;
    }
}

else
{
    header('Location: default');
    exit(0);
}
