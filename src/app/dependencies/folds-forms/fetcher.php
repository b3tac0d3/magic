<?php

class forms{

    public static function print_form($form_name, $form_dir = null){
        /*
            $form_dir is optional when the form is stored in a different
            directory other than the default.

            - Consider using init file to define default directory
            
         */
        if(empty($form_dir)) $form_dir = sm::dir("user_forms");
        if(!strpos($form_name, ".php")) $form_name .= ".php";
        $form = include_once($form_dir . $form_name);
        echo $form;
    }

} // class fetcher


?>