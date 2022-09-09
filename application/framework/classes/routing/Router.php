<?php

class Router 
{
    protected static array $URL;

    public function __construct(array $URL)
    {
        static::$URL = $URL;
    }

    public static function Get(string $from, string $to)
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $route = static::MatchRoute($from, $to);
            return $route;
        }
    }

    public static function Post(string $from, string $to)
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $route = static::MatchRoute($from, $to);
            return $route;
        }
    }

    public static function Put(string $from, string $to)
    {
        if($_SERVER['REQUEST_METHOD'] === 'PUT')
        {
            $route = static::MatchRoute($from, $to);
            return $route;
        }
    }

    private static function MatchRoute(string $from, string $to)
    {
        $url = static::$URL;
        $from = explode("/", trim(rtrim(htmlentities($from)), '/'));
        $to = explode("/", trim(rtrim(htmlentities($to)), '/'));

        for($i = 0; $i < count($from); $i++)
        {
            if(!str_contains($from[$i], ':'))
            {
                if((isset($url[$i])) && ($url[$i] != $from[$i])) return [];
            }
        }

        foreach($from as $key => $value)
        {
            if(str_contains($value, ':'))
            {
                $placeholder = ltrim($value, ':');
                $from[$key] = $placeholder;
            }
        }

        foreach($to as $key => $value)
        {
            if(str_contains($value, ':'))
            {
                $placeholder = ltrim($value, ':');

                for($i = 0; $i < count($from); $i++)
                {
                    if($from[$i] == $placeholder)
                    {
                        $to[$key] = $url[$i] ?? null;
                    }
                }
            }
        }

        if(count($to))
        {
            $url = [];

            for($i = 0; $i < count($to); $i++)
            {
                $url[$i] = $to[$i];
            }
        }

        if(count(static::$URL) > count($url)) {
            return [];
        }

        return $url;
    }
}
