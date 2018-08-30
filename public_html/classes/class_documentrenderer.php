<?php

/**
 * The DocumentRenderer Class, extends from abstract GUIRenderer class.
 * It is responsible for rendering GUI document type Components and Containers.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class DocumentRenderer extends GUIRenderer{

    /**
	 * The currentText property, holds the current rendered text pending to be sent to the render property.
	 * @access protected
	 * @var String
    */
    protected $currentText;
	
	/**
     * Constructor of DocumentRenderer Class, assigns the document reference and determines its tag.
     * @param GUIComponent  $document
     * @access public
     * @return Void
     */
	public function __construct(GUIComponent $document){
        parent::__construct($document);	
		if($document instanceof Comment){
		    $this->tag = "";
			$this->currentText = $document->getText();
		}	
		elseif($document instanceof Division) $this->tag = "div";
		elseif($document instanceof Paragraph) $this->tag = "p";
        elseif($document instanceof Document) $this->tag = "article";
		else $this->tag = "";
    }
	
	/**
     * The renderComment method, renders the properties of a GUIComment Object.  
     * Since comment really is not a HTML element, its rendering process is a bit unique.	 
     * @access public
     * @return DocumentRenderer
     */	
	public function renderComment(){	
		if($this->component->getHeading()) $this->renderHeading();
		if($this->component->getStyles()) $this->renderStyles();
		
        if($this->component->getCSS() instanceof ArrayObject){
            $this->tag = "span";
            $this->start()->renderCSS()->pause()
			              ->renderText()->end();			
        }		
		else $this->renderText();
		return $this;
	}

	/**
     * The renderText method, renders the text of a GUI Comment.   
     * It overrides parent method and adds its own implementation
     * @access public
     * @return DocumentRenderer
     */		
	public function renderText(){
	    $this->setRender($this->currentText);
        return $this;		
	}
	
	/**
     * The renderHeadings method, renders the headings of a GUI Comment.   
     * It is a protected method, cannot be called outside of the renderer class.
     * @access protected
     * @return DocumentRenderer
     */		
	protected function renderHeading(){
	    $heading = $this->component->getHeading();
	    $this->currentText = "<h{$heading}>{$this->currentText}</h{$heading}>";
	}

	/**
     * The renderStyles method, renders the styles of a GUI Comment.   
     * It is a protected method, cannot be called outside of the renderer class.
     * @access protected
     * @return DocumentRenderer
     */		
	protected function renderStyles(){
	    $styles = $this->component->getStyles();
	    foreach($styles as $style => $status){
		    $this->currentText = "<{$style}>{$this->currentText}</{$style}>";    
		}
	}
}  
?>