<?php
namespace System\Core;


class Security extends Component
{
    public function checkToken(){
        if($this->enable){

        }
        $response = $this->getDI('response');


        $response = Application::DI('#response');
        $session = Application::DI('#session');
        $response->isPost();
        $token_key = $response->getParam('token_key');

        if($token_key){

        }


    }
    public function setToken(){}


}