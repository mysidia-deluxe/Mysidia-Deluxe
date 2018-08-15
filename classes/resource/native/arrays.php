<?php

namespace Resource\Native;
use SplFixedArray, ArrayIterator, Exception;

/**
 * The Arrays Class, extending from SplFixedArray class
 * It defines how fixed sized numeric arrays are used in Mysidia Adoptables.
 * @category Resource
 * @package Native
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo None
 * @final
 *
 */

final class Arrays extends SplFixedArray implements Objective{

    /**
     * The each method, calls the given block once for each element in this Array.
     * @param Mixed  $block
     * @access public
     * @return Void
     */
    public function each($block){
        foreach($this as $element){
            call_user_func($block, $element);
        }
    } 

    /**
     * The equals method, checks whether target array is equivalent to this one.
     * @param Arrays  $array 
     * @access public
     * @return Boolean
     */
    public function equals(Objective $array){
	    if(!($array instanceof Arrays)) throw new InvalidArgumentException("Supplied argument array must be an instance of Arrays.");
        return ($this == $array);
    } 
	
    /**
     * The explode method, for array it simply returns the array itself.
     * @param String  $delimiter
     * @access public
     * @return Arrays
     */
    public function explode($delimiter = ","){
	    return $this;
    } 
			
			
	/**
     * The getClassName method, acquires the class name as Array.
     * @access public
     * @return String
     */		
    public function getClassName(){
	    return "Array";
	}
	
	/**
     * The getValue method, alias of method toArray().
     * @access public
     * @return Array
     */		
    public function getValue(){
	    return $this->toArray();
	}	
	
	/**
     * The iterator method, retrieves an ArrayIterator for this Array.
     * @access public
     * @return ArrayIterator
     */	
    public function iterator(){
        return new ArrayIterator($this->toArray());
    }	

	/**
     * The length method, returns the size of the array in java way.
     * @access public
     * @return Int
     */	
    public function length(){
        return $this->count();
    }	
	
	/**
     * The serialize method, serializes an array into string format.
     * @access public
     * @return String
     */
    public function serialize(){
        return serialize($this);
    }
   
    /**
     * The unserialize method, decode a string to its object representation.
	 * This method can be used to retrieve object info from Constants, Database and Sessions.
	 * @param String  $string
     * @access public
     * @return Arrays
     */
    public function unserialize($string){
        return unserialize($string);
    }
	
    /**
     * Magic method to_String() for Arrays class, returns basic array information.
     * @access public
     * @return String
     */	
	public function __toString(){
	    return "Array({$this->length()})";
	}
}
?>