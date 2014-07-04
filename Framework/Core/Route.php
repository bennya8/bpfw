<?php

namespace System\Core;

class Route extends Component
{
    protected $rules = array();

    protected $mode = 'pathinfo';

    protected $defaultModule = 'site';
    protected $defaultController = 'index';
    protected $defaultAction = 'index';

    protected $moduleParam = 'm';
    protected $controllerParam = 'c';
    protected $actionParam = 'a';

    protected $dispatch = array();
    protected $params = array();


    protected function pathinfo()
    {


    }

    protected function rewrite()
    {
    }

    protected function native()
    {
        $this->dispatch['module'] = isset($_GET['m']) && !empty($_GET['m']) ? $_GET['m'] : $this->defaultModule;
        $this->dispatch['controller'] = isset($_GET['c']) && !empty($_GET['c']) ? $_GET['c'] : $this->defaultController;
        $this->dispatch['action'] = isset($_GET['a']) && !empty($_GET['a']) ? $_GET['a'] : $this->defaultAction;
        unset($_GET['m']);
        unset($_GET['c']);
        unset($_GET['a']);
    }

    protected function sae()
    {


    }

    public function parseUrl()
    {
        switch (strtolower($this->mode)) {
            case 'pathinfo':
                $this->pathinfo();
                break;
            case 'rewrite':
                $this->rewrite();
                break;
            case 'sae':
                $this->sae();
                break;
            default:
                $this->native();
                break;
        }
    }

    public function buildUrl($path,$params = array())
    {
        $url = '';
        if(is_string()){

        }

    }



}