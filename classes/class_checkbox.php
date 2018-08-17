<?php

/**
 * The CheckBox Class, extends from abstract ButtonComponent class.
 * It defines a standard Check Box object to be used in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class CheckBox extends ButtonComponent{

    /**
	 * The type property, which is a radio button.
	 * @access protected
	 * @var String
    */
	protected $type;
	
    /**
	 * The checked property, specifies if the button is checked by default.
	 * @access protected
	 * @var Boolean
    */
	protected $checked = FALSE;
	
	/**
	 * The identifier property, determines the identifier that sets this checkbox to be checked.
	 * @access protected
	 * @var Array
    */
	protected $identifier = array("true", "yes", "enabled", "checked");
	
    /**
     * Constructor of CheckBox Class, which assigns basic checkbox properties.
     * @access public
     * @return Void
     */
	public function __construct($text = "", $name = "", $value = "", $identity = "", $event = ""){
	    parent::__construct($text, $name, $value, $event);
		if(!empty($identity)) $this->check($identity);
        $this->setType("checkbox");
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
        $this->type = $type;
		$this->setAttributes("Type");
    }
	
	/**
     * The isChecked method, getter method for property $checked.    
     * @access public
     * @return Boolean
     */	
	public function isChecked(){
	    return $this->checked;
	}
	
	/**
     * The setChecked method, setter method for property $checked.
	 * @param Boolean  $checked    
     * @access public
     * @return Void
     */
	public function setChecked($checked){
	    $this->checked = $checked;
		$this->setAttributes("Checked");
	}
	
	/**
     * The addIdentifier method, append a new identifier to the identifier list.
	 * @param String  $identifier  
     * @access public
     * @return Void
     */
	 public function addIdentifier($identifier){
	     $this->identifier[] = $identifier;   
	 }
	
	/**
     * The check method, determines if the checkbox should be checked or not based on the value supplied.
	 * @param String  $identity   
     * @access public
     * @return Void
     */
	public function check($identity = ""){
	    if(in_array($identity, $this->identifier) or $identity == $this->value) $this->setChecked(TRUE);
	}

	/**
     * Magic method __toString for CheckBox class, it reveals that the object is a checkbox.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia CheckBox class.");
	}    
} 
?>