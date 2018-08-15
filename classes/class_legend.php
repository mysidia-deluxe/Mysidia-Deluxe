<?php

/**
 * The Legend Class, extends from abstract GUIAccessory class.
 * It defines a standard Lagend Element to be used in a GUIContainer.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Legend extends GUIAccessory{

    /**
	 * The text property, contains the text of this label.
	 * @access protected
	 * @var String
    */
	protected $text;
	
    /**
     * Constructor of Legend Class, which assigns basic properties.
     * @access public
     * @return Void
     */
	public function __construct($text = "", $id = ""){
	    parent::__construct($id);
	    if(!empty($text)) $this->setText($text);
        $this->containers = array("Fieldset");        
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
     * The render method for Legend class, it renders option data field into html readable format.
	 * Similar to Label object, it does not call parent render method since it has only one attribute and no css.
     * @access public
     * @return Void
     */
    public function render(){
	    if($this->renderer->getStatus() == "ready"){
		    $this->renderer->start()
			     ->renderText()->end();
		}
		return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Lagend class, it reveals that the object is a legend.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia Legend class.");
	}    
} 
?>