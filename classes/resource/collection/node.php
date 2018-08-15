<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Native\Object; 

/**
 * The Node Class, extending from the root Object Class.
 * It defines a standard node type object that holds reference to its neighbor nodes.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class Node extends Object{

    /**
	 * The object property, it contains the actual object passed onto this Node.
	 * @access private
	 * @var Objective
     */
    private $object;
	
    /**
	 * The next property, it stores a reference of the next node adjacent to this Node.
	 * @access private
	 * @var Node
     */
    private $next;	
	
    /**
	 * The prev property, it stores a reference of the previous node adjacent to this Node.
	 * @access private
	 * @var Node
     */	
    private $prev;

	/**
     * Constructor of LinkedList Class, it initializes the LinkedList.
	 * @param Node  $prev	 
     * @param Objective  $object
	 * @param Node  $next
     * @access public
     * @return Void
     */	
	public function __construct(Objective $object = NULL, Node $next = NULL, Node $prev = NULL){
	    $this->object = $object;
		$this->next = $next;
		$this->prev = $prev;
	}
	
	/**
     * The get method, getter method for property $object. 
     * @access public
     * @return Objective
     */	
	public function get(){
	    return $this->object;
	}
		
	/**
     * The getNext method, getter method for property $next. 
     * @access public
     * @return Node
     */		
	public function getNext(){
	    return $this->next;
	}

	/**
     * The getPrev method, getter method for property $prev. 
     * @access public
     * @return Node
     */			
	public function getPrev(){
	    return $this->prev;
	}
	
	/**
     * The set method, setter method for property $object. 
	 * @param Objective  $object
     * @access public
     * @return Void
     */		
	public function set(Objective $object = NULL){
	    $this->object = $object;
	}
	
	/**
     * The setNext method, setter method for property $next. 
	 * @param Node  $next
     * @access public
     * @return Void
     */			
	public function setNext(Node $next = NULL){
	    $this->next = $next;
	}
	
	/**
     * The setPrev method, setter method for property $prev. 
	 * @param Node  $prev
     * @access public
     * @return Void
     */		
	public function setPrev(Node $prev = NULL){
	    $this->prev = $prev;
	}	
}
?>