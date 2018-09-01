<?php

namespace Resource\Collection;

use Resource\Native\Objective;
use Resource\Exception\IllegalStateException;
use Resource\Exception\NosuchElementException;

/**
 * The LinkedListIterator Class, extending from ListIterator Class.
 * It defines a standard linked list iterator, it can traverse forward or backward.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class LinkedListIterator extends ListIterator
{
    
    /**
     * The next property, it specifies the next Node in iteration.
     * @access private
     * @var Node
    */
    private $next;

    /**
     * The prev property, it specifies the last Node in iteration.
     * @access private
     * @var Node
    */
    private $prev;
    
    /**
     * Constructor of LinkedListIterator Class, initializes basic properties for the linked list iterator.
     * @param LinkedList  $list
     * @param Int  $index
     * @access public
     * @return Void
     */
    public function __construct(LinkedList $list, $index = 0)
    {
        parent::__construct($list, $index);
        $this->next = $list->node($index);
    }
    
    /**
     * The add method, append an object to the end of the linked list iterator.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function add(Objective $object)
    {
        $this->prev = null;
        if ($this->next == null) {
            $this->list->linkLast($object);
        } else {
            $this->list->linkBefore($object, $this->next);
        }
        $this->cursor++;
    }

    /**
     * The hasPrevious method, checks if the linked list iterator has objects before its current index.
     * @access public
     * @return Boolean
     */
    public function hasPrevious()
    {
        return ($this->cursor > 0);
    }
    
    /**
     * The next method, returns the next object in the iteration.
     * @access public
     * @return Objective
     */
    public function next()
    {
        if (!$this->hasNext()) {
            throw new NosuchElementException;
        }
        $this->prev = $this->next;
        $this->next = $this->next->getNext();
        $this->cursor++;
        return $this->prev->get();
    }

    /**
     * The nextIndex method, acquires the previous object on the linked list iterator.
     * @access public
     * @return Objective
     */
    public function previous()
    {
        if (!$this->hasPrevious()) {
            throw new NosuchElementException;
        }
        $this->next = $this->prev;
        $this->prev = ($this->next == null)?$this->prev:$this->next->getPrev();
        $this->cursor--;
        return $this->prev->get();
    }
    
    /**
     * The remove method, removes from the underlying linked list the last element returned by the linked list iterator.
     * @access public
     * @return Void
     */
    public function remove()
    {
        if ($this->prev == null) {
            throw new IllegalStateException;
        }
        $lastNext = $this->prev->getNext();
        $this->list->unlink($this->prev);
        
        if ($this->next == $this->prev) {
            $this->next = $lastNext;
        } else {
            $this->cursor--;
        }
        $this->prev = null;
    }

    /**
     * The set method, updates the object at the last returned index.
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function set(Objective $object)
    {
        if ($this->prev == null) {
            throw new IllegalStateException;
        }
        $this->prev->set($object);
    }
}
