<?php

/**
 * The UrlParser Class, it is part of the utility package.
 * It implements PHP basic url parser functions, and adds enhanced features upon them.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not sure, but will come in handy.
 */

final class UrlParser{
	private $path;
	private $url;
   
    public function __construct($url){		
		$path = (strpos($url, "admincp") !== FALSE)?"/admincp/":"/";
       	$this->path = SCRIPTPATH.$path;
        $this->url = str_replace($this->path, "", $url);
    }
	
	// parse the url and return an array of elements
    public function parse(){
        if(!$this->url) return array("controller" => "index");
		
        try{
		    $elements = array();	
		    $values = explode("/", $this->url);
            if($values[0] == "index") return $elements;
		    $class = (defined("SUBDIR"))?"ACP{$values[0]}Controller":"{$values[0]}Controller";

            @include_once("{$values[0]}.php");
		    $elements['controller'] = $values[0];
            $elements['action'] = $values[1];
        
		    $reflection = new ReflectionClass(ucfirst($class));
            $params = new ArrayObject($reflection->getConstants());

            if($params->count() == 0) return $elements;
            elseif($params->count() == 1) $elements[$params['PARAM']] = $values[2];
            else{
                $index = 2;
                foreach($params as $param){
                    $elements[$param] = $values[$index];
                    $index++;
                }
            }
        }
        catch(Exception $e){
            die("404 Page not found.");
        }		
        return $elements;
    }                
}     
?>