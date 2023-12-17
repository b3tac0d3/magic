<?php
session_start();

// Only set foundation info if not already set
if(!isset($_SESSION["Root"]["Id"])){
    // Get control info from hard code lib file
    $SetupVars = require_once "config.php";

    // Set session with control variable data
    $_SESSION["Root"] = $SetupVars;

    // Set dynamic session info
    $_SESSION["Root"]["Open"] = time();
    $_SESSION["Root"]["Id"] = session_id();
}

ini_set("display_errors", "off");
error_reporting(~E_ALL);

// Added to separate file so resources can be loaded on independent scripts (login, register, etc)
require_once $_SESSION["Root"]["App"]["Dirs"]["Php"] . "autoload.php";

// Final step is to call route file to direct traffic
require_once "src/routes/routes.php";
?>