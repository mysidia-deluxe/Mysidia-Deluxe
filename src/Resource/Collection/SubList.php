<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The SubList Class, extending from abstract Lists class.
 * It defines a standard sub list to handle a portion of a complete list.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class SubList extends Lists
{

    /**
     * The list property, it stores a reference to the original list object.
     * @access private
     * @var Lists
     */
    private $list;
    
    /**
     * The offset property, it determines the offset between fromIndex and toIndex
     * @access private
     * @var Int
     */
    private $offset;
    
    /**
     * The size property, it specifies the current size of the ArrayList.
     * @access private
     * @var Int
     */
    private $size;

    /**
     * Constructor of SubList Class, it initializes the SubList with basic properties.
     * @param Lists  $list
     * @param Int  $fromIndex
     * @param Int  $toIndex
     * @access public
     * @return Void
     */
    public function __construct(Lists $list, $fromIndex, $toIndex)
    {
        parent::__construct();
        if ($fromIndex < 0 or $toIndexor > $list->size() or $fromIndex > $toIndex) {
            throw new IndexOutOfBoundsException;
        }
        $this->list = $list;
        $this->offset = $fromIndex;
        $this->size = $toIndex - $fromIndex;
    }
    
    /**
     * The addAll method, append a collection of objects to the end of the SubList.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */
    public function addAll(Collective $collection)
    {
        return $this->insertAll($this->size, $collection);
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
        $deleted = $this->list->remove($index + $this->offset);
        $this->size--;
        return $deleted;
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
        $this->list->get($index + $this->offset);
    }
    
    /**
     * The insert method, inserts an object to any given index available in the SubList.
     * @param Int  $index
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function insert($index, Objective $object)
    {
        $this->rangeCheck($index);
        $this->list->insert($index, $object);
        $this->size++;
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
        $this->size += $collection->size();
        $this->list->insertAll($index, $collection);
        return true;
    }
    
    /**
     * The iterator method, acquires an instance of the listIterator object of this sub list.
     * @access public
     * @return ListIterator
     */
    public function iterator()
    {
        return $this->subListIterator();
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
        $this->list->removeRange($fromIndex, $toIndex);
        $this->size -= $toIndex - $fromIndex;
    }
    
    /**
     * The set method, updates a supplied index with a given object.
     * @param Int  $index
     * @param Objective  $object
     * @access public
     * @return Void
     */
    public function set($index, Objective $object)
    {
        $this->rangeCheck($index);
        $this->list->set($index + $this->offset, $object);
    }
    
    /**
     * The size method, returns the current size of this SubList.
     * @access public
     * @return Int
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * The subListIterator method, acquires an instance of the SubListIterator object of this subList.
     * @access public
     * @return SubListIterator
     */
    public function subListIterator()
    {
        return new SubListIterator($this, $this->offset, $this->offset + $this->size);
    }
}
