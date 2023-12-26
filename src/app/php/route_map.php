<?php
/*
    NOT THE SAME AS THE ROUTE FILE. THIS FILE IS SPECIFICALLY FOR PARSING ROUTES AND
    SENDING TO THE CORRECT ROUTES FILE TO PROCESS THE REQUEST. THIS FILE RUNS AUTOMATCIALLY
    AND SHOULD NEVER HAVE TO BE INCLUDED ANYWHERE ELSE. IT'S CALLED DIRECTLY FROM THE 
    PRIMARY INDEX FILE WHERE THE .HTACCESS FILE SENDS ALL REQUESTS TO.
*/

$RouteClass = new Document\RouteClass();

$Uri = $RouteClass -> GetUri();
$Dir = sm::Dir("Routes");

if(str_contains($Uri, "MagicForm/")){
    $File = "form_routes.php";
}elseif(str_contains($Uri, "MagicScript/")){
    $File = "script_routes.php";
}else{
    $File = "routes.php";
}

require_once $Dir . $File;