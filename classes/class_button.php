<?php

/**
 * The Button Class, extends from abstract ButtonComponent class.
 * It defines a standard clickable button in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Button extends ButtonComponent{

    /**
	 * The type property, specifies the type of this button.
	 * @access protected
	 * @var String
    */
	protected $type;
	
	/**
	 * The types property, defines allowed types for button object.
	 * @access protected
	 * @var Array
    */
	protected $types = array("button", "submit", "reset");
	
	/**
	 * The image property, specifies the image on this button.
	 * @access protected
	 * @var Image
    */
	protected $image;
	
    /**
     * Constructor of Button Class, which assigns basic button properties.
     * @access public
     * @return Void
     */
	public function __construct($text = "", $name = "", $value = "", $type = "submit", $event = ""){
	    parent::__construct($text, $name, $value, $event);
		$this->setType($type); 
	}
	
	/**
     * The getType method, getter method for property $type.    
     * @access public
     * @return String
     */	
	public function getType(){
	    return $this->type;
	}
	
	/**
     * The setType method, setter method for property $type.
	 * @param String  $type  
     * @access public
     * @return Void
     */
	public function setType($type){
		if(!in_array($type, $this->types)) throw new GUIException("The button type is invalid...");
		$this->type = $type;
		$this->setAttributes("Type");
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
	 * @param Image  $image  
     * @access public
     * @return Void
     */
	public function setImage(Image $image){
		$this->image = $image;
	}

	/**
     * Magic method __toString for Button class, it reveals that the object is a button.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Button class.");
	}    
}
    
?>