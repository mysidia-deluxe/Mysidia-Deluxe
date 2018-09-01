<?php

namespace Resource\Native;

use Resource\Utility\Comparable;

/**
 * The Boolean Class, extending the root Object class.
 * This class serves as a wrapper class for primitive data type boolean.
 * It is a final class, no child class shall derive from Boolean.
 * @category Resource
 * @package Native
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not much at this point.
 * @final
 *
 */

final class Boolean extends Object implements Comparable, Primitive
{
    
    /**
     * Size constant, specifies the size a boolean value occupies.
    */
    const Size = 8;
    
    /**
     * BooleanTrue constant, defines the True value for Boolean.
    */
    const BooleanTRUE = true;
    
    /**
     * BooleanFALSE constant, defines the False value for Boolean.
    */
    const BooleanFALSE = false;
    
    /**
     * The value property, which stores the primitive value for this Boolean object.
     * @access private
     * @var Boolean
    */
    private $value;
      
    /**
     * Constructor of Boolean Class, initializes the Boolean wrapper class.
     * If supplied argument is not of boolean type, type casting will be converted.
     * @param Any  $param
     * @access public
     * @return Void
     */
    public function __construct($param)
    {
        if (!is_bool($param)) {
            $param = (boolean)$param;
        }
        $this->value = $param;
    }

    /**
     * The getValue method, returns the primitive boolean value.
     * @access public
     * @return Boolean
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * The compareTo method, compares a boolean object to another.
     * @param Objective  $target
     * @access public
     * @return Int
     */
    public function compareTo(Objective $target)
    {
        if (!($target instanceof Boolean)) {
            throw new InvalidArgumentException("Supplied argument must be a boolean value!");
        }
        return ($this->equals($target))?0:($this->value ? 1 : -1);
    }

    /**
     * Magic method to_String() for Boolean class, casts boolean value into string.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return (string)$this->value;
    }
    
    /**
     * Magic method __invoke() for Boolean class, it returns the primitive data value for manipulation.
     * @access public
     * @return Number
     */
    public function __invoke()
    {
        return $this->value;
    }
}
