<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The abstract Set Class, extending from the abstract Collection Class and implements Settable Interface.
 * It is parent to all Set type objects, subclasses have access to all its defined methods.
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

abstract class Set extends Collection implements Settable{

 	/**
     * The equals method, evaluates if the given set is equivalent to the set.
	 * This implementation is different from a typical equals method for objects.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */		
    public function equals(Objective $object){
        if($object === $this) return TRUE;
		if(!($object instanceof Set)) return FALSE;		
        if($this->size() != $object->size()) return FALSE;
        return $this->containsAll($element);
    }
	
	/**
     * The hashCode method, returns the hash code for this set.
     * @access public
     * @return Int
     */			
    public function hashCode(){
	    $hash = 0;
		$iterator = $this->iterator;
		while($iterator->hasNext()){
		    $object = $iterator->next();
			if($object != NULL) $hash += $object->hashCode();
		}
		return $hash;
    }
	
 	/**
     * The removeAll method, removes a collection of objects from this set.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */			
    public function removeAll(Collective $collection){
        $deleted = FALSE;
        if($this->size() > $collection->size()){
            $iterator = $collection->iterator();
            while($iterator->hasNext()) {
                $this->remove($iterator->next());
                $deleted = TRUE;
            }
        }
        else{
            $iterator = $this->iterator();
            while($iterator->hasNext()){
                if($collection->contains($iterator->next())){
                    $iterator->remove($next);
                    $deleted = TRUE;
                }
            }
        }
        return $deleted;
    }	

	/**
     * The subSet method, acquires a portion of the Set ranging from the supplied two elements.
	 * @param Objective  $fromElement
	 * @param Objective  $toElement
     * @access public
     * @return Settable
     */		
	public function subSet(Objective $fromElement, Objective $toElement){
	    return FALSE;
	}	
}
?>