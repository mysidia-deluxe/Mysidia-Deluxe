<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The EntryTreeSet Class, extending from the abstract MapSet Class.
 * It defines a standard set to hold entries in a TreeMap, it is important for TreeMap type objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
class EntryTreeSet extends MapSet
{
    
    /**
     * Constructor of EntryTreeSet Class, it simply calls parent constructor.
     * @param TreeMap  $map
     * @access public
     * @return Void
     */
    public function __construct(TreeMap $map)
    {
        parent::__construct($map);
    }

    /**
     * The contains method, checks if a given entry is already on the EntryTreeSet.
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
        $value = $entry->getValue();
        $parent = $this->map->getEntry($entry->getKey());
        return($parent != null and $this->map->valueEquals($parent->getValue(), $value));
    }
    
    /**
     * The iterator method, acquires an instance of the entry iterator object of the EntryTreeSet.
     * @access public
     * @return EntryTreeIterator
     */
    public function iterator()
    {
        return new EntryTreeIterator($this->map, $this->map->getFirstEntry());
    }
    
    /**
     * The remove method, removes the mapping specified by the given Entry.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function remove(Objective $object)
    {
        if (!($object instanceof MapEntry)) {
            return false;
        }
        $entry = $object;
        $value = $entry->getValue();
        $parent = $this->map->getEntry($entry->getKey());
        if ($parent != null and $this->map->valueEquals($parent->value(), $value)) {
            $this->map->deleteEntry($parent);
            return true;
        }
        return false;
    }

    /**
     * The subSet method, acquires a portion of the KeyTreeSet ranging from the supplied two elements.
     * @param Objective  $fromElement
     * @param Objective  $toElement
     * @access public
     * @return Settable
     */
    public function subSet(Objective $fromElement, Objective $toElement)
    {
        return false;
    }
}
