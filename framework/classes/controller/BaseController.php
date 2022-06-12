<?php 

class BaseController
{
    public $params;

    public function __construct(String $controller, String $action = null, $id = null)
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
        }

        else
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = (isset($action)) ? $action : 'index';
        }
    }
}