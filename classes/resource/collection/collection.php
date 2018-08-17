<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Native\Object;
use Resource\Native\Mystring; 
use Resource\Exception\UnsupportedOperationException;

/**
 * The abstract Collection Class, extending from the root Object Class and implements Collective Interface.
 * It is parent to all Collection objects, subclasses have access to all its defined methods.
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
 
abstract class Collection extends Object implements Collective{

 	/**
     * The add method, append an object to the end of the collection.
	 * The method is disabled in abstract collection class, thus child class must implement its own version of add method.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */	
	public function add(Objective $object){
	    throw new UnsupportedOperationException;
	}
	
 	/**
     * The addAll method, append a collection of objects to the end of the Collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */	
	public function addAll(Collective $collection){
	    $added = FALSE;
		foreach($collection as $object){
		    if($this->add($object)) $added = TRUE;
		}
		return $added;
	}	

 	/**
     * The clear method, drops all objects currently stored in Collection.
     * @access public
     * @return Void
     */				
	public function clear(){
	    $iterator = $this->iterator();
		while($iterator->hasNext()){
		    $iterator->next();
			$iterator->remove();
		}
	}
	
	/**
     * The contains method, checks if a given object is already on the Collection.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */			
	public function contains(Objective $object){
	    $iterator = $this->iterator();		
		while($iterator->hasNext()){
			if($object->equals($iterator->next())) return TRUE;
	    }		
		return FALSE;
	}
	
	/**
     * The containsAll method, checks if a collection of objects are all available on the Collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */			
	public function containsAll(Collective $collection){
	    foreach($collection as $object){
		    if(!$this->contains($object)) return FALSE;
		}
		return TRUE;
	}

	/**
     * The count method, alias to the size() method.
     * @access public
     * @return Int
     */		
	public function count(){
        return $this->size();
    }

	/**
     * The getIterator method, alias to the iterator() method.
     * @access public
     * @return Iterator
     */			
    public function getIterator(){
        return $this->iterator();
    }

	/**
     * The hashCode method, returns the hash code for this collection.
	 * The method is disabled in abstract collection class, thus child class must implement its own version of hashCode method.
     * @access public
     * @return String
     */		
	public function hashCode(){
	    return NULL;
	}
	
	/**
     * The isEmpty method, checks if the collection is empty or not.
     * @access public
     * @return Boolean
     */		
	public function isEmpty(){
	    return ($this->size() == 0);
	}

 	/**
     * The remove method, removes a supplied Object from this collection.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */		
	public function remove(Objective $object){
	    $iterator = $this->iterator();
		while($iterator->hasNext()){
			if($object->equals($iterator->next())){
			    $iterator->remove();
				return TRUE;
			}
	    }		
		return FALSE;
	}

 	/**
     * The removeAll method, removes a collection of objects from this collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */		
	public function removeAll(Collective $collection){
	    $removed = FALSE;
		$iterator = $this->iterator();
		while($iterator->hasNext()){
		    if($collection->contains($iterator->next())){
			    $iterator->remove();
				$removed = TRUE;
			}
		}
		return $removed;
	}
	
	/**
     * The removeAll method, removes everything but the given collection of objects from this collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */			
	public function retainAll(Collective $collection){
		$retained = FALSE;
		$iterator = $this->iterator();
		while($iterator->hasNext()){
		    if(!$collection->contains($iterator->next())){
			    $iterator->remove();
				$retained = TRUE;
			}
		}
		return $retained;
	}
	
	/**
     * The toArray method, acquires an array copy of the objects stored in the collection.
     * @access public
     * @return Array
     */				
	public function toArray(){
	    $iterator = $this->iterator();
		$size = $iterator->size();
	    $array = array();
		for($i = 0; $i < $size; $i++){
		    $array[$i] = $iterator->next();
		}
		return $array;
	}
	
	/**
     * The magic method __toString, defines the string expression of the collection.
     * @access public
     * @return String
     */	
	public function __toString(){
	    $iterator = $this->iterator();
		if(!$iterator->valid()) return new String("[]");
		
		$stringBuilder = new String("[");
		while($iterator->hasNext()){
		    $object = $iterator->next();
			$stringBuilder->add(($object == $this) ? "(this collection)" : $object);
			if(!$iterator->hasNext()) {
			    $stringBuilder->add("]");
				return $stringBuilder;
			}
			$stringBuilder->add(", ");
		}
	}

	/**
     * The abstract size method, must be implemented by child class.
     * @access public
     * @return Int
	 * @abstract
     */		
    public abstract function size();
	
	/**
     * The abstract iterator method, must be implemented by child class.
     * @access public
     * @return Iterator
	 * @abstract
     */		
	public abstract function iterator();	
}
?>