<?php

class Controller
{
    public $params;

    public function __construct($controller, $action = null, $id = null)
    {
        if((isset($action) && ($id === null)) && ($action !== ''))
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = $action;
        }

        else if((isset($action, $id)) && ($action !== '') && ($id !== ''))
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = $action;
            $this->params['id'] = $id;
            $_SESSION[strtolower(singularize($controller))]['id'] = $id;
        }

        else
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = (isset($action)) ? $action : 'index';
        }
    }

    public static function redirect_to($location)
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
    }
}
