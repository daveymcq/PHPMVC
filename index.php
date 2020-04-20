<?php

require_once('initialize');

if(isset($_GET['url']))
{
    require_once('core/Controller.php');

    $url = explode("/", htmlentities($_GET['url']));

    @require_once(getcwd() .'/controllers/' . $url[0]. '.php');

    if(file_exists(getcwd() .'/models/' . singularize($url[0]). '.php'))
    {
        @require_once(getcwd() .'/models/' . singularize($url[0]). '.php');
    }

    $controller = null;
    $view = null;
    $id = null;

    switch(count($url))
    {
        case 1:
            $controller = new $url[0]($url[0]);

            if(method_exists($controller, 'index'))
            {
                 $view = $controller->index();
            }

        break;

        case 2:
            $url[1] = ($url[1] === '') ? 'index' : $url[1];
            $controller = new $url[0]($url[0], $url[1]);
            $view = null;
            
            if(method_exists($controller, $url[1]))
            {
                 $view = $controller->{$url[1]}();
            }

        break;

        case 3:
            $url[1] = ($url[1] === '') ? 'index' : $url[1];
            $controller = new $url[0]($url[0], $url[1], $url[2]);
            $view = null;

            if(method_exists($controller, $url[1]))
            {
                 $view = $controller->{$url[1]}($url[2]);
            }

        break;
    }
}

else
{
    header('Location: pages');
    exit(0);
}