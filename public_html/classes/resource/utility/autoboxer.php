<?php

namespace Resource\Utility;

use Resource\Native;

/**
 * The Autoboxer Class, it is part of the utility package and extends from the Object Class.
 * Since PHP does not provide AutoBoxing, this class serves as this function to box and unbox variables.
 * @category Resource
 * @package Utility
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not sure, but will come in handy.
 * @final
 */

final class Autoboxer extends Native\Object
{

    /**
     * The var property, it stores the last supplied variable for autoboxing/autounboxing.
     * @access private
     * @var Mixed
    */
    private $var = null;

    /**
     * The getVar method, getter method for property $var.
     * @access public
     * @return Mixed
     */
    public function getVar()
    {
        return $this->var;
    }
    
    /**
     * The setVar method, setter method for property $var.
     * @param Mixed  $var
     * @access public
     * @return Void
     */
    public function setVar($var)
    {
        $this->var = $var;
    }

    /**
     * The unwrap method, returns the primitive type value from its wrapper object.
     * @param Objective  $object.
     * @access public
     * @return Mixed
     */
    public function unwrap(Native\Objective $object)
    {
        $this->var = $object;
        return $this->var->getValue();
    }
    
    /**
     * The wrap method, wraps a primitive type into its corresponding objects.
     * @param Mixed
     * @access public
     * @return Object
     */
    public function wrap($var = null)
    {
        $this->var = $var;
        $type = gettype($var);
        $method = "wrap".ucfirst($type);
        return $this->$method();
    }

    public function wrapArray()
    {
        $size = count($this->var);
        $array = new Native\Arrays($size);
        for ($i = 0; $i < $size; $i++) {
            $array[$i] = $this->var[$i];
        }
        return $array;
    }
    
    /**
     * The wrapBoolean method, wraps a boolean value into its wrapper object.
     * @access private
     * @return Boolean
     */
    private function wrapBoolean()
    {
        return new Native\Boolean($this->var);
    }
    
    /**
     * The wrapDouble method, wraps an double value into its wrapper object.
     * @access private
     * @return Double
     */
    private function wrapDouble()
    {
        return new Native\Double($this->var);
    }
    
    /**
     * The wrapInteger method, wraps an integer value into its wrapper object.
     * @access private
     * @return Integer
     */
    private function wrapInteger()
    {
        return new Native\Integer($this->var);
    }
    
    /**
     * The wrapNULL method, wraps a null value into its wrapper object.
     * @access private
     * @return Null
     */
    private function wrapNULL()
    {
        return new Native\Mynull($this->var);
    }
    
    /**
     * The wrapString method, wraps a string value into its wrapper object.
     * @access private
     * @return String
     */
    private function wrapString()
    {
        return new Native\Mystring($this->var);
    }
}
