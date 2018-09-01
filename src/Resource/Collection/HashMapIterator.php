<?php

namespace Resource\Collection;

use Resource\Exception\IllegalStateException;
use Resource\Exception\NosuchElementException;

/**
 * The abstract HashMapIterator Class, extending from the abstract CollectionIterator Class.
 * It defines a base hash map iterator, it must be extended by subclasses.
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
 
abstract class HashMapIterator extends CollectionIterator
{

    /**
     * The map property, it stores a reference to the HashMap object.
     * @access private
     * @var HashMap
    */
    private $map;

    /**
     * The current property, it specifies the current Entry to return.
     * @access private
     * @var MapEntry
    */
    private $current;
    
    /**
     * The next property, it defines the next Entry in iteration.
     * @access private
     * @var MapEntry
    */
    private $next;

    /**
     * Constructor of HashMapIterator Class, initializes basic properties for the iterator.
     * @param HashMap  $map
     * @access public
     * @return Void
     */
    public function __construct(HashMap $map)
    {
        $this->map = $map;
        if ($this->map->size() > 0) {
            $entries = $this->map->getEntries();
            while ($this->cursor < $entries->length() and ($this->next = $entries[$this->cursor++]) == null);
        }
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
        return ($this->next != null);
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
        if ($entry == null) {
            throw new NosuchElementException;
        }
        if (($this->next = $entry->getNext()) == null) {
            $entries = $this->map->getEntries();
            while ($this->cursor < $entries->length() and ($this->next = $entries[$this->cursor++]) == null);
        }
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
        if ($this->current == null) {
            throw new IllegalStateException;
        }
        $key = $this->current->getKey();
        $this->current = null;
        $this->map->removeKey($key);
    }
}
