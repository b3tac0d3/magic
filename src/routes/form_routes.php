<?php

use Document\RouteClass;

$Route = new RouteClass();
$Controllers = sm::Dir("Controllers");
$Models = sm::Dir("Models");
$Script = str_replace("MagicForm/", "", $Route -> GetUri());

return match($Script){
    "UserLogin" => $Route -> RunScript($Controllers . "user")
    // "register_new_user" => $Route -> RunScript($Controllers . "user_registration.php"),
    // "user_delete" => $Route -> RunScript($Controllers . "user_registration.php")
};