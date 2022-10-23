<?php

if(isset($_GET['url']))
{
    $PARAMS = [];
    $REQUEST_URI = explode("/", trim(htmlentities($_GET['url'])));
    
    if(file_exists('application/configuration/routes.php'))
    {
        require_once('framework/configuration/initialize.php');
        require_once('application/controllers/Controller.php');
        require_once('application/models/Model.php');
        
        $application_routes_file = 'application/configuration/routes.php'; 
        $application_routes = file_get_contents($application_routes_file, false, null, 5, strlen(file_get_contents($application_routes_file)));

        if($REQUEST_URI[0] == 'public')
        {
            $REQUEST_URI = rtrim(implode('/', $REQUEST_URI), '/');

            if(!is_dir("application/{$REQUEST_URI}"))
            {
                if(file_exists("application/{$REQUEST_URI}"))
                {
                    $REQUEST_URI = "application/{$REQUEST_URI}";
                    echo file_get_contents($REQUEST_URI);
                    exit;
                }
            }

            if(file_exists('application/public/404.html'))
            {
                $REQUEST_URI = 'application/public/404.html';
                echo file_get_contents($REQUEST_URI);
            }
            
            exit;
        }

        if($application_routes)
        {
            if(preg_match_all('/[\S]+/', $application_routes, $matches))
            {
                if(isset(end($matches)[1]))
                {
                    require_once('framework/classes/routing/Router.php');
                    require_once($application_routes_file);

                    $appliaction_route_class = trim(htmlentities(end($matches)[1]));
                    $router = new $appliaction_route_class($REQUEST_URI);
                    $routes = get_class_methods($router);

                    $CONTROLLER = '';
                    $ACTION = '';
                    $MODEL = '';
                    $ID = '';

                    unset($routes[array_search('__construct', $routes)]);
                    unset($routes[array_search('match', $routes)]);
                    unset($routes[array_search('root', $routes)]);
                    unset($routes[array_search('post', $routes)]);
                    unset($routes[array_search('get', $routes)]);
                    unset($routes[array_search('put', $routes)]);

                    if(count($routes))
                    {
                        $matching_routes = [];
                        $routes_found = 0;
                        $route_index = 0;

                        foreach($routes as $route)
                        {
                            if($route = $router->{$route}($REQUEST_URI))
                            {
                                $matching_routes[] = $route;
                                $routes_found++;
                            }
                        }

                        if($routes_found === 0)
                        {
                            $REQUEST_URI = 'application/public/404.html';

                            if(file_exists($REQUEST_URI))
                            {
                                $page = file_get_contents($REQUEST_URI);
                                echo $page;
                            }

                            exit;
                        }

                        for($i = 0; $i < $routes_found; $i++) 
                        {
                            $REQUEST_URI = $matching_routes[$i];
                            $action = htmlentities(trim($REQUEST_URI[1] ?? ''));
                            $controller = htmlentities(pluralize(trim($REQUEST_URI[0] ?? '')));

                            if(method_exists(strtolower($controller), $action))
                            {
                                $route_index = $i;
                                break;
                            }

                            else if(method_exists(ucfirst($controller), $action))
                            {
                                $route_index = $i;
                                break;
                            }
                        }

                        if(count($REQUEST_URI) <= 3) 
                        {
                            switch(count($REQUEST_URI))
                            {
                                case 1:

                                    if(isset($REQUEST_URI[0]))
                                    {
                                        $params = [];
 
                                        $REQUEST_URI = $matching_routes[$route_index];

                                        $ACTION = htmlentities(trim($REQUEST_URI[1] ?? ''));
                                        $ID = strtolower(htmlentities(trim($REQUEST_URI[2] ?? '')));
                                        $MODEL = ucfirst(strtolower(singularize($REQUEST_URI[0] ?? '')));
                                        $CONTROLLER = htmlentities(pluralize(trim($REQUEST_URI[0] ?? '')));

                                        if(($CONTROLLER == '') || (!file_exists("application/views/{$CONTROLLER}/index.php")))
                                        {
                                            $REQUEST_URI = 'application/public/404.html';

                                            if(file_exists($REQUEST_URI))
                                            {
                                                $page = file_get_contents($REQUEST_URI);
                                                echo $page;
                                            }

                                            break;
                                        }

                                        if(file_exists('application/controllers/' . $CONTROLLER . '.php'))
                                        {
                                            require_once('application/controllers/' . $CONTROLLER . '.php');
                                        }

                                        if(file_exists('application/models/' . $MODEL . '.php'))
                                        {
                                            require_once('application/models/' . $MODEL . '.php');
                                        }

                                        if(method_exists(ucfirst($CONTROLLER), 'index'))
                                        {
                                            $controller_object = ucfirst($CONTROLLER);
                                            $controller = new $controller_object($CONTROLLER);
                                            $params = $controller->index($REQUEST_URI);
                                        }

                                        if(file_exists("application/views/{$CONTROLLER}/index.php"))
                                        {
                                            $controller = ucfirst($CONTROLLER);
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

                                    if(isset($REQUEST_URI[0], $REQUEST_URI[1]))
                                    {
                                        $params = [];
                                        
                                        $REQUEST_URI = $matching_routes[$route_index];

                                        $ACTION = htmlentities(trim($REQUEST_URI[1] ?? ''));
                                        $ID = strtolower(htmlentities(trim($REQUEST_URI[2] ?? '')));
                                        $MODEL = ucfirst(strtolower(singularize($REQUEST_URI[0] ?? '')));
                                        $CONTROLLER = htmlentities(pluralize(trim($REQUEST_URI[0] ?? '')));

                                        if(($CONTROLLER == '') || ($ACTION == ''))
                                        {
                                            $REQUEST_URI = 'application/public/404.html';

                                            if(file_exists($REQUEST_URI))
                                            {
                                                $page = file_get_contents($REQUEST_URI);
                                                echo $page;
                                            }

                                            break;
                                        }

                                        if(file_exists('application/controllers/' . $CONTROLLER . '.php'))
                                        {
                                            require_once('application/controllers/' . $CONTROLLER . '.php');
                                        }

                                        if(file_exists('application/models/' . $MODEL . '.php'))
                                        {
                                            require_once('application/models/' . $MODEL . '.php');
                                        }

                                        if(method_exists(ucfirst($CONTROLLER), $ACTION))
                                        {
                                            $controller_object = ucfirst($CONTROLLER);
                                            $controller = new $controller_object($CONTROLLER, $ACTION);
                                            $params = $controller->{$ACTION}($REQUEST_URI);
                                        }

                                        if(file_exists("application/views/{$CONTROLLER}/{$ACTION}.php"))
                                        {
                                            $controller = ucfirst($CONTROLLER);
                                            $action = $ACTION;

                                            $PARAMS[strtolower($controller)] = $params;
                                            $PARAMS['url'] = ['controller' => $controller, 'action' => $action];

                                            require_once('application/views/layout/header.php');
                                            require_once("application/views/{$CONTROLLER}/{$ACTION}.php");
                                            require_once('application/views/layout/footer.php');
                                        }

                                        else
                                        {
                                            $REQUEST_URI = 'application/public/404.html';

                                            if(file_exists($REQUEST_URI))
                                            {
                                                $page = file_get_contents($REQUEST_URI);
                                                echo $page;
                                            }
                                        }
                                    }

                                break;

                                case 3:

                                    if(isset($REQUEST_URI[0], $REQUEST_URI[1], $REQUEST_URI[2]))
                                    {
                                        $params = [];
 
                                        $REQUEST_URI = $matching_routes[$route_index];

                                        $ACTION = htmlentities(trim($REQUEST_URI[1] ?? ''));
                                        $ID = strtolower(htmlentities(trim($REQUEST_URI[2] ?? '')));
                                        $MODEL = ucfirst(strtolower(singularize($REQUEST_URI[0] ?? '')));
                                        $CONTROLLER = htmlentities(pluralize(trim($REQUEST_URI[0] ?? '')));

                                        if(($CONTROLLER == '') || ($ID == '') || ($ACTION == ''))
                                        {
                                            $REQUEST_URI = 'application/public/404.html';

                                            if(file_exists($REQUEST_URI))
                                            {
                                                $page = file_get_contents($REQUEST_URI);
                                                echo $page;
                                            }

                                            break;
                                        }

                                        if(file_exists('application/controllers/' . $CONTROLLER . '.php'))
                                        {
                                            require_once('application/controllers/' . $CONTROLLER . '.php');
                                        }

                                        if(file_exists('application/models/' . $MODEL . '.php'))
                                        {
                                            require_once('application/models/' . $MODEL . '.php');
                                        }

                                        if(method_exists(ucfirst($CONTROLLER), $ID))
                                        {
                                            $controller_object = ucfirst($CONTROLLER);
                                            $controller = new $controller_object($CONTROLLER, $ID, $ACTION);
                                            $params = $controller->{$ID}($ACTION, $REQUEST_URI);
                                        }

                                        if(file_exists("application/views/{$CONTROLLER}/{$ID}.php"))
                                        {
                                            $controller = ucfirst($CONTROLLER);
                                            $action = $ID;
                                            $id = $ACTION;

                                            $PARAMS[strtolower($controller)] = $params;
                                            $PARAMS['url'] = ['controller' => $controller, 'action' => $action, 'id' => $id];

                                            require_once('application/views/layout/header.php');
                                            require_once("application/views/{$CONTROLLER}/{$ID}.php");
                                            require_once('application/views/layout/footer.php');
                                        }

                                        else
                                        {
                                            $REQUEST_URI = 'application/public/404.html';

                                            if(file_exists($REQUEST_URI))
                                            {
                                                $page = file_get_contents($REQUEST_URI);
                                                echo $page;
                                            }
                                        }
                                    }

                                break;
                            }
                        }
                        
                        else
                        {
                            $params = [];

                            for($i = 0; $i < $routes_found; $i++) 
                            {
                                $REQUEST_URI = $matching_routes[$i];

                                $ACTION = htmlentities(trim($REQUEST_URI[1] ?? ''));
                                $ID = strtolower(htmlentities(trim($REQUEST_URI[2] ?? '')));
                                $MODEL = ucfirst(strtolower(singularize($REQUEST_URI[0] ?? '')));
                                $CONTROLLER = htmlentities(pluralize(trim($REQUEST_URI[0] ?? '')));

                                $query_string = [];
                                $index = 2;

                                while(isset($REQUEST_URI[$index]))
                                {
                                    $param_id = 'param_' . ($index - 2);
                                    $query_string[$param_id] = $REQUEST_URI[$index++];
                                }

                                if(file_exists('application/controllers/' . $CONTROLLER . '.php'))
                                {
                                    require_once('application/controllers/' . $CONTROLLER . '.php');
                                }

                                if(file_exists('application/models/' . $MODEL . '.php'))
                                {
                                    require_once('application/models/' . $MODEL . '.php');
                                }

                                if(method_exists(ucfirst($CONTROLLER), $ID))
                                {
                                    $QUERY_STRING = $query_string;
                                    $controller_object = ucfirst($CONTROLLER);
                                    $controller = new $controller_object($CONTROLLER, $ID, $ACTION, ...$QUERY_STRING);
                                    $params = $controller->{$ID}($ACTION, $REQUEST_URI);
                                }
                            }

                            if(($CONTROLLER == '') || ($ID == '') || ($ACTION == ''))
                            {
                                $REQUEST_URI = 'application/public/404.html';

                                if(file_exists($REQUEST_URI))
                                {
                                    $page = file_get_contents($REQUEST_URI);
                                    echo $page;
                                }

                                exit;
                            }

                            if(file_exists("application/views/{$CONTROLLER}/{$ID}.php"))
                            {
                                $controller = ucfirst($CONTROLLER);
                                $action = $ID;
                                $id = $ACTION;

                                $PARAMS[strtolower($controller)] = $params;
                                $PARAMS['url'] = ['controller' => $controller, 'action' => $action, 'id' => $id];
                                $PARAMS['url']['query_string'] = '';

                                foreach($query_string as $param => $value)
                                {
                                    $PARAMS['url']['query_string'] .= $value . '/';
                                }

                                require_once('application/views/layout/header.php');
                                require_once("application/views/{$CONTROLLER}/{$ID}.php");
                                require_once('application/views/layout/footer.php');
                            }
                        }
                    }
                }
            }
        }
    }
}
