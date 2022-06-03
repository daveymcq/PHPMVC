<?php

require_once('framework/initialize.php');

if(isset($_GET['url']))
{
    $PARAMS = [];
    
    $URL = explode("/", htmlentities($_GET['url']));

    $CONTROLLER = htmlentities(pluralize(trim($URL[0] ?? '')));
    $MODEL = htmlentities(singularize(trim($URL[0] ?? '')));
    $ACTION = htmlentities(trim($URL[1] ?? ''));
    $ID = htmlentities(trim($URL[2] ?? ''));

    require_once('application/controllers/Controller.php');
    require_once('application/models/Model.php');

    if(file_exists('application/controllers/' . $CONTROLLER . '.php'))
    {
        require_once('application/controllers/' . $CONTROLLER . '.php');
    }

    if(file_exists('application/models/' . $MODEL . '.php'))
    {
        require_once('application/models/' . $MODEL . '.php');
    }

    switch(count($URL))
    {
        case 1:

            if(isset($CONTROLLER))
            {
                $params = [];
                $controller = new $CONTROLLER($CONTROLLER);

                if(method_exists($controller, 'index'))
                {
                     $params = $controller->index();
                }

                if(file_exists("application/views/{$CONTROLLER}/index.php"))
                {
                    $controller = $CONTROLLER;
                    $action = 'index';

                    $PARAMS[strtolower($CONTROLLER)] = $params;
                    $PARAMS['url'] = ['controller' => $controller, 'action' => $action];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$CONTROLLER}/index.php");
                    require_once('application/views/layout/footer.php');
                }
            }

        break;

        case 2:

            if(isset($CONTROLLER, $ACTION))
            {
                $params = [];
                $controller = new $CONTROLLER($CONTROLLER, $ACTION);
                $action = ($ACTION === '') ? 'index' : $ACTION;

                if(method_exists($controller, $ACTION))
                {
                    $params = $controller->{$ACTION}();
                }

                else if(method_exists($controller, 'show'))
                {
                    $params = $controller->show($ACTION);
                }

                if(file_exists("application/views/{$CONTROLLER}/{$ACTION}.php"))
                {
                    $controller = $CONTROLLER;
                    $action = $ACTION;

                    $PARAMS[strtolower($controller)] = $params;
                    $PARAMS['url'] = ['controller' => $controller, 'action' => $action];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$CONTROLLER}/{$ACTION}.php");
                    require_once('application/views/layout/footer.php');
                }

                else if(is_numeric($ACTION) && file_exists("application/views/{$CONTROLLER}/show.php"))
                {
                    $controller = $CONTROLLER;
                    $action = 'show';
                    $id = $ACTION;

                    $PARAMS[strtolower($CONTROLLER)] = $params;
                    $PARAMS['url'] = ['controller' => $controller, 'action' => $action, 'id' => $id];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$CONTROLLER}/show.php");
                    require_once('application/views/layout/footer.php');
                }
            }

        break;

        case 3:

            if(isset($CONTROLLER, $ACTION, $ID))
            {
                $params = [];
                $controller = new $CONTROLLER($CONTROLLER, $ID, $ACTION);
                $action = ($ACTION === '') ? 'index' : $ACTION;

                if(method_exists($controller, $ID))
                {
                    $params = $controller->{$ID}($ACTION);
                }

                if(file_exists("application/views/{$CONTROLLER}/{$ID}.php"))
                {
                    $controller = $CONTROLLER;
                    $action = $ID;
                    $id = $ACTION;

                    $PARAMS[strtolower($controller)] = $params;
                    $PARAMS['url'] = ['controller' => $controller, 'action' => $action, 'id' => $id];

                    require_once('application/views/layout/header.php');
                    require_once("application/views/{$CONTROLLER}/{$ID}.php");
                    require_once('application/views/layout/footer.php');
                }
            }

        break;
    }
}

exit;