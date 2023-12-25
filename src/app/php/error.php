<?php

namespace Document;
use sm;

class ErrorClass{

    private $ErrorStatus = false;
    
    function __Construct($ErrorStatus = false){
        if(!empty($ErrorStatus)) $this -> ErrorStatus = $ErrorStatus;
    } // __Construct()


    function SetError($Code, $ErrorMessage = null, $ErrorStatus = true){
        $Errors = sm::Dir("Views") . "errors/";
        switch($Code){
            case 404:
                new ViewClass($Errors . "404.php");
                break;
            case "Auth":
                new ViewClass($Errors . "auth.php");
                break;
            case "Sess":
                new ViewClass($Errors . "session.php");
                break;
        }
        exit;
    } // SetError()

} // class ErrorClass