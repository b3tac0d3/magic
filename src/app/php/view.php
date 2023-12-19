<?php

namespace Document;
use sm;
use Document\SessionClass;

class ViewClass{

private $ViewsPath;
private $RawViewData;
private $RawLayoutData;
private $FinalOutputData;
private $SessionVerified = 0;

function __construct($ViewFileName, $ControllerData = null){
    $this -> ViewsPath = sm::Dir("Views");
    $this -> GetViewData($ViewFileName);
    // If not using presto syntax, we can output the raw view file and stop the scripts
    if($this -> CheckPrestoSyntax() != true){
        $this -> OutputFinalView($this -> RawViewData);
        return;
    }
    $this -> ParseViewData(); // This handles checking for layout, includes and requires
    $this -> MergeLayoutViewData();
    $this -> OutputFinalView($this -> FinalOutputData);
} // __construct()

function GetViewData($ViewFileName){
    ob_start();
        require_once($ViewFileName);
        $this -> RawViewData = ob_get_clean();
    if (ob_get_contents()) ob_end_clean();
    return;
} // GetViewData()

function CheckPrestoSyntax(){
    return substr($this -> RawViewData, 0, 7) === "@presto" ?: 0;
}

function ParseViewData(){
    $SearchArray = [
        "@sess" => "GetSess",
        "@auth" => "GetAuth",
        "@layout" => "GetLayout",
        "@include" => "GetIncludes",
        "@require" => "GetRequires"
    ];

    foreach($SearchArray as $Search => $Function){
        if(str_contains($this -> RawViewData, $Search))
            $this -> $Function();
    }
} // ParseViewData()

function GetSess($BypassMatch = 0){
    if(!empty(preg_match("/@sess/i", $this -> RawViewData, $SessRequired)) || $BypassMatch == 1){
        $Sess = new SessionClass();
        if($Sess -> ValidateUserSession() != 1){
            new ViewClass($this -> ViewsPath . "errors/session.php");
            exit;
        }
    }
    // If we've made it this far, set SessionVerified in case auth is also being used at the same time so it doesn't repeat the cycle
    $this -> SessionVerified = 1;
} // GetSess()

function GetAuth(){
    /* 
        Pages only need to be authorized by session permission values 
        so we're building in a shortcut to check session as well if it 
        hasn't already been checked 
    */
    // If session hasn't been verified, we verify now
    if(!empty(preg_match("/@auth\((\d+)\)/i", $this -> RawViewData, $PermissionRequired))){
        if($this -> SessionVerified != 1) $this -> GetSess(true);
        $Auth = new AuthClass();
        if($Auth -> AuthUserPage($PermissionRequired[1]) != 1){
            new ViewClass($this -> ViewsPath . "errors/auth.php");
            exit();
        }
    }
}

function GetLayout(){
    if(!empty(preg_match("/(?<!\\\)@layout\(\S+.\)/i", $this -> RawViewData, $Layout))){
        $LayoutFileName = preg_replace(array("/@layout\(/i", "/\)/"), "", $Layout[0]);
        $LayoutFileName = $this -> ViewsPath . str_replace(".", "/", $LayoutFileName) . ".php";
        if(is_file($LayoutFileName)){
            ob_start();
                require_once($LayoutFileName);
                $this -> RawLayoutData = ob_get_clean();
            if (ob_get_contents()) ob_end_clean();
        }else{
            echo "Did you misname your layout file?";
            exit;
        }
    }
} // GetLayout()

function GetIncludes(){
    if(!empty(preg_match("/(?<!\\\)@include\(\S+.\)/i", $this -> RawViewData, $Includes))){
        $IncludesFile = preg_replace(array("/@includes\(/i", "/\)/"), "", $Includes[0]);
        $IncludeFileName = str_replace(".", "/", $IncludesFile) . ".php";
        include_once sm::Dir("views") . $IncludeFileName;
    }
} // GetIncludes()

function GetRequires(){
    if(!empty(preg_match("/(?<!\\\)@require\(\S+.\)/i", $this -> RawViewData, $Requires))){
        $RequiresFile = preg_replace(array("/@requires\(/i", "/\)/"), "", $Requires[0]);
        $RequireFileName = str_replace(".", "/", $RequiresFile) . ".php";
        require_once sm::Dir("views") . $RequireFileName;
    }
} // GetRequires()

function MergeLayoutViewData(){
    
    $YieldCount = 0;
    $YieldArray = array();

    $OutputData = $this -> RawLayoutData;

    if(!empty($this -> RawLayoutData)){
        // Process layout file data
        preg_match_all("/@yield\(\S+\)/i", $this -> RawLayoutData, $FoundYields);
        $YieldCount = count($FoundYields[0]);
        $FoundYields = $FoundYields[0];

        for($i = 0; $i < $YieldCount; $i++){
            $YieldName = substr($FoundYields[$i], 6, strlen($FoundYields[$i]) - 6);
            $Yields[] = substr($YieldName, 1, strlen($YieldName) - 2);
        } // for

        // Process view file data
        preg_match_all("/((?<!\\\)\@section\(\S+\))(.*?)((?<!\\\)\@endsection)/sm", $this -> RawViewData, $FoundSections);

        // One the .000001% off chance that there's a reference to an @section or @endsection, fix the backslasmes
        $FoundSections[2] = str_replace("\@section", "@section", $FoundSections[2]);
        $FoundSections[2] = str_replace("\@endsection", "@endsection", $FoundSections[2]);
        
        // Merge the two data sets and remove additional @yield's that might not be fulfilled
        if(count($Yields) > 0){
            foreach($Yields as $y){
                $SectionFound = array_search("@section($y)", $FoundSections[1]);
                if($SectionFound !== false){
                    $OutputData = str_replace("@yield($y)", $FoundSections[2][$SectionFound], $OutputData);
                }else{
                    // Remove unused yields
                    $OutputData = str_replace("@yield($y)", "", $OutputData);
                }
            } // for
        } // if(count($Yields) > 0)
    } // if(empty(RawLayoutData))

    $this -> FinalOutputData = $OutputData;
} // MergeLayoutViewData()

function OutputFinalView($OutputData){
    echo $OutputData;
} // OutputFinalView()

} // class ViewClass