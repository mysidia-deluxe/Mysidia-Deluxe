<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The KeyMapSet Class, extending from the abstract MapSet Class.
 * It defines a standard set to hold keys in a Map, it is important for Map type objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
class KeyMapSet extends MapSet{
	
    /**
     * Constructor of KeyMapSet Class, it simply calls parent constructor.
	 * @param Mappable  $map
     * @access public
     * @return Void
     */	
	public function __construct(Mappable $map){
	    parent::__construct($map);
	}

	/**
     * The contains method, checks if a given key is already on the KeyMapSet.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */		
	public function contains(Objective $object){
	    return $this->map->containsKey($object);
	}
	
	/**
     * The iterator method, acquires an instance of the key iterator object of the KeyMapSet.
     * @access public
     * @return KeyIterator
     */			
    public function iterator(){
	    return $this->map->entrySet()->keyIterator();
	}
}
?>