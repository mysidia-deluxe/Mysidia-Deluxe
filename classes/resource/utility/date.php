<?php

namespace Resource\Utility;
use DateTime, DateTimeZone;
use Resource\Native\Objective;

/**
 * The Date Class, it is part of the utility package and extends from the DateTime Class.
 * It implements the root Object interface, and defines a __toString method.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not sure, but will come in handy.
 */

class Date extends DateTime implements Objective{

	/**
	 * The format property, it defines output format for the Date Object.
	 * @access private
	 * @var String
    */
    private $format = "Y-m-d";
 
 
    /**
     * The constructor for Date Class, it calls parent constructor and sets format property if necessary.
	 * @param String  $time
	 * @param DateTimeZone $timezone
	 * @param Format  $format
     * @access public
     * @return Void
     */
    public function __construct($time = "now", DateTimeZone $timezone = NULL, $format = NULL){
        parent::__construct($time, $timezone);
		if($format) $this->setFormat($format);
    }
	
    /**
     * The equals method, checks whether target date is equivalent to this one.
     * @param Objective  $object	 
     * @access public
     * @return Boolean
     */
    public function equals(Objective $object){
        if($object instanceof DateTime) return ($this->hashCode() == $object->hashCode());
		return FALSE;
    }	
	
    /**
     * The getClassName method, returns class name of this very class. 
     * @access public
     * @return String
     */	
    public function getClassName(){
        return $this->getClass();   
    }	
	
    /**
     * The getFormat method, getter method for property $format. 
     * @access public
     * @return String
     */	
    public function getFormat(){
	    return $this->format;
	}

	/**
     * The hashCode method, returns the hash code for the very Date.
     * @access public
     * @return Int
     */			
    public function hashCode(){
	    return hexdec(spl_object_hash($this));
    }

	/**
     * The serialize method, serializes the date into string format.
     * @access public
     * @return String
     */
    public function serialize(){
        return serialize($this);
    }
	
    /**
     * The setFormat method, setter method for property $format. 
	 * @param String  $format
     * @access public
     * @return Void
     */	
    public function setFormat($format){
	    $this->format = $format;
	}	

    /**
     * The unserialize method, decode a string to its date representation.
	 * @param String  $string
     * @access public
     * @return String
     */
    public function unserialize($string){
        return unserialize($string);
    }		
	
    /**
     * Magic method __toString() for Date class, outputs date information.
     * @access public
     * @return String
     */
    public function __toString(){
        return get_class($this);
    }    
}
}