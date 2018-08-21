<?php

/**
 * The Borders Class, extends from standard border class.
 * It defines a collection of border properties, and add its own unique attributes
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Borders extends Border{

    /**
	 * The border property, stores an array of defined directions for this border.
	 * @access protected
	 * @var ArrayObject
    */
	protected $border;
	
	/**
	 * The image property, species if the border uses an image.
	 * @access protected
	 * @var Image
    */
	protected $image;
	
    /**
	 * The radius property, defines the radius property of the border.
	 * @access protected
	 * @var String
    */
	protected $radius;
	
    /**
     * Constructor of Border Class, which assigns basic border properties.
     * @param Border|ArrayObject  $border
     * @param Color  $color
	 * @param String  $style 
	 * @param Int|String  $width 
	 * @param Image  $image 
     * @access public
     * @return Void
     */
	public function __construct($color = "", $style = "", $width = "", $border = "", $image = ""){
        parent::__construct("", $color, $style, $width);			
		$this->border = new ArrayObject();
		if(!empty($border)) $this->setBorder($border);	
		if(!empty($image)) $this->setImage($image);
	}
	
	/**
     * The getBorder method, getter method for property $border.    
     * @access public
     * @return Border|ArrayObject
     */
	public function getBorder(){
	    return $this->border;    
	}
	
	/**
     * The setBorder method, setter method for property $border.
	 * @param Border|ArrayObject  $border  
     * @access public
     * @return Void
     */
	public function setBorder($border){
	    if($border instanceof Border) $this->border->append($border);
		elseif($border instanceof ArrayObject) $this->border = $border;
		else throw new GUIException("The specified border is invalid.");
		$this->setAttributes("Border");
	}
	
	/**
     * The getImage method, getter method for property $image.    
     * @access public
     * @return Image
     */
	public function getImage(){
	    return $this->image;    
	}

	/**
     * The setImage method, setter method for property $image.
	 * @param String  $image 
     * @access public
     * @return Void
     */
	public function setImage(Image $image){
	    $this->image = $image;
		$this->setAttributes("Image");
	}
	
	/**
     * The getRadius method, getter method for property $radius.    
     * @access public
     * @return String
     */
	public function getRadius(){
	    return $this->radius;    
	}

	/**
     * The setRadius method, setter method for property $radius.
	 * @param String  $radius
     * @access public
     * @return Void
     */
	public function setRadius($radius, $unit = "px"){
	    if(is_numeric($radius) and in_array($unit, $this->units)) $this->radius = "{$radius}{$unit}";
		else throw new GUIException("The specified radius property is invalid.");
		$this->setAttributes("Radius");
	}

	/**
     * The render method for Borders class, it renders borders data field into html readable format.
     * @access public
     * @return Void
     */
    public function render(){    
        if(!$this->renderer->getRender()){
		    $this->renderer->renderBorders()->renderImage()->renderRadius();			
			if($this->border){
			    foreach($this->border as $border) $this->renderer->setRender($border->render());
			}
		}
		return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Borders class, it reveals that it is borders object.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Borders class.");
	}    
} 
?>