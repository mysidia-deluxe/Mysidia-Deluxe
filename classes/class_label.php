<?php

/**
 * The Label Class, extends from abstract GUIAccessory class.
 * It defines a standard Label Element to be used in a GUIContainer.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Label extends GUIAccessory{

    /**
	 * The for property, determines what element uses this label.
	 * @access protected
	 * @var String
    */
	protected $for;
	
    /**
     * Constructor of Label Class, which assigns basic properties.
     * @access public
     * @return Void
     */
	public function __construct($for = "", $id = ""){
	    parent::__construct($id);
	    if(!empty($for)) $this->setFor($for);
        $this->containers = array("GUIContainer");        
	}
	
	/**
     * The getFor method, getter method for property $for.    
     * @access public
     * @return String
     */
	public function getFor(){
	    return $this->for;    
	}
	
	/**
     * The setFor method, setter method for property $for.
	 * @param String  $for  
     * @access public
     * @return Void
     */
	public function setFor($for){
	    $this->for = $for;
		$this->setAttributes("For");
	}

	/**
     * The render method for Label class, it renders option data fields into html readable format.
	 * It is a simple operation, thus no need to call parent render method.
     * @access public
     * @return Void
     */
	public function render(){
	    if($this->renderer->getStatus() == "ready"){
		    $this->renderer->start()
			     ->renderFor()->end();
		}
		return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Label class, it reveals that the object is a label.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Label class.");
	}    
} 
?>