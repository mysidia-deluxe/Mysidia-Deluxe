<?php

/**
 * The Color Class, extends from abstract GUIElement class.
 * It defines a standard color element to be used in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Color extends GUIElement{

    /**
	 * The rgb property, stores the dec color code.
	 * @access protected
	 * @var ArrayObject
    */
	protected $rgb;
	
	/**
	 * The code property, speficies the hex color code.
	 * @access protected
	 * @var String
    */
	protected $code;
	
	/**
	 * The name property, determines the color name such as black and white.
	 * @access protected
	 * @var String
    */
	protected $name;
	
	/**
	 * The names property, defines allowable color names.
	 * @access protected
	 * @var String
    */
	protected $names = array("aliceblue", "black", "blue", "brown", "coral", "cyan", "fuchsia", "gold", 
	                         "green", "grey", "indigo", "lavander", "maroon", "navy", "orange", 
							 "pink", "purple", "red", "silver", "turquoise", "violet", "white", "yellow");

    /**
	 * The format property, speficies the initially defined format for color object.
	 * @access protected
	 * @var String
    */
	protected $format;
	
	/**
	 * The helper property, which can handle color code validation and transformation.
	 * @access protected
	 * @var ColorHelper
    */
	protected $helper;
	
    /**
     * Constructor of Color Class, which assigns basic color properties.
	 * The first argument can be a red dec code, the entire hex code, or even a color name.
	 * @param String|Array  $color	 
     * @access public
     * @return Void
     */
	public function __construct($color){
	    parent::__construct();
	    if(is_array($color)){
		    $this->rgb = new ArrayObject($color);
			$this->format = "rgb";
		}	
		elseif(strpos($color, "#") !== FALSE){
		    $this->code = $color;
			$this->format = "code";
		}		
	    elseif(in_array($color, $this->names)){
		    $this->name = $color;
			$this->format = "name";
		}	
		else throw new GUIException("The specified color property is invalid.");
	}
	
	/**
     * The getRGB method, returns an array of color properties   
     * @access public
     * @return ArrayObject
     */
	public function getRGB(){
	    if(!($this->rgb instanceof ArrayObject)) $this->getHelper()->getRGB(); 
	    return $this->rgb;    
	}
	
	/**
     * The setRGB method, setter method for property $rgb.
	 * @param Byte  $red
	 * @param Byte  $green
	 * @param Byte  $blue
     * @access public
     * @return Void
     */
	public function setRGB($red = "", $green = "", $blue= ""){
	    $this->rgb[0] = $red;
		$this->rgb[1] = $green;
		$this->rgb[2] = $blue;
	}
	
	/**
     * The getRed method, getter method for the red attribute of property $rgb.    
     * @access public
     * @return Byte
     */
	public function getRed(){
	    if(!($this->rgb instanceof ArrayObject)) $this->getHelper()->getRGB(); 
	    return $this->rgb[0];    
	}
	
	/**
     * The getGreen method, getter method for the green attribute of property $rgb.    
     * @access public
     * @return Byte
     */
	public function getGreen(){
	    if(!($this->rgb instanceof ArrayObject)) $this->getHelper()->getRGB(); 
	    return $this->rgb[1];    
	}
	
	/**
     * The getBlue method, getter method for the blue attribute of property $rgb. 
     * @access public
     * @return Byte
     */
	public function getBlue(){
	    if(!($this->rgb instanceof ArrayObject)) $this->getHelper()->getRGB(); 
	    return $this->rgb[2];    
	}
	
	/**
     * The getCode method, getter method for property $code.    
     * @access public
     * @return String
     */
	public function getCode(){
	    if(!$this->code) $this->getHelper()->getCode(); 
	    return $this->code;    
	}

	/**
     * The setCode method, setter method for property $code.
	 * @param String  $code     
     * @access public
     * @return Void
     */
	public function setCode($code = ""){
	    if(strpos($color, "#") === FALSE) throw new GUIException("Color code must start with the symbol #");
		$this->code = $code;
	}
	
	/**
     * The getName method, getter method for property $name.    
     * @access public
     * @return String
     */
	public function getName(){
	    if(!$this->name) $this->getHelper()->getName(); 
	    return $this->name;    
	}

	/**
     * The setName method, setter method for property $name.
	 * @param String  $name    
     * @access public
     * @return Void
     */
	public function setName($name = ""){
	    if(!in_array($name, $this->names)) throw new GUIException("The specified color name is invalid.");
		$this->name = $name;
	}
	
	/**
     * The getNames method, getter method for property $names.    
     * @access public
     * @return Array
     */
	public function getNames(){ 
	    return $this->names;    
	}
	
	/**
     * The getFormat method, getter method for property $format.    
     * @access public
     * @return String
     */
	public function getFormat(){
		return $this->format;
	}
	
	/**
     * The getHelper method, getter method for property $helper.    
     * @access public
     * @return ColorHelper
     */
	public function getHelper(){
		if(!$this->helper) $this->helper = new ColorHelper($this);
		return $this->helper;
	}
	
	/**
     * The render method for Color class, it renders font data field into html readable format.
     * @access public
     * @return String
     */
    public function render(){
	    if($this->renderer->getStatus() == "ready") $this->renderer->renderForeground();
	    return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Color class, it reveals that the object is a color.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Color class.");
	}    
} 
?>