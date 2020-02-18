<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The Mappable Interface, extending from the Collective interface.
 * A Map type Collection must implement this interface to be properly used.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

interface Mappable extends Collective
{
    
    /**
     * The containsKey method, checks if the map contains a specific key among its key-value pairs.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function containsKey(Objective $key);
    
    /**
     * The containsValue method, checks if the map contains a specific value among its key-value pairs.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function containsValue(Objective $value);

    /**
     * The entrySet method, returns a Set of key-value pair mappings for this Map.
     * @access public
     * @return Settable
     */
    public function entrySet();
    
    /**
     * The get method, acquires the value stored in the Map given its key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */
    public function get(Objective $key);
        
    /**
     * The keySet method, returns a Set of keys contained in this Map.
     * @access public
     * @return Settable
     */
    public function keySet();

    /**
     * The put method, associates a specific value with the specific key in this Map.
     * @param Objective  $key
     * @param Objective  $value
     * @access public
     * @return Objective
     */
    public function put(Objective $key, Objective $value);
    
    /**
     * The putAll method, copies all mappings from a specific map to this Map.
     * @param Mappable  $map
     * @access public
     * @return Objective
     */
    public function putAll(Mappable $map);
    
    /**
     * The valueSet method, returns a Set of values contained in this Map.
     * @access public
     * @return Settable
     */
    public function valueSet();
}
