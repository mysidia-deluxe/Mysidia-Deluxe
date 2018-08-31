<?php

namespace Resource\Native;

/**
 * The Primitive Interface, it is an interface that represents a primitive wrapper type.
 * By Implementing Primitive interface, objects can act like primitive type for operations.
 * @category Resource
 * @package Native
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
interface Primitive{
	
    /**
     * The getValue method, acquires the primitive data type value stored in the object.
     * @access public
     * @return String
     */	
    public function getValue();

}
?>