<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The KeyTreeSet Class, extending from the KeyMapSet Class and implementing the NavigableSettable Interface.
 * It defines a standard set to hold keys in a TreeMap, it is important for TreeMap type objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class KeyTreeSet extends KeyMapSet implements NavigableSettable
{
    
    /**
     * Constructor of KeyTreeSet Class, it simply calls parent constructor.
     * @param TreeMap  $map
     * @access public
     * @return Void
     */
    public function __construct(TreeMap $map)
    {
        parent::__construct($map);
    }

    /**
     * The ceiling method, obtains the least element in this KeyTreeSet greater than or equal to the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function ceiling(Objective $object)
    {
        return $this->map->ceilingKey();
    }

    /**
     * The comparator method, returns the comparator object used to order the elements in this KeyTreeSet.
     * @access public
     * @return Comparative
     */
    public function comparator()
    {
        return $this->map->comparator();
    }
    
    /**
     * The descendingIterator method, obtains an iterator object for KeyTreeSet in reversing order.
     * @access public
     * @return DescendingKeyIterator
     */
    public function descendingIterator()
    {
        return $this->map->descendingKeyIterator();
    }

    /**
     * The descendingSet method, returns a set with elements in reverse order as this TreeSet.
     * @access public
     * @return NavigableSettable
     */
    public function descendingSet()
    {
        return new KeyTreeSet($this->map->descendingMap());
    }
    
    /**
     * The first method, obtains the first object stored in this KeyTreeSet.
     * @access public
     * @return Objective
     */
    public function first()
    {
        return $this->map->firstKey();
    }

    /**
     * The floor method, obtains the greatest element in this KeyTreeSet less than or equal to the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function floor(Objective $object)
    {
        return $this->map->floorKey();
    }

    /**
     * The headSet method, acquires a portion of the KeyTreeSet ranging from the first element to the supplied element.
     * @param Objective  $toElement
     * @access public
     * @return SortedSettable
     */
    public function headSet(Objective $toElement)
    {
        return $this->headSets($toElement, false);
    }
    
    /**
     * The headSets method, acquires a portion of the KeyTreeSet ranging from the first element to the supplied element.
     * If a boolean TRUE value is supplied, the returned set will contain the supplied element at its tail.
     * @param Objective  $toElement
     * @param Boolean  $inclusive
     * @access public
     * @return SortedSettable
     */
    public function headSets(Objective $toElement, $inclusive)
    {
        return new KeyTreeSet($this->map->headMaps($toElement, $inclusive));
    }
    
    /**
     * The higher method, obtains the least element in this KeyTreeSet strictly greater than the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function higher(Objective $object)
    {
        return $this->map->higherKey();
    }
    
    /**
     * The iterator method, acquires an instance of the key iterator object of the KeyTreeSet.
     * @access public
     * @return KeyIterator
     */
    public function iterator()
    {
        return $this->map->keyIterator();
    }

    /**
     * The last method, obtains the last object stored in this KeyTreeSet.
     * @access public
     * @return Objective
     */
    public function last()
    {
        return $this->map->lastKey();
    }
    
    /**
     * The lower method, obtains the greatest element in this KeyTreeSet strictly less than the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function lower(Objective $object)
    {
        return $this->map->lowerKey();
    }

    /**
     * The pollFirst method, retrieves and removes the first/lowest element in the KeyTreeSet.
     * @access public
     * @return Objective
     */
    public function pollFirst()
    {
        $entry = $this->map->pollFirstEntry();
        return (($entry == null)?null:$entry->getKey());
    }

    /**
     * The pollLast method, retrieves and removes the last/greatest element in the KeyTreeSet.
     * @access public
     * @return Objective
     */
    public function pollLast()
    {
        $entry = $this->map->pollLastEntry();
        return (($entry == null)?null:$entry->getKey());
    }
    
    /**
     * The remove method, removes the underlying value in Iterator given its current key.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function remove(Objective $object)
    {
        $size = $this->size();
        $this->map->remove($object);
        return ($size != $this->size());
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
        return $this->subSets($fromElement, true, $toElement, false);
    }
    
    /**
     * The subSets method, acquires a portion of the KeyTreeSet ranging from the supplied two elements.
     * If boolean value TRUE is supplied for $inclusive, the return set will contain $fromElement and/or $toElement.
     * @param Objective  $fromElement
     * @param Boolean  $fromInclusive
     * @param Objective  $toElement
     * @param Boolean  $toInclusive
     * @access public
     * @return Settable
     */
    public function subSets(Objective $fromElement, $fromInclusive, Objective $toElement, $toInclusive)
    {
        return new KeyTreeSet($this->map->subMaps($fromElement, $fromInclusive, $toElement, $toInclusive));
    }

    /**
     * The tailSet method, acquires a portion of the KeyTreeSet ranging from the supplied element to the last element.
     * @param Objective  $fromElement
     * @access public
     * @return SortedSettable
     */
    public function tailSet(Objective $fromElement)
    {
        return $this->tailSets($fromElement, true);
    }
    
    /**
     * The tailSets method, acquires a portion of the KeyTreeSet ranging from the supplied element to the last element.
     * If a boolean TRUE value is supplied for $inclusive, the returned set will contain the supplied element at its head.
     * @param Objective  $fromElement
     * @param Boolean  $inclusive
     * @access public
     * @return SortedSettable
     */
    public function tailSets(Objective $fromElement, $inclusive)
    {
        return new KeyTreeSet($this->map->tailMaps($fromElement, $inclusive));
    }
}
