<?php

/**
 * The Abstract ButtonComponent Class, extends from abstract InputComponent class.
 * It is parent to all Button type GUI Components, but cannot be instantiated itself.
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
 
abstract class ButtonComponent extends InputComponent{
    
	/**
	 * The text property, specifies the text of this button.
	 * @access protected
	 * @var String
    */
	protected $text;
	
	/**
     * Constructor of ButtonComponent Class, which performs basic operations for all button types.
     * @access public
     * @return Void
     */
	public function __construct($text = "", $name = "", $value = "", $event = ""){
	    parent::__construct($name, $value, $event);
	    if(!empty($text)) $this->setText($text);
		$this->renderer = new ButtonRenderer($this);
	}
	
	/**
     * The setValue method, setter method for property $value.
	 * It overwrite parent setValue method by adding an attribute 'value' to render list.
	 * @param String  $value       
     * @access public
     * @return Void
     */
	public function setValue($value){
	    parent::setValue($value);
		$this->setAttributes("Value");
	}
	
	/**
     * The getText method, getter method for property $text.    
     * @access public
     * @return String
     */
	public function getText(){
	    return $this->text;    
	}
	
	/**
     * The setText method, setter method for property $text.
	 * @param String  $text    
     * @access public
     * @return Void
     */
	public function setText($text){
	    $this->text = $text;
	}
	
	/**
     * The render method for ButtonComponent class, it renders button data fields into HTML readable format.
     * @access public
     * @return String
     */	
	public function render(){
	    if($this->renderer->getStatus() == "ready"){
		    $this->renderer->start();   
		    parent::render()->renderText();
		    if($this instanceof Button) $this->renderer->renderImage()->end();
		}	
		return $this->renderer->getRender();
	}
	
	/**
     * Magic method __toString for ButtonComponent class, it reveals that the object is a button.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia ButtonComponent class.");
	}
}
?>