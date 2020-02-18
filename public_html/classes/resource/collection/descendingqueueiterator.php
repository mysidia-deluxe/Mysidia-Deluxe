<?php

namespace Resource\Collection;

use Resource\Exception\IllegalStateException;
use Resource\Exception\NosuchElementException;

/**
 * The DescendingQueueIterator Class, extending from DequeIterator Class.
 * It defines a special descending queue iterator, it traverses from the back to the front for a given list.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class DescendingQueueIterator extends DequeIterator
{
    
    /**
     * Constructor of DescendingQueueIterator Class, initializes basic properties for the iterator.
     * @param Dequeable  $deque
     * @access public
     * @return Void
     */
    public function __construct(Dequeable $deque)
    {
        parent::__construct($deque);
        $this->cursor = $deque->getTail();
        $this->fence = $deque->getHead();
    }
    
    /**
     * The hasNext method, checks if the descending iterator has not reached the end of its iteration yet.
     * @access public
     * @return Boolean
     */
    public function hasNext()
    {
        return ($this->cursor != $this->fence);
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
        $array = $this->queue->getArray();
        $this->cursor = ($this->cursor - 1) & ($array->length() - 1);
        $object = $array[$this->cursor];
        $this->last = $this->cursor;
        return $object;
    }
    
    /**
     * The remove method, removes from the underlying collection the last element returned by the descending iterator.
     * @access public
     * @return Void
     */
    public function remove()
    {
        if ($this->last < 0) {
            throw new IllegalStateException;
        }
        $array = $this->queue->getArray();
        if (!$this->queue->delete($this->last)) {
            $this->cursor = ($this->cursor + 1) & ($array->length() - 1);
            $this->fence = $this->queue->getHead();
        }
        $this->last = -1;
    }
}
