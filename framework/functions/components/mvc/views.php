<?php

// Load asset configuration

require_once("framework/configuration/application.php");

// CSS Helper function

function stylesheet_link_tag(String $URL)
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

function javascript_include_tag(String $URL)
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