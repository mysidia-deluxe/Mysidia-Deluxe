<?php

/**
 * The Cloneable Interface, it defines objects that can be cloned.
 * It is important for objects that have special clone operations.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not much at this point.
 *
 */
 
interface Cloneable{

    /**
     * Magic method __clone() for Object Class, returns a copy of Object with additional operations.
     * @access public
     * @return Object
     */
	public function __clone();

}
?>