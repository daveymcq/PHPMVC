<?php

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

