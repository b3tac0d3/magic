<?php

namespace Document;
use sm;
use User\SessionClass;
use Document\ErrorClass;

class ViewClass{

private $ViewsPath;
private $RawViewData;
private $RawLayoutData;
private $FinalOutputData;
private $SessionVerified = 0;
private $ControllerData;
private $YieldsData;
private $SectionsData;
private $Error;

function __construct($ViewFileName, $ControllerData = null){
    $this -> ViewsPath = sm::Dir("Views");
    $this -> Error = new ErrorClass();
    $this -> GetViewData($ViewFileName);
    // If not using presto syntax, we can output the raw view file and stop the scripts
    if($this -> CheckPrestoSyntax() != true){
        $this -> OutputFinalView($this -> RawViewData);
        return;
    }
    if(!empty($ControllerData)) $this -> ControllerData = $ControllerData;
    $this -> ParseViewData(); // This handles checking for layout, includes and requires
    $this -> CaptureLayoutYields();
    $this -> CaptureViewSections();
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
            $this -> Error -> SetError("Sess");
            return false;
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
            $this -> Error -> SetError("Auth");
            return false;
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

function CaptureLayoutYields(){
    preg_match_all("/@yield\(\S+\)/i", $this -> RawLayoutData, $FoundYields);
    $YieldCount = count($FoundYields[0]);
    $FoundYields = $FoundYields[0];
    for($i = 0; $i < $YieldCount; $i++){
        $YieldName = substr($FoundYields[$i], 6, strlen($FoundYields[$i]) - 6);
        $Yields[] = substr($YieldName, 1, strlen($YieldName) - 2);
    } // for
    if(count($Yields) < 1) $Yields = false;
    $this -> YieldsData = $Yields;
    return $Yields;
} // CaptureLayoutYields()

function CaptureViewSections(){
    $SectionKey = 0;

    // This expression is purposely using negactive lookback for the .0000001% chance that the user is trying to reference presto syntax in their code
    preg_match_all("/((?<!\\\)\@section\(\S+\))(.*?)((?<!\\\)\@endsection)/sm", $this -> RawViewData, $FoundSections);

    // One the .000001% off chance that there's a reference to an @section or @endsection, fix the backslasmes
    $FoundSections[2] = str_replace("\@section", "@section", $FoundSections[2]);
    $FoundSections[2] = str_replace("\@endsection", "@endsection", $FoundSections[2]);
    
    foreach($FoundSections[1] as $Section){
        // Set up the section name for the array keys
        $SectionName = substr($Section, strpos($Section, "(") + 1, strpos($Section, ")") - 9);
        // Get the current section content
        $CurrentSection = $FoundSections[2][$SectionKey];
        // Check for possible dynamic variables in presto
        preg_match("{{.*}}",$CurrentSection, $Variables);
        // If variables are found, process accordingly
        if(count($Variables) > 0) $CurrentSection = $this -> ConvertSectionVariables($CurrentSection, $Variables);
        // Add section content to section array
        $SectionsArray[$SectionName] = $CurrentSection;
        $SectionKey ++;
    }
    $this -> SectionsData = $SectionsArray;
    return $SectionsArray;
} // CaptureViewSections()

function ConvertSectionVariables($SectionData, $VariablesArray){
    $SplitArray = (explode(" ", str_replace(["{","}"], "", $VariablesArray[0])));
    foreach($SplitArray as $k => $v){
        if(!empty($this -> ControllerData[$v])){
            $SectionData = str_replace("{{{$v}}}", $this -> ControllerData[$v], $SectionData);
        }else{
            $SectionData = str_replace("{{{$v}}}", "", $SectionData);
        }
    }
    return $SectionData;
} // CaptureSectionVariables()

function MergeLayoutViewData(){
    $OutputData = $this -> RawLayoutData;
    foreach($this -> YieldsData as $k => $y){
        if(!empty($this -> SectionsData[$y])){
            // $SectionData = $this -> CaptureSectionVariables($SectionData);
            $OutputData = str_replace("@yield($y)", $this -> SectionsData[$y], $OutputData);
        }else{
            // Remove unused yields
            $OutputData = str_replace("@yield($y)", "", $OutputData);
        }
    } // for
    $this -> FinalOutputData = $OutputData;
} // MergeLayoutViewData()

function OutputFinalView($OutputData){
    echo $OutputData;
} // OutputFinalView()

} // class ViewClass