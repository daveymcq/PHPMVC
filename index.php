<?php

if(isset($_GET['url']))
{
    $URL = explode("/", trim(htmlentities($_GET['url'])));
    
    if(file_exists('application/configuration/routes.php'))
    {
        require_once('framework/initialize.php');
        require_once('application/models/Model.php');
        require_once('application/controllers/Controller.php');

        $application_routes_file = 'application/configuration/routes.php'; 
        $application_routes = file_get_contents($application_routes_file, false, null, 5, strlen(file_get_contents($application_routes_file)));

        if($URL[0] == 'public')
        {
            $url = rtrim(implode('/', $URL), '/');

            if(!is_dir("application/{$url}"))
            {
                if(file_exists("application/{$url}"))
                {
                    $url = "application/{$url}";
                    echo file_get_contents($url);
                    exit;
                }
            }

            if(file_exists('application/public/404.html'))
            {
                $url = 'application/public/404.html';
                echo file_get_contents($url);
            }
            
            exit;
        }

        if($application_routes)
        {
            if(preg_match_all('/[\S]+/', $application_routes, $matches))
            {
                if(isset(end($matches)[1]))
                {
                    require_once('framework/classes/routing/router.php');
                    require_once($application_routes_file);

                    $appliaction_route_class = trim(htmlentities(end($matches)[1]));
                    $router = new $appliaction_route_class($URL);
                    $routes = get_class_methods($router);

                    unset($routes[array_search('__construct', $routes)]);
                    unset($routes[array_search('Root', $routes)]);
                    unset($routes[array_search('Post', $routes)]);
                    unset($routes[array_search('Get', $routes)]);
                    unset($routes[array_search('Put', $routes)]);

                    if(count($routes))
                    {
                        $URL = null;

                        foreach($routes as $route)
                        {
                            if($route = $router->{$route}())
                            {
                                $URL = $route;
                                break;
                            }
                        }

                        if($URL === null)
                        {
                            $url = 'application/public/404.html';

                            if(file_exists($url))
                            {
                                $page = file_get_contents($url);
                                echo $page;
                            }

                            exit;
                        }

                        $CONTROLLER = strtolower(htmlentities(pluralize(trim($URL[0] ?? ''))));
                        $ACTION = strtolower(htmlentities(trim($URL[1] ?? '')));
                        $ID = strtolower(htmlentities(trim($URL[2] ?? '')));
                        $MODEL = strtolower(singularize($CONTROLLER));

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

                                    if(($CONTROLLER == '') || (!file_exists("application/views/{$CONTROLLER}/index.php")))
                                    {
                                        $url = 'application/public/404.html';

                                        if(file_exists($url))
                                        {
                                            $page = file_get_contents($url);
                                            echo $page;
                                        }

                                        break;
                                    }

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

                                    if(($CONTROLLER == '') || ($ACTION == ''))
                                    {
                                        $url = 'application/public/404.html';

                                        if(file_exists($url))
                                        {
                                            $page = file_get_contents($url);
                                            echo $page;
                                        }

                                        break;
                                    }

                                    if(method_exists($controller, $ACTION))
                                    {
                                        $params = $controller->{$ACTION}();
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

                                    else
                                    {
                                        $url = 'application/public/404.html';

                                        if(file_exists($url))
                                        {
                                            $page = file_get_contents($url);
                                            echo $page;
                                        }
                                    }
                                }

                            break;

                            case 3:

                                if(isset($CONTROLLER, $ACTION, $ID))
                                {
                                    $params = [];
                                    $controller = new $CONTROLLER($CONTROLLER, $ID, $ACTION);

                                    if(($CONTROLLER == '') || ($ID == '') || ($ACTION == ''))
                                    {
                                        $url = 'application/public/404.html';

                                        if(file_exists($url))
                                        {
                                            $page = file_get_contents($url);
                                            echo $page;
                                        }

                                        break;
                                    }

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
                }
            }
        }
    }
}
