<?php
session_start();

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class loginModel
{
    public function AuthModel($userName, $password)
    {
        mysql_connect("localhost","root","");
		mysql_select_db("test");
        
        $query = "select * from user where email = '$userName'";
        $result = mysql_query($query);
        
        if(mysql_num_rows($result) > 0)
        {
            $row = mysql_fetch_array($result, MYSQLI_ASSOC);
            if($password == $row['password'])
            {
                $_SESSION['userId'] = $row['id'];
                return array("status" => "success", "name" => $row['fname']);
            }
            else
                return array("status" => "failure", "reply" => "Password Mismatch");
        }
        else
            return array("status" => "failure", "reply" => "Email ID Not Found.");
    }
}
