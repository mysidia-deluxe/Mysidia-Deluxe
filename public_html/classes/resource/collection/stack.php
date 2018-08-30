<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Exception\EmptyStackException;

/**
 * The Stack Class, extending from ArrayList class and implementing Stackable Interface.
 * It defines a standard class to handle stack type collections, similar to Java's ArrayList.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class Stack extends ArrayList implements Stackable{

	/**
	 * serialID constant, it serves as identifier of the object being Stack.
     */
    const SERIALID = "1224463164541339165L";

	/**
     * Constructor of Stack Class, it initializes the stack given its size or another Collection Object.    
     * @param Int|Collective  $param
     * @access public
     * @return Void
     */	
	public function __construct($param = 10){
	    parent::__construct($param);
	}
	
 	/**
     * The peek method, looks at the object on top of the Stack without removing it.
	 * This method throws EmptyStackException if stack is empty.
     * @access public
     * @return Objective
     */		
	public function peek(){
	    if($this->isEmpty()) throw new EmptyStackException;
		return $this->get($this->size() - 1);
	}
	
 	/**
     * The pop method, pops an object from the Stack and returns the removed object.
	 * The method throws an EmptyStackException if if the Stack is empty.
     * @access public
     * @return Objective
     */		
	public function pop(){
	    $object = $this->peek();
		$this->delete($this->size() - 1);
		return $object;
	}  

 	/**
     * The push method, pushes an object onto the Stack and returns the pushed object.
	 * @param Objective  $object	 
     * @access public
     * @return Objective
     */			
	public function push(Objective $object){
        $this->add($object);
        return $object;		
	}	
	
	/**
     * The search method, searches through the Stack and returns 1-based position for an object.
     * @param Objective  $object 
     * @access public
     * @return Objective
     */		
	public function search(Objective $object){
	    $index = $this->lastIndexOf($object);
		if($index > 0) return ($this->size() - $index);
		return $index;
	}	
}
?>