<?php

require_once "../app/php/autoload.php";

use Document\RouteClass;

$Route = new RouteClass();
$Script = $_GET["script"];
$Path = sm::Dir("Models");

return match($Script){
    "UserLogin" => $Route -> RunScript($Path . "models/login.php")
    // "register_new_user" => $Route -> RunScript($Path . "user_registration.php"),
    // "user_delete" => $Route -> RunScript($Path . "user_registration.php")
};