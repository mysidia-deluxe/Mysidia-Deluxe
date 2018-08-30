<?php

use Resource\Collection\HashSet;

/**
 * The TableRenderer Class, extends from abstract GUIRenderer class.
 * It is responsible for rendering GUI Forms.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class TableRenderer extends GUIRenderer{
	
	/**
     * Constructor of TableRenderer Class, assigns the table reference and determines its tag.
     * @access public
     * @return Void
     */
	public function __construct(TableContainer $container){
        parent::__construct($container);	
		if($container instanceof Table) $this->tag = "table";
		elseif($container instanceof TRow) $this->tag = "tr";
		elseif($container instanceof THeader) $this->tag = "th";
		elseif($container instanceof TCell) $this->tag = "td";
		elseif($container instanceof TCol){
		    if($container->isGroup()) $this->tag = "colgroup";
            else $this->tag = "col";			
		}
		else $this->tag = "";
    }
	
	/**
     * The renderBordered method, renders the bordered property of a Table Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderBordered(){
	    $this->setRender(" border='1'");
        return $this;		
	}
	
	/**
     * The renderChar method, renders the char property of a TRow Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderChar(){
	    $this->setRender(" char='{$this->component->getChar()}'");
        return $this;		
	}

	/**
     * The renderHeaders method, renders the headers property of a TCell Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderHeaders(){
        $this->setRender(" headers='{$this->component->getHeaders()}'");
        return $this;		
	}
	
	/**
     * The renderRowspan method, renders the rowspan property of a TCell Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderRowspan(){
	    $this->setRender(" rowspan='{$this->component->getRowspan()}'");
        return $this;		
	}
	
	/**
     * The renderColspan method, renders the colspan property of a TCell Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderColspan(){
	    $this->setRender(" colspan='{$this->component->getColspan()}'");
        return $this;		
	}
	
	/**
     * The renderText method, renders the text property of a TCell Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderText(){
	    if(!is_null($this->component->getText())) $this->setRender($this->component->getText());
        return $this;		
	}
	
	/**
     * The renderScope method, renders the scope property of a THeader Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderScope(){
	    $this->setRender(" scope='{$this->component->getScope()}'");
        return $this;		
	}
	
	/**
     * The renderSpan method, renders the span property of a TCol Object.    
     * @access public
     * @return TableRenderer
     */	
	public function renderSpan(){
	    $this->setRender(" span='{$this->component->getSpan()}'");
        return $this;		
	}
	
	/**
     * The renderWidth method, renders the width property of a TableContainer.    
     * @access protected
     * @return TableRenderer
     */	
	protected function renderWidth(){
	    $this->setRender(" width:{$this->component->getWidth()};");
        return $this;		
	}
	
	/**
     * The renderHeight method, renders the height property of a TCell Object.    
     * @access protected
     * @return TableRenderer
     */	
	protected function renderHeight(){
	    $this->setRender(" height:{$this->component->getHeight()};");
        return $this;		
	}
	
	/**
     * The renderCollapsed method, renders the collapsed property of a Table Object.    
     * @access protected
     * @return TableRenderer
     */	
	protected function renderCollapsed(){
	    $this->setRender(" border-collapse:collapse;");
        return $this;		
	}
	
	/**
     * The renderSpacing method, renders the spacing property of a Table Object.    
     * @access protected
     * @return TableRenderer
     */	
	protected function renderSpacing(){
	    $this->setRender(" border-spacing:{$this->component->getSpacing()};");
        return $this;		
	}
	
	/**
     * The renderCaption method, renders the caption property of a Table Object.    
     * @access protected
     * @return TableRenderer
     */	
	protected function renderCaption(){
	    $this->setRender(" caption-side:{$this->component->getCaption()};");
        return $this;		
	}
	
	/**
     * The renderEmpty method, renders the empty property of a Table Object.    
     * @access protected
     * @return TableRenderer
     */	
	protected function renderEmpty(){
	    $this->setRender(" empty-cells:{$this->component->getEmpty()};");
        return $this;		
	}
	
	/**
     * The renderFixed method, renders the fixed property of a Table Object.    
     * @access protected
     * @return TableRenderer
     */	
	protected function renderFixed(){
	    $this->setRender(" table-layout:fixed;");
        return $this;		
	}

	/**
     * The renderCSS method, renders the css of a Table Container.  
     * It overwrites the parent renderCSS method to add its own.  
     * @access public
     * @return GUIRenderer
     */		
	public function renderCSS(){
		$this->setRender(" style='");
		$css = $this->component->getCSS();
		$iterator = $css->iterator();
		while($iterator->hasNext()){
		    $method = "get{$iterator->next()}";
			$this->setRender($this->component->$method()->render());		    
		}
		
		$attributes = $this->component->getTableAttributes();
		if($attributes instanceof HashSet){
		    $iterator = $attributes->iterator();
            while($iterator->hasNext()){
			    $method = "render{$iterator->next()}";
				$this->$method();
            }			
		}		
        $this->setRender("'");
		return $this;
	}
}  
?>