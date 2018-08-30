<?php

namespace Resource\Collection; 

/**
 * The DescendingKeyIterator Class, extending from the abstract TreeMapIterator Class.
 * It defines a standard descending iterator for TreeMap, it traverses in reverse order.
 * This is a final class, and thus no child class shall inherit from it. 
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 * @final
 *
 */
 
final class DescendingKeyIterator extends TreeMapIterator{
		
	/**
     * The next method, returns the next key in iteration.
     * @access public
     * @return Objective
     */		
	public function next(){
	    return $this->prevEntry()->getKey();	
	}
	
	/**
     * The nextValue method, returns the next value in iteration.
     * @access public
     * @return Objective
     */		
	public function nextValue(){
	    return $this->prevEntry()->getValue();	
	}		
}
?>