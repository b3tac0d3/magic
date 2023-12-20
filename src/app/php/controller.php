<?php

namespace Document;
use sm;
use Document\RouteClass;

class ControllerClass{

private $File;
private $Controller;
public $Model;
private $Function;
private $ViewFile;
private $ViewData = array();

function __Construct($File = null, $ViewFile = null, $Class = null, $Function = null){
    var_dump($ViewFile);
    $this -> SetController($this -> File = $File);
    if(!empty($Class)) $this -> SetClass($Class);
    if(!empty($Function)) $this -> RunFunction($Function);
    if(!empty($ViewFile)) 
        $this -> ViewFile = $ViewFile;
    else
        $this -> ViewFile = $File;
} // Construct()

function SetController($File){
    require_once($File);
} // SetController()

function SetClass($Class, $Function = null){
    $this -> Controller = new $Class;
} //SetClass()

function RunFunction($Function){
    $this -> Function = $Function;
    ($this -> Controller) -> $Function();
} // RunFunction()

function AddViewData($Key, $Data){
    if(isset($this -> ViewData[$Key])){
        $this -> ViewData[$Key] .= $Data;
    }else{
        $this -> ViewData[$Key] = $Data;
    }
} // AddViewData()

function GetModel($Model){
    $Model = sm::Dir("Models") . str_replace(".", "/", $Model) . ".php";
    require_once($Model);
} // GetModel()

function GetView($File){
    if(empty($File)) $File = $this -> ViewFile;
    $Route = new RouteClass();
    $Route -> View($File, $$this -> ViewData);
}


} // class ControllerClass