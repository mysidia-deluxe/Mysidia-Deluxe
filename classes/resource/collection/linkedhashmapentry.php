<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Exception\IllegalArgumentException;

/**
 * The LinkedHashMapEntry Class, extending from the HashMapEntry Class.
 * It defines a standard entry for LinkedHashMap type objects, which usually comes in handy.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class LinkedHashMapEntry extends HashMapEntry{
	
    /**
	 * The before property, it stores the MapEntry that comes before.
	 * @access protected
	 * @var MapEntry
    */
	protected $before;	
		
    /**
	 * The after property, it stores the MapEntry that comes after.
	 * @access protected
	 * @var MapEntry
    */
	protected $after;		

	/**
     * Constructor of LinkedHashMapEntry Class, it initializes a LinkedMapEntry with a key and a value.
	 * @param Int  $hash
     * @param Objective  $key
	 * @param Objective  $value
	 * @param MapEntry  $entry
     * @access public
     * @return Void
     */	
	public function __construct($hash = 0, Objective $key = NULL, Objective $value = NULL, MapEntry $entry = NULL){
	    parent::__construct($hash, $key, $value, $entry);
	}
	
 	/**
     * The addBefore method, inserts this entry before the specified existing entry in the list.
     * @param MapEntry  $entry
     * @access public
     * @return Void
     */		
	public function addBefore(MapEntry $entry){
        $this->after = $entry;
        $this->before = $entry->getBefore();
        $this->before->setAfter($this);
        $this->after->setBefore($this);      	
	}
	
	/**
     * The getAfter method, getter method for property $after. 
     * @access public
     * @return MapEntry
     */		
	public function getAfter(){
	    return $this->after;
	}

	/**
     * The getBefore method, getter method for property $before. 
     * @access public
     * @return MapEntry
     */		
	public function getBefore(){
	    return $this->before;
	}		
	
	/**
     * The recordAccess method, it is invoked whenever the value in an entry is overriden with put method.
     * @access public
     * @return Void
     */		
	public function recordAccess(HashMap $map){
	    if(!($map instanceof LinkedHashMap)) throw new IllegalArgumentException;
		if($map->getOrder()){
		    $this->remove();
			$this->addBefore($map->getHeader());
		}
	}
	
	/**
     * The recordRemoval method, it is invoked whenever the value in an entry is removed from LinkedHashMap.
     * @access public
     * @return Void
     */		
	public function recordRemoval(HashMap $map){
	    $this->remove();
	}	

 	/**
     * The remove method, removes this entry from the LinkedHashMap.
     * @param Objective  $key
     * @access public
     * @return Void
     */		
	public function remove(){
        $this->before->setAfter($this->after);
        $this->after->setBefore($this->before);		
	}
	
	/**
     * The setAfter method, setter method for property $after. 
	 * @param MapEntry  $after
     * @access public
     * @return Void
     */			
	public function setAfter(MapEntry $after = NULL){
	    $this->after = $after;
	}

	/**
     * The setBefore method, setter method for property $before. 
	 * @param MapEntry  $before
     * @access public
     * @return Void
     */			
	public function setBefore(MapEntry $before = NULL){
	    $this->before = $before;
	}		
}
?>