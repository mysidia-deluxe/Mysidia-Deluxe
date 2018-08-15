<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Exception\IllegalStateException;

/**
 * The PriorityQueueIterator Class, extending from QueueIterator Class.
 * It defines a standard priority queue iterator, it is usually used in PriorityQueue. 
 * Note that this iterator may NOT traverse in specified order.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class PriorityQueueIterator extends QueueIterator{
	
    /**
	 * The unvisited property, it stores a collection of unvisited portion of the heap that we must iterate through this time.
	 * @access protected
	 * @var ArrayDeque
    */
	protected $unvisited;	
		
    /**
	 * The lastIndex property, it specifies the last accessed index location.
	 * @access protected
	 * @var Int
    */		
	protected $lastIndex = -1;
	
    /**
	 * The lastObject property, it holds a reference to the last accessed object.
	 * @access protected
	 * @var Objective
    */		
	protected $lastObject;	
	
	/**
     * Constructor of PriorityQueueIterator Class, it simply calls parent constructor.   
     * @param PriorityQueue  $queue
     * @access public
     * @return Void
     */		
	public function __construct(PriorityQueue $queue){
	    parent::__construct($queue);
	}
	
 	/**
     * The hasNext method, checks if the iterator has not reached the end of its iteration yet.
     * @access public
     * @return Boolean
     */			
	public function hasNext(){
	    return ($this->cursor < $this->queue->size() or ($this->unvisited != NULL and !$this->unvisited->isEmpty()));
	}
	
	/**
     * The next method, returns the next object in the iteration.
     * @access public
     * @return Objective
     */		
	public function next(){
	    if($this->cursor < $this->queue->size()){           
            $array = $this->queue->getArray();
            return $array[$this->lastIndex = $this->cursor++];
        }
		if($this->unvisited != NULL){
		    $this->lastIndex = -1;
			$this->lastObject = $this->unvisited->poll();
			if($this->lastObject != NULL) return $this->lastObject;
		}
		throw new EmptyElementException;
	}
	
	/**
     * The remove method, removes from the underlying collection the last element returned by the iterator.
     * @access public
     * @return Void
     */	
	public function remove(){
	    if($this->lastIndex != -1){
            $moved = $this->queue->delete($this->lastIndex);
			$this->lastIndex = -1;
			if($moved == NULL) $this->cursor--;
			else{
			    if($this->unvisited == NULL) $this->unvisited = new ArrayDeque;
				$this->unvisited->add($moved);
			}
        }
        elseif($this->lastObject != NULL){
            $this->queue->removeEq($this->lastObject);
			$this->lastObject = NULL;
        }
        else throw new IllegalStateException;		
	}
}
?>