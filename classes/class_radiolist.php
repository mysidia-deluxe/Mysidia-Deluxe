<?php

/**
 * The RadioList Class, extends from abstract GuiContainer class.
 * It specifies a radio button list in which only one button can be selected.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class RadioList extends GUIContainer{
	
    /**
     * Constructor of RadioList Class, which assigns basic property to this list
	 * @param String  $name
	 * @param ArrayList  $components
	 * @param String  $identity
     * @access public
     * @return Void
     */
	public function __construct($name = "", $components = "", $identity = ""){
	    if(!empty($name)){
		    $this->name = $name;
			$this->id = $name;
		}
        parent::__construct($components);
		if(!empty($identity)) $this->check($identity);
        $this->renderer = new ListRenderer($this);		
	}

	/**
     * The add method, sets a RadioButton Object to a specific index.
	 * @param RadioButton $radio
     * @param int  $index	 
     * @access public
     * @return Void
     */	
	public function add(GUIComponent $radio, $index = -1){
        if($radio->getName() != $this->name) throw new GUIException("Cannot add unrelated radiobuttons to a RadioList.");
	    parent::add($radio, $index);			
	}
	
	/**
     * The check method, determines which radio button in this group should be set checked.
	 * @param String  $identity   
     * @access public
     * @return Void
     */
	public function check($identity){
	    foreach($this->components as $components){
		    if($components->getValue() == $identity) $components->setChecked(TRUE);
		}		
	}

	/**
     * Magic method __toString for RadioList class, it reveals that the object is a radiolist.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia RadioList class.");
	}    
}   
?>