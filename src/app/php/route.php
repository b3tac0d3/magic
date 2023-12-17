<?php

namespace Document;
use sm;

// Presto syntax is determined based on the contents of the file. The first line in the file should be @presto. If not, it will load as regualar HTML

class RouteClass{
    
    private $ViewFileUrl;
    private $ViewsPath;
    private $ControllersPath;
    private $ControllersFileUrl;
    private $SrcPath;

    function __construct(){
        if(empty($_SESSION)) session_start();
        $this -> SrcPath = sm::Dir("Src");
        $this -> ViewsPath = $this -> ViewFileUrl = sm::Dir("Views");
        $this -> ControllersPath = $this -> ControllersFileUrl = sm::Dir("Controllers");
    } // __construct()

    function View($FileName, $RequestType = "get"){
        // Used for calling a view file directly with know controller, session or authorization needed.
        // Make sure we have a valid file
        $this -> CheckViewFileExists($FileName);
        new ViewClass($this -> ViewFileUrl);
    } // view()

    function Ctrl($FileName, $Function = null, $RequestType = "get"){
        // Used for calling a controller
        // $this -> CheckFileExists($FileName);
        // new ControllerClass($this -> ControllerFileUrl);
    } // ctrl()

    function Sess(){
        // Used for checking a session before loading a logged-in or session file
    } // sess()

    function Auth(){
        // Used for broad page authorization through RBAC
    } // auth()

    function CheckViewFileExists($FileName){
        // Structure the URL
        $this -> ViewFileUrl .= $FileName;

        // Check if we have a directory first and default to index file if nothing is specified
        if(is_dir($this -> ViewFileUrl)){
            $this -> ViewFileUrl .= "/index.php";
            return true;
        // Check if we have a files
        }elseif(is_file($this -> ViewFileUrl .= ".php")){
            return true;
        // Throw an error because it's not an existing dir or file
        }else{
            // Throw error here and return nothing
            $this -> SetError(404);
            return false;
        }
    } // check_file_existence()

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

    private function SetError($code, $SetErrorStatus = true){
        if($code == 404){
            new ViewClass($this -> ViewsPath . "errors/404.php");
            exit();
        }
    }

}