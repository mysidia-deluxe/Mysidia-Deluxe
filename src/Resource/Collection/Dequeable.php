<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The DeQueable Interface, extending from the Queueable interface.
 * It defines a standard interface for Queue type Collection objects that can have their elements removed from both ends.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
interface Dequeable extends Queueable
{

    /**
     * The addFirst method, inserts an object at the first index of the Deque.
     * @param Objective $object
     * @access public
     * @return Void
     */
    public function addFirst(Objective $object);

    /**
     * The addLast method, inserts an object at the last index of the Deque.
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function addLast(Objective $object);

    /**
     * The descendingIterator method, acquires an instance of descending iterator object of this Deque.
     * This method returns an iterator with objects in reverse order as the Deque.
     * @access public
     * @return Iterator
     */
    public function descendingIterator();
    
    /**
     * The eraseFirst method, removes but not retrieve the object at the first index of the Deque.
     * The method throws an Exception if the Deque is empty.
     * @access public
     * @return Void
     */
    public function eraseFirst();
    
    /**
     * The eraseLast method, removes but not retrieve the object at the last index of the Deque.
     * The method throws an Exception if the Deque is empty.
     * @access public
     * @return Void
     */
    public function eraseLast();
        
    /**
     * The getFirst method, retrieves but not remove the object at the first index of Deque.
     * This method throws an Exception if Deque is empty.
     * @access public
     * @return Objective
     */
    public function getFirst();
    
    /**
     * The getLast method, retrieves but not remove the object at the last index of Deque.
     * This method throws an Exception if Deque is empty.
     * @access public
     * @return Objective
     */
    public function getLast();
    
    /**
     * The offerFirst method, inserts an object at the first index of the Deque.
     * This method will throw an Exception if the capacity of the Deque has been exhausted.
     * @param Objective $object
     * @access public
     * @return Boolean
     */
    public function offerFirst(Objective $object);

    /**
     * The offerFirst method, inserts an object at the last index of the Deque.
     * This method will throw an Exception if the capacity of the Deque has been exhausted.
     * @param Objective $object
     * @access public
     * @return Boolean
     */
    public function offerLast(Objective $object);
        
    /**
     * The peekFirst method, retrieves but not remove the object at the first index of Deque.
     * This method returns NULL if Deque is empty.
     * @access public
     * @return Objective
     */
    public function peekFirst();
    
    /**
     * The peekLast method, retrieves but not remove the object at the last index of Deque.
     * This method returns NULL if Deque is empty.
     * @access public
     * @return Objective
     */
    public function peekLast();
    
    /**
     * The pollFirst method, retrieves and removes the object at the first index of the Deque at the same time.
     * The method returns NULL if the Deque is empty.
     * @access public
     * @return Objective
     */
    public function pollFirst();
    
    /**
     * The pollLast method, retrieves and removes the object at the last index of the Deque at the same time.
     * The method returns NULL if the Deque is empty.
     * @access public
     * @return Objective
     */
    public function pollLast();
    
    /**
     * The pop method, pops an object from the stack represented by this Deque.
     * The method throws an Exception if if the Deque is empty.
     * @access public
     * @return Objective
     */
    public function pop();

    /**
     * The push method, pushes an object onto the stack represented by this Deque.
     * The method throws an Exception if if the Deque is empty.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function push(Objective $object);

    /**
     * The removeFirst method, removes and retrieves the first occurrence of a given object at this Deque.
     * The method throws an Exception if the Deque is empty.
     * @access public
     * @return Void
     */
    public function removeFirst(Objective $object);

    /**
     * The removeLast method, removes and retrieves the last occurrence of a given object at this Deque.
     * The method throws an Exception if the Deque is empty.
     * @access public
     * @return Void
     */
    public function removeLast(Objective $object);
}
