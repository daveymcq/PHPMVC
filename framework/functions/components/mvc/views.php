<?php

// CSS Helper function

function stylesheet_link_tag(string $URL)
{
    $stylesheet = STYLESHEETS_ASSETS_URL . '/' . trim(rtrim($URL, '.css')) . '.css';

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
    $javascript = JAVASCRIPTS_ASSETS_URL . '/' . trim(rtrim($URL, '.js')) . '.js';

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
    $route = htmlentities('/' . APPLICATION_ROOT . $url);
    return $route;
}
