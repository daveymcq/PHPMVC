<?php

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

function pluralize(string $singular)
{
    $plural = trim(htmlentities(singularize($singular)));

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

function singularize(string $plural)
{
    $singular = trim(htmlentities($plural));

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

function route(string $url)
{
    $route = htmlentities('/' . APPLICATION_ROOT . $url);
    return $route;
}

function validates_presence_of(ActiveRecordModel $object, string $attribute)
{
    return $object->validates_presence_of($attribute);
}

function validates_format_of(ActiveRecordModel $object, string $attribute, string $regex)
{
    return $object->validates_format_of($attribute, $regex);
}

function validates_length_of(ActiveRecordModel $object, string $attribute, int $minimum, int $maximum)
{
    return $object->validates_length_of($attribute, $minimum, $maximum);
}

function validates_uniqueness_of(ActiveRecordModel $object, string $attribute)
{
    return $object->validates_uniqueness_of($attribute);
}
