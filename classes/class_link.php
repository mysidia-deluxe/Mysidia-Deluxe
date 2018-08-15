<?php

/**
 * The Link Class, extends from abstract GUIAccessory class.
 * It defines a standard hyperlink element to be used in HTML.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Link extends GUIAccessory{

    /**
	 * The href property, defines the href query string for link object.
	 * @access protected
	 * @var URL
    */
	protected $href;

    /**
	 * The lang property, specifies the language of the linked document.
	 * @access protected
	 * @var String
    */
	protected $lang;
	
    /**
	 * The media property, stores the media type of this link.
	 * @access protected
	 * @var String
    */
	protected $media;
	
	/**
	 * The rel property, specifies the rel property for this link.
	 * @access protected
	 * @var String
    */
	protected $rel;
	
	/**
	 * The target property, stores the target type for this link.
	 * @access protected
	 * @var String
    */
	protected $target;
	
	/**
	 * The type property, defines the MIME type for this link.
	 * @access protected
	 * @var String
    */
	protected $type;
	
	/**
	 * The text property, contains the text associated with this link.
	 * @access protected
	 * @var String
    */
	protected $text;
	
	/**
	 * The image property, contains the image associated with this link.
	 * @access protected
	 * @var Image
    */
	protected $image;
	
	/**
	 * The listed property, it defines if the link is listed or not.
	 * @access protected
	 * @var Boolean
    */
	protected $listed = FALSE;
	
    /**
     * Constructor of Image Class, which assigns basic image properties.
     * @access public
     * @return Void
     */
	public function __construct($href, $component = "", $lineBreak = FALSE, $id = "", $event = ""){
	    parent::__construct($id);	
		$href = ($href instanceof URL)?$href:new URL($href);
		$this->setHref($href);
        if($component instanceof Image) $this->setImage($component);		
		else $this->setText($component);
		if($lineBreak) $this->setLineBreak(TRUE);
		if(!empty($event)) $this->setEvent($event);   
	}
	
	/**
     * The getHref method, getter method for property $href.    
     * @access public
     * @return URL
     */
	public function getHref(){
	    return $this->href;    
	}
	
	/**
     * The setHref method, setter method for property $href.
	 * @param URL  $href  
     * @access public
     * @return Void
     */
	public function setHref(URL $href){
	    $this->href = $href;
		$this->setAttributes("Href");
	}
	
	/**
     * The getLang method, getter method for property $lang.    
     * @access public
     * @return String
     */
	public function getLang(){
	    return $this->lang;    
	}

	/**
     * The setLang method, setter method for property $lang.
	 * @param String  $lang     
     * @access public
     * @return Void
     */
	public function setLang($lang){
	    $this->lang = $lang;
		$this->setAttributes("Lang");
	}
	
	/**
     * The getMedia method, getter method for property $media.    
     * @access public
     * @return String
     */
	public function getMedia(){
	    return $this->media;    
	}

	/**
     * The setMedia method, setter method for property $media.
	 * @param String  $media      
     * @access public
     * @return Void
     */
	public function setMedia($media){
	    $this->media = $media;
		$this->setAttributes("Media");
	}
	
		
	/**
     * The getRel method, getter method for property $rel.    
     * @access public
     * @return String
     */
	public function getRel(){
	    return $this->rel;    
	}

	/**
     * The setRel method, setter method for property $rel.
	 * @param String  $rel     
     * @access public
     * @return Void
     */
	public function setRel($rel){
	    $this->rel = $rel;
		$this->setAttributes("Rel");
	}
	
	/**
     * The getTarget method, getter method for property $target.    
     * @access public
     * @return String
     */	
	public function getTarget(){
	    return $this->target;
	}
	
	/**
     * The setTarget method, setter method for property $target.
	 * @param String  $target  
     * @access public
     * @return Void
     */
	public function setTarget($target){
	    $targets = array("blank", "parent", "self", "top");
		if(!in_array($target, $targets)) throw new GUIException("The link target is invalid...");
		$this->target = $target;
		$this->setAttributes("Target");
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
	}

	/**
     * The isListed method, getter method for property $listed.    
     * @access public
     * @return Boolean
     */
	public function isListed(){
	    return $this->listed;    
	}

	/**
     * The setListed method, setter method for property $listed.
	 * @param Boolean  $listed    
     * @access public
     * @return Void
     */
	public function setListed($listed){
	    $this->listed = $listed;
	}

	/**
     * The render method for Link class, it renders link data field into html readable format.
     * @access public
     * @return Void
     */
    public function render(){
		if($this->renderer->getStatus() == "ready"){
            if($this->listed){
                $this->renderer->renderList()->start();
		        parent::render()->renderText()->renderImage()->end();
                $this->renderer->renderListed();
            }
            else{
		        $this->renderer->start(); 
		        parent::render()->renderText()->renderImage()->end();
            }
		}	
		return $this->renderer->getRender();	
    }

	/**
     * Magic method __toString for Link class, it reveals that the object is a link.
     * @access public
     * @return String
     */
    public function __toString(){
	    return "This is an instance of Mysidia Link class.";
	}    
} 
?>