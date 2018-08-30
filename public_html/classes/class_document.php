<?php

/**
 * The Document Class, extends from abstract GUIContainer class.
 * Document is a top level container right now, it is where other GUIComponents and containers are added.
 * In future when we allow for multiple frames, document will become second level container.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 * @final
 *
 */
 
final class Document extends GUIContainer{
	
	/**
	 * The title property, holds the information of the document title.
	 * @access protected
	 * @var String
    */
	protected $title;
	
	/**
	 * The content property, stores a collection of rendered html elements.
	 * @access protected
	 * @var String
    */
	protected $content;
	
	/**
     * Constructor of Document Class, it calls parent constructor and retrieves all links/images information.   
	 * @param String  $title
	 * @param ArrayObject  $component
     * @access publc
     * @return Void
     */
	public function __construct($title = "", $components = ""){
        parent::__construct($components); 		
        $this->renderer = new DocumentRenderer($this);	
	}
	
	/**
     * The getTitle method, obtain the title of this document.	 
     * @access public
     * @return String
     */
	public function getTitle(){
	    if(!$this->title) throw new GUIException("This document has no title yet.");
	    return $this->title;
	}
	
	/**
     * The setTitle method, set the title of this document.
	 * @param String  $title 
     * @access public
     * @return Void
     */	
	public function setTitle($title){
	    $this->title = $title;
	}
	
	/**
     * The getContent method, obtain the content of this document.	 
     * @access public
     * @return String
     */
	public function getContent(){
	    if(!$this->content) $this->content = $this->render();
	    return $this->content;
	}
	
	/**
     * The addLangvar method, append a language variable into the document. 
     * @access public
     * @return Void
     */
	public function addLangvar($langvar, $lineBreak = FALSE){
	    $langvar = new Comment($langvar, $lineBreak);
		$this->add($langvar);
	}
	
	/**
     * Magic method __toString for Document class, it reveals that the class is a document.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is a Document object.");
	}
}
?>