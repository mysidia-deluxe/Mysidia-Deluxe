<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The HashMapEntry Class, extending from the MapEntry Class.
 * It defines a standard entry for HashMap type objects, which usually comes in handy.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class HashMapEntry extends MapEntry
{

    /**
     * The hash property, it specifies the hash of this HashMapEntry.
     * @access protected
     * @var Int
    */
    protected $hash;
    
    /**
     * The next property, it stores the next entry adjacent to this one.
     * @access protected
     * @var MapEntry
    */
    protected $next;

    /**
     * Constructor of HashMapEntry Class, it initializes a HashMapEntry with a key and a value.
     * @param Int  $hash
     * @param Objective  $key
     * @param Objective  $value
     * @param MapEntry  $entry
     * @access public
     * @return Void
     */
    public function __construct($hash = 0, Objective $key = null, Objective $value = null, MapEntry $entry = null)
    {
        parent::__construct($key, $value);
        $this->hash = $hash;
        $this->next = $entry;
    }
    
    /**
     * The equals method, checks whether target MapEntry is equivalent to this one.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function equals(Objective $object)
    {
        if (!($object instanceof HashMapEntry)) {
            return false;
        }
        $key = $this->getKey();
        $key2 = $object->getKey();
        
        if ($key == $key2 or ($key != null and $key->equals($key2))) {
            $value = $this->getValue();
            $value2 = $object->getValue();
            if ($value == $value2 or ($value != null and $value->equals($value2))) {
                return true;
            }
        }
        return false;
    }

    /**
     * The getHash method, getter method for property $hash.
     * @access public
     * @return Int
     */
    public function getHash()
    {
        return $this->hash;
    }
    
    /**
     * The getNext method, getter method for property $next.
     * @access public
     * @return MapEntry
     */
    public function getNext()
    {
        return $this->next;
    }
    
    /**
     * The recordAccess method, it is invoked whenever the value in an entry is overriden with put method.
     * @access public
     * @return Void
     */
    public function recordAccess(HashMap $map)
    {
    }
    
    /**
     * The recordRemoval method, it is invoked whenever the value in an entry is removed from HashMap.
     * @access public
     * @return Void
     */
    public function recordRemoval(HashMap $map)
    {
    }
    
    /**
     * The setNext method, setter method for property $next.
     * @param MapEntry  $next
     * @access public
     * @return Void
     */
    public function setNext(MapEntry $next = null)
    {
        $this->next = $next;
    }
}
