<?php

/**
 * The SelectionList Class, extends from the DropdownList class.
 * It specifies a single or multiple selection list.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class SelectionList extends DropdownList{

	/**
	 * The size property, determines how many options are viewable in SelectList at the same time.
	 * @access protected
	 * @var Int
    */
	protected $size;
	
	/**
	 * The multiple property, specifies if the selection list allows multiple choices.
	 * @access protected
	 * @var Boolean
    */
	protected $multiple = FALSE;
	
    /**
     * Constructor of SelectList Class, which assigns basic property to this list
     * @access public
     * @return Void
     */
	public function __construct($name = "", $multiple = FALSE, $components = "", $identity = "", $event = ""){
		parent::__construct($name, $components, $identity, $event);
        if($multiple) $this->setMultiple(TRUE);
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
	    if(!is_numeric($size)) throw new GUIException("The specified size is not numeric!");
	    $this->size = $size;
		$this->setAttributes("Size");
	}
	
	/**
     * The isMultiple method, getter method for property $multiple.    
     * @access public
     * @return Boolean
     */
	public function isMultiple(){
	    return $this->multiple;    
	}

	/**
     * The setMultiple method, setter method for property $multiple.
	 * @param Boolean  $multiple      
     * @access public
     * @return Void
     */
	public function setMultiple($multiple){
	    $this->multiple = $multiple;
		$this->setAttributes("Multiple");
	}

	/**
     * Magic method __toString for SelectionList class, it reveals that the object is a selection list.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia SelectionList class.");
	}    
}
    
?>