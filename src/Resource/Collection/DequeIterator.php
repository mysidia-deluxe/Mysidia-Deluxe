<?php

namespace Resource\Collection;
use Resource\Exception\IllegalStateException;
use Resource\Exception\NosuchElementException; 

/**
 * The DequeIterator Class, extending from QueueIterator Class.
 * It defines a standard dequeue iterator, it is usually used in ArrayDeque. 
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
class DequeIterator extends QueueIterator{

    /**
	 * The fence property, it defines the tail recorded at iterator construction.
	 * @access protected
	 * @var Int
    */		
	protected $fence;
	
    /**
	 * The last property, it specifies the last accessed index location.
	 * @access protected
	 * @var Int
    */		
	protected $last = -1;
		
	/**
     * Constructor of DequeIterator Class, initializes basic properties for the deque iterator.    
     * @param Dequeable  $deque
	 * @param Int  $index
     * @access public
     * @return Void
     */		
	public function __construct(Dequeable $deque){
	    parent::__construct($deque);
	    $this->cursor = $deque->getHead();
		$this->fence = $deque->getTail();
	}
	
 	/**
     * The hasNext method, checks if the iterator has not reached the end of its iteration yet.
     * @access public
     * @return Boolean
     */			
	public function hasNext(){
	    return ($this->cursor != $this->fence);
	}
	
	/**
     * The next method, returns the next object in the iteration.
     * @access public
     * @return Objective
     */		
	public function next(){
	    if(!$this->hasNext()) throw new NosuchElementException;
		$array = $this->queue->getArray();
		$object = $array[$this->cursor];
		$this->last = $this->cursor;
		$this->cursor = ($this->cursor + 1) & ($array->length() - 1);
		return $object;
	}
	
	/**
     * The remove method, removes from the underlying collection the last element returned by the iterator.
     * @access public
     * @return Void
     */	
	public function remove(){
	    if($this->last < 0) throw new IllegalStateException;
		$array = $this->queue->getArray();
        if($this->queue->delete($this->last)){
            $this->cursor = ($this->cursor - 1) & ($array->length() - 1);
			$this->fence = $this->queue->getTail();
        }
        $this->last = -1;		
	}
}
?>