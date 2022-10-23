<?php

class HttpRequestObject extends ActiveRecordModel
{
    public function __construct()
    {
        $PARAMS = self::GetController();
        $_SESSION['valid'] = false;
        
        if($PARAMS !== null)
        {
            if(is_array($PARAMS))
            {
                $HttpRequestObjects = [];

                foreach($PARAMS as $object)
                {
                    $HttpRequestObjects[] = $object;
                }

                $this->{strtolower(pluralize(get_class(end($PARAMS))))} = $HttpRequestObjects;
                $_SESSION['valid'] = true;
            }

            else
            {
                $attributes = get_object_vars($PARAMS);

                foreach($attributes as $attribute => $value)
                {
                    $this->{$attribute} = $value;
                }

                $_SESSION['valid'] = true;
            }

            return $this;
        }
    }

    public function valid()
    {
        return $_SESSION['valid'] ?? false;
    }

    private static function GetController()
    {
        global $PARAMS;
        return $PARAMS[strtolower($PARAMS['url']['controller'])];
    }
}
