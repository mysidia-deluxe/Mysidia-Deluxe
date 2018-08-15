<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The KeySet Class, extending from the KeyMapSet Class.
 * It defines a standard set to hold keys in a HashMap, it is important for HashMap type objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class KeySet extends KeyMapSet{
	
    /**
     * Constructor of KeySet Class, it simply calls parent constructor.
	 * @param HashMap  $map
     * @access public
     * @return Void
     */	
	public function __construct(HashMap $map){
	    parent::__construct($map);
	}
	
	/**
     * The iterator method, acquires an instance of the key iterator object of the KeySet.
     * @access public
     * @return KeyIterator
     */			
    public function iterator(){
	    return $this->map->keyIterator();
	}
	
	/**
     * The remove method, removes the underlying value in Iterator given its current key.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */		
	public function remove(Objective $object){
	    return $this->map->removeKey($object);
	}	
}
?>