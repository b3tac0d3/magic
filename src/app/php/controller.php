<?php

namespace Document;
use sm;
use Document\RouteClass;

class ControllerClass{

private $File;
private $Controller;
private $Model;
private $FunctionName;
private $ViewData = array();

function __Construct($FileName = null, $ModelName = null, $FunctionName = null, $ClassName = null){
    $this -> SetController($this -> File = $FileName);
    if(!empty($ModelName)) $this -> SetModel($ModelName);
    if(!empty($ClassName)) $this -> SetClass($ClassName);
    if(!empty($FunctionName)) $this -> RunFunction($FunctionName);
} // Construct()

function SetController($FileName){
    require_once($FileName);
} // SetController()

function SetClass($ClassName, $FunctionName = null){
    $this -> Controller = new $ClassName;
} //SetClass()

function SetModel($ModelName){
    $this -> Model = $ModelName;
} // SetModel()

function RunFunction($FunctionName){
    $this -> FunctionName = $FunctionName;
    ($this -> Controller) -> $FunctionName();
} // RunFunction()

function AddViewData($Key, $Data){
    $this -> ViewData[$Key] = $Data;
    var_dump($this -> ViewData['content']);exit;
} // AddViewData()

function AppendViewData($Key, $Data){
    $this -> ViewData[$Key] .= $Data;
}

function GetView($FileName){
    $Route = new RouteClass();
    $Route -> View($FileName);
}


} // ControllerClass