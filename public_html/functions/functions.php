<?php

// File ID: functions.php
// Purpose: Provides basic sitewide functions

$attr = getattributes(); 

// Begin functions definition:

function __autoload($name) {
  // The autoload function, a bit messy if you ask me
  $class_path = strtolower("classes/class_{$class}");  
  $dir = (defined("SUBDIR"))?"../":"";
  if(file_exist("{$dir}{$class_path}.php")) include("{$dir}{$class_path}.php");
  else{
	$abstract_path = strtolower("classes/abstract/abstract_{$class}");
	$interface_path = strtolower("classes/interfaces/interface_{$class}");
	if(file_exist("{$dir}{$abstract_path}.php")) include("{$dir}{$abstract_path}.php");
    elseif(file_exist("{$dir}{$interface_path}.php")) include("{$dir}{$interface_path}.php");
	else throw new Exception("Fatal Error: Class {$class} either does not exist!");
  }
}

function is_assoc($arr) {
   // From php.net, will help a lot in future
   return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
}

function checkrb($field, $value){
   $button = ($field == $value)?" checked":"";
   return $button;
}

function secure($data) {
	//This function performs security checks on all incoming form data
	if(is_array($data) and SUBDIR != "AdminCP") die("Hacking Attempt!");
	$data = htmlentities($data);
    $data = addslashes($data);	
	$data = strip_tags($data, '');
	return $data;
}

function redirect($url,$permanent = false){
    if($permanent) header("HTTP/1.1 301 Moved Permanently'");
    header("Location: ".$url);
    exit();
}      

function replace($old, $new, $template) {
	//This function replaces template values
	$template = str_replace($old, $new, $template);
	return $template;
}

function codegen($length, $symbols = 0){
	$set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
	$str = '';
	
	if($symbols == 1){
	  $symbols = array("~","`","!","@","$","#","%","^","+","-","*","/","_","(","[","{",")","]","}");
	  $set = array_merge($set, $symbols);
	}

	for($i = 1; $i <= $length; ++$i)
	{
		$ch = mt_rand(0, count($set)-1);
		$str .= $set[$ch];
	}

	return $str;
}

function passencr($username, $password, $salt){
    $mysidia = Registry::get("mysidia");
    $pepper = $mysidia->settings->peppercode;
    $password = md5($password);
    $newpassword = sha1($username.$password);
    $finalpassword = hash('sha512', $pepper.$newpassword.$salt);
    return $finalpassword;
}     

function ipgen($ip){
	$ip_long = ip2long($ip);

	if(!$ip_long){
		$ip_long = sprintf("%u", ip2long($ip));		
		if(!$ip_long){
			return 0;
		}
	}

	if($ip_long >= 2147483648) $ip_long -= 4294967296;
	return $ip_long;
}

function get_rand_id($length){
    if($length>0){ 
    $rand_id="";
      for($i=1; $i<=$length; $i++){
        mt_srand((double)microtime() * 1000000);
        $num = mt_rand(1,36);
        $rand_id .= assign_rand_value($num);
      }
    }
    return $rand_id;
} 

function timeconverter($unit){
	switch($unit){
		case "secs":
			$converter = 1;
			break;
		case "minutes":	
            $converter = 60;
            break;
	    case "hours":	
            $converter = 3600;
            break;
        case "weeks":
            $converter = 604800;
            break; 
        case "months":
            $converter = 2592000;
            break;
		case "years":
            $converter = 31536000;
            break;	
        default:
             $converter = 86400;			   
    }
	return $converter;	
}

function getadmimages() {
    $mysidia = Registry::get("mysidia");
	$formcontent = "";
	$stmt = $mysidia->db->select("filesmap", array());
	while($row = $stmt->fetchObject()) {
		$wwwpath = $row->wwwpath;   
		$friendlyname= $row->friendlyname; 
		$formcontent .= "<option value='{$wwwpath}'>{$friendlyname}</option>";
	}
	return $formcontent;
}

function globalsettings(){
    $mysidia = Registry::get("mysidia");
	$settings = new stdclass;
   	$stmt = $mysidia->db->select("settings", array());
	while($row = $stmt->fetchObject()){
	  $property = $row->name;
	  $settings->$property = $row->value;
	}
	return $settings;
}

function getattributes(){
    // This function defines default attributes for html table, form and other stuff...
    $attr = new stdclass;

    // Get default attributes for html tables...	
	$attr->table = new stdclass;
	$attr->table->align = "center";
	$attr->table->style = "";
	$attr->table->background = array();
	$attr->table->border = 1;
	$attr->table->cellpadding = "";
	$attr->table->cellspacing = "";
	$attr->table->frame = "";
	$attr->table->rules = "";
	$attr->table->summary = "";
	$attr->table->width = "";	
	
	// Get default attributes for html forms...
	$attr->form = new stdclass;
	$attr->form->action = "index.php";
	$attr->form->accept = "";
	$attr->form->enctype = "";
	$attr->form->method = "post";
	$attr->form->name = "form";
	$attr->form->target = "";
	
	// All done, at least for this time being... 
    return $attr;	
}

function getpoundsettings(){
    // This function defines default attributes for html table, form and other stuff...
	$settings = new stdclass; 
	$mysidia = Registry::get("mysidia");
   	$stmt = $mysidia->db->select("pound_settings", array());
	while($row = $stmt->fetchObject()){
      $property = $row->varname;
      foreach($row as $key => $val){       
        @$settings->$property->$key = $val;
      }
	}
	return $settings;
}
?>