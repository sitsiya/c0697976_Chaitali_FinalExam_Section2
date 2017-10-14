<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("loginModel.php");

class loginController
{
    var $userName;
    var $password;
    
    public function __construct($u, $p)
    {
        $this->userName = $u;
        $this->password = $p;
    }
    
    public function Auth()
    {
        $model = new loginModel();
        $authStatus = $model->AuthModel($this->userName, $this->password);
        if($authStatus["status"] == "success")
        {
            //return "Hi, ".$authStatus["name"];
            $view['Success'] = "Hi, ".$authStatus["name"];
        }
        else
        {
            //return "Authentication Failure.<br/>".$authStatus["reply"];
            $view['Error'] = "Authentication Failure.<br/>".$authStatus["reply"];
        }
        ob_flush();
        include("loginView.php");
    }
}
