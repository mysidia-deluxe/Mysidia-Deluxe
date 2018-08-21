<?php

use Resource\Collection\ArrayList as ArrayList;
use Resource\Collection\HashSet as HashSet;

/**
 * The TCell Class, extends from abstract TableContainer class.
 * It defines a standard table cell with the tag <td>, can be added to container Row. 
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class TCell extends TableContainer{

	/**
	 * The text property, it stores the text inside this table cell.
	 * @access protected
	 * @var String
    */
	protected $text;

	/**
	 * The headers property, it defines the headers associated with this table cell.
	 * @access protected
	 * @var String
    */
	protected $headers;

	/**
	 * The rowspan property, defines the rowspan of this table cell.
	 * @access protected
	 * @var Int
    */
	protected $rowspan;
	
	/**
	 * The colspan property, defines the colspan of this table cell.
	 * @access protected
	 * @var Int
    */
	protected $colspan;

	/**
	 * The height property, it stores the height of the table cell.
	 * @access protected
	 * @var String
    */
	protected $height;
	
	/**
     * Constructor of TCell Class, sets up basic table properties and calls parent constructor. 
     * It is designed to be flexible enough to handle simple text with alignment.
     * If a table cell holds complicated content, you should use the add() method to insert GUIComponent.	 
	 * @param ArrayObject|String  $components
	 * @param String  $name
	 * @param String  $headers
	 * @param String  $width
	 * @param String  $event
     * @access publc
     * @return Void
     */
	public function __construct($components = "", $name = "", $headers = "", $width = "", $event = ""){
        parent::__construct($name, $width, $event, $components);
		if(is_scalar($components)) $this->setText($components);
        $this->headers = $headers;		
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
     * The getHeaders method, getter method for property $headers.    
     * @access public
     * @return String
     */
	public function getHeaders(){
	    return $this->headers;    
	}

	/**
     * The setHeaders method, setter method for property $headers.
	 * @param String  $headers    
     * @access public
     * @return Void
     */
	public function setHeaders($headers){
	    $this->headers = $headers;
		$this->setAttributes("Headers");
	}
	
	/**
     * The getRowspan method, getter method for property $rowspan.    
     * @access public
     * @return Int
     */
	public function getRowspan(){
	    return $this->rowspan;    
	}

	/**
     * The setRowspan method, setter method for property $rowspan.
	 * @param Int  $rowspan   
     * @access public
     * @return Void
     */
	public function setRowspan($rowspan){
	    if(!is_int($rowspan)) throw new GUIException("The specified rowspan is not valid.");
	    $this->rowspan = $rowspan;
		$this->setAttributes("Rowspan");
	}
	
	/**
     * The getColspan method, getter method for property $colspan.    
     * @access public
     * @return Int
     */
	public function getColspan(){
	    return $this->colspan;    
	}

	/**
     * The setColspan method, setter method for property $colspan.
	 * @param Int  $colspan  
     * @access public
     * @return Void
     */
	public function setColspan($colspan){
	    if(!is_int($colspan)) throw new GUIException("The specified colspan is not valid.");
	    $this->colspan = $colspan;
		$this->setAttributes("Colspan");
	}
	
	/**
     * The getHeight method, getter method for property $height.    
     * @access public
     * @return String
     */
	public function getHeight(){
	    return $this->height;    
	}

	/**
     * The setHeight method, setter method for property $height.
	 * @param Int|String  $height    
     * @access public
     * @return Void
     */
	public function setHeight($height){
	    if(!$this->inline) $this->inline = TRUE;
	    if(is_numeric($height)) $this->height = "{$height}px";
	    else $this->height = $height;
		$this->setTableAttributes("Width");
	}
		
	/**
     * The method render for TCell class, it validates components and sorts components by indexes.
	 * It has a unique complex implementation of its rendering process, does not call parent constructor.
     * @access public
     * @return String
     */
	public function render(){	    
        if($this->renderer->getStatus() == "ready"){
		    $this->renderer->start();			
		    if($this->css instanceof HashSet) $this->renderer->renderCSS();			
		    if($this->attributes instanceof HashSet) $this->renderer->renderAttributes();
			$this->renderer->pause();
			
			if($this->components instanceof ArrayList) $this->renderer->renderComponents();
            parent::render();
			$this->renderer->renderText()->end();			
        }
		return $this->renderer->getRender();
	}
	
	/**
     * Magic method __toString for TCell class, it reveals that the class is a Table Cell.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is The Table Cell class.");
	}
}
?>