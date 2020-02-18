<?php

namespace Resource\Collection;

use Resource\Native\Objective;
use Resource\Native\Arrays;

/**
 * The LinkedHashMap Class, extending from the HashMap Class.
 * It defines an ordered HashMap accessible from both the front and back.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class LinkedHashMap extends HashMap
{

    /**
     * serialID constant, it serves as identifier of the object being LinkedHashMap.
     */
    const SERIALID =  "3801124242820219131L";
    
    /**
     * The header property, it stores the head of doubly linked list.
     * @access protected
     * @var MapEntry
     */
    private $header;
    
    /**
     * The order property, it defines if an access order is specified for this LinkedHashMap.
     * @access protected
     * @var Boolean
    */
    protected $order;
    
    /**
     * Constructor of LinkedHashMap Class, it calls parent constructor and adds its own implementation.
     * @param Int|Mappable  $param
     * @param Float  $loadFactor
     * @param Boolean  $order
     * @access public
     * @return Void
     */
    public function __construct($param = HashMap::DEFAULTCAPACITY, $loadFactor = HashMap::DEFAULTLOAD, $order = false)
    {
        parent::__construct($param, $loadFactor);
        $this->order = $order;
        if (is_int($param)) {
            $this->header = new LinkedHashMapEntry(-1, null, null, null);
            $this->header->setBefore($this->header);
            $this->header->setAfter($this->header);
        }
    }

    /**
     * The addEntry method, adds an entry with a specific key, value and hash code.
     * @param Int  $hash
     * @param Objective  $key
     * @param Objective  $value
     * @param Int  $index
     * @access public
     * @return Void
     */
    public function addEntry($hash = 0, Objective $key = null, Objective $value = null, $index = 0)
    {
        $this->createEntry($hash, $key, $value, $index);
        $eldest = $this->header->getAfter();
        if ($this->removeEldest($eldest)) {
            $this->removeKey($eldest->getKey());
        } else {
            if ($this->size >= $this->threshold) {
                $this->resize(2*$this->entries->length());
            }
        }
    }
    
    /**
     * The clear method, drops all key-value pairs currently stored in this LinkedHashMap.
     * @access public
     * @return Void
     */
    public function clear()
    {
        parent::clear();
        $this->header->setBefore($this->header);
        $this->header->setAfter($this->header);
    }
    
    /**
     * The containsValue method, checks if the LinkedHashMap contains a specific value among its key-value pairs.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function containsValue(Objective $value = null)
    {
        if ($value == null) {
            for ($entry = $this->header->getAfter(); $entry != $this->header; $entry = $entry->getAfter()) {
                if ($entry->getValue() == null) {
                    return true;
                }
            }
        } else {
            for ($entry = $this->header->getAfter(); $entry != $this->header; $entry = $entry->getAfter()) {
                if ($value->equals($entry->getValue())) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * The createEntry method, it is similar to addEntry but does not resize the entries array or remove eldest entry.
     * @param Int  $hash
     * @param Objective  $key
     * @param Objective  $value
     * @param Int  $index
     * @access public
     * @return Void
     */
    public function createEntry($hash = 0, Objective $key = null, Objective $value = null, $index = 0)
    {
        $oldEntry = $this->entries[$index];
        $entry = new LinkedHashMapEntry($hash, $key, $value, $oldEntry);
        $this->entries[$index] = $entry;
        $entry->addBefore($this->header);
        $this->size++;
    }
        
    /**
     * The entryIterator method, acquires an instance of the EntryIterator object of this LinkedHashMap.
     * @access public
     * @return EntryLinkedIterator
     */
    public function entryIterator()
    {
        return new EntryLinkedIterator($this);
    }
    
    /**
     * The get method, acquires the value stored in the LinkedHashMap given its key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function get(Objective $key)
    {
        $entry = $this->getEntry($key);
        if ($entry == null) {
            return null;
        }
        $entry->recordAccess($this);
        return $entry->getValue();
    }

    /**
     * The getHeader method, getter method for property $header.
     * @access public
     * @return MapEntry
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * The getOrder method, getter method for property $order.
     * @access public
     * @return Boolean
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * The keyIterator method, acquires an instance of the KeyIterator object of this LinkedHashMap.
     * @access public
     * @return KeyLinkedIterator
     */
    public function keyIterator()
    {
        return new KeyLinkedIterator($this);
    }

    /**
     * The removeEldest method, allows the map to modify itself as directed by its return value.
     * @param Entry  $eldest
     * @access protected
     * @return Boolean
     */
    protected function removeEldest(Entry $eldest = null)
    {
        return false;
    }
    
    /**
     * The transfer method, transfers all old entries to new entries.
     * @param Arrays  $newEntries
     * @access public
     * @return Void
     */
    public function transfer(Arrays $newEntries)
    {
        $newCapacity = $newEntries->length();
        for ($entry = $this->header->getAfter(); $entry != $this->header; $entry = $entry->getAfter()) {
            $index = $this->indexFor($entry->getHash(), $newCapacity);
            $entry->setNext($newEntries[$index]);
            $newEntries[$index] = $entry;
        }
    }

    /**
     * The valueIterator method, acquires an instance of the ValueIterator object of this LinkedHashMap.
     * @access public
     * @return ValueLinkedIterator
     */
    public function valueIterator()
    {
        return new ValueLinkedIterator($this);
    }
}
