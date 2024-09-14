<?php
use Document\ControllerClass;
// use DevConfigModel;

class DevConfigController extends ControllerClass{

function __construct(){
    $this -> GetModel("dev");
    $this -> Model = new DevConfigModel();
    $this -> AddViewData("Content", $this -> CreateOutput());
    $this -> GetView("dev.config");
} // __Construct()

function CreateOutput(){
    return 
        "<h2 class = 'title'>Server Variables</h2>".
        $this -> Model -> ListVars($_SERVER).
        "<h2 class = 'title'>Config Variables</h2>".
        $this -> Model -> ListVars($_SESSION["Root"]).
        "<h2 class = 'title'>Session Variables</h2>".
        $this -> Model -> ListVars($_SESSION);
} // CreateOutput()

} // class DevConfigController
?>