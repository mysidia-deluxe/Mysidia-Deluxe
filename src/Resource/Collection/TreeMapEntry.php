<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The TreeMapEntry Class, extending from the MapEntry Class.
 * It defines a standard entry for TreeMap type objects, which usually comes in handy.
 * This is a final class, no child class shall inherit from it.
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

final class TreeMapEntry extends MapEntry
{

    /**
     * The color property, it defines the color of the Entry.
     * @access private
     * @var Boolean
    */
    private $color;

    /**
     * The left property, it stores the left entry adjacent to this one.
     * @access private
     * @var MapEntry
    */
    private $left;
    
    /**
     * The parent property, it defines the parent entry above this one.
     * @access private
     * @var Objective
    */
    private $parent;
    
    /**
     * The right property, it stores the right entry adjacent to this one.
     * @access private
     * @var MapEntry
    */
    private $right;

    /**
     * Constructor of TreeMapEntry Class, it initializes a TreeMapEntry with a key and a value.
     * @param Objective  $key
     * @param Objective  $value
     * @param MapEntry  $parent
     * @access public
     * @return Void
     */
    public function __construct(Objective $key = null, Objective $value = null, MapEntry $parent = null)
    {
        parent::__construct($key, $value);
        $this->parent = $parent;
        $this->color = TreeMap::BLACK;
    }
    
    /**
     * The equals method, checks whether target MapEntry is equivalent to this one.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function equals(Objective $object)
    {
        if (!($object instanceof TreeMapEntry)) {
            return false;
        }
        return (($this->valueEquals($this->key, $object->getKey())) and ($this->valueEquals($this->value, $object->getValue())));
    }

    /**
     * The getColor method, getter method for property $color.
     * @access public
     * @return Boolean
     */
    public function getColor()
    {
        return $this->color;
    }
    
    /**
     * The getLeft method, getter method for property $left.
     * @access public
     * @return MapEntry
     */
    public function getLeft()
    {
        return $this->left;
    }
    
    /**
     * The getParent method, getter method for property $parent.
     * @access public
     * @return MapEntry
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * The getRight method, getter method for property $right.
     * @access public
     * @return MapEntry
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * The setColor method, setter method for property $color.
     * @param Boolean  $color
     * @access public
     * @return Void
     */
    public function setColor($color = false)
    {
        $this->color = $color;
    }
    
    /**
     * The setLeft method, setter method for property $left.
     * @param MapEntry  $left
     * @access public
     * @return Void
     */
    public function setLeft(MapEntry $left = null)
    {
        $this->left = $left;
    }

    /**
     * The setParent method, setter method for property $parent.
     * @param MapEntry  $parent
     * @access public
     * @return Void
     */
    public function setParent(MapEntry $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * The setRight method, setter method for property $right.
     * @param MapEntry  $right
     * @access public
     * @return Void
     */
    public function setRight(MapEntry $right = null)
    {
        $this->right = $right;
    }
    
    /**
     * The valueEquals method, evaluates if two given values are equal to each other.
     * @param Objective  $object
     * @param Objective  $object2
     * @access public
     * @return Boolean
     */
    public function valueEquals(Objective $object, Objective $object2)
    {
        return (($object == null)?($object2 == null):$object->equals($object2));
    }
}
