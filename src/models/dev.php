<?php 

use Document\ModelClass;

class DevConfigModel extends ModelClass{

private $Output;

function ListVars($Input){
    foreach($Input as $k => $v){
        if(is_array($v)){
            $this -> Output .= "<h3>{{$k}}</h3><div class = 'indent' title = '$k'>";
            $this -> ListVars($v);
            $this -> Output .= "</div>";
        }else{
            $this -> Output .= "<div class = 'li'>[$k] = $v</div>";
        }
    }
    return $this -> Output;
} // ListVars()

} // class DevConfigModel