<?php

namespace Resource\Native;

/**
 * The Objective Interface, it is the interface that all Mysidia classes should implement minus a few special cases.
 * It defines a standard interface for Mysidia Objects, the root class Object also implements this interface.
 * This interface is very useful for classes that extend from PHP's built-in classes, as they cannot extend from root Object Class.
 * By Implementing Objective interface, objects of the specific class can be used in Collections Framework.
 * @category Resource
 * @package Native
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
interface Objective
{

    /**
     * The equals method, checks whether target object is equivalent to this one.
     * @param Objective  $object
     * @access public
     * @return Boolean
     */
    public function equals(Objective $object);
    
    /**
     * The getClassName method, returns class name of an instance.
     * The return value may differ depending on child classes.
     * @access public
     * @return String
     */
    public function getClassName();
    
    /**
     * Magic method to_String() for Object class, returns object information.
     * @access public
     * @return String
     */
    public function __toString();
}
