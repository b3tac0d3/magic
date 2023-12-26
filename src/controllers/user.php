<?php

use Document\ControllerClass;
require_once sm::Dir("Models") . "user/login.php";
// require_once sm::Dir("Models") . "user/registration.php";

$Login = new User\UserLogin();

switch($_GET["Script"] ?? null){
    default:
    case "Logout":
        $Login -> Logout();
        break;
    case "UserLogin":
        $Login -> CheckUserLogin();
        break;
}

class UserClass extends ControllerClass{} // UserClass