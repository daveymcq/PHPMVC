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
            require_once("views/{$controller}/{$action}.php");
        }

        else if((isset($action, $id)) && ($action !== '') && ($id !== ''))
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = $action;
            $this->params['id'] = $id;
            require_once("views/{$controller}/{$action}.php");
        }

        else
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = (isset($action)) ? $action : 'index';
            require_once("views/{$controller}/{$this->params['action']}.php");
        }

        return $this->index();
    }

    public function index() {}

    public function new() {}

    public function create() {}

    public function show($id) {}

    public function edit($id) {}

    public function update($id) {}

    public function delete($id) {}
}