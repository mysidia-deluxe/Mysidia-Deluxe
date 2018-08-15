<?php

namespace Resource\Collection; 
use Resource\Native\Objective;
use Resource\Exception\IllegalArgumentException;

/**
 * The AscendingSubMap Class, extending from the abstract SubMap Class.
 * It defines a standard AscendingSubMap for Navigable Maps, which will come in handy.
 * This is a final class, and thus no child class shall inherit from it.  
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 * @final
 *
 */

final class AscendingSubMap extends SubMap{

	/**
	 * serialID constant, it serves as identifier of the object being AscendingSubMap.
     */
    const SERIALID = "919286545866124006L";

	/**
     * The comparator method, returns the comparator object used to order the keys in this AscendingSubMap.
     * @access public
     * @return Comparative
     */		
	public function comparator(){
	    return $this->map->comparator();
	}

	/**
     * The descendingKeyIterator method, obtains a key iterator of this SubMap in reversing order.
     * @access public
     * @return DescendingIterator
     */		
	public function descendingKeyIterator(){
        return new DescendingSubKeyIterator($this, $this->absHighest(), $this->absLow());
    }			
	
	/**
     * The descendingMap method, obtains a map in the reversing order for keys contained in this SubMap.
     * @access public
     * @return DescendingSubMap
     */		
	public function descendingMap(){	    
        $map = $this->descendingSubMap;
		return (($map == NULL)?new DescendingSubMap($this->map, $this->fromStart, $this->low, $this->lowInclusive, $this->toEnd, $this->high, $this->highInclusive):$map);
    }		

	/**
     * The entrySet method, returns a Set of entries contained in this SubMap.
     * @access public
     * @return AscendingEntrySet
     */		
	public function entrySet(){
	    $entrySet = $this->entrySubSet;	
		return ($entrySet == NULL)?new AscendingSubSet($this):$entrySet;
    }	
	
	/**
     * The headMaps method, acquires a portion of the SubMap ranging from the first key to the supplied key.
	 * If a boolean TRUE value is supplied, the returned set will contain the supplied key at its tail.	 
	 * @param Objective  $toKey
	 * @param Boolean  $inclusive	 
     * @access public
     * @return AscendingSubMap
     */		
	public function headMaps(Objective $toKey, $inclusive = FALSE){
        if(!$this->inRanges($toKey, $inclusive)) throw new IllegalArgumentException("toKey out of range");	
        return new AscendingSubMap($this->map, $this->fromStart, $this->low, $this->lowInclusive, FALSE, $toKey, $inclusive);	
	}
	
	/**
     * The keyIterator method, acquires an instance of the KeyIterator object of this SubMap.
     * @access public
     * @return KeySubIterator
     */			
	public function keyIterator(){
        return new KeySubIterator($this, $this->absLowest(), $this->absHigh());
    }	
	
	/**
     * The subMap method, acquires a portion of the SubMap ranging from the supplied two keys.
	 * This is a final method, and thus cannot be overriden by child class.	 	 
	 * @param Objective  $fromKey
	 * @param Boolean  $fromInclusive
	 * @param Objective  $toKey
	 * @param Boolean  $toInclusive
     * @access public
     * @return AscendingSubMap
	 * @final
     */		
	public function subMaps(Objective $fromKey, $fromInclusive, Objective $toKey, $toInclusive){
        if(!$this->inRanges($fromKey, $fromInclusive)) throw new IllegalArgumentException("fromKey out of range");
        if(!$this->inRanges($toKey, $toInclusive)) throw new IllegalArgumentException("toKey out of range");
        return new AscendingSubMap($this->map, FALSE, $fromKey, $fromInclusive, FALSE, $toKey, $toInclusive);		
    }			

	/**
     * The tailMaps method, acquires a portion of the SubMap ranging from the supplied key to the last key.
	 * If a boolean TRUE value is supplied for $inclusive, the returned set will contain the supplied key at its head.	 
	 * @param Objective  $fromKey
	 * @param Boolean  $inclusive	 
     * @access public
     * @return AscendingSubMap
     */		
	public function tailMaps(Objective $fromKey, $inclusive){
        if(!$this->inRanges($fromKey, $inclusive)) throw new IllegalArgumentException("fromKey out of range");	
        return new AscendingSubMap($this->map, FALSE, $fromKey, $inclusive, $this->toEnd, $this->high, $this->highInclusive);
    }			
	
	/**
     * The abstract subCeiling method, acquires the absolute ceiling entry to the given key from the SubSet.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
     */		
    public function subCeiling(Objective $key){
        return $this->absCeiling($key);
    }	

	/**
     * The subFloor method, acquires the absolute floor entry to the given key from the SubSet.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
     */		
    public function subFloor(Objective $key){
        return $this->absFloor($key);
    }	
	
	/**
     * The abstract subHigher method, acquires the absolute higher entry than the given key from the SubSet.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
     */		
    public function subHigher(Objective $key){
	    return $this->absHigher($key);
	}
	
	/**
     * The abstract subHighest method, acquires the absolute Highest entry from the SubSet.
     * @access public
     * @return TreeMapEntry
     */		
    public function subHighest(){
        return $this->absHighest();
    }	

	/**
     * The abstract subLower method, acquires the absolute lower entry than the given key from the SubSet.
	 * @param Objective  $key
     * @access public
     * @return TreeMapEntry
     */		
    public function subLower(Objective $key){
        return $this->absLower($key);
    }	
	
	/**
     * The abstract subLowest method, acquires the absolute lowest entry from the SubSet.
     * @access public
     * @return TreeMapEntry
     */		
    public function subLowest(){
        return $this->absLowest();
    }	
}
?>