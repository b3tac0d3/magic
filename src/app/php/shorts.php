<?php

class sm{
    public static function Url($Input){
        // Return any pre-definded URL
        if(empty($_SESSION["Root"]["App"]["Urls"][$Input]))
            return "Shorts function Url not located";
        else
            return $_SESSION["Root"]["App"]["Urls"][$Input];
    } // url()

    public static function Dir($Input){
        // Return and pre-defined directory
        if(empty($_SESSION["Root"]["App"]["Dirs"][$Input]))
            return "Shorts function Dir not located";
        else
            return $_SESSION["Root"]["App"]["Dirs"][$Input];
    } // dir()

    public static function Cus($Input){
        // Return any pre-defined custom URL or directory created by user
        return $_SESSION["Root"]["App"]["Custom"][$Input];
    } // cus()

    public static function Dep($Input, $Type = "Url"){
        // Quickly access a dependency directory
        if($Type == "Url")
            return $_SESSION["Root"]["App"]["Depends"]["Urls"][$Input];
        else
            return $_SESSION["Root"]["App"]["Depends"]["Dirs"][$Input];
    }
}