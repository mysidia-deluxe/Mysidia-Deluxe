<?php

namespace Resource\Utility;
use Resource\Native\Object;

/**
 * The MetaProperty Class, it is part of the utility package and extends from the Object Class.
 * It implements PHP basic variable/property manipulation functionalities, which can come in handy.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not sure, but will come in handy.
 */

final class MetaProperty extends Object{

	/**
	 * The type property, it stores the type of a property/variable.
	 * @access private
	 * @var String
    */
    private $type;
 
    /**
     * The getType method, return a type of the property/variable supplied.
	 * @param Object  $var
	 * @access public
     * @return String
     */	
    public function getType($var = ""){
	    $this->type = gettype($var);
	    return $this->type;
    } 

    /**
     * The getType method, returns the value of a variable as a specific type.
	 * @param Object  $var
	 * @param String  $type
	 * @access public
     * @return Boolean
     */	
    public function getValue($var = "", $type = ""){
	    $method = $type."val";
		return $method($var);
    }

    /**
     * The exists method, evaluates if a variable is declared.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function exists($var){
	    return isset($var);
	} 	
	
    /**
     * The isEmpty method, evaluates if a variable is empty.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isEmpty($var){
	    return empty($var);
	} 

    /**
     * The isNull method, evaluates if a variable is null.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isNull($var){
	    return is_null($var);
	}
	
	/**
     * The isScalar method, evaluates if a variable is scalar.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isScalar($var){
	    return is_scalar($var);
	}		
	
    /**
     * The isNumeric method, evaluates if a variable is numeric.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isNumeric($var){
	    return is_numeric($var);
	}

    /**
     * The isInteger method, evaluates if a variable is integer.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isInteger($var){
	    return is_int($var);
	}	

    /**
     * The isFloat method, evaluates if a variable is a floating number.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isFloat($var){
	    return is_float($var);
	}	
	
    /**
     * The isBoolean method, evaluates if a variable is boolean.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isBoolean($var){
	    return is_bool($var);
	}
	
    /**
     * The isString method, evaluates if a variable is a string.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isString($var){
	    return is_string($var);
	}	
		
	/**
     * The isArray method, evaluates if a variable is an array.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isArray($var){
	    return is_array($var);
	}

	/**
     * The isObject method, evaluates if a variable is an object.
	 * @param Object  $var
	 * @access public
     * @return Boolean
     */		
    public function isObject($var){
	    return is_object($var);
	}		
	
    /**
     * The reset method, reset the MetaProperty object so that it can be used for other properties.
	 * @access public
     * @return Void
     */		
	public function reset(){
	    $this->type = NULL;
		$this->scalar = FALSE;
	}
}