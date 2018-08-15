<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Exception\IllegalArgumentException;
use Resource\Exception\IllegalStateException;
use Resource\Exception\NosuchElementException;

/**
 * The abstract Queue Class, extending from abstract Collection class and implementing Queueable Interface.
 * It defines a standard class to handle queue type collections, similar to Java's Abstract Queue.
 * However, this class is abstract and thus needs concrete implementation in order to use its functionalities.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 * @abstract
 *
 */

abstract class Queue extends Collection implements Queueable{

	/**
     * Constructor of Queue Class, it simply calls parent constructor.   
     * @access public
     * @return Void
     */	
	public function __construct(){
	    parent::__construct();
	}

 	/**
     * The add method, append an object to the end of the Queue.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */		
    public function add(Objective $object){
	    if($this->offer($object)) return TRUE;
        else throw new IllegalStateException;		
	}
	
 	/**
     * The addAll method, append a collection of objects to the end of the Queue.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */	
	public function addAll(Collective $collection){
	    if($collection == $this) throw IllegalArgumentException;
		$modified = FALSE;
		$iterator = $collection->iterator();
		while($iterator->hasNext()){
		    if($this->add($object)) $modified = TRUE;  
		}
		return $modified;
	}

 	/**
     * The clear method, drops all objects currently stored in the Queue.
     * @access public
     * @return Void
     */				
	public function clear(){
	    while($this->poll() != NULL);
	}		

 	/**
     * The element method, retrieves but not remove the head of the queue.
	 * This method throws an Exception if the Queue is empty.
     * @access public
     * @return Objective
     */		
	public function element(){
        $object = $this->peek();
		if($object == NULL) throw new NosuchElementException;
		return $object;
    }	
	
 	/**
     * The erase method, removes and retrieve the head of the queue.
	 * This method throws an Exception if the Queue is empty.
     * @access public
     * @return Objective
     */			
	public function erase(){
        $object = $this->poll();
		if($object == NULL) throw new NosuchElementException;
		return $object;
    }		
}
?>