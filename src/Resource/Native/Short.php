<?php

namespace Resource\Native;

use Exception;
use Resource\Exception\ClassCastException;

/**
 * The Short Class, extending from the abstract Number class.
 * This class serves as a wrapper class for primitive data type short.
 * It is a final class, no child class shall derive from Short.
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

final class Short extends Number
{
  
    /**
     * Size constant, specifies the size a short value occupies.
    */
    const Size = 16;
    
    /**
     * MinValue constant, a Short cannot contain number less than -32768.
    */
    const MinValue = -32768;
    
    /**
     * MaxValue constant, a Short cannot contain number greater than 32767.
    */
    const MaxValue = 32767;
    
    /**
     * Constructor of Short Class, initializes the Short wrapper class.
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
     * The octalString method, converts numeric values to octal strings.
     * @access public
     * @return String
     */
    public function octalString()
    {
        return new String(decoct($this->value));
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
     * The verify method, validates the supplied argument to see if a Short object can be instantiated.
     * @param Number  $num
     * @access public
     * @return Boolean
     */
    public function verify($num)
    {
        if ($num > self::MaxValue) {
            throw new Exception('Supplied value cannot be greater than 32767 for Short type.');
        } elseif ($num < self::MinValue) {
            throw new Exception('Supplied value cannot be smaller than -32768 for Short type.');
        } else {
            return true;
        }
    }
}
