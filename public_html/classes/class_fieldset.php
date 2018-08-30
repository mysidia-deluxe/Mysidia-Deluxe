<?php

/**
 * The FieldSet Class, extends from the abstract GUIContainer class.
 * It specifies a standard fieldset object that defines a section.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class FieldSet extends GUIContainer{

	/**
	 * The disabled property, checks if elements in this fieldset is disabled.
	 * @access protected
	 * @var Boolean
    */
	protected $disabled = FALSE;
	
    /**
     * Constructor of FieldSet Class, which assigns basic property to this set
	 * It is possible to create a FieldSet with an ID/Name, or with a legend. 
	 * @param String|Legend  $name
	 * @param ArrayObject  $components
	 * @param String  $event
     * @access public
     * @return Void
     */
	public function __construct($name = "", $components = "", $event = ""){
		parent::__construct($components);
        if($name instanceof Legend){
            $this->setName($name->getText());
            $this->add($name);
        }
        elseif(!empty($name)) $this->setName($name);
        else $this->name = "";

		if(!empty($event)) $this->setEvent($event);
		$this->renderer = new ListRenderer($this);
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
     * Magic method __toString for FieldSet class, it reveals that the object is a fieldset.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia FieldSet class.");
	}    
}
    
?>