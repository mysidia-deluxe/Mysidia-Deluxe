<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The EntrySet Class, extending from the abstract MapSet Class.
 * It defines a standard set to hold entries in a HashMap, it is important for HashMap type objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class EntrySet extends MapSet
{
    
    /**
     * Constructor of EntrySet Class, it simply calls parent constructor.
     * @param HashMap  $map
     * @access public
     * @return Void
     */
    public function __construct(HashMap $map)
    {
        parent::__construct($map);
    }

    /**
     * The contains method, checks if a given entry is already on the EntrySet.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function contains(Objective $object)
    {
        if (!($object instanceof MapEntry)) {
            return false;
        }
        $entry = $object;
        $candidate = $this->map->getEntry($entry->getKey());
        return($candidate != null and $candidate->equals($entry));
    }
    
    /**
     * The iterator method, acquires an instance of the entry iterator object of the EntrySet.
     * @access public
     * @return EntryIterator
     */
    public function iterator()
    {
        return $this->map->entryIterator();
    }
    
    /**
     * The remove method, removes the mapping specified by the given Entry.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function remove(Objective $object)
    {
        if (!($object instanceof Entry)) {
            return false;
        }
        return ($this->map->removeMapping($object) != null);
    }
}
