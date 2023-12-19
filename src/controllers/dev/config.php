<?php
use Document\ControllerClass;

class DevConfigController extends ControllerClass{

private $Output;

function __construct(){
    $this -> CreateOutput();
    $this -> AddViewData("content", $this -> Output);
}

function CreateOutput(){
    $this -> Output = 
        "<h2 class = 'title'>Server Variables</h2>".
        $this -> ListVars($_SERVER).
        "<h2 class = 'title'>Config Variables</h2>".
        $this -> ListVars($_SESSION["Root"]).
        "<h2 class = 'title'>Session Variables</h2>".
        $this -> ListVars($_SESSION);
    return;
}

function ListVars($Input){
    foreach($Input as $k => $v){
        if(is_array($v)){
            $this -> Output .= "<h3>{{$k}}</h3><div class = 'indent' title = '$k'>";
            $this -> ListVars($v);
            $this -> Output .= "</div>";
        }else{
            $this -> Output .= "<div class = 'li'>[$k] = $v</div>";
        }
    }
    return;
}
} // class DevConfigController
?>