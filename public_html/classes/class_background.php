<?php

/**
 * The Background Class, extends from abstract GUIElement class.
 * It defines a standard background element to be used in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Background extends GUIElement{

    /**
	 * The attachment property, speficies the background attachment property(scrolled or fixed).
	 * @access protected
	 * @var String
    */
	protected $attachment;

    /**
	 * The color property, stores the background color if it has been specified.
	 * @access protected
	 * @var Color
    */
	protected $color;
	
	/**
	 * The variant property, stores the background image if it has been specified
	 * @access protected
	 * @var Image
    */
	protected $image;
	
	/**
	 * The position property, determines the background position.
	 * @access protected
	 * @var String
    */
	protected $position;
	
	/**
	 * The repeat property, defines the repeat settings of the background.
	 * @access protected
	 * @var String
    */
	protected $repeat;
	
	/**
	 * The clip property, defines the painting area of the background.
	 * @access protected
	 * @var String
    */
	protected $clip;
	
	/**
	 * The origin property, determines the orign of this background.
	 * @access protected
	 * @var String
    */
	protected $origin;
	
    /**
     * Constructor of Background Class, which assigns basic background properties.
	 * @param Color|Image  $source
     * @param String  $position
     * @param String  $origin 
     * @access public
     * @return Void
     */
	public function __construct($source = "", $position = "", $repeat = "", $origin = ""){	
	    parent::__construct();
		if(!empty($source)){
		    if($source instanceof Color) $this->setColor($source);
			elseif($source instanceof Image) $this->setImage($source);
			else throw new GUIException("The specified source is invalid.");
		}	
        if(!empty($position)) $this->setPosition($position);	
		if(!empty($repeat)) $this->setRepeat($repeat);	
		if(!empty($origin)) $this->setOrign($origin);   
	}
	
	/**
     * The getAttachment method, getter method for property $attachment.    
     * @access public
     * @return String
     */
	public function getAttachment(){
	    return $this->attachment;    
	}
	
	/**
     * The setAttachment method, setter method for property $attachment.
	 * @param String  $attachment  
     * @access public
     * @return Void
     */
	public function setAttachment($attachment){
	    $attachments = array("scroll", "fixed", "inherit");
		if(!in_array($attachment, $attachments)) throw new GUIException("The specified attachment type is invalid.");
	    $this->attachment = $attachment;
		$this->setAttributes("Attachment");
	}
	
	/**
     * The getColor method, getter method for property $color.    
     * @access public
     * @return Color
     */
	public function getColor(){
	    return $this->color;    
	}

	/**
     * The setColor method, setter method for property $color.
	 * @param Color  $color   
     * @access public
     * @return Void
     */
	public function setColor(Color $color){
	    $this->color = $color;
		$this->setAttributes("Color");
	}
	
	/**
     * The getImage method, getter method for property $image.    
     * @access public
     * @return Image
     */
	public function getImage(){
	    return $this->image;    
	}

	/**
     * The setImage method, setter method for property $image.
	 * @param Image  $image  
     * @access public
     * @return Void
     */
	public function setImage(Image $image){
	    $this->image = $image;
		$this->setAttributes("Image");
	}

	/**
     * The getPosition method, getter method for property $position.    
     * @access public
     * @return String
     */
	public function getPosition(){
	    return $this->position;    
	}

	/**
     * The setPosition method, setter method for property $position.
	 * @param String  $position   
     * @access public
     * @return Void
     */
	public function setPosition($position){
	    $positions = array("bottom", "left", "right", "top", "center");
		if(!in_array($position, $positions)) throw new GUIException("The specified position property is invalid.");
	    $this->position = $position;
		$this->setAttributes("Position");
	}
	
	/**
     * The getRepeat method, getter method for property $repeat.    
     * @access public
     * @return String
     */
	public function getRepeat(){
	    return $this->repeat;    
	}

	/**
     * The setRepeat method, setter method for property $repeat.
	 * @param String  $repeat  
     * @access public
     * @return Void
     */
	public function setRepeat($repeat){
	    $repeats = array("repeat", "repeat-x", "repeat-y", "no-repeat");
		if(!in_array($repeat, $repeats)) throw new GUIException("The specified clip property is invalid.");
	    $this->repeat = $repeat;
		$this->setAttributes("Repeat");
	}
	
	/**
     * The getClip method, getter method for property $clip.    
     * @access public
     * @return String
     */
	public function getClip(){
	    return $this->clip;    
	}

	/**
     * The setClip method, setter method for property $clip.
	 * @param String  $clip   
     * @access public
     * @return Void
     */
	public function setClip($position){
	    $clips = array("border-box", "padding-box", "content-box");
		if(!in_array($clip, $clips)) throw new GUIException("The specified clip property is invalid.");
	    $this->clip = $clip;
		$this->setAttributes("Clip");
	}
	
	/**
     * The getOrigin method, getter method for property $origin.    
     * @access public
     * @return String
     */
	public function getOrigin(){
	    return $this->origin;    
	}

	/**
     * The setOrigin method, setter method for property $origin.
	 * @param String  $origin  
     * @access public
     * @return Void
     */
	public function setOrigin($origin){
	    $origins = array("border-box", "padding-box", "content-box");
		if(!in_array($origin, $origins)) throw new GUIException("The specified origin property is invalid.");
	    $this->origin = $origin;
		$this->setAttributes("Origin");
	}

	/**
     * Magic method __toString for Background class, it reveals that the object is a background.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia Background class.");
	}    
} 
?>