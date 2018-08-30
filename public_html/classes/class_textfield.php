<?php

/**
 * The TextField Class, extends from abstract TextComponent class.
 * It defines a standard editable textfield in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class TextField extends TextComponent{

    /**
	 * The autocomplete property, determines if autocmplete feature is turned on/off for this text field.
	 * @access protected
	 * @var Int
    */
	protected $autocomplete = TRUE;

    /**
	 * The size property, specifies the size of this text field.
	 * @access protected
	 * @var Int
    */
	protected $size;
	
	/**
     * Constructor of TextField Class, which assigns basic text field properties.
     * @access public
     * @return Void
     */
	public function __construct($name = "", $value = "", $length = "", $event = ""){
	    parent::__construct($name, $value, $event);
		if(is_numeric($length)) $this->setMaxLength($length);
	}
	
	/**
     * The isAutocomplete method, getter method for property $autocomplete.    
     * @access public
     * @return Boolean
     */	
	public function isAutocomplete(){
	    return $this->autocomplete;
	}
	
	/**
     * The setAutocomplete method, setter method for property $autocomplete.
	 * @param Boolean  $autocomplete  
     * @access public
     * @return Void
     */
	public function setAutocomplete($autocomplete){
	    $this->autocomplete = $autocomplete;
		$this->setAttributes("Autocomplete");
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
	 * @param Int  $autocomplete  
     * @access public
     * @return Void
     */
	public function setSize($size){
	    if(!is_numeric($size)) throw new GUIException("The supplied size is not numeric!");
	    $this->size = $size;
		$this->setAttributes("Size");
	}

	/**
     * Magic method __toString for TextField class, it reveals that the object is a text field.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia TextField class.");
	}    
}
    
?>