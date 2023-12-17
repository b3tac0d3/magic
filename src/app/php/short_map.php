<?php

class sm{
    public static function Url($input){
        // Return any pre-definded URL
        return $_SESSION["Root"]["App"]["Urls"][$input];
    } // url()

    public static function Dir($input){
        // Return and pre-defined directory
        return $_SESSION["Root"]["App"]["Dirs"][$input];
    } // dir()

    public static function Cus($input){
        // Return any pre-defined custom URL or directory created by user
        return $_SESSION["Root"]["App"]["Custom"][$input];
    } // cus()
}