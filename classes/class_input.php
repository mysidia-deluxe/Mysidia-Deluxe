<?php

use Resource\Native\Mystring;
use Resource\Collection\HashMap;
use Resource\Utility\Autoboxer;

/**
 * The Input Class, it is one of Mysidia system core classes.
 * It acts as a secure wrapper for user input in $_GET and $_POST.
 * Input is a final class, no child class shall derive from it.
 * An instance of Input class is generated upon Mysidia system object's creation. 
 * This specific instance is available from Registry, just like any other Mysidia core objects. 
 * @category Resource
 * @package Core
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo incorporate input class in Mysidia adoptables system.
 */

final class Input extends Core implements Initializable{

	/**
	 * The action property, which specifies users action.
	 * @access private
	 * @var String
    */
    private $action;
	
	/**
	 * The autoboxer property, it can be useful converting between primitive types from/to their wrapper types.
	 * @access private
	 * @var Autoboxer
    */
    private $autoboxer;	

	/**
	 * The get property, it stores all user input vars in $_GET.
	 * @access private
	 * @var HashMap
    */
    private $get;
	
	/**
	 * The post property, it stores all user input vars in $_POST.
	 * @access private
	 * @var HashMap
    */
    private $post; 
	
    /**
	 * The request property, which holds request method information: get, post or else.
	 * @access public
	 * @var String
    */
    public $request;	
	
	/**
     * Constructor of Input Class, it generates basic properties for an input object.
     * @access public
     * @return Void
     */	 
    public function __construct(){	 
        $this->checkrequest();
	    $this->initialize();
    }
  
    /**
     * The initialize method, which handles parsing of user input vars.
     * @access public
     * @return Void
     */
    public function initialize(){	
        $this->autoboxer = new Autoboxer;	
	    if($_POST){
		    $this->post = new HashMap;
		    foreach($_POST as $key => $value){
			    $value = $this->secure($value);
			    $this->post->put(new Mystring($key), $this->autoboxer->wrap($value));   
			}
            unset($_POST);     
	    }
    }
  
    /**
     * The post method, returns a user input var stored in Input::$post property.
	 * @param Mystring  $key
     * @access public
     * @return Mixed
     */
    public function post($key = ""){
        if(!$this->post) return NULL;
        elseif(empty($key)) return $this->post;
        else{
		    $value = $this->post->get(new String($key));
		    return ($value == NULL)?NULL:$this->autoboxer->unwrap($value);
        }
    }
  
    /**
     * The get method, returns a user input var stored in Input::$get property.
	 * @param Mystring  $key
     * @access public
     * @return Object
     */
    public function get($key = ""){
        if(empty($key) and $this->get instanceof HashMap) return $this->get;
		return $this->get->get(new Mystring($key));
    }

    /**
     * The set method, assign dispatcher's variables into Input object's get and action properties.
	 * @param HashMap  $vars
     * @access public
     * @return Void
     */	
	public function set(HashMap $get){
	    if($this->get) throw new Exception("Cannot reassign get variables.");
	    $this->get = $get;
        $this->action = $get->get(new Mystring("action"));
	}
  
    /**
     * The action method, verifies whether a specified action is taken by this user.
     * @access private
     * @return Mixed
     */
    public function action(){
        if(!$this->action) return NULL;
	    return $this->action->getValue();
    }
  
    /**
     * The checkrequest method, checks to see the request method of a particular user
     * @access private
     * @return Boolean
     */
    private function checkrequest(){
        // This method checks if there is user input, and returns the request_method if evaluated to be true
        if($_SERVER['REQUEST_METHOD'] == "POST"){
  	        $this->request = "post";
		    return TRUE;
	    }	
	    elseif($_SERVER['REQUEST_METHOD'] == "GET"){
	        $this->request = "get";
		    return TRUE;
	    }	
	    else $this->request = FALSE;
    }
  
    /**
     * The secure method, parse user input in a safe manner.
	 * @param Mixed  $data
     * @access public
     * @return Mixed
     */
    public function secure($data){
	    if(is_string($data)){
	        $data = htmlentities($data);
            $data = addslashes($data);	
	        $data = strip_tags($data, '');
            $data = str_replace("%20", " ", $data);
		}	
	    return $data;
    }  
}
?>