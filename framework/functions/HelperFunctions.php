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

function redirect_to($location)
{
    $url = APPLICATION_ROOT . '/' . $location;

    if(is_array($location))
    {
        $url = APPLICATION_ROOT;

        if(isset($location['controller']))
        {
            $controller = "{$location['controller']}";
            $url .= "/{$controller}";

            if(isset($location['action']))
            {
                $url .= "/{$location['action']}";

                if(isset($location['id']))
                {
                    $url .= "/{$location['id']}";
                }
            }
        }
        else
        {
            return false;
        }
    }

    header("Location: /{$url}");
    exit(0);
}