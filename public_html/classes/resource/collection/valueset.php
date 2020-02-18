<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The ValueSet Class, extending from the ValueMapSet Class.
 * It defines a standard set to hold values in a HashMap, it is important for HashMap type objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class ValueSet extends ValueMapSet
{
    
    /**
     * Constructor of ValueSet Class, it simply calls parent constructor.
     * @param HashMap  $map
     * @access public
     * @return Void
     */
    public function __construct(HashMap $map)
    {
        parent::__construct($map);
    }
    
    /**
     * The iterator method, acquires an instance of the value iterator object of the ValueSet.
     * @access public
     * @return ValueIterator
     */
    public function iterator()
    {
        return $this->map->valueIterator();
    }
    
    /**
     * The remove method, removes the underlying value in Iterator given its current key.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function remove(Objective $object)
    {
        return $this->map->removeKey($object);
    }
}
