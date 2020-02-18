<?php

namespace Resource\Collection;

use Resource\Native\Objective;
use Resource\Native\Arrays;
use Resource\Exception\NosuchElementException;

/**
 * The LinkedList Class, extending from abstract SequentialList class and implementing Dequeable and Stackable Interface.
 * It defines a standard class to handle LinkedList type collections, similar to Java's LinkedList.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
class LinkedList extends SequentialList implements Dequeable, Stackable
{

    /**
     * serialID constant, it serves as identifier of the object being LinkedList.
     */
    const SERIALID = "876323262645176354L";

    /**
     * The first property, it stores a reference of the first node on this LinkedList.
     * @access private
     * @var Node
     */
    private $first;
    
    /**
     * The last property, it stores a reference of the last node on this LinkedList.
     * @access private
     * @var Node
     */
    private $last;
    
    /**
     * The size property, it specifies the current size of the LinkedList.
     * @access private
     * @var Int
     */
    private $size = 0;

    /**
     * Constructor of LinkedList Class, it initializes the LinkedList.
     * @param Collective  $param
     * @access public
     * @return Void
     */
    public function __construct($param = "")
    {
        if ($param instanceof Collective) {
            $this->addAll($param);
        }
    }

    /**
     * The add method, append an object to the end of the LinkedList.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function add(Objective $object)
    {
        $this->linkLast($object);
        return true;
    }

    /**
     * The addAll method, append a collection of objects to the end of the LinkedList.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */
    public function addAll(Collective $collection)
    {
        return $this->insertAll($this->size, $collection);
    }

    /**
     * The addFirst method, inserts an object at the beginning of the LinkedList.
     * @param Objective $object
     * @access public
     * @return Void
     */
    public function addFirst(Objective $object)
    {
        $this->linkFirst($object);
    }

    /**
     * The addLast method, inserts an object at the end of the LinkedList.
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function addLast(Objective $object)
    {
        $this->linkLast($object);
    }
    
    /**
     * The clear method, drops all objects currently stored in this LinkedList.
     * @access public
     * @return Void
     */
    public function clear()
    {
        $this->first = null;
        $this->last = null;
        $this->size = 0;
    }
    
    /**
     * The contains method, checks if a given object is already on the LinkedList.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function contains(Objective $object)
    {
        return ($this->indexOf($object) != -1);
    }

    /**
     * The delete method, removes an Object at the supplied index and returns the deleted object.
     * @param Int  $index
     * @access public
     * @return Objective
     */
    public function delete($index)
    {
        $this->rangeCheck($index);
        return $this->unlink($this->node($index));
    }

    /**
     * The descendingIterator method, acquires an instance of DescendingIterator object of this LinkedList.
     * This method returns an iterator with objects in reverse order as the LinkedList.
     * @access public
     * @return DescendingListIterator
     */
    public function descendingIterator()
    {
        return new DescendingListIterator($this);
    }

    /**
     * The element method, retrieves but not remove the first Node of the LinkedList.
     * This method throws an Exception if the LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function element()
    {
        return $this->getFirst();
    }
    
    /**
     * The erase method, removes but not retrieve the first Node of the LinkedList.
     * @access public
     * @return Void
     */
    public function erase()
    {
        $this->unlinkFirst($this->first);
    }

    /**
     * The eraseFirst method, removes but not retrieve the object at the first Node of the LinkedList.
     * The method throws an Exception if the LinkedList is empty.
     * @access public
     * @return Void
     */
    public function eraseFirst()
    {
        $this->unlinkFirst($this->first);
    }
    
    /**
     * The eraseLast method, removes but not retrieve the object at the last Node of the LinkedList.
     * The method throws an Exception if the LinkedList is empty.
     * @access public
     * @return Void
     */
    public function eraseLast()
    {
        $this->unlinkLast($this->last);
    }
    
    /**
     * The get method, acquires the object stored at a given index.
     * @param Int  $index
     * @access public
     * @return Objective
     */
    public function get($index)
    {
        $this->rangeCheck($index);
        $node = $this->node($index);
        return $node->get();
    }

    /**
     * The getArray method, retrieves an instance of the array object that contains data inside this LinkedList.
     * @access public
     * @return Arrays
     */
    public function getArray()
    {
        $array = new Arrays($this->size);
        $i = 0;
        for ($node = $this->first; $node != null; $node = $node->getNext()) {
            $array[$i] = $node->get();
            $i++;
        }
        return $array;
    }
    
    /**
     * The getFirst method, retrieves but not remove the object at the first Node of the LinkedList.
     * The method throws an Exception if the LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function getFirst()
    {
        if ($this->first == null) {
            throw new NosuchElementException;
        }
        return $this->first->get();
    }
    
    /**
     * The getLast method, retrieves but not remove the object at the last Node of the LinkedList.
     * The method throws an Exception if the LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function getLast()
    {
        if ($this->last == null) {
            throw new NosuchElementException;
        }
        return $this->last->get();
    }

    /**
     * The indexOf method, returns the first index found for a given object.
     * @param Objective  $object
     * @access public
     * @return Int
     */
    public function indexOf(Objective $object)
    {
        $index = 0;
        if ($object == null) {
            for ($node = $this->first; $node != null; $node = $node->getNext()) {
                if ($node->get() == null) {
                    return $index;
                }
                $index++;
            }
        } else {
            for ($node = $this->first; $node != null; $node = $node->getNext()) {
                if ($object->equals($node->get())) {
                    return $index;
                }
                $index++;
            }
        }
        return -1;
    }
    
    /**
     * The insert method, inserts an object to any given index available in the LinkedList.
     * @param Int  $index
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function insert($index, Objective $object)
    {
        $this->rangeCheck($index);
        if ($index == $this->size) {
            $this->linkLast($object);
        } else {
            $this->linkBefore($object, $this->node($index));
        }
    }
    
    /**
     * The insertAll method, inserts a collection of objects at a given index.
     * @param Int  $index
     * @param Collective  $collection
     * @access public
     * @return Void
     */
    public function insertAll($index, Collective $collection)
    {
        $this->rangeCheck($index);
        $array = $collection->getArray();
        if ($array->length() == 0) {
            return false;
        }
        
        if ($index == $this->size) {
            $successor = null;
            $predecessor = $this->last;
        } else {
            $successor = $this->node($index);
            $predecessor = $successor->getPrev();
        }
        
        foreach ($array as $object) {
            $new = new Node($object, null, $predecessor);
            if ($predecessor == null) {
                $this->first = $new;
            } else {
                $predecessor->setNext($new);
            }
            $predecessor = $new;
        }
        
        if ($successor == null) {
            $this->last = $predecessor;
        } else {
            $predecessor->setNext($successor);
            $successor->setPrev($predecessor);
        }
        $this->size += $array->length();
        return true;
    }
    
    /**
     * The lastIndexOf method, returns the last index found for a given object.
     * @param Objective  $object
     * @access public
     * @return Int
     */
    public function lastIndexOf(Objective $object)
    {
        $index = $this->size;
        if ($object == null) {
            for ($node = $this->last; $node != null; $node = $node->getPrev()) {
                $index--;
                if ($node->get() == null) {
                    return $index;
                }
            }
        } else {
            for ($node = $this->first; $node != null; $node = $node->getPrev()) {
                $index--;
                if ($object->equals($node->get())) {
                    return $index;
                }
            }
        }
        return -1;
    }

    /**
     * The linkBefore method, carries out the operation to attach an object ahead of a given Node.
     * @param Objective  $object
     * @param Node  $successor
     * @access public
     * @return Void
     */
    public function linkBefore(Objective $object, Node $successor)
    {
        $predecessor = $successor->getPrev();
        $new = new Node($object, $successor, $predecessor);
        $successor->setPrev($new);
        if ($predecessor == null) {
            $this->first = $new;
        } else {
            $predecessor->setNext($new);
        }
        $this->size++;
    }

    /**
     * The linkFirst method, carries out the operation to attach an object to the front of LinkedList.
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function linkFirst(Objective $object)
    {
        $first = $this->first;
        $new = new Node($object, $first, null);
        $this->first = $new;
        if ($first == null) {
            $this->last = $new;
        } else {
            $first->setPrev($new);
        }
        $this->size++;
    }
    
    /**
     * The linkLast method, carries out the operation to attach an object to the end of LinkedList.
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function linkLast(Objective $object)
    {
        $last = $this->last;
        $new = new Node($object, null, $last);
        $this->last = $new;
        if ($last == null) {
            $this->first = $new;
        } else {
            $last->setNext($new);
        }
        $this->size++;
    }

    /**
     * The listIterator method, acquires an instance of the ListIterator for this LinkedList.
     * @access public
     * @return ListIterator
     */
    public function listIterator($index = 0)
    {
        $this->rangeCheck($index);
        return new LinkedListIterator($this, $index);
    }
    
    /**
     * The node method, returns the non-Null Node at the specified object index.
     * @param Int  $index
     * @access public
     * @return Node
     */
    public function node($index)
    {
        if ($index < ($this->size >> 1)) {
            $node = $this->first;
            for ($i = 0; $i < $index; $i++) {
                $node = $node->getNext();
            }
        } else {
            $node = $this->last;
            for ($i = $this->size - 1; $i > $index; $i--) {
                $node = $node->getPrev();
            }
        }
        return $node;
    }
        
    /**
     * The offer method, inserts a specific Object to the end of the LinkedList.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function offer(Objective $object)
    {
        return $this->add($object);
    }

    /**
     * The offerFirst method, inserts an object at the first Node of the LinkedList.
     * This method will throw an Exception if the capacity of the LinkedList has been exhausted.
     * @param Objective $object
     * @access public
     * @return Boolean
     */
    public function offerFirst(Objective $object)
    {
        $this->addFirst($object);
        return true;
    }

    /**
     * The offerFirst method, inserts an object at the last Node of the LinkedList.
     * This method will throw an Exception if the capacity of the LinkedList has been exhausted.
     * @param Objective $object
     * @access public
     * @return Boolean
     */
    public function offerLast(Objective $object)
    {
        $this->addLast($object);
        return true;
    }
    
    /**
     * The peek method, retrieves but not remove the first Node of LinkedList.
     * This method returns NULL if LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function peek()
    {
        return ($this->first == null)?null:$this->first->get();
    }

    /**
     * The peekFirst method, retrieves but not remove the object at the first Node of LinkedList.
     * This method returns NULL if LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function peekFirst()
    {
        return $this->peek();
    }
    
    /**
     * The peekLast method, retrieves but not remove the object at the last Node of LinkedList.
     * This method returns NULL if LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function peekLast()
    {
        return ($this->last == null)?null:$this->last->get();
    }
    
    /**
     * The poll method, retrieves and removes the first Node of LinkedList at the same time.
     * @access public
     * @return Objective
     */
    public function poll()
    {
        return ($this->first == null)?null:$this->unlinkFirst($this->first);
    }
    
    /**
     * The pollFirst method, retrieves and removes the object at the first Node of the LinkedList at the same time.
     * The method returns NULL if the LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function pollFirst()
    {
        return $this->poll();
    }
    
    /**
     * The pollLast method, retrieves and removes the object at the last Node of the LinkdList at the same time.
     * The method returns NULL if the LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function pollLast()
    {
        return ($this->last == null)?null:$this->unlinkLast($this->last);
    }
    
    /**
     * The pop method, pops an object from the stack represented by this LinkedList.
     * The method throws an Exception if if the LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function pop()
    {
        return $this->unlinkFirst($this->first);
    }

    /**
     * The push method, pushes an object onto the stack represented by this LinkedList.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function push(Objective $object)
    {
        $this->addFirst($object);
    }
    
    /**
     * The remove method, removes a supplied Object from this LinkedList.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function remove(Objective $object = null)
    {
        $this->removeFirst($object);
    }
    
    /**
     * The removeFirst method, removes and retrieves the first occurrence of a given object at this LinkedList.
     * The method throws an Exception if the LinkedList is empty.
     * @access public
     * @return Objective
     */
    public function removeFirst(Objective $object = null)
    {
        if ($object == null) {
            for ($node = $this->first; $node != null; $node = $node->getNext()) {
                if ($node->get() == null) {
                    $this->unlink($node);
                    return true;
                }
            }
        } else {
            for ($node = $this->first; $node != null; $node = $node->getNext()) {
                if ($object->equals($node->get())) {
                    $this->unlink($node);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * The removeLast method, removes and retrieves the last occurrence of a given object at this LinkedList.
     * The method throws an Exception if the LinkedList is empty.
     * @access public
     * @return Void
     */
    public function removeLast(Objective $object = null)
    {
        if ($object == null) {
            for ($node = $this->last; $node != null; $node = $node->getPrev()) {
                if ($node->get() == null) {
                    $this->unlink($node);
                    return true;
                }
            }
        } else {
            for ($node = $this->last; $node != null; $node = $node->getPrev()) {
                if ($object->equals($node->get())) {
                    $this->unlink($node);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * The search method, searches through the LinkedList and returns 1-based position for an object.
     * @param Int  $index
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function search(Objective $object)
    {
        $index = $this->lastIndexOf($object);
        if ($index > 0) {
            return ($this->size - $index);
        }
        return $index;
    }

    /**
     * The set method, updates a supplied Node with a given object.
     * @param Int  $index
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function set($index, Objective $object)
    {
        $this->rangeCheck($index);
        $node = $this->node($index);
        $element = $node->get();
        $node->set($object);
        return $element;
    }
    
    /**
     * The size method, returns the current size of this LinkedList.
     * @access public
     * @return Int
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * The toArray method, acquires the data stored in LinkedList in Array format.
     * @access public
     * @return Array
     */
    public function toArray()
    {
        $array = $this->getArray();
        return $array->toArray();
    }
    
    /**
     * The unlink method, unlinks non-Null Node inside this LinkedList.
     * @param Node  $first
     * @access public
     * @return Objective
     */
    public function unlink(Node $node)
    {
        $object = $node->get();
        $next = $node->getNext();
        $prev = $node->getPrev();
        
        if ($prev == null) {
            $this->first = $next;
        } else {
            $prev->setNext($next);
            $node->setPrev(null);
        }
        
        if ($next == null) {
            $this->last = $prev;
        } else {
            $next->setPrev($prev);
            $node->setNext(null);
        }
        
        $node->set(null);
        $this->size--;
        return $object;
    }
    
    /**
     * The unlinkFirst method, unlinks non-Null first Node and returns the object at this Node.
     * @param Node  $first
     * @access private
     * @return Objective
     */
    private function unlinkFirst(Node $first)
    {
        $object = $first->get();
        $next = $first->getNext();
        $first->set(null);
        $first->setNext(null);
        $this->first = $next;
        if ($next == null) {
            $this->last = null;
        } else {
            $next->setPrev(null);
        }
        $this->size--;
        return $object;
    }
    
    /**
     * The unlinkLast method, unlinks non-Null last Node and returns the object at this Node.
     * @param Node  $last
     * @access private
     * @return Objective
     */
    private function unlinkLast(Node $last)
    {
        $object = $last->get();
        $prev = $last->getPrev();
        $last->set(null);
        $last->setPrev(null);
        $this->last = $prev;
        if ($prev == null) {
            $this->first = null;
        } else {
            $prev->setNext(null);
        }
        $this->size--;
        return $object;
    }
}
