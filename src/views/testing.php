<style type = "text/css">
    .indent{
        padding-left: 1em;
        margin: 0;
        border-left: 2px dashed gray;
        cursor: pointer;
    }
    .li{
        line-height: 1.5em;
    }
</style>
<?php

// function test_me($var1 = 0, $var2 = 1, $var3 = 52){
//     echo "var1 = $var1
//     <br/>var2 = $var2
//     <br/>var3 = $var3";
// }

// test_me(12, var3: 9);

// var_dump($_SESSION["Root"]);

ListVars($_SESSION["Root"]);

function ListVars($Input){
    foreach($Input as $k => $v){
        if(is_array($v)){
            echo "<h3>[$k]</h3><div class = 'indent' title = '$k'>";
            ListVars($v);
            echo "</div>";
        }else{
            echo "<div class = 'li'><b>$k</b> = $v</div>";
        }
    }
}