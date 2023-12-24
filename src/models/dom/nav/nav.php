<?php

namespace Navigation;
use sm;

class Navigation{

    function BuildNavLink($Name, $InputPath = null, $Class = null){
        /* 
            -- July 10, 2023
            -- b3tac0d3
            This function is basically temporary to make the nav work. Consider making more useful in the future
            with better URI reading or redoing in javascript just for fun.
        */
        $Aria = null;

        if(!str_contains($Class ?? 0, "spadeScript")) 
            $Href = sm::url("Base") . $InputPath;
        else
            $Href = $InputPath;
        
        $HardPath = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        

        if(array_search($InputPath, $HardPath)){
            $Class = "active";
            $Aria = "aria-current='page'";
        }elseif(count($HardPath) == 1 && $Name == "Home"){
            $Class = "active";
            $Aria = "aria-current='page'";
        }

        return 
            "<li class='nav-item'>
                <a href='$Href' class='nav-link $Class' $Aria>
                    $Name
                </a>
            </li>";
    } // BuildNavLink()

} // class siteNav