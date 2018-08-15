<?php

/**
 * The Media Class, extends from abstract GUIAccessory class.
 * It defines a standard media object that can be easily embeded.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Media extends GUIAccessory implements Resizable{

    /**
	 * The type property, specifies the type of this media.
	 * @access protected
	 * @var String
    */
	protected $type;
	
    /**
	 * The width property, specifies the width of this media object.
	 * @access protected
	 * @var Int
    */
	protected $width = 400;
	
	/**
	 * The height property, specifies the height for this media object.
	 * @access protected
	 * @var Int
    */
	protected $height = 400;
	
	/**
	 * The data property, stores the data url of this media object.
	 * @access protected
	 * @var Link
    */
	protected $src;
	
    /**
     * Constructor of Media Class, which assigns basic media properties.
	 * @param Link  $data
	 * @param String  $name
	 * @param Int  $dimension
	 * @param String  $event
     * @access public
     * @return Void
     */
	public function __construct($data = "", $name = "", $dimension = "", $event = ""){
	    parent::__construct($name);
	    if($data instanceof Link) $this->setData($data);		
		if(is_numeric($dimension)){
		    $this->setWidth($dimension);
			$this->setHeight($dimension);
		}
		if(!empty($event)) $this->setEvent($event);        
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
     * The setType method, setter method for property $type.
	 * @param String  $type  
     * @access public
     * @return Void
     */
	public function setType($type){
		$this->type = $type;
		$this->setAttributes("Type");
	}
	
	/**
     * The getData method, getter method for property $data.    
     * @access public
     * @return Link
     */
	public function getData(){
	    return $this->data;    
	}

	/**
     * The setData method, setter method for property $data.
	 * @param Link $data       
     * @access public
     * @return Void
     */
	public function setData(Link $data){
	    $this->data = $data;
		$this->setAttributes("Data");
	}
	
	/**
     * The getWidth method, getter method for property $width.    
     * @access public
     * @return Int
     */
	public function getWidth(){
	    return $this->width;    
	}

	/**
     * The setWidth method, setter method for property $width.
	 * @param Int  $width      
     * @access public
     * @return Void
     */
	public function setWidth($width = 400){
	    $this->width = $width;
		$this->setAttributes("Width");
	}
	
		
	/**
     * The getHeight method, getter method for property $height.    
     * @access public
     * @return Int
     */
	public function getHeight(){
	    return $this->height;    
	}

	/**
     * The setHeight method, setter method for property $height.
	 * @param Int  $height     
     * @access public
     * @return Void
     */
	public function setHeight($height = 400){
	    $this->height = $height;
		$this->setAttributes("Height");
	}
	
	/**
     * The resize method, resizes the width and height simultaneous while keeping aspect ratio.
	 * @param Int  $dimension
     * @param Boolean  $percent	 
     * @access public
     * @return Void
     */
	public function resize($dimension, $percent = FALSE){	
	    if($percent){
		    $this->width *= $dimension;
			$this->height *= $dimension;
		}
	    else{
	        $this->width = $dimension;
		    $this->height = $dimension;
		}
		$this->setAttributes("Width");
		$this->setAttributes("Height");		
	}

	/**
     * The render method for Media class, it renders media data field into html readable format.
     * @access public
     * @return Void
     */
    public function render(){		
		if($this->renderer->getStatus() == "ready"){
		    $this->renderer->start(); 
		    parent::render()->pause()->end();
		}	
		return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Media class, it reveals that the object is a media.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia Media class.");
	}    
} 
?>