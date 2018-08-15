<?php

/**
 * The abstract Spacing Class, extends from abstract GUIElement class.
 * It defines a standard spacing element to be used in HTML, but cannot be instantiated itself.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

abstract class Spacing extends GUIElement{

    /**
	 * The direction property, defines the direction(left, right, top, bottom) of the spacing attribute.
	 * @access protected
	 * @var String
    */
	protected $direction;
	
	/**
	 * The space property, stores the space of the spacing attribute.
	 * @access protected
	 * @var Int
    */
	protected $space;
	
	/**
	 * The directions property, stores the valid spacing directions to use.
	 * @access protected
	 * @var Array
    */
	protected $directions = array("bottom", "left", "right", "top");
	
    /**
     * Constructor of Margin Class, which assigns basic spacing properties.
     * @param String  $direction
     * @param Int|String  $width 
     * @access public
     * @return Void
     */
	public function __construct($direction = "", $width = ""){
	    parent::__construct();
		if(!empty($direction)) $this->setDirection($direction);
        if(!empty($width)) $this->setWidth($width);		
	}
	
	/**
     * The getDirection method, getter method for property $direction.    
     * @access public
     * @return String
     */
	public function getDirection(){
	    return $this->direction;    
	}
	
	/**
     * The setDirection method, setter method for property $direction.
	 * @param String  $direction 
     * @access public
     * @return Void
     */
	public function setDirection($direction){
	    if(!in_array($direction, $this->directions)) throw new GUIException("The specified spacing position is invalid.");
	    $this->direction = $direction;
		$this->setAttributes("Direction");
	}
	
	/**
     * The getWidth method, getter method for property $width.    
     * @access public
     * @return Int
     */
	public function getWidth(){
	    return $this->width;    
	}

	/**
     * The setWidth method, setter method for property $width.
	 * @param Int  $width 
     * @access public
     * @return Void
     */
	public function setWidth($width){
        if(is_numeric($width)) $this->width = "{$width}px";
	    else $this->width = $width;
		$this->setAttributes("Width");
	}
	
	/**
     * The getDirections method, getter method for property $directions.    
     * @access public
     * @return Array
     */
	public function getDirections(){
	    return $this->directions;    
	}

	/**
     * Magic method __toString for Spacing class, it reveals that it is a spacing object.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia Spacing class.");
	}    
} 
?>