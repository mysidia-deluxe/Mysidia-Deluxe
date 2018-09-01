<?php

namespace Resource\Collection;

/**
 * The abstract QueueIterator Class, extending from abstract CollectionIterator Class.
 * It defines a standard queue iterator, but does not have full functionality as iterator yet.
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

abstract class QueueIterator extends CollectionIterator
{

    /**
     * The queue property, it stores a reference to the queue object.
     * @access protected
     * @var Queueable
    */
    protected $queue;
    
    /**
     * Constructor of QueueIterator Class, initializes basic properties for the queue iterator.
     * @param Queueable  $queue
     * @access public
     * @return Void
     */
    public function __construct(Queueable $queue)
    {
        $this->queue = $queue;
        $this->cursor = 0;
    }

    /**
     * The current method, returns the object at the current index.
     * @access public
     * @return Objective
     */
    public function current()
    {
        return $this->queue->get($this->cursor);
    }

    /**
     * The getQueue method, fetches the internal Queue object to external script.
     * @access public
     * @return Queueable
     */
    public function getQueue()
    {
        return $this->queue;
    }
}
