<?php

function pluralize($quantity, $singular, $plural = null)
{
    if($quantity == 1 || !strlen($singular)) return $singular;
    if($plural !== null) return $plural;

    $last_letter = strtolower($singular[strlen($singular) - 1]);

    switch($last_letter)
    {
        case 'y':
            return substr($singular, 0, -1) . 'ies';
        case 's':
            return $singular . 'es';
        default:
            return $singular . 's';
    }
}

function singularize(String $plural)
{
    $singular = $plural;

    if(substr($plural, 0, -3) === 'ies')
    {
        $singular = substr($plural, 0, -3);
        $singular .= 'y';
    }

    else if(substr($plural, 0, -2) === 'es')
    {
        $singular = substr($plural, 0, -2);
        $singular .= 's';
    }

    else
    {
        $singular = substr($plural, 0, -1);
    }

    return $singular;
}