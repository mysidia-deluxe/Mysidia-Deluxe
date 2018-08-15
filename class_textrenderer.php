<?php

/**
 * The TextRenderer Class, extends from abstract GUIRenderer class.
 * It is responsible for rendering text type GUI Components.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class TextRenderer extends GUIRenderer{
	
	/**
     * Constructor of TextRenderer Class, assigns the text reference and determines its tag.
     * @access public
     * @return Void
     */
	public function __construct(TextComponent $text){
        parent::__construct($text);
		if($text instanceof TextArea) $this->tag = "textarea";
		else $this->tag = "input";
    } 
	
	/**
     * The renderMaxLength method, renders the maxlength property of a TextComponent Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderMaxLength(){
	    $this->setRender(" maxlength='{$this->component->getMaxLength()}'");
        return $this;		
	}  
	
	
	/**
     * The renderSize method, renders the size property of a TextField Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderSize(){
	    $this->setRender(" size='{$this->component->getSize()}'");
        return $this;		
	}

	/**
     * The renderReadOnly method, renders the readOnly property of a TextComponent Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderReadOnly(){
	    $this->setRender(" readonly='readonly'");
        return $this;		
	}  
		
	/**
     * The renderAutoComplete method, renders the autocomplete property of a TextField Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderAutoComplete(){
	    if(!$this->component->isAutocomplete()) $this->setRender(" autocomplete='off'");
        return $this;		
	}

 	/**
     * The renderRows method, renders the height of a TextArea Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderRows(){
	    $this->setRender(" rows='{$this->component->getRows()}'");
        return $this;		
	}  	
	
	/**
     * The renderCols method, renders the width of a TextArea Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderCols(){
	    $this->setRender(" cols='{$this->component->getCols()}'");
        return $this;		
	}
	
	/**
     * The renderWrapped method, renders the wrapped property of a TextArea Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderWrapped(){
	    $this->setRender(" wrap='hard'");
        return $this;		
	}
	
	/**
     * The renderAccept method, renders the accept property of a FileField Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderAccept(){
		if($this->component->getAccept()) $this->setRender(" accept='{$this->component->getAccept()}/*'>");
		else $this->setRender(">");
        return $this;		
	}

	/**
     * The renderValue method, renders the value of a TextComponent Object.    
     * @access public
     * @return TextRenderer
     */	
	public function renderValue(){
        if($this->component instanceof TextArea) $this->setRender(">{$this->component->getValue()} ");
		elseif(!is_null($this->component->getValue())) $this->setRender(" value='{$this->component->getValue()}'>");
		else $this->setRender(">");
        return $this;		
	}

    /**
     * The end method for TextRenderer class, ends the rendering process.
     * It makes sure that only textarea gets its end tag.
     * @access public
     * @return Void
     */	
	public function end(){
	    if($this->tag == "textarea") $this->setRender("</{$this->tag}>");
		$this->status = "ended";
	}
}
    
?>