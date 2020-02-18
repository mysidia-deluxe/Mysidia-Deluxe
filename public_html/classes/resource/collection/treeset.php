<?php

namespace Resource\Collection;

use Resource\Native\Objective;
use Resource\Native\Mynull;
use Resource\Utility\Comparative;

/**
 * The TreeSet Class, extending from the abstract MapSet Class and implementing the NavigableSettable Interface.
 * It is a set implementation based on TreeMap, but a lot simpler and faster.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class TreeSet extends MapSet implements NavigableSettable
{

    /**
     * serialID constant, it serves as identifier of the object being TreeSet.
     */
    const SERIALID = "-2479143000061671589L";

    /**
     * The dummy property, it defines a dummy Null Object to associate with objects in backup Map.
     * @access protected
     * @var Null
     */
    protected $dummy;
    
    /**
     * Constructor of LinkedHashSet Class, it initializes the TreeSet given its capacity or another Collection Object.
     * @param Collective  $collection
     * @param Comparative  $comparator
     * @access public
     * @return Void
     */
    public function __construct(Collective $collection = null, Comparative $comparator = null)
    {
        if ($collection instanceof NavigableMappable) {
            parent::__construct($collection);
        } else {
            $this->map = new TreeMap($collection, $comparator);
            if ($collection != null) {
                $this->addAll($collection);
            }
        }
        $this->dummy = new Mynull;
    }

    /**
     * The add method, append a specific object to the TreeSet if it is not already present.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function add(Objective $object)
    {
        return $this->map->put($object, $this->dummy);
    }

    /**
     * The addAll method, append a collection of objects to the TreeSet.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */
    public function addAll(Collective $collection)
    {
        if ($this->map->size() == 0 and $collection->size() > 0 and $collection instanceof SortedSettable and $this->map instanceof TreeMap) {
            $set = $collection;
            $map = $this->map;
            $setComparator = $set->comparator();
            $mapComparator = $map->comparator();
            if ($setComparator == $mapComparator or ($setComparator != null and $setComparator->equals($mapComparator))) {
                $map->addAll($set, $this->dummy);
                return true;
            }
        }
        return parent::addAll($collection);
    }

    /**
     * The ceiling method, obtains the least element in this TreeSet greater than or equal to the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function ceiling(Objective $object)
    {
        return $this->map->ceilingKey();
    }
    
    /**
     * The comparator method, returns the comparator object used to order the elements in this TreeSet.
     * @access public
     * @return Comparative
     */
    public function comparator()
    {
        return $this->map->comparator();
    }
    
    /**
     * The contains method, checks if a given object is already on the TreeSet.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function contains(Objective $object)
    {
        return $this->map->containsKey($object);
    }
    
    /**
     * The descendingIterator method, acquires an instance of DescendingIterator object of this TreeSet.
     * This method returns an iterator with objects in reverse order as the set.
     * @access public
     * @return DescendingSetIterator
     */
    public function descendingIterator()
    {
        return $this->map->descendingKeySet()->iterator();
    }

    /**
     * The descendingSet method, returns a set with elements in reverse order as this TreeSet.
     * @access public
     * @return NavigableSettable
     */
    public function descendingSet()
    {
        return new TreeSet($this->map->descendingMap());
    }

    /**
     * The first method, obtains the first object stored in this TreeSet.
     * @access public
     * @return Objective
     */
    public function first()
    {
        return $this->map->firstKey();
    }

    /**
     * The floor method, obtains the greatest element in this TreeSet less than or equal to the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function floor(Objective $object)
    {
        return $this->map->floorKey();
    }
    
    /**
     * The headSet method, acquires a portion of the TreeSet ranging from the first element to the supplied element.
     * @param Objective  $toElement
     * @access public
     * @return SortedSettable
     */
    public function headSet(Objective $toElement)
    {
        return $this->headSets($toElement, false);
    }
    
    /**
     * The headSets method, acquires a portion of the TreeSet ranging from the first element to the supplied element.
     * If a boolean TRUE value is supplied, the returned set will contain the supplied element at its tail.
     * @param Objective  $toElement
     * @param Boolean  $inclusive
     * @access public
     * @return SortedSettable
     */
    public function headSets(Objective $toElement, $inclusive)
    {
        return new TreeSet($this->map->headMaps($toElement, $inclusive));
    }

    /**
     * The higher method, obtains the least element in this TreeSet strictly greater than the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function higher(Objective $object)
    {
        return $this->map->higherKey();
    }

    /**
     * The iterator method, acquires an iterator Object for this TreeSet.
     * @access public
     * @return EntryIterator
     */
    public function iterator()
    {
        return $this->map->keyIterator();
    }
    
    /**
     * The last method, obtains the last object stored in this TreeSet.
     * @access public
     * @return Objective
     */
    public function last()
    {
        return $this->map->lastKey();
    }

    /**
     * The lower method, obtains the greatest element in this TreeSet strictly less than the given object.
     * @param Objective  $object
     * @access public
     * @return Objective
     */
    public function lower(Objective $object)
    {
        return $this->map->lowerKey();
    }

    /**
     * The pollFirst method, retrieves and removes the first/lowest element in the TreeSet.
     * @access public
     * @return Objective
     */
    public function pollFirst()
    {
        $entry = $this->map->pollFirstEntry();
        return (($entry == null)?null:$entry->getKey());
    }

    /**
     * The pollLast method, retrieves and removes the last/greatest element in the TreeSet.
     * @access public
     * @return Objective
     */
    public function pollLast()
    {
        $entry = $this->map->pollLastEntry();
        return (($entry == null)?null:$entry->getKey());
    }
    
    /**
     * The remove method, removes a supplied Object from the TreeSet if it is present.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function remove(Objective $object)
    {
        return ($this->map->remove($object) == $this->dummy);
    }

    /**
     * The subSet method, acquires a portion of the TreeSet ranging from the supplied two elements.
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
     * The subSets method, acquires a portion of the TreeSet ranging from the supplied two elements.
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
        return new TreeSet($this->map->subMaps($fromElement, $fromInclusive, $toElement, $toInclusive));
    }

    /**
     * The tailSet method, acquires a portion of the TreeSet ranging from the supplied element to the last element.
     * @param Objective  $fromElement
     * @access public
     * @return SortedSettable
     */
    public function tailSet(Objective $fromElement)
    {
        return $this->tailSets($fromElement, true);
    }
    
    /**
     * The tailSets method, acquires a portion of the TreeSet ranging from the supplied element to the last element.
     * If a boolean TRUE value is supplied for $inclusive, the returned set will contain the supplied element at its head.
     * @param Objective  $fromElement
     * @param Boolean  $inclusive
     * @access public
     * @return SortedSettable
     */
    public function tailSets(Objective $fromElement, $inclusive)
    {
        return new TreeSet($this->map->tailMaps($fromElement, $inclusive));
    }
}
