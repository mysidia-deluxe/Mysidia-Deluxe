<?php

namespace Resource\Native;

use Resource\Utility\Comparable;

/**
 * The Abstract Number Class, extends parent Object root class.
 * Similar to Java's number class, it's parent to all numeric type wrapper classes.
 * A number cannot be instantiated using new keyword, since it's abstract.
 * @category Resource
 * @package Native
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not much at this point.
 * @abstract
 *
 */

abstract class Number extends Object implements Comparable, Primitive
{

    /**
     * The value property, which stores the primitive numeric value.
     * @access protected
     * @var Number
    */
    protected $value;

    
    /**
     * Constructor of Number Class, it verifies if supplied primitive data type is valid.
     * @param Number  $num
     * @access public
     * @return Void
     */
    public function __construct($num)
    {
        $this->verify($num);
    }
   
    /**
     * The getValue method, returns the primitive data type value.
     * @access public
     * @return Number
     */
    public function getValue()
    {
        return $this->value;
    }
   
    /**
     * The intValue method, casts and fetchs int primitive value.
     * @access public
     * @return Int
     */
    public function intValue()
    {
        return (int)$this->value;
    }
   
    /**
     * The floatValue method, casts and fetchs float primitive value.
     * @access public
     * @return Float
     */
    public function floatValue()
    {
        return (float)$this->value;
    }
   
    /**
     * The doubleValue method, casts and fetchs double primitive value.
     * @access public
     * @return Double
     */
    public function doubleValue()
    {
        return (double)$this->value;
    }
   
    /**
     * The isPositive method, checks if the number is positive or not.
     * @access public
     * @return Boolean
     */
    public function isPositive()
    {
        return($this->value > 0)?true:false;
    }
    
    /**
     * The isNegative method, checks if the number is negative or not.
     * @access public
     * @return Boolean
     */
    public function isNegative()
    {
        return($this->value < 0)?true:false;
    }
 
    /**
     * The compareTo method, compares this number to another number.
     * @param Objective  $target
     * @access public
     * @return Int
     */
    public function compareTo(Objective $target)
    {
        if (!($target instanceof Number)) {
            throw new InvalidArgumentException("Supplied argument must be a numeric value!");
        }
        return ($this->equals($target))?0:($this->value - $target->getValue());
    }
 
    /**
     * The toByte method, converts value and returns a Byte Object.
     * @access public
     * @return Byte
     */
    public function toByte()
    {
        return new Byte($this->value);
    }
   
    /**
     * The toShort method, converts value and returns a Short Object.
     * @access public
     * @return Short
     */
    public function toShort()
    {
        return new Short($this->value);
    }
    
    /**
     * The toInteger method, converts value and returns an Integer Object.
     * @access public
     * @return Integer
     */
    public function toInteger()
    {
        return new Integer($this->value);
    }
    
    /**
     * The toLong method, converts value and returns a Long Object.
     * @access public
     * @return Long
     */
    public function toLong()
    {
        return new Long($this->value);
    }
    
    /**
     * The toFloat method, converts value and returns a Float Object.
     * @access public
     * @return Float
     */
    public function toFloat()
    {
        return new Float($this->value);
    }
    
    /**
     * The toFloat method, converts value and returns a Double Object.
     * @access public
     * @return Double
     */
    public function toDouble()
    {
        return new Double($this->value);
    }
   
    /**
     * Magic method __toString() for Number class, casts its primitive value to string.
     * This method is inherited in all of Number's child classes.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * Magic method __invoke() for Number class, it returns the primitive data value for manipulation.
     * This method is inherited in all of Number's child classes.
     * @access public
     * @return Number
     */
    public function __invoke()
    {
        return $this->value;
    }
    
    /**
     * The abstract verify method, its implementation is left over to child classes.
     * @param Number $num
     * @access public
     * @return Boolean
     * @abstract
     */
    abstract public function verify($num);
}
