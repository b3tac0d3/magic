<?php

use Document\ControllerClass;

$Route = new Document\RouteClass();

match($Uri = $Route -> GetUri()){
    
    default => $Route -> View($Uri),

    "", "index", "home" => $Route -> View("home"),

    "dev/config" => $Route -> Ctrl("dev.config", ClassName: "DevConfigController")

};