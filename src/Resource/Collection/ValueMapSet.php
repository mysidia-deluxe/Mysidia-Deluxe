<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The ValueMapSet Class, extending from the abstract MapSet Class.
 * It defines a standard set to hold values in a Map, it is important for Map type objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class ValueMapSet extends MapSet{
	
    /**
     * Constructor of ValueMapSet Class, it simply calls parent constructor.
	 * @param Mappable  $map
     * @access public
     * @return Void
     */	
	public function __construct(Mappable $map){
	    parent::__construct($map);
	}

	/**
     * The contains method, checks if a given value is already on the ValueMapSet.
     * @param Objective  $value 
     * @access public
     * @return Boolean
     */		
	public function contains(Objective $object){
	    return $this->map->containsValue($object);
	}
	
	/**
     * The iterator method, acquires an instance of the value iterator object of the ValueMapSet.
     * @access public
     * @return ValueIterator
     */			
    public function iterator(){
	    return $this->map->entrySet()->valueIterator();
	}
}
?>