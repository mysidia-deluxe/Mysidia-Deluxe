<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The NavigableMappable Interface, extending from the SortedMappable interface.
 * It defines an extended sorted map interface with navigation methods.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

interface NavigableMappable extends SortedMappable
{

    /**
     * The ceilingEntry method, returns an entry associated with the least key greater than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function ceilingEntry(Objective $key);

    /**
     * The ceilingKey method, acquires the least key greater than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function ceilingKey(Objective $key);

    /**
     * The descendingKeySet method, obtains a key set of this map in reversing order.
     * @access public
     * @return NavigableSettable
     */
    public function descendingKeySet();
    
    /**
     * The descendingMap method, obtains a map in the reversing order for keys contained in this map.
     * @access public
     * @return NavigableMappable
     */
    public function descendingMap();
    
    /**
     * The firstEntry method, returns the entry with the least key in the map.
     * @access public
     * @return MapEntry
     */
    public function firstEntry();
    
    /**
     * The floorEntry method, returns an entry associated with the greatest key less than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function floorEntry(Objective $key);

    /**
     * The floorKey method, acquires the greatest key less than or equal to the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function floorKey(Objective $key);

    /**
     * The headMaps method, acquires a portion of the TreeMap ranging from the first key to the supplied key.
     * If a boolean TRUE value is supplied, the returned set will contain the supplied key at its tail.
     * @param Objective  $toKey
     * @param Boolean  $inclusive
     * @access public
     * @return NavigableMappable
     */
    public function headMaps(Objective $toKey, $inclusive);
    
    /**
     * The higherEntry method, returns an entry associated with the least key strictly greater than the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function higherEntry(Objective $key);

    /**
     * The higherKey method, acquires the least key strictly greater than the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function higherKey(Objective $key);

    /**
     * The lastEntry method, returns the entry with the greatest key in the map.
     * @access public
     * @return MapEntry
     */
    public function lastEntry();
    
    /**
     * The lowerEntry method, returns an entry associated with the greatest key strictly less than the given key.
     * @param Objective  $key
     * @access public
     * @return MapEntry
     */
    public function lowerEntry(Objective $key);

    /**
     * The lowerKey method, acquires the greatest key strictly less than the given key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function lowerKey(Objective $key);

    /**
     * The navigableKeySet method, obtains a key set of this map in the same order.
     * @access public
     * @return NavigableSettable
     */
    public function navigableKeySet();
    
    /**
     * The pollFirstEntry method, retrieves and removes the entry associated with the least key in the map.
     * @access public
     * @return MapEntry
     */
    public function pollFirstEntry();

    /**
     * The pollLastEntry method, retrieves and removes the entry associated with the greatest key in the map.
     * @access public
     * @return MapEntry
     */
    public function pollLastEntry();
    
    /**
     * The subMap method, acquires a portion of the Map ranging from the supplied two keys.
     * If boolean value TRUE is supplied for $inclusive, the return set will contain $fromKey and/or $toKey.
     * @param Objective  $fromKey
     * @param Boolean  $fromInclusive
     * @param Objective  $toKey
     * @param Boolean  $toInclusive
     * @access public
     * @return SortedMappable
     */
    public function subMaps(Objective $fromKey, $fromInclusive, Objective $toKey, $toInclusive);

    /**
     * The tailMap method, acquires a portion of the Map ranging from the supplied key to the last key.
     * If a boolean TRUE value is supplied for $inclusive, the returned set will contain the supplied key at its head.
     * @param Objective  $fromKey
     * @param Boolean  $inclusive
     * @access public
     * @return SortedMappable
     */
    public function tailMaps(Objective $fromKey, $inclusive);
}
