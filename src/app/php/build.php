<?php

class GlobalBuild{

    function BuildNavLink($Name, $Href, $ActiveLink = null){
        /*
            7/19/24 - b3tac0d3
            This is a basic filler function for now to build nav links. It could stand to be updated in the future
            to calculate active links a little more accurately.
        */
        $CurrentHref = str_replace("/magic", "", $_SERVER["REQUEST_URI"]);
        $ActivePage = "";
        if(empty($ActiveLink)) $ActiveLink = [$Href]; // Assigning this value as a single key array will save code time in the subsequent search
        if(!is_array($ActiveLink)) $ActiveLink = [$ActiveLink]; // If the link was passed as a string, convert to array to save future logic
        
        // var_dump($CurrentHref);exit;
        foreach($ActiveLink as $x)
            if($CurrentHref == "/" . $x)$ActivePage = "active";

        return "<li class='nav-item'><a href='$Href' class='nav-link $ActivePage'>$Name</a></li>";
    } # BuildNavLink()

} # Class GlobalBuild