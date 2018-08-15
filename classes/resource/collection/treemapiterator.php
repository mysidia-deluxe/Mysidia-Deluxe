<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Exception\IllegalStateException;
use Resource\Exception\NosuchElementException;

/**
 * The abstract TreeMapIterator Class, extending from the abstract CollectionIterator Class.
 * It defines a base tree map iterator, it must be extended by subclasses. 
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

abstract class TreeMapIterator extends CollectionIterator{

    /**
	 * The map property, it stores a reference to the TreeMap object.
	 * @access private
	 * @var TreeMap
    */		
	private $map;

    /**
	 * The current property, it specifies the current Entry to return.
	 * @access private
	 * @var TreeMapEntry
    */		
	private $current;
	
    /**
	 * The next property, it defines the next Entry in iteration.
	 * @access private
	 * @var TreeMapEntry
    */		
	private $next;	

	/**
     * Constructor of TreeMapIterator Class, initializes basic properties for the iterator. 
     * @param TreeMap  $map
	 * @param MapEntry  $first
     * @access public
     * @return Void
     */		
	public function __construct(TreeMap $map, MapEntry $first){
	    $this->map = $map;
		$this->next = $first;
	}	

 	/**
     * The current method, returns the current entry in the iterator.
     * @access public
     * @return Entry
     */			
	public function current(){
	    return $this->current;
	}	
	
	/**
     * The hasNext method, checks if the iterator has next entry.
	 * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Entry
	 * @final
     */		
	public final function hasNext(){
	    return ($this->next != NULL);    
	}	
	
	/**
     * The nextEntry method, returns the next entry in iteration.
	 * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Entry
	 * @final
     */		
	public final function nextEntry(){
	    $entry = $this->next;   
        if($entry == NULL) throw new NosuchElementException;
        $this->next = $this->map->successor($entry);
		$this->current = $entry;
        return $entry;		
	}
	
	/**
     * The prevEntry method, returns the previous entry in iteration.
	 * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Entry
	 * @final
     */		
	public final function prevEntry(){
	    $entry = $this->next;
        if($entry == NULL) throw new NosuchElementException;
        $this->next = $this->map->predecessor($entry);
		$this->current = $entry;
        return $entry;		
	}	

	/**
     * The remove method, removes from the underlying value associated with the current key in iteration.
     * @access public
     * @return Void
     */	
	public function remove(){
	    if($this->current == NULL) throw new IllegalStateException;
		if($this->current->getLeft() != NULL and $this->current->getRight() != NULL) $this->next = $this->current;
		$this->map->deleteEntry($this->current);
		$this->current = NULL;
	}	
}
?>