<?php

$Route = new Document\RouteClass();

match($Uri = $Route -> GetUri()){
    
    default => $Route -> View($Uri),

    "", "index", "home" => $Route -> Ctrl("home")

};