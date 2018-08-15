<?php

/**
 * The Dimension Class, extends from abstract GUIElement class.
 * It defines a standard dimension element used mostly in a division block.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Dimension extends GUIElement{

	/**
	 * The width property, determines the width of the division block.
	 * @access protected
	 * @var String
    */
	protected $width;
	
	/**
	 * The height property, defines the height of the division block.
	 * @access protected
	 * @var String
    */
	protected $height;
	
    /**
     * Constructor of Dimension Class, which assigns width and/or height properties.
	 * @param Int  $count
     * @param String  $width
     * @param Array  $rule 
     * @access public
     * @return Void
     */
	public function __construct($width = "", $height = ""){	
	    parent::__construct();
		if(!empty($width)) $this->setWidth($width);	 
        if(!empty($height)) $this->setHeight($height);		
	}
	
	/**
     * The getWidth method, getter method for property $width.    
     * @access public
     * @return String
     */
	public function getWidth(){
	    return $this->width;
	}
	
	/**
     * The setWidth method, setter method for property $width.
	 * @param String  $width     
     * @access public
     * @return Void
     */
	public function setWidth($width){
	    $this->width = $width;
		$this->setAttributes("Width");
	}
	
	/**
     * The getHeight method, getter method for property $height.    
     * @access public
     * @return String
     */
	public function getHeight(){
	    return $this->height;
	}
	
	/**
     * The setHeight method, setter method for property $height.
	 * @param String  $height  
     * @access public
     * @return Void
     */
	public function setHeight($height){
	    $this->height = $height;
		$this->setAttributes("Height");
	}
	
	/**
     * Magic method __toString for Dimension class, it reveals that the object is a dimension.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia Dimension class.");
	}    
} 
?>