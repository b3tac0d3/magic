<?php

namespace Aces;
use PDO;
use PDOException;

if(!defined("AcesConfig")) require_once($_SERVER['DOCUMENT_ROOT'] . "/src/app/plugins/aces/config.php");

class Db{
    private $Log;
    private $Db;

    function connect($DbName = null){
        $this -> Log = new Log();
        if(empty($_SESSION)) session_start();
        $Host = AcesDbHost;
        $Charset = AcesDbCharset;
        $Port = AcesDbPort;
        $User = AcesDbUser;
        $Pass = AcesDbPass;
        if(empty($Db_name)) $Db_name = AcesDbName;

        try{
            $this -> Db = new PDO("mysql:host=$Host;charset=$Charset;port=$Port;Dbname=$DbName", $User, $Pass);
        }catch(PDOException $e){
            // $this -> Log -> set_record("connection_error", ["error" => trim($e -> getMessage())]);
            echo $e -> getMessage();
            return;
        } // try

        $this -> Db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // If we've made it this far, Log the good connection
        $this -> Log -> set_record("connection", ["Database" => $DbName]);
        return $this -> Db;
    } // connect()
} // class Db

?>