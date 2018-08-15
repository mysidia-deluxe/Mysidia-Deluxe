<?php

/**
 * The Abstract InputComponent Class, extends from abstract GUIComponent class.
 * It is parent to all GUI Input type GUI components, but cannot be instantiated itself.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 * @abstract
 *
 */
 
abstract class InputComponent extends GUIComponent{
	
	/**
	 * The value property, specifies the value of this input component.
	 * @access protected
	 * @var String
    */
	protected $value;
	
	/**
	 * The autofocus property, checks if the input component is autofocused.
	 * @access protected
	 * @var Boolean
    */
	protected $autofocus = FALSE;
	
	/**
	 * The disabled property, checks if the input component is disabled.
	 * @access protected
	 * @var Boolean
    */
	protected $disabled = FALSE;
	
	/**
     * Constructor of InputComponent Class, which performs basic operations for all input types.
     * @access public
     * @return Void
     */
	public function __construct($name = "", $value = "", $event = ""){
		if(!empty($name)){
		    $this->setName($name);
			$this->setID($name);
		}	
		if(!empty($value) or $value == 0) $this->setValue($value);
		if(!empty($event)) $this->setEvent($event);
	}
	
	/**
     * The getValue method, getter method for property $value.    
     * @access public
     * @return String
     */
	public function getValue(){
	    return $this->value;    
	}

	/**
     * The setValue method, setter method for property $value.
	 * @param String  $value       
     * @access public
     * @return Void
     */
	public function setValue($value){
	    $this->value = $value;
	}
	
	/**
     * The isAutofocus method, getter method for property $autofocus.    
     * @access public
     * @return Boolean
     */
	public function isAutofocus(){
	    return $this->autofocus;    
	}

	/**
     * The setAutofocus method, setter method for property $autofocus.
	 * @param Boolean  $autofocus      
     * @access public
     * @return Void
     */
	public function setAutofocus($autofocus = TRUE){
	    $this->autofocus = $autofocus;
		$this->setAttributes("Autofocus");
	}	
	
	/**
     * The isDisabled method, getter method for property $disabled.    
     * @access public
     * @return Boolean
     */
	public function isDisabled(){
	    return $this->disabled;    
	}

	/**
     * The setDisabled method, setter method for property $disabled.
	 * @param Boolean  $disabled       
     * @access public
     * @return Void
     */
	public function setDisabled($disabled = TRUE){
	    $this->disabled = $disabled;
		$this->setAttributes("Disabled");
	}	
	
	/**
     * Magic method __toString for InputComponent class, it reveals that the class belong to GUI package.
     * @access public
     * @return String
     */
    public function __toString(){
	    return "This is the InputComponent Class.";
	}
}
?>