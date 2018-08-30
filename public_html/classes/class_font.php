<?php

/**
 * The Font Class, extends from abstract GUIElement class.
 * It defines a standard font element to be used in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Font extends GUIElement{

    /**
	 * The size property, speficies the font size.
	 * @access protected
	 * @var Int
    */
	protected $size;

    /**
	 * The family property, stores the font family.
	 * @access protected
	 * @var String
    */
	protected $family;
	
	/**
	 * The variant property, defines the font variant.
	 * @access protected
	 * @var String
    */
	protected $variant;
	
	/**
	 * The weight property, determines the font weight.
	 * @access protected
	 * @var String
    */
	protected $weight;
	
    /**
     * Constructor of Font Class, which assigns basic font properties.
	 * @param Int  $size
     * @param String  $family
     * @param String  $variant
     * @param String  $id
     * @param String  $event	 
     * @access public
     * @return Void
     */
	public function __construct($size = "", $family = ""){
	    parent::__construct();	
		if(!empty($size)) $this->setSize($size);
        if(!empty($family)) $this->setFamily($family);	
	}
	
	/**
     * The getSize method, getter method for property $size.    
     * @access public
     * @return Int
     */
	public function getSize(){
	    return $this->size;    
	}
	
	/**
     * The setSize method, setter method for property $size.
	 * @param Int  $size  
     * @access public
     * @return Void
     */
	public function setSize($size){
	    if(!is_numeric($size)) throw new GUIException("The specified font size is not numeric!");
	    $this->size = $size;
		$this->setAttributes("Size");
	}
	
	/**
     * The getFamily method, getter method for property $family.    
     * @access public
     * @return String
     */
	public function getFamily(){
	    return $this->family;    
	}

	/**
     * The setFamily method, setter method for property $family.
	 * @param String  $family   
     * @access public
     * @return Void
     */
	public function setFamily($family){
	    $this->family = $family;
		$this->setAttributes("Family");
	}
	
	/**
     * The getVariant method, getter method for property $variant.    
     * @access public
     * @return String
     */
	public function getVariant(){
	    return $this->variant;    
	}

	/**
     * The setVariant method, setter method for property $variant.
	 * @param String  $variant   
     * @access public
     * @return Void
     */
	public function setVariant($variant){
	    $variants = array("normal", "small-caps", "inherit");
		if(!in_array($variant, $variants)) throw new GUIException("The specified font variant property is invalid.");
	    $this->variant = $variant;
		$this->setAttributes("Variant");
	}

	/**
     * The getWeight method, getter method for property $weight.    
     * @access public
     * @return String
     */
	public function getWeight(){
	    return $this->weight;    
	}

	/**
     * The setWeight method, setter method for property $weight.
	 * @param String  $weight   
     * @access public
     * @return Void
     */
	public function setWeight($weight){
	    $weights = array("normal", "bold", "bolder");
		if(!in_array($weight, $weights) and !is_numeric($weight)) throw new GUIException("The specified font weight property is invalid.");
	    $this->weight = $weight;
		$this->setAttributes("Weight");
	}

	/**
     * Magic method __toString for Font class, it reveals that the object is a font.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Font class.");
	}    
} 
?>