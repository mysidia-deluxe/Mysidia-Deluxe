<?php

/**
 * The Abstract TextComponent Class, extends from abstract InputComponent class.
 * It is parent to all GUI Text type GUI components, but cannot be instantiated itself.
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
 
abstract class TextComponent extends InputComponent{
	
	/**
	 * The maxlength property, specifies the max length allowed for this text component.
	 * @access protected
	 * @var Int
    */
	protected $maxLength;
	
	/**
	 * The readonly property, specifies if the text component is read only.
	 * @access protected
	 * @var Boolean
    */
	protected $readOnly = FALSE;
	
	/**
     * Constructor of TextComponent Class, which performs basic operations for all text types.
     * @access public
     * @return Void
     */
	public function __construct($name = "", $value = "", $event = ""){
	    parent::__construct($name, $value, $event);		
		$this->renderer = new TextRenderer($this);
	}
	
	/**
     * The getMaxLength method, getter method for property $maxLength.    
     * @access public
     * @return String
     */
	public function getMaxLength(){
	    return $this->maxLength;    
	}
	
	/**
     * The setMaxLength method, setter method for property $maxLength.
	 * @param Int  $length    
     * @access public
     * @return Void
     */
	public function setMaxLength($length){
	    if(!is_numeric($length)) throw new GUIException("The supplied max length value is not numeric!");
	    $this->maxLength = $length;
		$this->setAttributes("MaxLength");
	}
	
	/**
     * The getReadOnly method, getter method for property $readOnly.    
     * @access public
     * @return Boolean
     */
	public function isReadOnly(){
	    return $this->readOnly;    
	}
	
	/**
     * The setReadOnly method, setter method for property $readOnly.
	 * @param Boolean  $readOnly   
     * @access public
     * @return Void
     */
	public function setReadOnly($readOnly){
	    $this->readOnly = $readOnly;
		$this->setAttributes("ReadOnly");
	}

	/**
     * The render method for TextComponent class, it renders text data fields into HTML readable format.
     * @access public
     * @return String
     */	
	public function render(){
	    if($this->renderer->getStatus() == "ready"){
		    $this->renderer->start();   
		    parent::render()->renderValue()->end();
		}	
		return $this->renderer->getRender();
	} 
	
	/**
     * Magic method __toString for TextComponent class, it reveals that the class belong to GUI package.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is the TextComponent Class.");
	}
}
?>