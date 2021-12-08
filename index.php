<?php

if(isset($_GET['url']))
{
    $_PARAMS = [];
    $_MESSAGE = [];

    $url = explode("/", htmlentities($_GET['url']));

    define('APPLICATION_PATH', str_replace("\\", "/", getcwd()));
    define('APPLICATION_ROOT', explode('/', APPLICATION_PATH)[count(explode('/', APPLICATION_PATH)) - 1]);

    @require_once('framework/initialize');
    @require_once('application/controllers/Controller.php');
    @require_once('application/models/Model.php');
    @require_once('application/controllers/' . pluralize($url[0]) . '.php');

    if(file_exists('application/models/' . singularize($url[0]) . '.php'))
    {
        @require_once('application/models/' . singularize($url[0]) . '.php');
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

                else if(method_exists($controller, 'show'))
                {
                    $params = $controller->show($url[1]);
                }

                if(file_exists("application/views/{$url[0]}/{$url[1]}.php"))
                {
                    $_PARAMS[strtolower($url[0])] = $params;
                    $_PARAMS['url'] = ['controller' => $url[0], 'action' => $url[1]];

                    @require_once("application/views/{$url[0]}/{$url[1]}.php");
                }

                else if(is_numeric($url[1]) && file_exists("application/views/{$url[0]}/show.php"))
                {
                    $_PARAMS[strtolower($url[0])] = $params;
                    $_PARAMS['url'] = ['controller' => $url[0], 'action' => 'show', 'id' => $url[1]];

                    @require_once("application/views/{$url[0]}/show.php");
                }
            }

        break;

        case 3:

            if(isset($url[0], $url[1], $url[2]))
            {
                $url[0] = pluralize($url[0]);
                $url[1] = ($url[1] === '') ? 'index' : $url[1];
                $controller = new $url[0]($url[0], $url[2], $url[1]);
                $params = [];

                if(method_exists($controller, $url[2]))
                {
                    $params = $controller->{$url[2]}($url[1]);
                }

                if(file_exists("application/views/{$url[0]}/{$url[2]}.php"))
                {
                    $_PARAMS[strtolower($url[0])] = $params;
                    $_PARAMS['url'] = ['controller' => $url[0], 'action' => $url[2], 'id' => $url[1]];

                    @require_once("application/views/{$url[0]}/{$url[2]}.php");
                }
            }

        break;
    }
}

else
{
    header('Location: application/public');
    exit(0);
}
