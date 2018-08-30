<?php

use Resource\Native\Object;

/**
 * The Router Class, it manages routes and assign important environment variables.
 * The router handles different routing methods for main site, ACP and so on.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not sure, but will come in handy.
 */

final class Router extends Object{

  	/**
	 * The path property, specifies the path of the route.
	 * @access private
	 * @var String
    */	  
	private $path;
	
	/**
	 * The url property, holds a reference to the site url
	 * After constructor operation, the url is cut down to exclude the path string.
	 * @access private
	 * @var String
    */	  
	private $url;
	
	/**
	 * The frontController property, specifies the Front Controller to process user request.
	 * @access private
	 * @var String
    */	 	
	private $frontController;
	
	/**
	 * The appController property, specifies the Application Controller to process user request.
	 * @access private
	 * @var String
    */	 
    private $appController;
	
	/**
	 * The action property, defines the action of the user request.
	 * @access private
	 * @var String
    */	 
	private $action;
	
	/**
	 * The params property, stores all parameters entered by the user.
	 * @access private
	 * @var ArrayObject
    */	
	private $params;

	/**
     * Constructor of Router Class, it initializes basic router properties. 
     * @param String  $url 
     * @access public
     * @return Void
     */
    public function __construct($url){	
	    $this->setFrontController($url);
		$this->path = SCRIPTPATH.$this->path;
        $this->url = str_replace($this->path, "", $url);
    }
	
	/**
     * The getFrontController method, getter method for property $frontController. 
     * @access public
     * @return String
     */
	public function getFrontController(){
		return $this->frontController;
	}

	/**
     * The setFrontController method, setter method for property $frontController. 
	 * This method is only available upon Router Object Instantiation, its private so cannot be accessed externally.
	 * @param String  $url
     * @access public
     * @return String
     */
	private function setFrontController($url){
	 	if(strpos($url, "admincp") !== FALSE){
			$this->path = "/admincp";
            $this->frontController = "admincp";   
        }
        elseif(strpos($url, "install") !== FALSE){
			$this->path = "/install";
            $this->frontController = "install";
	    }
	    else{
			$this->path = "";
		    $this->frontController = "index";
		}		
	}

	/**
     * The getAppController method, getter method for property $appController. 
     * @access public
     * @return String
     */
    public function getAppController(){
        return $this->appController;
    }

	/**
     * The setAppController method, setter method for property $appController. 
	 * This method is only available during routing process, its private so cannot be accessed externally.
	 * @param String  $controller
     * @access public
     * @return String
     */
	private function setAppController($controller){	
	    $this->appController = (!$controller)?"index":$controller;
	}
	
	/**
     * The getAction method, getter method for property $action. 
     * @access public
     * @return String
     */
    public function getAction(){
        return $this->action;
    }

	/**
     * The setAction method, setter method for property $action. 
	 * This method is only available during routing process, its private so cannot be accessed externally.
	 * @param String  $action
     * @access public
     * @return String
     */	
	private function setAction($action){
        if(strpos($action, "page-") !== FALSE){
            $this->setParams(array($action));
            $action = "index";
        }
        $this->action = (!$action)?"index":$action;
	}

	/**
     * The getParams method, getter method for property $params. 
     * @access public
     * @return ArrayObject
     */
    public function getParams(){
        return $this->params;
    }
	
	/**
     * The setParams method, setter method for property $params. 
	 * This method is only available during routing process, its private so cannot be accessed externally.
	 * @param Array  $params
     * @access public
     * @return String
     */	
    private function setParams($params){
		@include_once("{$this->appController}.php");
        if(!$params) return;
		$class = ($this->frontController == "admincp")?"ACP{$this->appController}Controller":"{$this->appController}Controller";
		$reflection = new ReflectionClass(ucfirst($class));
		$constants = new ArrayObject($reflection->getConstants());
		if($constants->count() == 0) return;
		else{
            $this->params = new ArrayObject;
			$index = 0;
		    foreach($constants as $key => $param){
                if(strpos($params[$index], "page-") !== FALSE){
                    $page = explode("-", $params[$index]);
                    $this->params->offsetSet($page[0], $page[1]);
                }
                else $this->params->offsetSet($param, $params[$index]);
                $index++;				
			}
		}
    }	

	/**
     * The route method, this is where the routing process takes place as the router interprets URL.
     * @access public
     * @return String
     */		
	public function route(){		
		try{
		    $query = explode("/", $this->url);
            array_shift($query);
			$this->setAppController(array_shift($query));
            $this->setAction(array_shift($query));
			$this->setParams($query);
        }
        catch(Exception $e){
            die($e->getmessage());
            //die("404 Page not found.");
        }
	}
}     
?>