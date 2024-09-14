<?php

require_once "../app/php/autoload.php";

use Document\RouteClass;

$Route = new RouteClass();
$Script = $_GET["Script"];

return match($Script){
    "Logout" => $Route -> RunScript(sm::Dir("UserPhp") . "login")
};