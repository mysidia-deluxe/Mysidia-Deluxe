<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Exception\IllegalStateException;

/**
 * The ListIterator Class, extending from abstract CollectionIterator.
 * It defines a standard list iterator, it can traverse forward or backward.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class ListIterator extends CollectionIterator{

    /**
	 * The list property, it stores a reference to the list object.
	 * @access protected
	 * @var Lists
    */
	protected $list;
		
    /**
	 * The last property, it specifies the last accessed index location.
	 * @access protected
	 * @var Int
    */		
	protected $last = -1;
	
	/**
     * Constructor of ListIterator Class, initializes basic properties for the list iterator.    
     * @param Lists  $list
	 * @param Int  $index
     * @access public
     * @return Void
     */		
	public function __construct(Lists $list, $index = 0){
	    $this->list = $list;
		$this->cursor = $index;
	}
	
 	/**
     * The add method, append an object to the end of the iterator.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */		
	public function add(Objective $object){
	    $this->list->insert($this->cursor, $object);
		$this->last = -1;
		$this->cursor++;		
	}

 	/**
     * The current method, returns the object at the current index. 
     * @access public
     * @return Objective
     */			
	public function current(){
	    return $this->list->get($this->cursor);
	}

 	/**
     * The getList method, fetches the internal List object to external script.
     * @access public
     * @return Listable
     */		
	public function getList(){
	    return $this->list;
	}	
	
 	/**
     * The hasNext method, checks if the iterator has not reached the end of its iteration yet.
     * @access public
     * @return Boolean
     */			
	public function hasNext(){
	    return ($this->cursor != $this->list->size());
	}

 	/**
     * The hasPrevious method, checks if the list iterator has objects before its current index.
     * @access public
     * @return Boolean
     */		
	public function hasPrevious(){
	    return ($this->cursor != 0);
	}
	
	/**
     * The next method, returns the next object in the iteration.
     * @access public
     * @return Objective
     */		
	public function next(){
	    $next = $this->current();
		$this->cursor++;
		$this->last = $this->cursor - 1;
		return $next;
	}
	
	/**
     * The nextIndex method, return the next index on the list iterator.
     * @access public
     * @return Int
     */	
	public function nextIndex(){
	    return $this->cursor;
	}

 	/**
     * The nextIndex method, acquires the previous object on the list iterator.
     * @access public
     * @return Objective
     */		
	public function previous(){
	    $this->cursor--;
	    $previous = $this->list->get($this->cursor);
		$this->last = $this->cursor;
		return $previous;
	}

 	/**
     * The previousIndex method, return the previous index on the list iterator.
     * @access public
     * @return Int
     */			
	public function previousIndex(){
	    return ($this->cursor - 1);
	}
	
	/**
     * The remove method, removes from the underlying collection the last element returned by the iterator.
     * @access public
     * @return Void
     */	
	public function remove(){
	    if($this->last < 0) throw new IllegalStateException;
        $this->list->delete($this->last);
		if($this->last < $this->cursor) $this->cursor--;
		$this->last = -1;		
	}

	/**
     * The set method, updates the object at the current index.
     * @param Objective  $object 
     * @access public
     * @return Void
     */		
	public function set(Objective $object){
	    if($this->last < 0) throw new IllegalStateException;
		$this->list->set($this->last, $object);		
	}
}
?>