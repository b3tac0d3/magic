<?php

namespace user;
use aces;
use spades\spades;

if(empty($_SESSION)) session_start();
require_once $_SESSION["fnd"]["app"]["dirs"]["php"] . "autoload.php";;

$reg = new user_registration();

switch($_REQUEST["script"] ?? null){
    default:
    case "register_new_user":
        $reg -> register_user();
        break;
    case "user_delete":
        $reg -> delete_user();
        break;
}

class user_registration{

    private $username;
    private $password;
    private $password_confirm;
    private $fname;
    private $lname;

    function register_user(){
        $this -> username = trim($_REQUEST["username"]);
        $this -> password = trim($_REQUEST["password"]);
        $this -> password_confirm = trim($_REQUEST["password_confirm"]);
        $this -> fname = trim($_REQUEST["fname"]);
        $this -> lname = trim($_REQUEST["lname"]);

        $ajax = new spades();
        
        // Validate all information has been filled out
        if(
        empty($this -> username) ||
        empty($this -> password) ||
        empty($this -> password_confirm) ||
        empty($this -> fname) ||
        empty($this -> lname)){
            echo $ajax -> quickMsg("Please fill out all fields");
            return;
        }

        // Validate user name length
        if(strlen($this -> username) < 5){
            echo $ajax -> quickMsg("Username must be longer than 5 characters");
            return;
        }

        // Validate password length
        if(strlen($this -> password) < 6){
            echo $ajax -> quickMsg("Password must be at least 6 characters long");
            return;
        }

        // Validate passwords match
        if($this -> password != $this -> password_confirm){
            echo $ajax -> quickMsg("Passwords don't match");
            return;
        }

        // Check database for existing user
        $db = new aces\query();
        $validate_user = $db -> set_select_column("username") -> set_where("username", $this -> username) -> select("users");
        if(count($validate_user) > 0){
            echo $ajax -> quickMsg("Username already exists in database");
            return;
        }

        // If we've made it this far, user can be added to database
        // Update password to math with salt
        $salt = rand(1000, 9999);
        $password = password_hash($this -> password . $salt, PASSWORD_DEFAULT);
        
        // Set up user insert cols and vals
        $user_insert_cols = ["username", "password", "salt", "main_role"];
        $user_insert_vals = [$this -> username, $password, $salt, 49];
        
        // Add user to db
        $db1 = new aces\query();
        $user_add = $db1 -> set_insert_array($user_insert_cols, $user_insert_vals) -> insert("users", "User registration form");
        $user_id = $user_add["last_insert_id"];

        // Set up contact insert cols and vals
        $cont_insert_cols = ["user_id", "fname", "lname"];
        $cont_insert_vals = [$user_id, $this -> fname, $this -> lname];
        
        // Add user contact info for reference
        $db2 = new aces\query();
        $db2 -> set_insert_array($cont_insert_cols, $cont_insert_vals) -> insert("contacts", "User registration form");

        echo $ajax -> quickMsg("done");
        return;
        
    } // register_user()

    function check_existing_user(){}

    function add_user(){}

    function delete_user(){
        
        $this -> username = trim($_REQUEST["username"]);
        
        $ajax = new spades();
       
        // Check database for existing user
        // $db = new aces\query();
        // $validate_user = $db -> set_column("username") -> set_where("username", $this -> username) -> select("users");
        // if(count($validate_user) < 1){
        //     echo $ajax -> quickMsg("Username not found");
        //     return;
        // }

        $db1 = new aces\query();
        $db1 -> set_update_column("active", 0) -> set_where("username", $this -> username) -> update("users");

        echo $ajax -> quickMsg("done");
        return;

    }

} // class user_registration

?>