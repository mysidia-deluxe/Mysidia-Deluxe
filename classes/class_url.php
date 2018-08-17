<?php

use Resource\Native\Object;
use Resource\Native\Mystring;

/**
 * The URL Class, it is part of the utility package and extends from the Object Class.
 * It implements PHP basic url functions, and adds enhanced features upon them.
 * a URL object is immutable, once set it cannot be altered with setter methods.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not sure, but will come in handy.
 */

final class URL extends Object{

	/**
	 * REGEX constant, it is used to identify valid and invalid url.
    */
    const REGEX = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
  		
	/**
	 * The scheme property, stores the scheme of the url.
	 * @access private
	 * @var String
    */				
    private $scheme; 
	
	/**
	 * The host property, stores the host of the url.
	 * @access private
	 * @var String
    */
    private $host;
	
	/**
	 * The path property, specifies the path portion of the url string.
	 * @access private
	 * @var String
    */
    private $path;
	
	/**
	 * The query property, specifies the query portion of this string.
	 * @access private
	 * @var String
    */
    private $query;
	
	/**
	 * The fragment property, determines the fragment section of the sting, if it exists.
	 * @access private
	 * @var String
    */
	private $fragment;
   
   	/**
	 * The url property, defines the entire url string that can be referenced later.
	 * @access private
	 * @var String
    */
    private $url;
   
   	/**
     * Constructor of URL Class, it validates and sets up a URL object, can perform parser operations. 
	 * @param String  $url
	 * @param Boolean  $parse
     * @access publc
     * @return Void
     */
    public function __construct($url, $validate = FALSE, $parse = FALSE){
        $mysidia = Registry::get("mysidia");
        if ($validate and !$this->isValid($url)){
            throw new UrlException('The specified URL is invalid.');
        }
		
        $this->url = (!preg_match(self::REGEX, $url))?$mysidia->path->getAbsolute().$url:$url;
		if($parse) $this->parseURL();
    }
   
    /**
     * The getScheme method, getter method for property $scheme.    
     * @access public
     * @return String
     */
    public function getScheme(){
        return $this->scheme;
    }
   
    /**
     * The getHost method, getter method for property $host.    
     * @access public
     * @return String
     */
    public function getHost(){
        return $this->host;
    }
   
    /**
     * The getPath method, getter method for property $path.    
     * @access public
     * @return String
     */
    public function getPath(){
        return $this->path;
    }
   
    /**
     * The getQuery method, getter method for property $query.    
     * @access public
     * @return String
     */
    public function getQuery(){
        return $this->query;
    }
	
	/**
     * The getFragment method, getter method for property $fragment.    
     * @access public
     * @return String
     */
	public function getFragment(){
	    return $this->fragment;
	}
	
	/**
     * The getURL method, getter method for property $url.    
     * @access public
     * @return String
     */
	public function getURL(){
	    return $this->url;
	}
	
	/**
     * The isValid method, checks if the url is valid.
     * For absolute path, it validates the url string. For relative path, it checks if the file exists.	 
     * @param String  $url	 
     * @access private
     * @return String
     */
	private function isValid($url){
	    if(preg_match(self::REGEX, $url)) return TRUE;
        elseif(file_exists($url)) return TRUE;
		else return FALSE;
	}
	
	/**
     * The parseURL method, parses the url and assigns useful URL properties. 
     * @access public
     * @return Void
     */
	public function parseURL(){
	    $url = parse_url($this->url);
        $this->scheme = $url['scheme'];
        $this->host = $url['host'];
       
        if(isset($url['path'])) $this->path = $url['path'];     
        if(isset($url['query'])) $this->query = $url['query'];
		if(isset($url['fragment'])) $this->fragment = $url['fragment'];
	}
	
	/**
     * The addQueryString method, create a new URL object from the given additional parameters.
     * @param Array  $params	 
     * @access public
     * @return String
     */
    public function addQueryString(array $params){
        if(empty($params)) {
            throw new UrlException('The specified query string parameters are invalid.');
        }
       
        $queryString = '';
        foreach ($params as $key => $value) {
            $queryString .= '&' . $key . '=' . urlencode($value);
        }
        $queryString = $this->queryString === null ?trim($queryString, '&'):$this->queryString . $queryString;
        $url = $this->scheme . '://' . $this->host . $this->path . '?' . $query;
        return new URL($url);
    }                
	
	/**
     * Magic method __toString for URL class, it outputs the parsed url in string format.
	 * It should only be used if the URL has been parsed, otherwise use URL::getURL instead.
     * @access public
     * @return String
     */
	public function __toString(){
	    return $this->host.$this->path.$this->query.$this->fragment;
	}
}     
?>