<?php

/**
 * The Margin Class, extends from abstract Spacing class.
 * It defines a standard margin element to be used in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Margin extends Spacing{

    /**
	 * The type property, defines this spacing element as a margin.
	 * @access protected
	 * @var String
    */
	protected $type;
	
    /**
     * Constructor of Margin Class, it simply calls parent constructor.
     * @param String  $direction
     * @param Int|String  $width 
     * @access public
     * @return Void
     */
	public function __construct($direction = "", $width = ""){
	    parent::__construct($direction, $width);	
		$this->type = "margin";
	}
	
	/**
     * The getType method, getter method for property $type.    
     * @access public
     * @return String
     */
	public function getType(){
	    return $this->type;    
	}
	
	/**
     * The render method for Margin class, it renders margin data field into html readable format.
     * @access public
     * @return Void
     */
    public function render(){
	    if(!($this->renderer instanceof ElementRenderer)) throw new GUIException("Cannot find Renderer Object..."); 
	    
        if(!$this->renderer->getRender()){
            $this->renderer->renderMargin()
                           ->renderWidth();
        }
		return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Margin class, it reveals that it is a margin object.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Margin class.");
	}    
} 
?>