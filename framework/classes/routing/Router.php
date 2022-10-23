<?php

class Router 
{
    protected static array $URL;

    public function __construct(array $URL)
    {
        static::$URL = $URL;
    }

    public static function get(string $to)
    {
        $route = static::match($to, $to, 'get');
        return $route;
    }

    public static function post(string $to)
    {
        $route = static::match($to, $to, 'post');
        return $route;
    }

    public static function put(string $to)
    {
        $route = static::match($to, $to, 'put');
        return $route;
    }

    public static function root(string $to, string $request_via = 'get')
    {
        $route = static::match('/', $to, $request_via);
        return $route;
    }    

    public static function match(string $from, string $to, string $request_via = 'get')
    {
        if(strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($request_via))
        {
            $url = static::$URL;
            $to = explode("/", trim(rtrim(htmlentities($to)), '/'));
            $from = explode("/", trim(rtrim(htmlentities($from)), '/'));

            if(!((count($url) === 2) && (($url[0] === '') && ($url[1] === ''))))
            {
                $to = (count($url) === count($from)) ? $to : [];

                if(count($to)) 
                {
                    $placeholders = 0;

                    for($i = 0; $i < count($from); $i++)
                    {
                        if(!str_contains($from[$i], ':'))
                        {
                            if((isset($url[$i])) && ($url[$i] != $from[$i])) 
                            {
                                $to = [];
                                break;
                            }
                        }

                        else
                        {
                            $placeholders++;
                        }
                    }

                    if($placeholders > 0)
                    {
                        for($i = 0; $i < count($to); $i++)
                        {
                            if(str_contains($to[$i], ':'))
                            {
                                for($j = 0; $j < count($from); $j++)
                                {
                                    if($from[$j] == $to[$i])
                                    {
                                        $to[$i] = $url[$j] ?? '';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            return $to;
        }
    }
}
