<?php

require_once('initialize');

if(isset($_GET['url']))
{
    $_PARAMS = [];
    $_MESSAGE = [];

    $url = explode("/", htmlentities($_GET['url']));

    @require_once('core/Controller.php');
    @require_once(getcwd() .'/controllers/' . $url[0]. '.php');

    if(file_exists(getcwd() .'/models/' . singularize($url[0]). '.php'))
    {
        @require_once(getcwd() .'/models/' . singularize($url[0]). '.php');
    }

    switch(count($url))
    {
        case 1:
            $controller = new $url[0]($url[0]);

            if(method_exists($controller, 'index'))
            {
                 $params = $controller->index();

                 if(file_exists("views/{$url[0]}/index.php"))
                 {
                     $_PARAMS[strtolower(singularize($url[0]))] = $params;
                     @require_once("views/{$url[0]}/index.php");
                 }
            }
            else
            {
                echo "No action exists for {$url[0]}/index";
            }

        break;

        case 2:
            $url[1] = ($url[1] === '') ? 'index' : $url[1];
            $controller = new $url[0]($url[0], $url[1]);

            if(method_exists($controller, $url[1]))
            {
                 $params = $controller->{$url[1]}();

                 if(file_exists("views/{$url[0]}/{$url[1]}.php"))
                 {
                     $_PARAMS[strtolower(singularize($url[0]))] = $params;
                     @require_once("views/{$url[0]}/{$url[1]}.php");
                 }
            }
            else
            {
                echo "No action exists for {$url[0]}/{$url[1]}.";
            }

        break;

        case 3:
            $url[1] = ($url[1] === '') ? 'index' : $url[1];
            $controller = new $url[0]($url[0], $url[1], $url[2]);

            if(method_exists($controller, $url[1]))
            {
                 $params = $controller->{$url[1]}($url[2]);

                 if(file_exists("views/{$url[0]}/{$url[1]}.php"))
                 {
                     $_PARAMS[strtolower(singularize($url[0]))] = $params;
                     @require_once("views/{$url[0]}/{$url[1]}.php");
                 }
            }
            else
            {
                echo "No action exists for {$url[0]}/{$url[1]}/{$url[2]}.";
            }

        break;
    }
}

else
{
    header('Location: pages');
    exit(0);
}
