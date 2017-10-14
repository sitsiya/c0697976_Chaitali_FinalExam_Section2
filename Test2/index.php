<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">

h1{
color: Darkblue;

}
label{

color: green;
}

</style>
</head>
<body style=background-image: url(bg.jpg) >
<?php

require_once(dirname(__FILE__) . "/common/HTMLview.php");
require_once(dirname(__FILE__) . "/src/controller/LoginController.php");

session_start();

// Making the session contain info of what browser started the session, to prevent hijacking of session.
if(!isset($_SESSION["httpAgent"]))
{
    $_SESSION["httpAgent"] = $_SERVER["HTTP_USER_AGENT"];
}

$view = new HTMLView();
$ctrl = new \controller\LoginController();

$htmlBody = $ctrl->checkActions();

$view->echoHTML($htmlBody);
?>
</body>
</html>