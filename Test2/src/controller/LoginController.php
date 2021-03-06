<?php

namespace controller;

require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");
require_once("src/view/MessageView.php");
require_once("src/view/CookieStorageView.php");

class LoginController {
    private $model;
    private $view;
    private $messages;
    private $autoLogin;

    public function getPostedUsername() {
        return $_POST["username"];;
    }

    public function getPostedPassword() {
        return $_POST["password"];;
    }

    // Constructor, connects all the layers
    public function __construct() {
        $this->model = new \model\LoginModel();
        $this->view = new \view\LoginView($this->model);
        $this->messages = new \view\MessageView();
        $this->autoLogin = new \view\CookieStorageView();
    }

    public function checkActions() {
        if($this->model->getLoginStatus() == false && isset($_COOKIE[$this->autoLogin->getCookieUsername()]) && isset($_COOKIE[$this->autoLogin->getCookieToken()]))
        {
            if ($this->autoLogin->autoLoginCreationDate($_COOKIE[$this->autoLogin->getCookieUsername()], $_COOKIE[$this->autoLogin->getCookieCreationDate()]) == true)
            {
                try
                {
                    // Checks the username and password in the model, to see that it exists.
                    $this->model->doAutoLogin($_COOKIE[$this->autoLogin->getCookieUsername()], $_COOKIE[$this->autoLogin->getCookieToken()]);
                    $this->messages->save("Login successful");
                    header('Location: index.php');
                    exit;
                }
                catch (\Exception $e)
                {
                    $this->messages->save("Felaktig information i cookie");
                    $this->autoLogin->autoLoginCookieRemove();
                }
            }
            else
            {
                $this->messages->save("Felaktig information i cookie");
                $this->autoLogin->autoLoginCookieRemove();
            }
        }

        // If a user tries to login, the input is checked and validated.
        if($this->view->onClickLogin())
        {
            if ($this->getPostedUsername() == "")
            {
                $this->messages->save("Username");
            }
            elseif ($this->getPostedPassword() == "")
            {
                $this->messages->save("Password");
            }
            else
            {
                try
                {
                    // Checks the username and password in the model, to see that it exists.
                    $this->model->doLogin($this->getPostedUsername(), $this->getPostedPassword());

                    // If the user wanted to be remembered a cookie with a hashed password is generated.
                    if(isset($_POST["stayLoggedIn"]))
                    {
                        $this->autoLogin->autoLoginCookie($this->getPostedUsername(), $this->model->retriveToken($this->getPostedUsername()));
                        $this->messages->save("Login successfull");
                        header('Location: index.php');
                        exit;
                    }

                    $this->messages->save("Login successfull");
                    header('Location: index.php');
                    exit;
                }
                catch (\Exception $e)
                {
                    $this->messages->save("Login successfull");
                }
            }
        }
        // If a user tries to logout, the session is returned to null.
        elseif ($this->view->onClickLogout())
        {
            $this->autoLogin->autoLoginCookieRemove();
            $this->model->doLogout();
            $this->messages->save("You have now logged out");
            header('Location: index.php');
            exit;
        }

        return $this->view->showPage();
    }
}