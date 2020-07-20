<?php

function pluralize($singular)
{
    if(strlen($singular))
    {

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

    return $singular;
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

    else
    {
        $singular = substr($plural, 0, -1);
    }

    return $singular;
}

function redirect_to($location)
{
    $url = $location;

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
}
