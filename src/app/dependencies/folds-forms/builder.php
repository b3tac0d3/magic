<?php

namespace folds;
use sm;

class builder{
    
    private $elements;

    function label($value, $attributes = []){
        // $elements is optional and allows for DOM elements to be added inside label tags for certain types of CSS designs
        $elem_attributes = $this -> process_attributes($attributes);

        $this -> elements .= $output = "<label $elem_attributes>$value</label>";
        return $output;
    } // label()

    function input($type, $attributes = []){
        /*  Example
            input -> ("text", [
                "name:username", 
                "placeholder:username", 
                "id:username", 
                "readonly", 
                "class:class1 class2 class3"
            ]);
        */
        $elem_attributes = $this -> process_attributes($attributes);
        
        $this -> elements .= $output = "<input type = '$type' $elem_attributes/>";
        return $output;
    } // input()

    function select($attributes = [], $options = null){
        $elem_attributes = $this -> process_attributes($attributes);

        $this -> elements .= $output = "<select $elem_attributes>$options</select>";
        return $output;
    } // select()

    function select_option($value, $attributes = []){
        // If attributes doesn't contain a "value" option, option value will default to name value
        $elem_attributes = $this -> process_attributes($attributes);

        if(!empty($elem_attributes) && !strpos($elem_attributes,"value=")){
            // No user assigned value so given by function
            $elem_attributes .= " value='$value'";
        }

        $this -> elements .= $output = "<option $elem_attributes>$value</option>";
        return $output;
    } // select_option()

    function select_optgroup($label, $options, $attributes = []){
        $elem_attributes = $this -> process_attributes($attributes);

        $this -> elements .= $output = "<optgroup label='$label' $elem_attributes>$options</optgroup>";
        return $output;
    } // select_optgroup()

    function textarea($attributes = [], $value = null){
        $elem_attributes = $this -> process_attributes($attributes);

        $this -> elements .= $output = "<textarea $elem_attributes>$value</textarea>";
        return $output;
    } // textarea()

    function button($value, $attributes = []){
        $elem_attributes = $this -> process_attributes($attributes);

        $this -> elements .= $output = "<button $elem_attributes>$value</button>";
        return $output;
    } // button()

    function meter(){} // meter()

    function progress(){} // progress()

    function div($attributes = [], $elements = []){
        /* Example
        div(
            ["class:text-center"],
            [$x -> input("text", ["id:username"])]
        ); 

        $element_tag can be antying but defaults to div
        */
        $div_elements = null;

        // Elements inside the div
        foreach($elements as $e){
            $div_elements .= $e;
        }

        $elem_attributes = $this -> process_attributes($attributes);

        $this -> elements .= $output = "<div $elem_attributes>$div_elements</div>";
        return $output;
    } // div()

    function elem($tag, $attributes = [], $elements = []){
            $elem_elements = null;

            // Elements inside the div
            foreach($elements as $e){
                $elem_elements .= $e;
            }
    
            $elem_attributes = $this -> process_attributes($attributes);
    
            $this -> elements .= $output = "<$tag $elem_attributes>$elem_elements</$tag>";
            return $output;
    } // elem()

    function form($attributes = [], $elements = []){
        $elem_attributes = $this -> process_attributes($attributes);
        $element_output = null;
        foreach($elements as $e){
            $element_output .= $e;
        }

        // FIND A WAY TO WORK IN THE MESSAGE CLEANER AND WITH OPTIONS IN THE FUTURE 10/6/23
        return "
            <form $elem_attributes>
                <div class = 'form_message text-danger'></div>
                {$element_output}
            </form>";
    } // mk_form()

    function print_form($attributes = []){
        echo $this -> form($attributes);
    } // print_form()

    function action($input){
        // Allow action to be entered without .php and with dir-dot syntax
        $path_array = explode(".", $input);
        $action = sm::url($path_array[0]);
        for($x = 1; $x < count($path_array); $x++){
            $action .= $path_array[$x];
            if($x < count($path_array) - 1){
                $action .= "/";
            }else{
                $action .= ".php";
            }
        }
        return $action;
    } // action()




    private function process_attributes($attributes){
        // Stop if no attributes assigned
        if(empty($attributes)) return;
        
        $output_attributes = null;
        
        // Loop attributes and process
        foreach($attributes as $a){
            $att_arr = explode("|", $a);
            $key = $att_arr[0];

            // Check for attribute short names
            if(strlen($key) == 2) $key = $this -> process_short_attribute($key);
            
            // Check if attribute is static or dynamic
            if(isset($att_arr[1]) && !empty($val = $att_arr[1])){
                $output_attributes .= "$key='$val'";
            }else{
                $output_attributes .= "$key"; // Assign static attribute (ex: autofocus)
            } // if
            
            // Space between attributes for output readability
            if(next($attributes) != 0) $output_attributes .= " ";
        } // for

        return $output_attributes;
    } // process_attributes()

    private function process_short_attribute($in){
        switch(strtolower($in)){
            default:
                $out = $in;
                break;
            case "nm":
                $out = "name";
                break;
            case "cl":
                $out = "class";
                break;
            case "tr":
                $out = "target";
                break;
            case "ac":
                $out = "action";
                break;
            case "st":
                $out = "style";
                break;
            case "ph":
                $out = "placeholder";
                break;
        }
        return $out;
    } // process_short_attribute()

    private function process_short_input_name($in){
        match(strtolower($in)){
            default => $out = $in,
            "cl" => $out = "color",
            "dt" => $out = "date",
            "dl" => $out = "datetime-local",
            "em" => $out = "email",
            "fl" => $out = "file",
            "hd" => $out = "hidden",
            "im" => $out = "image",
            "mn" => $out =  "month",
            "nm" => $out = "number",
            "pw" => $out = "password",
            "rd" => $out = "radio",
            "rn" => $out = "range",
            "re" => $out = "reset",
            "se" => $out = "search",
            "sm" => $out = "submit",
            "te" => $out = "tel",
            "tx" => $out = "text",
            "tm" => $out = "time",
            "ur" => $out = "url",
            "wk" => $out = "week"
        };
        return $out;
    }
}
?>