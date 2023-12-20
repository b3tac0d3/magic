<?php

namespace Document;
use sm;

class ErrorClass{

    private $ErrorStatus = false;
    
    function __Construct($ErrorStatus = false){
        if(!empty($ErrorStatus)) $this -> ErrorStatus = $ErrorStatus;
    } // __Construct()


    function SetError($code, $ErrorStatus = true){
        if($code == 404){
            new ViewClass(sm::Dir("Views") . "errors/404.php");
            exit();
        }
    } // SetError()

} // class ErrorClass