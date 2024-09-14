<?php

require_once "../app/php/autoload.php";

$Route = new Document\RouteClass();

$Controllers = sm::Dir("Controllers");
$Models = sm::Dir("Models");

match($_REQUEST["Script"]){
    "UserLogin" => $Route -> RunScript(sm::Dir("UserPhp") . "login")
    // "register_new_user" => $Route -> RunScript($Controllers . "user_registration.php"),
    // "user_delete" => $Route -> RunScript($Controllers . "user_registration.php")
};