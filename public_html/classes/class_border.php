<?php

/**
 * The Border Class, extends from abstract Spacing class.
 * It defines a standard border element to be used in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Border extends Spacing{

    /**
	 * The color property, defines the border color attribute.
	 * @access protected
	 * @var Color
    */
	protected $color;
	
	/**
	 * The style property, determines the border style attribute.
	 * @access protected
	 * @var String
    */
	protected $style;
	
	/**
	 * The styles property, stores an array of valid border styles.
	 * @access protected
	 * @var Array
    */
	protected $styles = array("none", "hidden", "dotted", "dashed", "solid", "double", "groove", "ridge", "inset", "outset", "inherit");
	
    /**
     * Constructor of Border Class, which assigns basic border properties.
     * @param String  $direction
     * @param Color  $color
	 * @param String  $style 
	 * @param Int|String  $width 	 
     * @access public
     * @return Void
     */
	public function __construct($direction = "", $color = "", $style = "", $width = ""){
        parent::__construct($direction, $width);	
		if($color instanceof Color) $this->color = $color;
        if(!empty($style)) $this->style = $this->setStyle($style);
        $this->directions = array_push($this->directions, "outline"); 		
	}
	
	/**
     * The getColor method, getter method for property $color.    
     * @access public
     * @return Color
     */
	public function getColor(){
	    return $this->color;    
	}
	
	/**
     * The setColor method, setter method for property $color.
	 * @param Color  $color  
     * @access public
     * @return Void
     */
	public function setColor(Color $color){
	    $this->color = $color;
		$this->setAttributes("Color");
	}
	
	/**
     * The getStyle method, getter method for property $style.    
     * @access public
     * @return String
     */
	public function getStyle(){
	    return $this->style;    
	}

	/**
     * The setStyle method, setter method for property $style.
	 * @param String  $style 
     * @access public
     * @return Void
     */
	public function setStyle($style){
	    if(!in_array($style, $this->styles)) throw new GUIException("The specified border style is invalid.");
	    $this->style = $style;
		$this->setAttributes("Style");
	}
	
	/**
     * The getStyles method, getter method for property $styles.    
     * @access public
     * @return String
     */
	public function getStyles(){
	    return $this->styles;    
	}

	/**
     * The render method for Border class, it renders border data field into html readable format.
     * @access public
     * @return Void
     */
    public function render(){  
        if(!$this->renderer->getRender()) $this->renderer->renderBorder();
		return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Border class, it reveals that it is a border object.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Border class.");
	}    
} 
?>