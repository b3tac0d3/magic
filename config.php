<?php

$AppRootDir = "magic";
$AppName = "Magic";
$PageTitle = "Magic";
$LocalPort = "80"; // Leave blank for default port 80
$MySQLPort = "3306";
$AppUrl = "http://localhost";

// MySQL variables. Set here so all changes are made at top of file.
$MySQLHost = "localhost";
$MySQLDbName = "magic";
$MySQLUsername = "root";
$MySQLPassword = "root";

// -1 = Default to AppState settings. Any other value will allow overwriting of default AppState unless Live mode is engaged.
$DebugMode = -1;
$DebugLevel = -1;
$AppCache = -1;
$AppHeader = -1;

// Set AppState after dev options to give chance to change it
$AppState = GetAppState(AppState);

return array(
    /************
    Dev
    ************/
    "Dev" => array(
    /*    
        Set the AppState for dev purposes
        */
        "AppState" => $AppState,

        /*
        Used for dev only
        dev: $DebugMode = 1;
        prod: $DebugMode = 0;
        */
        "DebugMode" => $DebugMode,

        /*
        The type of errors you want to receive. Set to 0 for production.
        Debug Level
        0) Off
        1) [Low] Major errors only
        2) [Medium] Major errors and warnings
        3) [High] Major errors, warnings and notices (E-ALL)
        */
        "DebugLevel" => $DebugLevel,

        // Usually only used for Alpha Mode
        "AppHeader" => $AppHeader
    ), // $dev array

    /************
    App
    ************/
    "App" => array(
    /* App or site name */
        "AppName" => $AppName,

        /* Default page title */
        "PageTitle" => $PageTitle,

        /* App root directory */
        "AppRootDir" => $AppRootDir,

        /* Server environment */
        "AppEnv" => "linux",

        /* Base directory where Src file is located */
        "BaseDir" => $BaseDir = $_SERVER["DOCUMENT_ROOT"] . "/$AppRootDir",

        /* Base URL for site */
        "BaseUrl" => $BaseUrl = $AppUrl . (!empty($LocalPort) && $LocalPort != "80" ? ":" . $LocalPort : "") . "/" . $AppRootDir,

        // Sub-Directory for URL/URI purposes
        "BaseUriExt" => "$AppRootDir/",

        // Cache pages and scripts
        "AppCache" => $AppCache,

    /************
    Base URL Paths
    ************/
     "Urls" => array(

        "Base" => $BaseUrl . "/", // Redundant for simple shortspings functionality later

        "Src" => $Src = $BaseUrl . "/src/",

        "Views" => $Views = $Src . "views/",

        "Controllers" => $Src . "controllers/",

        "Models" => $Src . "models/",

        "App" => $App = $Src . "app/",

        "User" => $User = $Src . "user/",

        "Css" => $App . "css/",

        "Js" => $App . "js/",

        "Php" => $php = $App . "php/",

        "Img" => $App . "img/",

        "Forms" => $App . "forms/",

        "UserCss" => $User . "css/",

        "UserJs" => $User . "js/",

        "UserPhp" => $User . "php/",

        "UserImg" => $User . "img/",

        "UserForms" => $User . "forms/",

        "Plugins" => $PluginsUrl = $App . "plugins/",

        "Depends" => $DependsUrl = $App . "dependencies/",

        "Logs" => $App . "logs/",

        "Structure" => $Structure = $Src . "structure/",

        "Dom" => $Structure . "dom/",

        "Nav" => $Structure . "nav/",

        "Layouts" => $Structure . "layouts/"
    ), // "Url array


    /************
    Directories
    ************/
    "Dirs" => array(

        "Base" => $BaseDir . "/",
            
        "Src" => $Src = $BaseDir . "/src/",

        "Routes" => $Src . "routes/",

        "Views" => $Views = $Src . "views/",

        "Controllers" => $Src . "controllers/",

        "Models" => $Src . "models/",

        "App" => $App = $Src . "app/",

        "User" => $User = $Src . "user/",

        "Css" => $App . "css/",

        "Js" => $App . "js/",

        "Php" => $Php = $App . "php/",

        "Img" => $App . "img/",

        "Forms" => $App . "forms/",

        "UserCss" => $User . "css/",

        "UserJs" => $User . "js/",

        "UserPhp" => $User . "php/",

        "UserImg" => $User . "img/",

        "UserForms" => $User . "forms/",

        "Plugins" => $PluginsDir = $App . "plugins/",

        "Depends" => $DependsDir = $App . "dependencies/",

        "Logs" => $App . "logs/",

        "Structure" => $Structure = $Src . "structure/",

        "Dom" => $Structure . "dom/",

        "Nav" => $Structure . "nav/",

        "Layouts" => $Structure . "layouts/"
    ), // $dirs array

    /************
    Plugins Paths - Stand-alone plugins that containt depndencies which the framework is built with.
    ************/
    "Depends" => array(
        "Urls" => array(
            // SQL
            "Aces" => $DependsUrl . "aces-sql/",

            // Errors
            "Decks" => $DependsUrl . "decks/",

            // Logging
            "Flops" => $DependsUrl . "flops/",

            // Form Building
            "Folds" => $DependsUrl . "folds-forms/",

            // Ajax Quick Library
            "Spades" => $DependsUrl . "spades-ajax/"
        ), // Urls array
        "Dirs" => array(
            // SQL
            "Aces" => $DependsDir . "aces-sql/",

            // Errors
            "Decks" => $DependsDir . "decks/",

            // Logging
            "Flops" => $DependsDir . "flops/",

            // Form Building
            "Folds" => $DependsDir . "folds-forms/",

            // Ajax Quick Library
            "Spades" => $DependsDir . "spades-ajax/"
        ) // Dirs array
    ) // Plugins array
    ), // $App array

    /************
    db
    ************/
    "Db" => array(
        /* Connection Type */
        "Connection" => "mysql",

        /* Host name */
        "Host" => $MySQLHost,

        /* Default charset */
        "Charset" => "utf8mb4",

        /* Default port */
        "Port" => $MySQLPort,

        /* DataBase name */
        "Database" => $MySQLDbName,

        /* SQL user */
        "Username" => $MySQLUsername,

        /* SQL password */
        "Password" => $MySQLPassword
    ) // $db array
); // $fdn array




function GetAppState($AppState){
    global $DebugMode, $DebugLevel, $AppCache, $AppHeader;
    if($AppState == "Live"){
        $DebugMode = 0;
        $DebugLevel = 0;
        $AppCache = 1;
        $AppHeader = 0;
    }elseif($AppState == "Alpha"){
        if($DebugMode == -1) $DebugMode = 1;
        if($DebugLevel == -1) $DebugLevel = 3;
        if($AppCache == -1) $AppCache = 0;
        if($AppHeader == -1) $AppHeader = 1;
    }elseif($AppState == "Beta"){
        if($DebugMode == -1) $DebugMode = 1;
        if($DebugLevel == -1) $DebugLevel = 2;
        if($AppCache == -1) $AppCache = 0;
        if($AppHeader == -1) $AppHeader = 0;
    }
    SetDevOpts();
    return $AppState;
}

function SetDevOpts(){
    global $DebugMode, $DebugLevel, $AppCache, $AppHeader;
    // Cache
    if($AppCache == 0){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
    // Error checking
    if($DebugLevel == 3){
        ini_set("display_errors", "on");
        error_reporting(E_ALL);
    }elseif($DebugLevel == 2){
        ini_set("display_errors", "on");
        error_reporting(~E_ALL & ~E_NOTICE);
    }else{
        ini_set("display_errors", "off");
        error_reporting(~E_ALL);
    }
}