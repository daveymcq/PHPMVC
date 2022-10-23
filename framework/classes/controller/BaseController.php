<?php 

class BaseController
{
    protected array $params;

    public function __construct(string ...$attributes)
    {
        $controller = $attributes[0] ?? '';
        $action = $attributes[1] ?? '';
        $id = $attributes[2] ?? '';

        if((isset($action) && ($id == '')) && ($action != ''))
        {
            $this->params['controller'] = $controller;
            $this->params['action'] = $action;
        }

        else if((isset($action, $id)) && ($action != '') && ($id != ''))
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

        if(count($attributes) > 3)
        {
            for($i = 2; $i < count($attributes); $i++)
            {
                $param_id = array_keys($attributes)[$i];
                $this->params['query_string'] = $attributes[$param_id];
            }
        }
    }
}
