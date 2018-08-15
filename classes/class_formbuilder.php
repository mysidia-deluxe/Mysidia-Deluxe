<?php

use Resource\Collection\ArrayList;

/**
 * The FormBuilder Class, extends from the Form class.
 * It provides shortcut for building forms in quick manner.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class FormBuilder extends Form{

	/**
	 * The Helper property, determines the helper class used to process form content.
	 * @access protected
	 * @var FormHelper
    */
	protected $helper;	

	/**
     * Constructor of Form Class, sets up basic form properties.   
	 * @param String  $name
	 * @param String  $action
	 * @param String  $method
	 * @param String  $event
	 * @param ArrayList  $components
     * @access publc
     * @return Void
     */
	public function __construct($name = "", $action = "", $method = "", $event = "", $components = ""){
        parent::__construct($name, $action, $method, $event, $components); 			
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
     * The buildTextField method, build a TextField object to the Form.
	 * @param String  $name
     * @param String  $value	 
     * @access public
     * @return FormBuilder
     */
	public function buildTextField($name, $value = ""){
	    $this->add(new TextField($name, $value));
		return $this;
	}
	
	/**
     * The buildPasswordField method, build a PasswordField object to the Form.
	 * @param String  $type
	 * @param String  $name
     * @param String  $value
     * @param Boolean  $lineBreak	 
     * @access public
     * @return FormBuilder
     */
	public function buildPasswordField($type, $name, $value = "", $lineBreak = FALSE){
	    $this->add(new PasswordField($type, $name, $value, $lineBreak));
		return $this;
	}
	
	/**
     * The buildTextArea method, build a TextArea object to the Form.
	 * @param String  $name
     * @param String  $value
     * @param Int  $rows
     * @param Int  $cols	 
     * @access public
     * @return FormBuilder
     */
	public function buildTextArea($name, $value = "", $rows = 4, $cols = 45){
	    $this->add(new TextArea($name, $value, $rows, $cols));
		return $this;
	}

	/**
     * The buildButton method, build a Button object to the Form.
	 * @param String  $text
	 * @param String  $name
     * @param String  $value
     * @param String  $type 
     * @access public
     * @return FormBuilder
     */
	public function buildButton($text, $name, $value = "", $type = "submit"){
	    $this->add(new Button($text, $name, $value, $type));
		return $this;
	}
	
	/**
     * The buildCheckBox method, build a CheckBox object to the Form.
	 * @param String  $text
	 * @param String  $name
     * @param String  $value
     * @param String  $identity	 
     * @access public
     * @return FormBuilder
     */
	public function buildCheckBox($text, $name, $value = "", $identity = ""){
	    $this->add(new CheckBox($text, $name, $value, $identity));
		return $this;
	}
		
	/**
     * The buildRadioList method, build a RadioList object to the Form.
	 * @param String  $name
     * @param LinkedHashMap  $RadioMap
     * @param String  $identity	 
     * @access public
     * @return FormBuilder
     */
	public function buildRadioList($name, $radioMap, $identity = ""){
	    $radioButtons = new ArrayList;
		$iterator = $radioMap->iterator();
		while($iterator->hasNext()){
		    $radio = $iterator->next();
			$radioButtons->add(new RadioButton($radio->getKey(), $name, $radio->getValue()));
		}
	    $this->add(new RadioList($name, $radioButtons, $identity));
        return $this;		
	}
	
	/**
     * The buildDropdownList method, build a DropdownList object to the Form.
	 * @param String  $name
     * @param String  $type
     * @param String  $identity	 
     * @access public
     * @return FormBuilder
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
     * The buildComment method, build a Comment object to the Form.
	 * @param String  $text
     * @param Boolean  $linebreak	 
     * @access public
     * @return FormBuilder
     */
	public function buildComment($text, $linebreak = TRUE){
	    $this->add(new Comment($text, $linebreak));
		return $this;
	}
	
	/**
     * The buildParagraph method, build a Paragraph object to the Form.
	 * @param String|Comment  $comment
     * @param String $name	 
     * @access public
     * @return FormBuilder
     */
	public function buildParagraph($comment, $name = ""){
	    if(!($comment instanceof Comment)) $comment = new Comment($comment);
	    $this->add(new Paragraph($comment, $name));
		return $this;
	}
	
	/**
     * Magic method __toString for FormBuilder class, it reveals that the class is a Form Builder.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is The FormBuilder class.");
	}
}
?>