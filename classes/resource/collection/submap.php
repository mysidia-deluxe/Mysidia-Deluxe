<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Exception\IllegalArgumentException;

/**
 * The abstract SubMap Class, extending from the abstract Map Class and implementing the NavigableMappable Interface.
 * It defines a standard SubMap for Navigable Maps, but must be extended by child classes.
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

abstract class SubMap extends Map implements NavigableMappable{

    /**
	 * The map property, it stores a reference to the backup map object.
	 * @access protected
	 * @var TreeMap
    */		
	protected $map;

    /**
	 * The descendingSubMap property, it holds a reference to the DescendingMap of this SubMap.
	 * @access protected
	 * @var DescendingSubMap
     */
    protected $descendingSubMap;	

    /**
	 * The entrySubSet property, it holds a reference to the subset of the Entries holding key-value pairs in the SubMap.
	 * @access protected
	 * @var EntrySubSet
     */
    protected $entrySubSet;	
	
    /**
	 * The fromStart property, species if the lower (absolute) bound is the start of the backing map.
	 * @access protected
	 * @var Boolean
    */
	protected $fromStart;	

    /**
	 * The high property, it defines the upper bound for the SubMap.
	 * @access protected
	 * @var Objective
    */
	protected $high;		
	
    /**
	 * The highInclusive property, determines if the upper bound is the inclusive bound.
	 * @access protected
	 * @var Boolean
    */
	protected $highInclusive;	
	
    /**
	 * The low property, it defines the lower bound for the SubMap.
	 * @access protected
	 * @var Objective
    */
	protected $low;	
	
    /**
	 * The lowInclusive property, determines if the lower bound is the inclusive bound. 
	 * @access protected
	 * @var Boolean
    */
	protected $lowInclusive;	

    /**
	 * The navigableKeySubSet property, it holds a reference to the navigable subset representing keys inside the SubMap.
	 * @access protected
	 * @var KeySet
     */
    protected $navigableKeySubSet;
	
    /**
	 * The toEnd property, species if the upper (absolute) bound is the end of the backing map.
	 * @access protected
	 * @var Boolean
    */
	protected $toEnd;	
	
	/**
     * Constructor of SubMap Class, it initializes basic properties for this Navigable SubMap.  
     * @param TreeMap  $map
	 * @param Comparative  $comparator
     * @access public
     * @return Void
     */	
	public function __construct(TreeMap $map, $fromStart, Objective $low = NULL, $lowInclusive, $toEnd, Objective $high = NULL, $highInclusive){
        if(!$fromStart and !$toEnd) {
            if($map->compare($low, $high) > 0) throw new IllegalArgumentException("fromKey > toKey");
        } 
	    else{
            if(!$fromStart) $map->compare($low, $low);
            if(!$toEnd) $map->compare($high, $high);
        }
        $this->map = $map;
        $this->fromStart = $fromStart;
        $this->low = $low;
        $this->lowInclusive = $lowInclusive;
        $this->toEnd = $toEnd;
        $this->high = $high;
        $this->highInclusive = $highInclusive;	    
	}

	/**
     * The absCeiling method, returns the absolute Ceiling TreeMapEntry than the entry with a given key.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absCeiling(Objective $key){
        if($this->tooLow($key)) return $this->absLowest();
		$entry = $this->map->getCeilingEntry($key);
        return (($entry == NULL or $this->tooHigh($entry->getKey()))?NULL:$entry);			 
	}			

	/**
     * The absFloor method, returns the absolute Floor TreeMapEntry than the entry with a given key.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absFloor(Objective $key){
        if($this->tooHigh($key)) return $this->absHighest();
		$entry = $this->map->getFloorEntry($key);
        return (($entry == NULL or $this->tooLow($entry->getKey()))?NULL:$entry);			 
	}	

	/**
     * The absHigh method, returns the absolute high fence for ascending traversal.
	 * This is a final method, and thus cannot be overriden by child class.
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absHigh(){
        return ($this->toEnd?NULL:($this->highInclusive?
                $this->map->getHigherEntry($this->high):
				$this->map->getCeilingEntry($this->high)));        			 
	}		
	
	/**
     * The absHigher method, returns the absolute higher TreeMapEntry than the entry with a given key.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absHigher(Objective $key){
        if($this->tooLow($key)) return $this->absLowest();
		$entry = $this->map->getHigherEntry($key);
        return (($entry == NULL or $this->tooHigh($entry->getKey()))?NULL:$entry);			 
	}			
	
	/**
     * The absHighest method, returns the absolute highest TreeMapEntry from this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absHighest(){
        $entry =($this->toEnd?
		         $this->map->getLastEntry():
                ($this->highInclusive?
				 $this->map->getFloorEntry($this->high):
				 $this->map->getLowerEntry($this->high)));
        return (($entry == NULL or $this->tooLow($entry->getKey()))?NULL:$entry);				 
	}				

	/**
     * The absLow method, returns the absolute low fence for ascending traversal.
	 * This is a final method, and thus cannot be overriden by child class.
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absLow(){
        return ($this->fromStart?NULL:($this->lowInclusive?
                $this->map->getLowerEntry($this->low):
				$this->map->getFloorEntry($this->low)));        			 
	}	
	
	/**
     * The absLowest method, returns the absolute lowest TreeMapEntry from this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absLowest(){
        $entry =($this->fromStart?
		         $this->map->getFirstEntry():
                ($this->lowInclusive?
				 $this->map->getCeilingEntry($this->low):
				 $this->map->getHigherEntry($this->low)));
        return (($entry == NULL or $this->tooHigh($entry->getKey()))?NULL:$entry);				 
	}	

	/**
     * The absLower method, returns the absolute Lower TreeMapEntry than the entry with a given key.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @final
     */		
	public final function absLower(Objective $key){
        if($this->tooHigh($key)) return $this->absHighest();
		$entry = $this->map->getLowerEntry($key);
        return (($entry == NULL or $this->tooLow($entry->getKey()))?NULL:$entry);			 
	}	

	/**
     * The ceilingEntry method, returns an entry associated with the least key greater than or equal to the given key.
	 * This is a final method, and thus cannot be overriden by child class.	 
	 * @param Objective  $key
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function ceilingEntry(Objective $key){
        return $this->map->exportEntry($this->subCeiling($key));
    }	

	/**
     * The ceilingKey method, acquires the least key greater than or equal to the given key.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return Objective
	 * @final
     */		
	public final function ceilingKey(Objective $key){
        return $this->map->key($this->subCeiling($key), TRUE);
	}
	
	/**
     * The containsKey method, checks if the SubMap contains a specific key among its key-value pairs.
	 * This is a final method, and thus cannot be overriden by child class.	 
     * @param Objective  $object 
     * @access public
     * @return Boolean
	 * @final
     */		
	public final function containsKey(Objective $key = NULL){
	    return ($this->inRange($key) and $this->map->containsKey($key));    
	}	

	/**
     * The descendingKeySet method, obtains a key set of this SubMap in reversing order.
	 * This is a final method, and thus cannot be overriden by child class.	 
     * @access public
     * @return NavigableSettable
	 * @final
     */		
	public function descendingKeySet(){
        return $this->descendingMap()->navigableKeySet();
    }		
	
	/**
     * The firstEntry method, returns the entry with the least key in the Submap.
	 * This is a final method, and thus cannot be overriden by child class.	 	 
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function firstEntry(){
	    return $this->map->exportEntry($this->subLowest());
	}
	
	/**
     * The firstKey method, obtains the first key object stored in this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.	 	 
     * @access public
     * @return Objective
	 * @final
     */		
	public final function firstKey(){
	    return $this->map->key($this->subLowest());
	}
	
	/**
     * The FloorEntry method, returns an entry associated with the least key strictly greater than the given key.
	 * This is a final method, and thus cannot be overriden by child class.	 
	 * @param Objective  $key
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function floorEntry(Objective $key){
        return $this->map->exportEntry($this->subFloor($key));
    }	

	/**
     * The floorKey method, acquires the greatest key less than or equal to the given key.
	 * This is a final method, and thus cannot be overriden by child class.	 
	 * @param Objective  $key
     * @access public
     * @return Objective
	 * @final
     */		
	public final function floorKey(Objective $key){
        return $this->map->key($this->subFloor($key), TRUE);
    }		

	/**
     * The fromStart method, getter method for property fromStart.
     * @access public
     * @return Boolean
     */		
	public function fromStart(){
	    return $this->fromStart;
	}		
	
 	/**
     * The get method, acquires the value stored in the SubMap given its key.
	 * This is a final method, and thus cannot be overriden by child class.		 
     * @param Objective  $key
     * @access public
     * @return Objective
	 * @final
     */		
 	public function get(Objective $key){
	    return (!$this->inRange($key)?NULL:$this->map->get($key));
	}

	/**
     * The getMap method, getter method for property map.
     * @access public
     * @return TreeMap
     */		
	public function getMap(){
	    return $this->map;
	}		
	
	/**
     * The headMap method, acquires a portion of the SubMap ranging from the first key to the supplied key.
	 * This is a final method, and thus cannot be overriden by child class.		 
	 * @param Objective  $toKey
     * @access public
     * @return NavigableMappable
	 * @final
     */		
	public function headMap(Objective $toKey){
        return $this->map->headMaps($toKey, FALSE);
    }		
	
	/**
     * The higherEntry method, returns an entry associated with the least key strictly greater than the given key.
	 * This is a final method, and thus cannot be overriden by child class.	 
	 * @param Objective  $key
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function higherEntry(Objective $key){
        return $this->map->exportEntry($this->subHigher($key));
    }	

	/**
     * The higherKey method, acquires the least key strictly greater than the given key.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return Objective
	 * @final
     */		
	public final function higherKey(Objective $key){
        return $this->map->key($this->subHigher($key), TRUE);
	}
	
	/**
     * The inCloseRange method, validates the key is within close range of this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return Boolean
	 * @final
     */		
	public final function inCloseRange(Objective $key){
	    return (($this->fromStart or $this->map->compare($key, $this->low) >= 0) and ($this->toEnd or $this->map->compare($this->high, $key) >= 0));
	}		
	
	/**
     * The inRange method, validates the key is within range of this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return Boolean
	 * @final
     */		
	public final function inRange(Objective $key){
	    return (!$this->tooLow($key) and !$this->tooHigh($key));
	}	
	
	/**
     * The inRanges method, validates the key is within range of this SubMap accounting for inclusive properties.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
	 * @param Boolean  $inclusive
     * @access public
     * @return Boolean
	 * @final
     */		
	public final function inRanges(Objective $key, $inclusive = FALSE){
	    return ($inclusive?$this->inRange($key):$this->inCloseRange($key));
	}		

	/**
     * The isEmpty method, checks if the SubMap is empty or not.
     * @access public
     * @return Boolean
     */		
	public function isEmpty(){
	    return (($this->fromStart and $this->toEnd)?$this->map->isEmpty():$this->entrySet()->isEmpty());
	}	

	/**
     * The iterator method, acquires an instance of the entry iterator object of the SubMap.
     * @access public
     * @return EntrySubIterator
     */			
    public function iterator(){
	    return $this->entrySet()->iterator();
	}

	/**
     * The keySet method, returns a Set of keys contained in this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.		 
     * @access public
     * @return KeySet
	 * @final
     */		
	public final function keySet(){
        return $this->navigableKeySet();
    }	
	
	/**
     * The lastEntry method, returns the entry with the greatest key in the SubMap.
	 * This is a final method, and thus cannot be overriden by child class.	 	 
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function lastEntry(){
	    return $this->map->exportEntry($this->subHighest());    
    }	
	
	/**
     * The lastKey method, obtains the last key object stored in this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.	 	 
     * @access public
     * @return Objective
	 * @final
     */		
	public final function lastKey(){
	    return $this->map->key($this->subHighest());
    }		
	
	/**
     * The lowerEntry method, returns an entry associated with the greatest key strictly less than the given key.
	 * This is a final method, and thus cannot be overriden by child class.	 
	 * @param Objective  $key
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function LowerEntry(Objective $key){
        return $this->map->exportEntry($this->subLower($key));
    }	

	/**
     * The lowerKey method, acquires the greatest key strictly less than the given key.
	 * This is a final method, and thus cannot be overriden by child class.	 
	 * @param Objective  $key
     * @access public
     * @return Objective
	 * @final
     */			
	public final function LowerKey(Objective $key){
        return $this->map->key($this->subLower($key), TRUE);
	}	

	/**
     * The navigableKeySet method, obtains a key set of this SubMap in the same order.
	 * This is a final method, and thus cannot be overriden by child class.		 
     * @access public
     * @return NavigableSettable
	 * @final
     */		
	public final function navigableKeySet(){
        $keySet = $this->navigableKeySubSet;
        return (($keySet != NULL)?$keySet:($this->navigableKeySubSet = new KeyTreeSet($this)));	
    }		
	
	/**
     * The pollFirstEntry method, retrieves and removes the entry associated with the least key in the SubMap.
	 * This is a final method, and thus cannot be overriden by child class.		 
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function pollFirstEntry(){
	    $entry = $this->subLowest();
		$exportEntry = $this->map->exportEntry($entry);
		if($entry != NULL) $this->map->deleteEntry($entry);
		return $exportEntry;	
	}

	/**
     * The pollLastEntry method, retrieves and removes the entry associated with the greatest key in the SubMap.
	 * This is a final method, and thus cannot be overriden by child class.		 
     * @access public
     * @return MapEntry
	 * @final
     */		
	public final function pollLastEntry(){
	    $entry = $this->subHighest();
		$exportEntry = $this->map->exportEntry($entry);
		if($entry != NULL) $this->map->deleteEntry($entry);
		return $exportEntry;		
	}	
	
	/**
     * The put method, associates a specific value with the specific key in this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.
     * @param Objective  $key
	 * @param Objective  $value
     * @access public
     * @return Objective
	 * @final
     */		
	public final function put(Objective $key = NULL, Objective $value = NULL){
 	    if(!$this->inRange($key) and $this->map->containsKey($key)) throw new IllegalArgumentException("key out of range");
        return $this->map->put($key, $value);		
	}	

 	/**
     * The remove method, removes a specific key-value pair from the SubMap.
	 * This is a final method, and thus cannot be overriden by child class.	 
     * @param Objective  $key
     * @access public
     * @return Objective
	 * @final
     */		
	public function remove(Objective $key = NULL){
        return (!$this->inRange($key)?NULL:$this->map->remove($key)); 	
	}
	
	/**
     * The size method, returns the current size of this SubMap.
     * @access public
     * @return Int
     */			
	public function size(){
	    return (($this->fromStart and $this->toEnd)?$this->map->size():$this->entrySet()->size());
	}		

	/**
     * The subMap method, acquires a portion of the TreeMap ranging from the supplied two keys.
	 * This is a final method, and thus cannot be overriden by child class.	 	 
	 * @param Objective  $fromKey
	 * @param Objective  $toKey
     * @access public
     * @return NavigableMappable
	 * @final
     */		
	public function subMap(Objective $fromKey, Objective $toKey){
        return $this->map->subMaps($fromKey, TRUE, $toKey, FALSE);    
    }			
	
	/**
     * The tailMap method, acquires a portion of the SubMap ranging from the supplied key to the last key.
	 * This is a final method, and thus cannot be overriden by child class.	 
	 * @param Objective  $fromKey
     * @access public
     * @return NavigableMappable
	 * @final
     */		
	public final function tailMap(Objective $fromKey){
        return $this->map->tailMaps($fromKey, FALSE);
    }	

	/**
     * The toEnd method, getter method for property toEnd.
     * @access public
     * @return Boolean
     */		
	public function toEnd(){
	    return $this->toEnd;
	}	
	
	/**
     * The tooHigh method, checks if the given Key is beyond the upper bound of this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return Boolean
	 * @final
     */		
	public final function tooHigh(Objective $key){
	    if(!$this->toEnd){
		    $comparison = $this->map->compare($key, $this->high);
			if($comparison > 0 or ($comparison == 0 and !$this->highInclusive)) return TRUE;
		}
		return FALSE;
	}	

	/**
     * The tooLow method, checks if the given Key is beyond the lower bound of this SubMap.
	 * This is a final method, and thus cannot be overriden by child class.
	 * @param Objective  $key
     * @access public
     * @return Boolean
	 * @final
     */		
	public final function tooLow(Objective $key){
	    if(!$this->fromStart){
		    $comparison = $this->map->compare($key, $this->low);
			if($comparison < 0 or ($comparison == 0 and !$this->lowInclusive)) return TRUE;
		}
		return FALSE;
	}

	/**
     * The abstract descendingKeyIterator method, must be implemented by child class.
     * @access public
     * @return DescendingKeyIterator
	 * @abstract
     */		
    public abstract function descendingKeyIterator();		
	
	/**
     * The abstract keyIterator method, must be implemented by child class.
     * @access public
     * @return KeyIterator
	 * @abstract
     */		
    public abstract function keyIterator();		
	
	/**
     * The abstract subCeiling method, must be implemented by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @abstract
     */		
    public abstract function subCeiling(Objective $key);	

	/**
     * The abstract subFloor method, must be implemented by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @abstract
     */		
    public abstract function subFloor(Objective $key);		
	
	/**
     * The abstract subHigher method, must be implemented by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @abstract
     */		
    public abstract function subHigher(Objective $key);
	
	/**
     * The abstract subHighest method, must be implemented by child class.
     * @access public
     * @return TreeMapEntry
	 * @abstract
     */		
    public abstract function subHighest();		

	/**
     * The abstract subLower method, must be implemented by child class.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
	 * @abstract
     */		
    public abstract function subLower(Objective $key);	
	
	/**
     * The abstract subLowest method, must be implemented by child class.
     * @access public
     * @return TreeMapEntry
	 * @abstract
     */		
    public abstract function subLowest();	
}
?>