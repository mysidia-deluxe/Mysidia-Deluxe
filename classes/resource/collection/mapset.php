<?php

namespace Resource\Collection;

/**
 * The abstract MapSet Class, extending from the abstract Set Class.
 * It defines a standard set to hold keys or values in a Map, but it is abstract.
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

abstract class MapSet extends Set{

    /**
	 * The map property, it stores a reference to the source Map object.
	 * @access protected
	 * @var Mappable
    */
	protected $map; 
	
    /**
     * Constructor of MapSet Class, it initializes the MapSet by assigning a reference of the source Map Object.
	 * @param Mappable  $map
     * @access public
     * @return Void
     */	
	public function __construct(Mappable $map){
	    $this->map = $map;
	}

 	/**
     * The clear method, drops all objects currently stored in MapSet.
     * @access public
     * @return Void
     */			
	public function clear(){
        $this->map->clear();
    }	
	
	/**
     * The isEmpty method, checks if the MapSet is empty or not.
     * @access public
     * @return Boolean
     */		
	public function isEmpty(){
	    return $this->map->isEmpty();
	}
	
	/**
     * The size method, returns the current size of the MapSet.
     * @access public
     * @return Int
     */			
    public function size(){
	    return $this->map->size();
	}
}
?>