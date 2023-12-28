<?php
session_start();

/////////////////////////////////////////////////////
// REMOVE FOR LIVE 
/////////////////////////////////////////////////////
require_once("preloader.php");

// Run preloader file if we need to do a reset
if(constant("ResetFoundation") == 1){
    $FileName = "preloader.php";
    $TempName = "preloader.php";

    $BaseFile = fOpen($FileName, "r") or die("Unable to Open file!");

    $Data = fread($BaseFile, filesize($FileName));
    $Data = str_replace(1, 0, $Data);

    $TempFile = fOpen($TempName, "w") or die("Unable to Open file!");
    fwrite($TempFile, $Data);

    fclose($BaseFile);
    fclose($TempFile);

    // Clear session info for clean slate
    $_SESSION = null;
    session_unset();
    session_destroy();

    // Clear server cache
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
}

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

/////////////////////////////////////////////////////
// END REMOVE FOR LIVE 
/////////////////////////////////////////////////////

/* 
Debugging is set up here instead of the autoload function because
the values can't change unless the setup.php file has been updated.
*/

// Set debugging informaiton from setup_vars
// Debug mode will not work if Dev mode is not active
if($_SESSION["Root"]["Dev"]["DebugMode"] == 1 || $_SESSION["Root"]["Dev"]["DevMode"] == 1){
    switch($_SESSION["Root"]["Dev"]["DebugLevel"]){
        default:
        case "0":
            ini_set("display_errors", "off");
            error_reporting(~E_ALL);
            break;
        case "1":
            ini_set("display_errors", "on");
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
            break;
        case "2":
            ini_set("display_errors", "on");
            error_reporting(~E_ALL & ~E_NOTICE);
            break;
        case "3":
            ini_set("display_errors", "on");
            error_reporting(E_ALL);
            break;
    } // case()
} // if

// If AppCache == 1, do nothing. Else, set no-cache mode
if(isset($SetupVars["AppCache"]) && $SetupVars["AppCache"] != 0){
    // Dev cache control
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

// Added to separate file so resources can be loaded on independent scripts (login, register, etc)
require_once $_SESSION["Root"]["App"]["Dirs"]["Php"] . "autoload.php";

// Final step is to call route file to direct traffic
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
?>