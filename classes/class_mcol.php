<?php

/**
 * The MCol Class, extends from abstract GUIElement class.
 * It defines a standard multi-column element to be used in HTML Div.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class MCol extends GUIElement{

    /**
	 * The browser property, speficies the browser of the user.
	 * It is important for MCol since the css element is browser-dependent.
	 * @access protected
	 * @var 
    */
	protected $browser;

    /**
	 * The count property, speficies the number of columns available.
	 * @access protected
	 * @var Int
    */
	protected $count;

    /**
	 * The gap property, stores the gap between each column.
	 * @access protected
	 * @var String
    */
	protected $gap;
	
	/**
	 * The rule property, defines the rules for multi-column element.
	 * @access protected
	 * @var String
    */
	protected $rule;
	
	/**
	 * The span property, determines the column span.
	 * @access protected
	 * @var String
    */
	protected $span;
	
	/**
	 * The colWidth property, defines the column width.
	 * @access protected
	 * @var String
    */
	protected $colWidth;
	
    /**
     * Constructor of MCol Class, which assigns basic multi-column properties.
	 * @param Int  $count
     * @param String  $width
     * @param Array  $rule 
     * @access public
     * @return Void
     */
	public function __construct($count = "", $rule = "", $colWidth = ""){	
	    parent::__construct();
		$this->setBrowser($_SERVER['HTTP_USER_AGENT']);
        if(is_int($count)) $this->setCount($count);	
		if(is_array($rule) and count($rule) == 3) $this->setRule($rule[0], $rule[1], $rule[2]);
		if(!empty($colWidth)) $this->setColWidth($colWidth);	  
	}
	
	/**
     * The getBrowser method, getter method for property $browser.    
     * @access public
     * @return String
     */
	public function getBrowser(){
	    return $this->browser;    
	}
	
	/**
     * The setBrowser method, setter method for property $browser.
	 * It is determined upon MCol object instantiation, cannot be altered later.
	 * @param String  $attachment  
     * @access protected
     * @return Void
     */
	protected function setBrowser($browser){
        if(strpos($browser, "Firefox") !== FALSE){
            $this->browser = "-moz-";
        }
        elseif(strpos($browser, "Chrome") !== FALSE or strpos($browser, "Safari") !== FALSE){
            $this->browser = "-webkit-";
        }
	    else $this->browser = "";
	}
	
	/**
     * The getCount method, getter method for property $count.    
     * @access public
     * @return Int
     */
	public function getCount(){
	    return $this->count;    
	}

	/**
     * The setCount method, setter method for property $count.
	 * @param Int  $count   
     * @access public
     * @return Void
     */
	public function setCount($count){
	    $this->count = $count;
		$this->setAttributes("Count");
	}
	
	/**
     * The getGap method, getter method for property $gap.    
     * @access public
     * @return String
     */
	public function getGap(){
	    return $this->gap;    
	}

	/**
     * The setGap method, setter method for property $gap.
	 * @param Int|String  $gap  
     * @access public
     * @return Void
     */
	public function setGap($gap){
	    $this->gap = (is_numeric($gap))?"{$gap}px":$gap;
		$this->setAttributes("Gap");
	}

	/**
     * The getRule method, getter method for property $rule.    
     * @access public
     * @return Array
     */
	public function getRule(){
	    return $this->rule;    
	}

	/**
     * The setRule method, setter method for property $rule.
	 * @param String  $width
     * @param String  $style
     * @param Color  $color	 
     * @access public
     * @return Void
     */
	public function setRule($width = "", $style = "", $color = ""){
	    $this->rule = "";
	    if(!empty($width)) $this->rule .= $width;
		if(!empty($style)) $this->rule .= " {$style}";
		if($color instanceof Color) $this->rule .= " {$color->getCode()}";
		$this->setAttributes("Rule");
	}
	
	/**
     * The getSpan method, getter method for property $span.    
     * @access public
     * @return String
     */
	public function getSpan(){
	    return $this->span;    
	}

	/**
     * The setSpan method, setter method for property $span.
	 * @param String  $span  
     * @access public
     * @return Void
     */
	public function setSpan($span){
	    $this->span = $span;
		$this->setAttributes("Span");
	}
	
	/**
     * The getColWidth method, getter method for property $colWidth.    
     * @access public
     * @return String
     */
	public function getColWidth(){
	    return $this->colWidth;    
	}

	/**
     * The setColWidth method, setter method for property $colWidth.
	 * @param String  $colWidth   
     * @access public
     * @return Void
     */
	public function setColWidth($colWidth){
	    $this->colWidth = (is_numeric($colWidth))?"{$colWidth}px":$colWidth;
		$this->setAttributes("ColWidth");
	}
	
	/**
     * Magic method __toString for MCol class, it reveals that the object is a multicolumn.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia MultiColumn class.");
	}    
} 
?>