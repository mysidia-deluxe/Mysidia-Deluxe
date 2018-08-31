<?php

namespace Resource\Native;
use Exception;

/**
 * The Byte Class, extending from the abstract Number class.
 * This class serves as a wrapper class for primitive data type byte.
 * It is a final class, no child class shall derive from Byte.
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

final class Byte extends Number{

	/**
	 * Size constant, specifies the size a byte value occupies.
    */
    const Size = 8;
	
	/**
	 * MinValue constant, a byte cannot contain number less than -128.
    */
    const MinValue = -128;
	
	/**
	 * MaxValue constant, a byte cannot contain number greater than 127.
    */
    const MaxValue = 127;
   
    /**
     * Constructor of Byte Class, initializes the Byte wrapper class.
	 * If supplied argument is not an integer, it will be converted to int primitive type.
	 * @param Number  $num
     * @access public
     * @return Void
     */
    public function __construct($num){
	    if(!is_int($num)) $num = (int)$num;
	    parent::__construct($num);		
        $this->value = $num;
    }

 	/**
     * The binaryString method, converts numeric values to binary strings.
     * @access public
     * @return String
     */
	public function binaryString(){
        return new String(decbin($this->value));	
	}	
	
	/**
     * The verify method, validates the supplied argument to see if a Byte object can be instantiated.
	 * @param Number  $num
     * @access public
     * @return Boolean
     */
	public function verify($num){
	    if($num > self::MaxValue) throw new Exception('Supplied value cannot be greater than 127 for Byte type.');
 		elseif($num < self::MinValue) throw new Exception('Supplied value cannot be smaller than -128 for Byte type.');
		else return TRUE;
	}
}
?>