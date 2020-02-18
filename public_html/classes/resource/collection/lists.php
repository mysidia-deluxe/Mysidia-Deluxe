<?php

namespace Resource\Collection;

use Resource\Native\Objective;
use Resource\Exception\UnsupportedOperationException;

/**
 * The abstract Lists Class, extending from the abstract Collection Class and implements Listable Interface.
 * It is parent to all List type objects, subclasses have access to all its defined methods.
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

abstract class Lists extends Collection implements Listable
{

    /**
     * Constructor of Lists Class, it simply calls parent constructor.
     * @access public
     * @return Void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * The delete method, removes an Object at the supplied index and returns the deleted object.
     * The method is disabled in abstract Lists class, thus child class must implement its own version of delete method.
     * @param Int  $index
     * @access public
     * @return Objective
     */
    public function delete($index)
    {
        throw new UnsupportedOperationException;
    }

    /**
     * The hashCode method, returns the hash code for this list.
     * @access public
     * @return String
     */
    public function hashCode()
    {
        $hash = new Hash;
        $iterator = $this->iterator();
        while ($iterator->next()) {
            $hash->update($iterator->next()->hashCode());
        }
        return $hash->finalize();
    }

    /**
     * The indexOf method, returns the first index found for a given object.
     * @param Objective  $object
     * @access public
     * @return Int
     */
    public function indexOf(Objective $object)
    {
        $iterator = $this->listIterator();
        while ($iterator->hasNext()) {
            if ($object->equals($iterator->getNext())) {
                return $iterator->previousIndex();
            }
        }
        return -1;
    }

    /**
     * The insert method, inserts an object to any given index available in the List.
     * The method is disabled in abstract Lists class, thus child class must implement its own version of insert method.
     * @param Int  $index
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function insert($index, Objective $object)
    {
        throw new UnsupportedOperationException;
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
        $modified = false;
        $iterator = $collection->iterator();
        while ($iterator->hasNext()) {
            $this->insert($index++, $c_iterator->next());
            $modified = true;
        }
        return $modified;
    }
    
    /**
     * The iterator method, acquires an instance of the listIterator object of this list.
     * @access public
     * @return ListIterator
     */
    public function iterator()
    {
        return $this->listIterator(0);
    }

    /**
     * The lastIndexOf method, returns the last index found for a given object.
     * @param Objective  $object
     * @access public
     * @return Int
     */
    public function lastIndexOf(Objective $object)
    {
        $iterator = $this->listIterator($this->size());
        while ($iterator->hasPrevious()) {
            if ($object->equals($iterator->getPrevious())) {
                return $iterator->nextIndex();
            }
        }
        return -1;
    }

    /**
     * The listIterator method, acquires an instance of the listIterator object of this list.
     * @access public
     * @return ListIterator
     */
    public function listIterator($index = 0)
    {
        $this->rangeCheck($index);
        return new ListIterator($this, $index);
    }

    /**
     * The rangeCheck method, checks if the supplied index is at the appropriate range.
     * @param Int  $index
     * @access protected
     * @return Void
     */
    protected function rangeCheck($index)
    {
        if ($index < 0 or $index > $this->size()) {
            throw new IndexOutOfBoundsException;
        }
    }

    /**
     * The removeRange method, removes a collection of objects from a starting to ending index.
     * @param Int  $fromIndex
     * @param Int  $toIndex
     * @access public
     * @return Void
     */
    public function removeRange($fromIndex, $toIndex)
    {
        $this->rangeCheck($index);
        $iterator = $this->listIterator($fromIndex);
        $n = $toIndex - $fromIndex;
        for ($i = 0; $i < $n; $i++) {
            $iterator->next();
            $iterator->remove();
        }
    }
    
    /**
     * The listIterator method, acquires a Sublist from a certain index to an end Index of the List.
     * @param Int  $fromIndex
     * @param Int  $toIndex
     * @access public
     * @return SubList
     */
    public function subList($fromIndex, $toIndex)
    {
        $this->rangeCheck($index);
        return new SubList($this, $fromIndex, $toIndex);
    }
}
