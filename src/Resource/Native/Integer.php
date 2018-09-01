<?php

namespace Resource\Native;

use Exception;
use Resource\Exception\ClassCastException;

/**
 * The Integer Class, extending from the abstract Number class.
 * This class serves as a wrapper class for primitive data type int.
 * It is a final class, no child class shall derive from Integer.
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

final class Integer extends Number
{
  
    /**
     * Size constant, specifies the size an integer value occupies.
    */
    const Size = 32;
    
    /**
     * MinValue constant, an integer cannot contain number less than -2147483648.
    */
    const MinValue = -2147483648;
    
    /**
     * MaxValue constant, an integer cannot contain number greater than 2147483647.
    */
    const MaxValue = 2147483647;
   
   
    /**
     * Constructor of Integer Class, initializes the Integer wrapper class.
     * If supplied argument is not an integer, it will be converted to int primitive type.
     * @param Number  $num
     * @access public
     * @return Void
     */
    public function __construct($num)
    {
        if (!is_int($num)) {
            $num = (int)$num;
        }
        parent::__construct($num);
        $this->value = $num;
    }

    /**
     * The binaryString method, converts numeric values to binary strings.
     * @access public
     * @return String
     */
    public function binaryString()
    {
        return new String(decbin($this->value));
    }

    /**
     * The downto method, iterates the given block from this value n to the lower limit.
     * @param Int  $limit
     * @param Mixed  $block
     * @access public
     * @return Void
     */
    public function downto($limit, $block)
    {
        for ($i = $this->value; $i >= $limit; $i--) {
            call_user_func($block);
        }
    }

    /**
     * The hexString method, converts numeric values to hex strings.
     * @access public
     * @return String
     */
    public function hexString()
    {
        return new String(dechex($this->value));
    }
    
    /**
     * The octalString method, converts numeric values to octal strings.
     * @access public
     * @return String
     */
    public function octalString()
    {
        return new String(decoct($this->value));
    }

    /**
     * The times method, iterates the given block in n times, passing in values from zero to n - 1.
     * @param Mixed  $block
     * @access public
     * @return Void
     */
    public function times($block)
    {
        $num = abs($this->value);
        for ($i = 0; $i < $num; $i++) {
            call_user_func($block);
        }
    }
    
    /**
     * The toByte method, converts value and returns a Byte Object.
     * @access public
     * @return Byte
     */
    public function toByte()
    {
        if ($this->value < Byte::MinValue or $this->value > Byte::MaxValue) {
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
        if ($this->value < Short::MinValue or $this->value > Short::MaxValue) {
            throw new ClassCastException('Cannot convert to Short type.');
        }
        return new Short($this->value);
    }

    /**
     * The upto method, iterates the given block from this value n to the upper limit.
     * @param Int  $limit
     * @param Mixed  $block
     * @access public
     * @return Void
     */
    public function upto($limit, $block)
    {
        for ($i = $this->value; $i <= $limit; $i++) {
            call_user_func($block);
        }
    }
    
    /**
     * The verify method, validates the supplied argument to see if an Integer object can be instantiated.
     * @param Number  $num
     * @access public
     * @return Boolean
     */
    public function verify($num)
    {
        if ($num > self::MaxValue) {
            throw new Exception('Supplied value cannot be greater than 2147483647 for Int type.');
        } elseif ($num < self::MinValue) {
            throw new Exception('Supplied value cannot be smaller than -2147483648 for Int type.');
        } else {
            return true;
        }
    }
}
