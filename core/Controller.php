<?php

class Controller
{
    public Array $params;

    public function __construct($controller, $action = null, $id = null)
    {
        if((isset($action) && ($id === null)) && ($action !== ''))
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = $action;

            if(file_exists("views/{$controller}/{$action}.php"))
            {
                @require_once("views/{$controller}/{$action}.php");
            }
        }

        else if((isset($action, $id)) && ($action !== '') && ($id !== ''))
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = $action;
            $this->params['id'] = $id;

            if(file_exists("views/{$controller}/{$action}.php"))
            {
                @require_once("views/{$controller}/{$action}.php");
            }
        }

        else
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = (isset($action)) ? $action : 'index';

            if(file_exists("views/{$controller}/{$this->params['action']}.php"))
            {
                @require_once("views/{$controller}/{$this->params['action']}.php");
            }
        }
    }
}