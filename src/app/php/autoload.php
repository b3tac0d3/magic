<?php
if(empty($_SESSION)) session_start();

$depends = $_SESSION["Root"]["App"]["Dirs"]["Depends"];
$php = $_SESSION["Root"]["App"]["Dirs"]["Php"];

// PHP Scripts
RequireMulti(
    "short_map",
    "view",
    "controller",
    "model",
    "authorize",
    "session",
    "route",
    "error"
);

function RequireMulti($files) {
    global $php;
    global $depends;
    $files = func_get_args();
    foreach($files as $file)
        require_once($php . $file . ".php");
}