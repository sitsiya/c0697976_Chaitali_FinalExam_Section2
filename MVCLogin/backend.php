<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("loginController.php");

if(isset($_POST['action']))
{
    switch ($_POST['action'])
    {
        case "login":
        $controller = new loginController($_POST['userName'], $_POST['password']);
        echo $controller->Auth();
        break;
    }
    echo "Succesfully inserted!!!!";
}else{
        echo "Not Success........";
    }

?>
