<?php
/*
	3/14/17 b3tac0d3
	To avoid errors, this class should have a built in function to 
	shut off all redirects and refreshes prior to turning a new one on.
	Consider for future releases.
*/

namespace spades;

class spades{
	
	protected $message = NULL;
	protected $status = 1;
	protected $refresh = 0;
	protected $badInputs = array();
	protected $classes;
	protected $text = NULL;
	protected $html = NULL;
	protected $pushState = NULL;
	protected $redirect = NULL;
	protected $redirOn = 0;
	protected $redirCb = 0;
	protected $redirCbLink = NULL;
	protected $alertTxt = NULL;
	protected $alertOn = 0;
	protected $errcnt = 0;
	protected $arrays = array();
	protected $openData = NULL;
	
	function __construct($class = 'red'){
		//$this -> classes = $class;
	} # __construct
	
	function quickMsg($msg, $class = null, $stat = 0){
		$this -> appendMsg($msg);
		$this -> addClass($class); # add a quick class such as red
		$this -> setStatus($stat);
		return $this -> mkJson();
	}
	
	function appendMsg($inp){
		# typically used on alert forms to reply with message in form before processing
		# adds linebreaks by itself so isn't good for general text return option
		$this -> message .= $inp . "<br>\n";
	}
	
	function addError($msg = NULL, $inp = 1){
		# add an error to the list of errors 
		if(!empty($msg)) $this -> appendMsg($msg); // easily add return message in one line
		$this -> setStatus(0); // assume if errors are present, status is 0 by default
		$this -> errcnt = $this -> errcnt + $inp; // keep count of the errors in case we decide to use it
	}
	
	function getErrors(){
		# get current errors that have been logged by js/ajax/php
		return $this -> errcnt;
	}
	
	function setAlert($inp){
		# used for pop up alerts on screen
		$this -> alertTxt = $inp;
		$this -> alertOn = 1;
	}
	
	function setStatus($inp){
		# class status - typically in js 0 = bad, 1 = good
		$this -> status = $inp;
	}
	
	function getStatus(){
		# get status - can be used by php to check current status before proceeding
		return $this -> status;
	}
	
	function chkStatus(){
		# this function is used to check the status after the form has been validated. 
		# if it returns anything other than 1, the form won't proceed.
		if($this -> status != 1){
			echo $this -> mkJson();
			exit();
		}
	}
	
	function setRefresh($inp){
		$this -> refresh = $inp;
	}
	
	function setRedirect($inp){
		$this -> redirect = $inp;
		$this -> redirOn = 1;
	}
	
	function setColorbox($inp){
		# if the redirect is opening a new colorbox (subsquent or new popup)
		$this -> redirCbLink = $inp;
		$this -> redirCb = 1;
	}
	
	function setText($inp){
		# this is the reply text to show - ie settings - the new value to populate the html with
		$this -> text = $inp;
	}
	
	function setHtml($inp){
		# return HTML to populate an ajax element
		$this -> html = $inp;
	}
	
	function addBadInput($inp){
		# dependent on the input of "."(class) or "#"(id) to identify elements for js to highlight
		array_push($this -> badInputs, $inp);
	}
		
	function addClass($inp){
		# add class to return for js to assign to an element
		$this -> classes = "$inp";
	}
	
	function setPushState($inp){
		# for js history.pushstate to change the url when ajaxing
		$this -> pushState = $inp;
	}
	
	function setArray($inp){
		# this is a standard data array that we can add sub arrays to
		# inp in this case = the sub-array name
		# this function can be used to generate multiple levels of sub-arrays
		array_push($this -> arrays, $inp);
	}
	
	function setArrayData($a, $k, $v){
		# $a = array name (sub-array of $this -> arrays)
		# $k = array key 
		# $v = array value (can also be a sub-array assigned to key)
		$this -> arrays[$a][$k] = $v;
	}
	
	function setOpenData($inp){
		# variable capable of accepting various data types for any other situation
		$this -> openData = $inp;
	}
	
	function appendOpenData($inp){
		# alternate use for users who want to add multiple parts to $this -> openData
		# without having to code for appending
		$this -> openData .= $inp;
	}
	
	function mkJson(){
		# return the compiled data of the entire class in a JSON array
		$newMessage = "<pre>" . $this -> message . "<pre>";
        // var_dump(json_encode($this -> genArray()));
		return json_encode($this -> genArray());
	}
	
	function mkArray(){
		# return the compiled data of the entire class in a standard array
		$newMessage = "<pre>" . $this -> message . "<pre>";
		return $this -> genArray();
	}
	
	private function genArray(){
		# only called internally to produce compiled class data
		return array(
			"message" => $this -> message,
			"status" => $this -> status,
			"refresh" => $this -> refresh,
			"pushState" => $this -> pushState,
			"badInputs" => $this -> badInputs,
			"classes" => $this -> classes,
			"text" => $this -> text,
			"html" => $this -> html,
			"redirect" => $this -> redirect,
			"redirOn" => $this -> redirOn,
			"redirCb" => $this -> redirCb,
			"redirCbLink" => $this -> redirCbLink,
			"alertTxt" => $this -> alertTxt,
			"alertOn" => $this -> alertOn,
			"arrays" => $this -> arrays,
			"openData" => $this -> openData
		);
	}
	
}

?>