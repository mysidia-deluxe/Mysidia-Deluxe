<?php

namespace Resource\Utility;
use ArrayObject;
use Resource\Native\Object;

/**
 * The MetaMethod Class, it is part of the utility package and extends from the Object Class.
 * It implements PHP basic method/function manipulation functionalities, which can come in handy.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not sure, but will come in handy.
 */

final class MetaMethod extends Object{

	/**
	 * The args property, it stores an array of arguments.
	 * @access private
	 * @var ArrayObject
    */
    private $params;
	
	/**
	 * The num property, it stores the number of arguments.
	 * @access private
	 * @var Int
    */
    private $num;	
 
    /**
     * The getArg method, return an argument from the argument list.
	 * @param Int  $index
	 * @access public
     * @return String
     */	
    public function getParam($index = 0){
	    if(!$this->params) $this->params = new ArrayObject(func_get_args());
        return $this->params[$index];
    } 
 
    /**
     * The getParams method, return an array of parameters.
	 * @access public
     * @return ArrayObject
     */	
    public function getParams(){
	    if(!$this->params) $this->params = new ArrayObject(func_get_args());
        return $this->params;
    }
	
    /**
     * The numArgs method, return the number of arguments.
	 * @access public
     * @return Int
     */		
	public function numArgs(){
	    if(!$this->num) $this->num = func_num_args();
		return $this->num;
	}
		
    /**
     * The call method, it calls a callback from a class instance method.
	 * @access public
     * @return Void
     */		
	public function call(){
		if($this->numArgs() < 2) throw new Exception("Invalid callback method specified.");
		$params = $this->getParams()->getArrayCopy();
		$class = array_shift($params);
		$method = array_shift($params);
		return call_user_func_array(array($class, $method), $params);	
	}
	
    /**
     * The callStatic method, it calls a callback from a class static method.
	 * @access public
     * @return Method
     */		
	public function callStatic(){
		if($this->numArgs() < 2) throw new Exception("Invalid callback method specified.");
		$params = $this->getParams()->getArrayCopy();
		$class = array_shift($param);
		$method = array_shift($params);
		return forward_static_call_array(array($class, $method), $params);
	}
	
    /**
     * The anonymous method, creates a lambda method.
	 * @access public
     * @return Method
     */	
    public function anonymous($params, $code){
        return create_function($params, $code);	
    }
	
    /**
     * The reset method, reset the MetaMethod object so that it can be used for other methods.
	 * @access public
     * @return Void
     */		
	public function reset(){
	    $this->params = NULL;
		$this->num = NULL;
	}
}