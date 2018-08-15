<?php

/**
 * The IFrame Class, extends from abstract GUIContainer class.
 * It is a flexible PHP iframe class, can perform a series of operations.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class IFrame extends GUIAccessory{
	
	/**
	 * The width property, defines the width of this iframe.
	 * @access protected
	 * @var String
    */
	protected $width;
	
	/**
	 * The height property, defines the height of this iframe.
	 * @access protected
	 * @var String
    */
	protected $height;
	
	/**
	 * The src property, it specifies the url associated with this iframe.
	 * @access protected
	 * @var URL
    */
	protected $src;
	
	/**
	 * The sandbox property, determines a set of extra restriction for iframe.
	 * @access protected
	 * @var String
    */
	protected $sandbox;
	
	/**
     * Constructor of IFrame Class, sets up basic frame properties.   
	 * @param String  $name
	 * @param URL|String  $src
	 * @param Int|String  $width
	 * @param Int|String  $height
	 * @param String  $event
     * @access publc
     * @return Void
     */
	public function __construct($name = "", $src = "", $width = "", $height = "", $event = ""){
        parent::__construct($name); 
        if(!empty($name)) $this->name = $name;
		if(!empty($src)){
		    if($src instanceof URL) $this->setSrc($src);
			else $this->setSrc(new URL($src));
		}
		if(!empty($width)) $this->setWidth($width);
		if(!empty($height)) $this->setHeight($height);
		if(!empty($event)) $this->event = $event;			
	}
			
	/**
     * The getSrc method, getter method for property $src.    
     * @access public
     * @return URL
     */
	public function getSrc(){
	    return $this->src;    
	}

	/**
     * The setSrc method, setter method for property $src.
	 * @param URL  $src     
     * @access public
     * @return Void
     */
	public function setSrc(URL $src){
	    $this->src = $src;
		$this->setAttributes("Src");
	}
	
	/**
     * The getWidth method, getter method for property $width.    
     * @access public
     * @return String
     */
	public function getWidth(){
	    return $this->width;    
	}

	/**
     * The setWidth method, setter method for property $width.
	 * @param Int|String  $width    
     * @access public
     * @return Void
     */
	public function setWidth($width){
	    if(!$this->inline) $this->inline = TRUE;
	    if(is_numeric($width)) $this->width = "{$width}px";
	    else $this->width = $width;
		$this->setAttributes("Width");
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
		$this->setAttributes("Height");
	}
	
	/**
     * The getSandbox method, getter method for property $sandbox.    
     * @access public
     * @return String
     */
	public function getSandbox(){
	    return $this->sandbox;    
	}

	/**
     * The setSandbox method, setter method for property $sandbox.
	 * @param String  $sandbox  
     * @access public
     * @return Void
     */
	public function setSandbox($sandbox){
	    $this->sandbox = $sandbox;
		$this->setAttributes("Sandbox");
	}
		
	/**
     * The method render for IFrame class, it renders iframe data field into html readable format.
     * @access public
     * @return String
     */
	public function render(){
		if($this->renderer->getStatus() == "ready"){
		    $this->renderer->start(); 
		    parent::render()->pause()->end();
		}	
		return $this->renderer->getRender();
	}
	
	/**
     * Magic method __toString for IFrame class, it reveals that the class is an IFrame.
     * @access public
     * @return String
     */
    public function __toString(){
	    return "This is The IFrame class.";
	}
}
?>