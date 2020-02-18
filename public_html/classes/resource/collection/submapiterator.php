<?php

namespace Resource\Collection;

use Resource\Native\Objective;
use Resource\Exception\NosuchElementException;
use Resource\Exception\IllegalStateException;

/**
 * The abstract SubMapIterator Class, extending from the abstract CollectionIterator Class.
 * It defines a base sub map iterator, it must be extended by subclasses.
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

abstract class SubMapIterator extends CollectionIterator
{

    /**
     * The map property, it holds a reference to the SubMap object.
     * @access protected
     * @var SubMap
    */
    protected $map;

    /**
     * The current property, it specifies the current Entry to return.
     * @access protected
     * @var MapEntry
    */
    protected $current;

    /**
     * The dummy property, it defines a dummy Null Object for future operations.
     * @access protected
     * @var Null
    */
    protected $dummy;
    
    /**
     * The fenceKey property, it stores the key of the fence provided in Iterator.
     * @access protected
     * @var Objective
    */
    protected $fenceKey;
    
    /**
     * The next property, it defines the next Entry in iteration.
     * @access protected
     * @var MapEntry
    */
    protected $next;

    /**
     * Constructor of SubMapIterator Class, initializes basic properties for the iterator.
     * @param SubMap  $map
     * @param TreeMapEntry  $first
     * @param TreeMapEntry  $fence
     * @access public
     * @return Void
     */
    public function __construct(SubMap $map, TreeMapEntry $first = null, TreeMapEntry $fence = null)
    {
        $this->map = $map;
        $this->next = $first;
        $this->dummy = new Mynull;
        $this->fenceKey = ($fence == null)?$this->dummy:$fence->getKey();
    }

    /**
     * The current method, returns the current entry in the iterator.
     * @access public
     * @return Entry
     */
    public function current()
    {
        return $this->current;
    }
    
    /**
     * The hasNext method, checks if the iterator has next entry.
     * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Entry
     * @final
     */
    final public function hasNext()
    {
        return ($this->next != null and $this->next->getKey() != $this->fenceKey);
    }
    
    /**
     * The nextEntry method, returns the next entry in iteration.
     * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Entry
     * @final
     */
    final public function nextEntry()
    {
        $entry = $this->next;
        if ($entry == null or $entry->getKey() == $this->fenceKey) {
            throw new NosuchElementException;
        }
        $map = $this->map->getMap();
        $this->next = $map->successor($entry);
        $this->current = $entry;
        return $entry;
    }

    /**
     * The prevEntry method, returns the previous entry in iteration.
     * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Entry
     * @final
     */
    final public function prevEntry()
    {
        $entry = $this->next;
        if ($entry == null or $entry->getKey() == $this->fenceKey) {
            throw new NosuchElementException;
        }
        $map = $this->map->getMap();
        $this->next = $map->predecessor($entry);
        $this->current = $entry;
        return $entry;
    }
    
    /**
     * The remove method, removes from the underlying value associated with the current key in iteration.
     * @access public
     * @return Void
     */
    public function remove()
    {
        $this->removeAscending();
    }

    /**
     * The removeAscending method, removes from the underlying value associated with the current key in iteration and iterates backward.
     * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Void
     * @final
     */
    final public function removeAscending()
    {
        if ($this->current == null) {
            throw new IllegalStateException;
        }
        if ($this->current->getLeft() != null and $this->current->getRight() != null) {
            $this->next = $this->current;
        }
        $map = $this->map->getMap();
        $map->deleteEntry($this->current);
        $this->current = null;
    }

    /**
     * The removeDescending method, removes from the underlying value associated with the current key in iteration and iterates forward.
     * This is a final method, and thus can not be overriden by child class.
     * @access public
     * @return Void
     * @final
     */
    final public function removeDescending()
    {
        if ($this->current == null) {
            throw new IllegalStateException;
        }
        $map = $this->map->getMap();
        $map->deleteEntry($this->current);
        $this->current = null;
    }
}
