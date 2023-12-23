<?php 

$aces_doc_root = $_SERVER["DOCUMENT_ROOT"];
// Use if log directory is the same for all
$aces_log_directory = "logs/";

// Master config file for aces
define("AcesConfig", 1); // DO NOT CHANGE

// Database conneection info
define("AcesDbHost", $_SESSION['Root']['Db']['Host']);
define("AcesDbCharset", $_SESSION['Root']['Db']['Charset']);
define("AcesDbPort", $_SESSION['Root']['Db']['Port']);
define("AcesDbName", $_SESSION['Root']['Db']['Database']);
define("AcesDbUser", $_SESSION['Root']['Db']['Username']);
define("AcesDbPass", $_SESSION['Root']['Db']['Password']);

// Turn file logs on or off
define("AcesLogStatusQuery", true); // Query log on or off (true | false)
define("AcesLogStatusConnection", true); // Connection log on or off (true | false)
define("AcesLogStatusError", true); // Error log on or off (true |)

// Log file paths (directories)
define("AcesLogFileDirQuery", $aces_doc_root . $aces_log_directory); // Query log file location
define("AcesLogFileDirConnection", $aces_doc_root . $aces_log_directory); // Connection log file location
define("AcesLogFileDirQueryError", $aces_doc_root . $aces_log_directory); // Query error log file location
define("AcesLogFileDirConnectionError", $aces_doc_root . $aces_log_directory); // Connection error log file location

// Log options
// How long until starting a new log
define("AcesLogTimeLimitQuery", "M"); // Default to monthly - "W" (Weekly) | "M" (Monthly) | "Q" (Quarterly) | "Y" (Yearly)
define("AcesLogTimeLimitConnection", "M"); // Default to monthly - "W" (Weekly) | "M" (Monthly) | "Q" (Quarterly) | "Y" (Yearly)

// Database record logging options
define("AcesDbRecordLoggingLife", true); // Set to false if you don't want to log record create and delete records in the database
define("AcesDbRecordLoggingEdits", true); // Set to false if you don't want to log record edits and values in the database

?>