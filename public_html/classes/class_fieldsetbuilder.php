<?php

/**
 * The FieldSetBuilder Class, extends from FieldSet class.
 * It provides shortcut for building fieldsets in quick manner.
 * It is usually working with fieldsets inside a form.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class FieldSetBuilder extends Fieldset{

	/**
	 * The Helper property, determines the helper class used to process fieldset content.
	 * @access protected
	 * @var FormHelper
    */
	protected $helper;	

    /**
     * Constructor of FieldSetBuilder Class, which assigns basic property to the fieldset
	 * @param String  $legend
     * @access public
     * @return Void
     */
	public function __construct($legend = ""){
		parent::__construct("", new Legend($legend));
	}
	
	/**
     * The getHelper method, getter method for property $helper.    
     * @access public
     * @return FormHelper
     */
	public function getHelper(){
	    return $this->helper;    
	}

	/**
     * The setHelper method, setter method for property $helper.
	 * @param FormHelper  $helper   
     * @access public
     * @return Void
     */
	public function setHelper(FormHelper $helper){
	    $this->helper = $helper;
	}

	/**
     * The buildButton method, build a Button object to the FieldSet.
	 * @param String  $text
	 * @param String  $name
     * @param String  $value
     * @param String  $type 
     * @access public
     * @return FieldSetBuilder
     */
	public function buildButton($text, $name, $value = "", $type = "submit"){
	    $this->add(new Button($text, $name, $value, $type));
		return $this;
	}
	
	/**
     * The buildDropdownList method, build a DropdownList object to the FieldSet.
	 * @param String  $name
     * @param String  $type
     * @param String  $identity	 
     * @access public
     * @return FieldSetBuilder
     */
	public function buildDropdownList($name, $type, $identity = ""){
	    if(!$this->helper) $this->helper = new FormHelper;
		$method = "build{$type}";
	    $dropdownList = $this->helper->$method($name);
		if(!empty($identity)) $dropdownList->select($identity);
	    $this->add($dropdownList);
        return $this;		
	}
		
	/**
     * The buildComment method, build a Comment object to the FieldSet.
	 * @param String  $text
     * @param Boolean  $linebreak	 
     * @access public
     * @return FieldSetBuilder
     */
	public function buildComment($text, $linebreak = TRUE){
	    $this->add(new Comment($text, $linebreak));
		return $this;
	}
	
	/**
     * Magic method __toString for FormBuilder class, it reveals that the class is a Form Builder.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is The FieldSetBuilder class.");
	}
}
?>