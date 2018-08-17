<?php

namespace Resource\Collection;
use Countable, IteratorAggregate;
use Resource\Native\Objective;
use Resource\Native\Object;
use Resource\Native\Mystring;

/**
 * The Collective Interface, extending from the Objective interface.
 * It defines a standard interface for any Collection Objects to implement.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
interface Collective extends Objective, Countable, IteratorAggregate{

 	/**
     * The add method, append an object to the end of the collection.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */	
	public function add(Objective $object);

 	/**
     * The addAll method, append a collection of objects to the end of the Collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */		
	public function addAll(Collective $collection);
	
 	/**
     * The clear method, drops all objects currently stored in Collection.
     * @access public
     * @return Void
     */			
	public function clear();
	
	/**
     * The contains method, checks if a given object is already on the Collection.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */		
	public function contains(Objective $object);
	
	/**
     * The containsAll method, checks if a collection of objects are all available on the Collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */		
	public function containsAll(Collective $collection);
	
	/**
     * The hashCode method, returns the hash code for this collection.
     * @access public
     * @return String
     */		
	public function hashCode();
	
	/**
     * The isEmpty method, checks if the collection is empty or not.
     * @access public
     * @return Boolean
     */		
	public function isEmpty();
	
	/**
     * The iterator method, acquires an instance of the iterator object of this collection.
     * @access public
     * @return Iterator
     */			
    public function iterator();
	
 	/**
     * The remove method, removes a supplied Object from this collection.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */		
	public function remove(Objective $object);
	
 	/**
     * The removeAll method, removes a collection of objects from this collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */			
	public function removeAll(Collective $collection);
	
	/**
     * The removeAll method, removes everything but the given collection of objects from this collection.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */			
	public function retainAll(Collective $collection);
	
	/**
     * The size method, returns the current size of the collection.
     * @access public
     * @return Int
     */			
    public function size();
	
	/**
     * The toArray method, acquires an array copy of the objects stored in the collection.
     * @access public
     * @return Array
     */			
	public function toArray();
	
}
    
?>