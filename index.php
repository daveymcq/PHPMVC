<?php

if(isset($_GET['url']))
{
    require_once('core/Controller.php');

    $url = explode("/", htmlentities($_GET['url']));

    require_once(getcwd() .'/controllers/' . $url[0]. '.php');

    $controller = null;
    $view = null;
    $id = null;

    switch(count($url))
    {
        case 1:
            $controller = new $url[0]($url[0]);
        break;

        case 2:
            $url[1] = ($url[1] === '') ? 'index' : $url[1];
            $controller = new $url[0]($url[0], $url[1]);
            $view = $controller->{$url[1]}();
        break;

        case 3:
            $url[1] = ($url[1] === '') ? 'index' : $url[1];
            $controller = new $url[0]($url[0], $url[1], $url[2]);
            $view = $controller->{$url[1]}($url[2]);
        break;
    }
}

else
{
    header('Location: pages');
    exit(0);
}