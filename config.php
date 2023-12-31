<?php

$AppName = "magic";
$LocalPort = "8888"; // Leave blank for default port 80
$MySQLPort = "8889";
$AppUrl = "http://localhost";

$DevMode = 1;
$DebugMode = 1;
$DebugLevel = 3;
$AppCache = 0;

return array(
/************
Dev
************/
"Dev" => array(
/*    
Set for dev only. Must be set to 0 in prod. If set to 0, debug mode will not work.
- If a hard change is made to foundation variables during dev, change $reset_foundatoin to true for changes to take effect on next page load.
- If FOUNDATION[DEV][DEV_MODE] is set to true, foundation will automatically reset on each page load.
*/
"DevMode" => $DevMode,

/*
Used for dev only.
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
"DebugLevel" => $DebugLevel
), // $dev array

/************
App
************/
"App" => array(
/* App or site name */
"AppName" => $AppName,

/* Server environment */
"AppEnv" => "linux",

/* Base directory where Src file is located */
"BaseDir" => $BaseDir = $_SERVER["DOCUMENT_ROOT"] . "/$AppName",

/* Base URL for site */
"BaseUrl" => $BaseUrl = $AppUrl . (!empty($LocalPort) && $LocalPort != "80" ? ":" . $LocalPort : "") . "/" . $AppName,

// Sub-Directory for URL/URI purposes
"BaseUriExt" => "$AppName/",

// Cache pages and scripts
"AppCache" => $AppCache,

/************
Base URL Paths
************/
"Urls" => array(

"Base" => $BaseUrl . "/", // Redundant for simple shortspings functionality later

"Src" => $Src = $BaseUrl . "/src/",

"Views" => $Src . "views/",

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

$PluginsUrl = "Plugins" => $App . "plugins/",

"Depends" => $App . "dependencies/",

"Logs" => $App . "logs/"
), // "Url array


/************
Directories
************/
"Dirs" => array(

"Base" => $BaseDir . "/",
    
"Src" => $Src = $BaseDir . "/src/",

"Routes" => $Src . "routes/",

"Views" => $Src . "views/",

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

$PluginsDir = "Plugins" => $App . "plugins/",

"Depends" => $App . "dependencies/",

"Logs" => $App . "logs/"
), // $dirs array

/************
Plugins Paths - Stand-alone plugins that containt depndencies which the framework is built with.
************/
"Plugins" => array(
    "Urls" => array(
        // SQL
        "Aces" => $PluginsUrl . "aces/",

        // Errors
        "Decks" => $PluginsUrl . "decks/",

        // Logging
        "Flops" => $PluginsUrl . "flops/",

        // Form Building
        "Folds" => $PluginsUrl . "folds/",

        // Ajax Quick Library
        "Spades" => $PluginsUrl . "spades/"
    ), // Urls array
    "Dirs" => array(
        // SQL
        "Aces" => $PluginsDir . "aces/",

        // Errors
        "Decks" => $PluginsDir . "decks/",

        // Logging
        "Flops" => $PluginsDir . "flops/",

        // Form Building
        "Folds" => $PluginsDir . "folds/",

        // Ajax Quick Library
        "Spades" => $PluginsDir . "spades/"
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
"Host" => "localhost",

/* Default charset */
"Charset" => "utf8mb4",

/* Default port */
"Port" => $MySQLPort,

/* DataBase name */
"Database" => "cards",

/* SQL user */
"Username" => "root",

/* SQL password */
"Password" => "root"
) // $db array
); // $fdn array