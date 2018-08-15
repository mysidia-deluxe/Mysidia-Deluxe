<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The Stackable Interface, extending from the Listable interface.
 * It defines a standard interface for Stack type Collection objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

interface Stackable extends Listable{

 	/**
     * The peek method, looks at the object on top of the Stack without removing it.
	 * This method throws EmptyStackException if stack is empty.
     * @access public
     * @return Objective
     */		
	public function peek();
	
 	/**
     * The pop method, pops an object from the Stack and returns the removed object.
	 * The method throws an EmptyStackException if if the Stack is empty.
     * @access public
     * @return Objective
     */		
	public function pop();

 	/**
     * The push method, pushes an object onto the Stack and returns the pushed object.
	 * @param Objective  $object	 
     * @access public
     * @return Objective
     */			
	public function push(Objective $object);
	
	/**
     * The search method, searches through the Stack and returns 1-based position for an object.
     * @param Objective  $object 
     * @access public
     * @return Objective
     */		
	public function search(Objective $object);
	
}
    
?>