<?php

namespace User;
use Aces;
use Spades\Spades;
use User\SessionClass;

if(empty($_SESSION)) session_start();
require_once $_SESSION["fnd"]["app"]["dirs"]["php"] . "autoload.php";;

$login = new UserLogin();

switch($_GET["Script"] ?? null){
    default:
    case "Logout":
        $login -> Logout();
        break;
    case "UserLogin":
        $login -> CheckUserLogin();
        break;
}

class UserLogin{

    private $UserDataArray;

    private $InputUserName;

    private $InputPassword;

    private $InputRememberMe;

    private $UserRole;

    function CheckUserLogin(){

        $query_start_time = microtime(true);
    
        $this -> InputUserName = $_REQUEST["username"];
        $this -> InputPassword = $_REQUEST["password"];
        $this -> InputRememberMe = $_REQUEST["rememberMe"] ?? null;

        $Ajax = new Spades();

        // Check to make sure we don't have empty fields
        if(empty($this -> InputUserName) || empty($this -> InputPassword)){
            echo $Ajax -> QuickMessage("Please enter a username and a password to continue.");
            return;
        }

        // Get user info for verifying and logging
        $this -> QueryUserInfo($this -> InputUserName);

        if($this -> TestUserName() == false){
            // User not found. Create message and call it.
            $this -> AuditLogUserLogin(-1);
            echo $Ajax -> QuickMessage("Username or password not found.");
            return;
        }

        if($this -> TestUserPassword() == false){
            // User found but password bad. Create message and call it.
            $this -> AuditLogUserLogin(0);
            echo $Ajax -> QuickMessage("Username or password not found!");
            return;
        }

        // If we've made it this far, go ahread and log in
        
        // Log user login
        $this -> AuditLogUserLogin(1);

        // Set up session
        $session = new SessionClass();
        $session -> CreateUserSession($this -> InputUserName, $this -> UserDataArray["main_role"], $this -> UserDataArray["id"]);

        // Return the JSON to spades to finish jquery scripts
        $Ajax -> SetRedirect("dashboard");
        echo $Ajax -> MakeJson();
        
        return;
    } // CheckUserLogin()
    
    function QueryUserInfo($Username){
        $Db = new aces\query();
        $this -> UserDataArray = $Db -> SetWhere("username", $Username) -> SetFetch("1") -> Select("users");
    } // QueryUserInfo()

    function TestUserName(){
        return !empty($this -> UserDataArray) ? true : false;
    } // TestUserName()

    function TestUserPassword(){
        $DbHash = $this -> UserDataArray["password"];
        $Salt = $this -> UserDataArray["salt"];
        $Password = $this -> InputPassword . $Salt;
        return password_verify($Password, $DbHash) ? true : false;
    } // TestUserPassword()
    
    function AuditLogUserLogin($Status){
        /*
            Login Status: 
                -1 Bad User
                0 Bad Pass
                1 Success
        */
        $UserId = $this -> UserDataArray["id"] ?? null;
        $Username = $this -> InputUserName ?? null;
        $SessionId = $_SESSION["fnd"]["id"];
        $CreateIp = $_SERVER['REMOTE_ADDR'];

        $Columns = ["user_id", "username", "login_status", "create_sess_id", "create_ip"];
        $Values = [$UserId, $Username, $Status, $SessionId, $CreateIp];

        $Db = new Aces\Query();
        $Db -> SetInsertArray($Columns, $Values) -> Insert("log_UserLogins");
    } // AuditLogUserLogin

    function Logout(){
        $session = new SessionClass();
        $Ajax = new spades();

        $session -> EndUserSession();
        $Ajax -> SetRedirect("home");
        
        echo $Ajax -> MakeJson();
        return;
    }
} // class login