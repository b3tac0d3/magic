<?php

namespace Document;
use sm;

// Presto syntax is determined based on the contents of the file. The first line in the file should be @presto. If not, it will load as regualar HTML

class RouteClass{
    
    function __construct(){
        if(empty($_SESSION)) session_start();
    } // __construct()

    function View($FileName, $PassData = null, $RequestType = "get"){
        // Used for calling a view file directly with know controller, session or authorization needed.
        // PassData is used for passing data from the model to the view. It should always be done in json format
        // Make sure we have a valid file
        $FileName = $this -> CheckFileExists(sm::Dir("Views") . $FileName);
        new ViewClass($FileName);
    } // view()

    function Ctrl($FileName, $ModelName = null, $ClassName = null, $Function = null, $RequestType = "get"){
        // Used for calling a controller
        $ClassName = $ClassName ?: ucwords($FileName) . "Controller";
        $FileName = $this -> CheckFileExists(sm::Dir("Controllers") . $FileName);
        new ControllerClass($FileName, $ModelName, $Function, $ClassName);
    } // ctrl()

    function Sess(){
        // Used for checking a session before loading a logged-in or session file
    } // sess()

    function Auth(){
        // Used for broad page authorization through RBAC
    } // auth()

    function GetUri(){
        $uri = $_SERVER['REQUEST_URI'];
        
        if(strpos($uri, "?")){
            $uri = substr($uri, 1, (strpos($uri, "?") - 1));
        }else{
            $uri = substr($uri, 1);
        }

        // If using local server or sub-direcotry, this is the line to prepend the uri with the correct path information
        if(!empty($base_uri_ext = $_SESSION["Root"]["App"]["BaseUriExt"])) $uri = str_replace($base_uri_ext, "", $uri);
        
        return $uri;
    } // get_uri()

    private function CheckFileExists($FileName){
        // Start by parsing file name to replace dots with slashes. This is for simple routing
        $FileName = str_replace(".", "/", $FileName);
        if(is_dir($FileName)){ // Check if we have a directory first and default to index file if nothing is specified
            return $FileName . "/index.php";
        }elseif(is_file($FileName .= ".php")){ // Check if we have a files
            return $FileName;
        }else{ // Throw an error because it's not an existing dir or file
            $this -> SetError(404);
            return false;
        }
    } // check_file_existence()

    private function SetError($code, $ErrorStatus = true){
        if($code == 404){
            new ViewClass(sm::Dir("Views") . "errors/404.php");
            exit();
        }
    }

}