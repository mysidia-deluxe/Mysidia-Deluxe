<?php

namespace Resource\Native;

use Exception;
use Resource\Exception\ClassCastException;

/**
 * The Float Class, extending from the abstract Number class.
 * This class serves as a wrapper class for primitive data type float.
 * It is a final class, no child class shall derive from Float.
 * @category Resource
 * @package Native
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Design the binary, octal, hex code conversion methods.
 * @final
 *
 */

final class Float extends Number
{
    
    /**
     * Size constant, specifies the size a float value occupies.
    */
    const Size = 32;
    
    /**
     * Base constant, stores the base used for exponent.
    */
    const Base = 10;
    
    /**
     * MinCoeff constant, specifies the coefficient for minimum exponent.
    */
    const MinCoeff = 1.4;
    
    /**
     * MaxCoeff constant, specifies the coefficient for maximum exponent.
    */
    const MaxCoeff = 3.4;
    
    /**
     * MinExp constant, defines the minimum allowable exponent.
    */
    const MinExp = -45;
    
    /**
     * MaxExp constant, defines the maximum allowable exponent.
    */
    const MaxExp = 38;
   
   
    /**
     * Constructor of Float Class, initializes the Float wrapper class.
     * If supplied argument is not a float, it will be converted to float primitive type.
     * @param Number  $num
     * @access public
     * @return Void
     */
    public function __construct($num)
    {
        if (!is_float($num)) {
            $num = (float)$num;
        }
        parent::__construct($num);
        $this->value = $num;
    }
    
    /**
     * The getExp method, gets the exponent of this number.
     * @access private
     * @return Int
     */
    private function getExp($num)
    {
        return (int)log10(abs($num));
    }

    /**
     * The getMax method, gets the maximum allowable number in Float class.
     * @access private
     * @return Float
     */
    private function getMax()
    {
        return (self::MaxCoeff * pow(self::Base, self::MaxExp));
    }
    
    /**
     * The getMin method, gets the minimum allowable number in Float class.
     * @access private
     * @return Float
     */
    private function getMin()
    {
        return (-1 * self::MaxCoeff * pow(self::Base, self::MaxExp));
    }
        
    /**
     * The toByte method, converts value and returns a Byte Object.
     * @access public
     * @return Byte
     */
    public function toByte()
    {
        if ($this->intValue($this->value) < Byte::MinValue or $this->intValue($this->value) > Byte::MaxValue) {
            throw new ClassCastException('Cannot convert to Byte type.');
        }
        return new Byte($this->value);
    }
   
    /**
     * The toShort method, converts value and returns a Short Object.
     * @access public
     * @return Short
     */
    public function toShort()
    {
        if ($this->intValue($this->value) < Short::MinValue or $this->intValue($this->value) > Short::MaxValue) {
            throw new ClassCastException('Cannot convert to Short type.');
        }
        return new Short($this->value);
    }
    
    /**
     * The toInteger method, converts value and returns an Integer Object.
     * @access public
     * @return Integer
     */
    public function toInteger()
    {
        if ($this->intValue($this->value) < Integer::MinValue or $this->intValue($this->value) > Integer::MaxValue) {
            throw new ClassCastException('Cannot convert to Integer type.');
        }
        return new Integer($this->value);
    }
    
    /**
     * The toLong method, converts value and returns a Long Object.
     * @access public
     * @return Long
     */
    public function toLong()
    {
        if ($this->intValue($this->value) < Long::MinValue or $this->intValue($this->value) > Long::MaxValue) {
            throw new ClassCastException('Cannot convert to Long type.');
        }
        return new Long($this->value);
    }
    
    /**
     * The verify method, validates the supplied argument to see if a Float object can be instantiated.
     * @param Number  $num
     * @access public
     * @return Boolean
     */
    public function verify($num)
    {
        if ($num > $this->getMax()) {
            throw new Exception('Supplied value cannot be greater than 3.4*10e+38 for Float type.');
        } elseif ($num < $this->getMin()) {
            throw new Exception('Supplied value cannot be smaller than -3.4*10e+38 for Float type.');
        } elseif ($this->getExp($num) < self::MinExp) {
            throw new Exception('Supplied value with exponent cannot be less than 1.4*10e-45 for Float type.');
        } else {
            return true;
        }
    }
}
