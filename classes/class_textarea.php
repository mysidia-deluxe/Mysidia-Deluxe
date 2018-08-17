<?php

/**
 * The TextArea Class, extends from abstract TextComponent class.
 * It defines an editable textarea in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class TextArea extends TextComponent{

    /**
	 * The rows property, specifies the height of this text area.
	 * @access protected
	 * @var Int
    */
	protected $rows;

    /**
	 * The cols property, specifies the width of this text area.
	 * @access protected
	 * @var Int
    */
	protected $cols;
	
	/**
	 * The wraps property, determines if the text area is hard or soft wrapped upon form submission.
	 * soft = FALSE(default), hard = TRUE.
	 * @access protected
	 * @var Int
    */
	protected $wrap = FALSE;
	
	/**
     * Constructor of TextArea Class, which assigns basic text area properties.
     * @access public
     * @return Void
     */
	public function __construct($name = "", $value = "", $rows = 4, $cols = 45, $event = ""){
	    parent::__construct($name, $value, $event);
		if(is_numeric($rows)) $this->setRows($rows);
		if(is_numeric($cols)) $this->setCols($cols);
	}
	
	/**
     * The getRows method, getter method for property $rows.    
     * @access public
     * @return Int
     */	
	public function getRows(){
	    return $this->rows;
	}
	
	/**
     * The setRows method, setter method for property $rows.
	 * @param Int  $rows  
     * @access public
     * @return Void
     */
	public function setRows($rows){
	    if(!is_numeric($rows)) throw new GUIException("The supplied height is not numeric!");
	    $this->rows = $rows;
		$this->setAttributes("Rows");
	}
	
	/**
     * The getCols method, getter method for property $cols.    
     * @access public
     * @return Int
     */	
	public function getCols(){
	    return $this->cols;
	}
	
	/**
     * The setCols method, setter method for property $cols.
	 * @param Int  $cols  
     * @access public
     * @return Void
     */
	public function setCols($cols){
	    if(!is_numeric($cols)) throw new GUIException("The supplied height is not numeric!");
	    $this->cols = $cols;
		$this->setAttributes("Cols");
	}
	
	/**
     * The isWrapped method, getter method for property $wrap.    
     * @access public
     * @return Boolean
     */	
	public function isWrapped(){
	    return $this->wrap;
	}
	
	/**
     * The setWrapped method, setter method for property $wrap.
	 * @param Boolean  $wrap
     * @access public
     * @return Void
     */
	public function setWrapped($wrap){
	    $this->wrap = $wrap;
		$this->setAttributes("Wrapped");
	}
	
	/**
     * The append method, append a string to the end of TextArea.
	 * @param String  $text
     * @access public
     * @return Void
     */
	public function append($text){
	    $this->value .= $text;
	}
	
	/**
     * The insert method, insert a string in the specified position in TextArea.
	 * @param String  $text
	 * @param Int  $position
     * @access public
     * @return Void
     */
	public function insert($text, $position){
	    if(!is_numeric($position)) throw new GUIException("The supplied position is not numeric!");
		$text1 = substr_replace($this->value, $text, $position);
	    $text2 = substr_replace($this->value, "", 0, $position);
		$this->value = $text1.$text2;
	}
	
	/**
     * The replace method, replace a string from a starting to an end index in TextArea.
	 * @param String  $text
	 * @param Int  $start
	 * @param Int  $end
     * @access public
     * @return Void
     */
	public function replace($text, $start, $end){
	    if(!is_numeric($start) or !is_numeric($end)) throw new GUIException("The supplied positions are not numeric!");
		$length = $end - $start;
		$this->value = substr_replace($this->value, $text, $start, $length);
	}
	
	/**
     * The lineCount method, returns the actual number of lines contained in TextArea.    
     * @access public
     * @return Int
     */	
	public function lineCount(){
	    return ceil(strlen($this->value)/$this->rows);
	}

	/**
     * Magic method __toString for TextArea class, it reveals that the object is a text area.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia TextArea class.");
	}    
}
    
?>