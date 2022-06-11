<?php

class Router 
{
    protected Array $URL;

    public function __construct(Array $URL)
    {
        $this->URL = $URL;
    }

    public function Get(String $from, String $to)
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $route = Router::MatchRoute($from, $to);
            return $route;
        }
    }

    public function Post(String $from, String $to)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $route = Router::MatchRoute($from, $to);
            return $route;
        }
    }

    private function MatchRoute(String $from, String $to)
    {
        $url = $this->URL;
        $from = explode("/", trim(rtrim(htmlentities($from)), '/'));
        $to = explode("/", trim(rtrim(htmlentities($to)), '/'));

        for($i = 0; $i < count($from); $i++)
        {
            if(!str_contains($from[$i], ':'))
            {
                if($url[$i] != $from[$i]) return false;
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
                if($to[$i])
                {
                    $url[$i] = $to[$i];
                }
            }
        }

        return $url;
    }
}