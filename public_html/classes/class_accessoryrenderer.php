<?php

/**
 * The AccessoryRenderer Class, extends from abstract GUIRenderer class.
 * It is responsible for rendering accessory type GUIComponents.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class AccessoryRenderer extends GUIRenderer{
	
	/**
     * Constructor of AccessoryRenderer Class, assigns the text reference and determines its tag.
     * @access public
     * @return Void
     */
	public function __construct(GUIAccessory $accessory){
        parent::__construct($accessory);
        if($accessory instanceof Link) $this->tag = "a";
		elseif($accessory instanceof Image) $this->tag = "img";
		elseif($accessory instanceof Media) $this->tag = "object";
		else $this->tag = strtolower(get_class($accessory));
    }
	
		/**
     * The renderHref method, renders the href property of an Link Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderHref(){
	    $this->setRender(" href='{$this->component->getHref()->getURL()}'");
        return $this;		
	}
	
	/**
     * The renderRel method, renders the rel property of an Link Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderRel(){
	    $this->setRender(" rel='{$this->component->getRel()}'");
        return $this;		
	}
	
	/**
     * The renderMedia method, renders the media property of an Link Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderMedia(){
	    $this->setRender(" media='{$this->component->getMedia()}'");
        return $this;		
	}
	
	/**
     * The renderLang method, renders the lang property of an Link Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderLang(){
	    $this->setRender(" hreflang='{$this->component->getLang()}'");
        return $this;		
	}
	
	/**
     * The renderImage method, renders the image property of an Link Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderImage(){
	    $image = $this->component->getImage();
	    if($image instanceof Image) $this->setRender($image->render());
        return $this;		
	}

	/**
     * The renderList method, append a <li> tag at the beginning of the link.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderList(){        
	    $this->setRender("<li>");
        return $this;		
	}

	/**
     * The renderListed method, append a </li> tag at the beginning of the link.    
     * @access public
     * @return ElementRenderer
     */	
    public function renderListed(){
	    $this->setRender("</li>");
        return $this;
    }
	
	/**
     * The renderSrc method, renders the src property of an Image/IFrame Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderSrc(){
	    $this->setRender(" src='{$this->component->getSrc()->getURL()}'");
        return $this;		
	}
	
	/**
     * The renderAlt method, renders the alt property of an Image Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderAlt(){
	    $this->setRender(" alt='{$this->component->getAlt()}'");
        return $this;		
	}
	
	/**
     * The renderWidth method, renders the width property of an Image/IFrame Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderWidth(){
	    $this->setRender(" width='{$this->component->getWidth()}'");
        return $this;		
	}
	
	/**
     * The renderHeight method, renders the height property of an Image/IFrame Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderHeight(){
	    $this->setRender(" height='{$this->component->getHeight()}'");
        return $this;		
	}
	
	/**
     * The renderSandbox method, renders the sandbox property of an IFrame Object.    
     * @access public
     * @return ElementRenderer
     */	
	public function renderSandbox(){
	    $this->setRender(" sandbox='{$this->component->getSandbox()}'");
        return $this;		
	}

	/**
     * The renderData method, renders the data property of a media Object.    
     * @access public
     * @return ElementRenderer
     */	
    public function renderData(){
	    $this->setRender(" data='{$this->component->getData()->getHref()}'");
        return $this;	
    }	
	
	/**
     * The renderFor method, renders the for property of a Label Object.    
     * @access public
     * @return AccessoryRenderer
     */	
	public function renderFor(){
	    if($this->component->getFor()) $this->setRender(" for='{$this->component->getFor()}'>");
		else $this->setRender(">");
        return $this;		
	}
	
	/**
     * The renderLabel method, renders the label property of an Option Object.    
     * @access public
     * @return AccessoryRenderer
     */	
	public function renderLabel(){
	    $this->setRender(" label='{$this->component->getLabel()}'");
        return $this;		
	}

	/**
     * The renderValue method, renders the value of an Option Object.    
     * @access public
     * @return AccessoryRenderer
     */	
	public function renderValue(){
        $this->setRender(" value='{$this->component->getValue()}'");
        return $this;		
	}
	
	/**
     * The renderSelected method, renders the selected property of an Option Object.    
     * @access public
     * @return AccessoryRenderer
     */	
	public function renderSelected(){
	    $this->setRender(" selected='selected'");
        return $this;		
	}
}  
?>