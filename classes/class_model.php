<?php

use Resource\Native\Object;
use Resource\Native\String;

/**
 * The Abstract Model Class, extends from abstract object class.
 * It is parent to all model type classes, which stores domain object properties.
 * @category Model
 * @package Model
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 * @abstract
 *
 */
 
abstract class Model extends Object{

 	/**
	 * OBJ constant, stores the fetch mode Object.
    */
    const OBJ = "object";
	
	/**
	 * MODEL constant, stores the fetch mode Model.
    */
    const MODEL = "model";
	
	/**
	 * GUI constant, stores the fetch mode GUI.
    */
    const GUI = "gui";
	
	/**
	 * INSERT constant, defines the assign mode Insert.
    */
	const INSERT = "insert";
	
	/**
	 * UPDATE constant, defines the assign mode Update.
    */
	const UPDATE = "update";
	
	/**
	 * DELETE constant, defines the assign mode Delete.
    */	
	const DELETE = "delete";
	
	/**
     * Constructor of Model Class, which simply serves as a marker for child classes.
     * @access public
     * @return Void
     */
	public function __construct(){
	
	}
	
	/**
     * Magic method __toString for Model class, it reveals that the class belong to model package.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia Model class.");
	}
	
	/**
     * Abstract method save for Model class, it must be implemented by child domain model classes.
     * @access protected
     * @abstract
     */
	protected abstract function save($field, $value);
}
?>