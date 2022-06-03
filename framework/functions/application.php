<?php

function pluralize(String $singular)
{
    $plural = singularize($singular);

    if(substr($plural, strlen($plural) - 1, strlen($plural)) === 'y')
    {
        $plural = substr($plural, 0, -1);
        $plural .= 'ies';
    }

    else if(substr($plural, strlen($plural) - 1, strlen($plural)) === 's')
    {
        $plural = substr($plural, 0, -1);
        $plural .= 'es';
    }

    else
    {
        $plural .= 's';
    }

    return $plural;
}

function singularize(String $plural)
{
    $singular = $plural;

    if(substr($plural, strlen($plural) - 3, strlen($plural)) === 'ies')
    {
        $singular = substr($plural, 0, -3);
        $singular .= 'y';
    }

    else if(substr($plural, strlen($plural) - 2, strlen($plural)) === 'es')
    {
        $singular = substr($plural, 0, -2);
        $singular .= 's';
    }

    else if(substr($plural, strlen($plural) - 1, strlen($plural)) === 's')
    {
        $singular = substr($plural, 0, -1);
    }

    return $singular;
}