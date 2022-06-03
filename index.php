<?php

error_reporting(0);

require_once('framework/initialize.php');

if(isset($_GET['url']))
{
    $PARAMS = [];
    $URL = explode("/", htmlentities($_GET['url']));

    require_once('application/controllers/Controller.php');
    require_once('application/models/Model.php');

    if(file_exists('application/controllers/' . $URL[0] . '.php'))
    {
        require_once('application/controllers/' . $URL[0] . '.php');
    }

    if(file_exists('application/models/' . singularize($URL[0]) . '.php'))
    {
        require_once('application/models/' . singularize($URL[0]) . '.php');
    }

    switch(count($URL))
    {
        case 1:

            if(isset($URL[0]))
            {
                $URL[0] = pluralize($URL[0]);
                $controller = new $URL[0]($URL[0]);
                $params = [];

                if(method_exists($controller, 'index'))
                {
                     $params = $controller->index();
                }

                if(file_exists("application/views/{$URL[0]}/index.php"))
                {
                    $PARAMS[strtolower($URL[0])] = $params;
                    $PARAMS['url'] = ['controller' => $URL[0], 'action' => 'index'];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$URL[0]}/index.php");
                    require_once('application/views/layout/footer.php');
                }
            }

        break;

        case 2:

            if(isset($URL[0], $URL[1]))
            {
                $URL[0] = pluralize($URL[0]);
                $URL[1] = ($URL[1] === '') ? 'index' : $URL[1];
                $controller = new $URL[0]($URL[0], $URL[1]);
                $params = [];

                if(method_exists($controller, $URL[1]))
                {
                    $params = $controller->{$URL[1]}();
                }

                else if(method_exists($controller, 'show'))
                {
                    $params = $controller->show($URL[1]);
                }

                if(file_exists("application/views/{$URL[0]}/{$URL[1]}.php"))
                {
                    $PARAMS[strtolower($URL[0])] = $params;
                    $PARAMS['url'] = ['controller' => $URL[0], 'action' => $URL[1]];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$URL[0]}/{$URL[1]}.php");
                    require_once('application/views/layout/footer.php');
                }

                else if(is_numeric($URL[1]) && file_exists("application/views/{$URL[0]}/show.php"))
                {
                    $PARAMS[strtolower($URL[0])] = $params;
                    $PARAMS['url'] = ['controller' => $URL[0], 'action' => 'show', 'id' => $URL[1]];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$URL[0]}/show.php");
                    require_once('application/views/layout/footer.php');
                }
            }

        break;

        case 3:

            if(isset($URL[0], $URL[1], $URL[2]))
            {
                $URL[0] = pluralize($URL[0]);
                $URL[1] = ($URL[1] === '') ? 'index' : $URL[1];
                $controller = new $URL[0]($URL[0], $URL[2], $URL[1]);
                $params = [];

                if(method_exists($controller, $URL[2]))
                {
                    $params = $controller->{$URL[2]}($URL[1]);
                }

                if(file_exists("application/views/{$URL[0]}/{$URL[2]}.php"))
                {
                    $PARAMS[strtolower($URL[0])] = $params;
                    $PARAMS['url'] = ['controller' => $URL[0], 'action' => $URL[2], 'id' => $URL[1]];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$URL[0]}/{$URL[2]}.php");
                    require_once('application/views/layout/footer.php');
                }
            }

        break;
    }
}

exit;