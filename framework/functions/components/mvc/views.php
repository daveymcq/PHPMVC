<?php

// CSS Helper function

function stylesheet_link_tag(string $URL)
{
    if((isset($_SERVER['HTTPS'])) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) 
    {
        $STYLESHEETS_ASSETS_URL = 'https://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/stylesheets';

        if(explode('/', parse_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $STYLESHEETS_ASSETS_URL = 'https://' . $_SERVER['SERVER_NAME'] . '/' . '/application/assets/stylesheets';
        }
    }

    else 
    {
        $STYLESHEETS_ASSETS_URL = 'http://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/stylesheets';

        if(explode('/', parse_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $STYLESHEETS_ASSETS_URL = 'http://' . $_SERVER['SERVER_NAME'] . '/' . '/application/assets/stylesheets';
        }
    }

    $stylesheet = $STYLESHEETS_ASSETS_URL . '/' . trim(rtrim($URL, '.css')) . '.css';

    if(file_exists(stristr($stylesheet, 'application')))
    {
        $stylesheet_link_tag = '<link rel="stylesheet" href="' . $stylesheet . '">';
        echo $stylesheet_link_tag;
    }

    else
    {
        $stylesheet = trim(rtrim($URL, '.css')) . '.css';
        echo $stylesheet_link_tag = '<link rel="stylesheet" href="' . $stylesheet . '">';
    }

    return $stylesheet_link_tag;
}

// JavaScript Helper function

function javascript_include_tag(string $URL)
{
    if((isset($_SERVER['HTTPS'])) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) 
    {
        $JAVASCRIPTS_ASSETS_URL = 'https://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/javascripts';

        if(explode('/', parse_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $JAVASCRIPTS_ASSETS_URL = 'https://' . $_SERVER['SERVER_NAME'] . '/' . '/application/assets/javascripts';
        }
    }

    else 
    {
        $JAVASCRIPTS_ASSETS_URL = 'http://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/application/assets/javascripts';

        if(explode('/', parse_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $JAVASCRIPTS_ASSETS_URL = 'http://' . $_SERVER['SERVER_NAME'] . '/' . '/application/assets/javascripts';
        }
    }

    $javascript = $JAVASCRIPTS_ASSETS_URL . '/' . trim(rtrim($URL, '.js')) . '.js';

    if(file_exists(stristr($javascript, 'application')))
    {
        $javascript_include_tag = '<script src="' . $javascript . '"></script>';
        echo $javascript_include_tag;
    }

    else
    {
        $javascript = trim(rtrim($URL, '.js')) . '.js';
        echo $javascript_include_tag = '<script src="' . $javascript . '"></script>';
    }

    return $javascript_include_tag;
}

function error_messages_for(ActiveRecordModel $object)
{
    if(isset($_SESSION['VALIDATION_ERRORS'][get_class($object)]))
    {
        $errors = $_SESSION['VALIDATION_ERRORS'][get_class($object)];
        unset($_SESSION['VALIDATION_ERRORS'][get_class($object)]);

        foreach($errors as $error)
        {
            $error = '<p>* ' . ucfirst(implode(' ', explode('_', htmlentities($error)))) . '</p>';
            echo $error;
        }
    }
}

function route(string $url)
{
    if((isset($_SERVER['HTTPS'])) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) 
    {
        $route = htmlentities('https://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/' . $url);

        if(explode('/', parse_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $route = htmlentities('https://' . $_SERVER['SERVER_NAME'] . '/' . $url);
        }
    }

    else
    {
        $route = htmlentities('http://' . $_SERVER['SERVER_NAME'] . '/' . APPLICATION_ROOT . '/' . $url);

        if(explode('/', parse_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])['path'])[1] != APPLICATION_ROOT)
        {
            $route = htmlentities('http://' . $_SERVER['SERVER_NAME'] . '/' . $url);
        }
    }

    return $route;
}
