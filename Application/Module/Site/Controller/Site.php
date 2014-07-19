<?php

namespace App\Module\Site\Controller;

use System\Core\Controller;

class Site extends Controller
{
    public function index()
    {
        $this->assign('hello', '^_^');
        $this->display('index');
    }
}