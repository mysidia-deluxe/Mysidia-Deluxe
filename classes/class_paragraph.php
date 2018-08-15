<?php

/**
 * The Paragraph Class, extends from abstract GUIContainer class.
 * It defines a paragraph type container with <p> tag, can be easily styled.
 * A paragraph can be viewed as a well formmated collection of GUI Comments.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class Paragraph extends GUIContainer{

    /**
	 * The comments property, it is useful if the paragraph contains comments type GUIComponent.
	 * @access protected
	 * @var ArrayObject
    */
	protected $comments;
		
	/**
     * Constructor of Paragraph Class, sets up basic paragraph properties.  
	 * The parameter $component can be a colleciton of components, a comment type GUIComponent, or a simple string.
	 * @param Comment|ArrayObject  $components
	 * @param String  $name
	 * @param String  $event
     * @access publc
     * @return Void
     */
	public function __construct($components = "", $name = "", $event = ""){
        parent::__construct($components);
		if(!empty($name)){
		    $this->setName($name);
			$this->setID($name);
		}

        $this->comments = new ArrayObject;
		if($components instanceof Comment) $this->comments->append($components);
		if(!empty($event)) $this->setEvent($event);
		$this->lineBreak = FALSE; 
        $this->renderer = new DocumentRenderer($this);	
	}
	
	/**
     * The getComments method, getter method for property $comments.    
     * @access public
     * @return ArrayObject
     */	
	public function getComments(){
	    return $this->comments;
	}
	
	/**
     * The setComments method, setter method for property $comments.
	 * @param Comment  $comment
     * @access public
     * @return Void
     */
	public function setComments(Comment $comment){
	    $this->comments->append($comment);
	}

	/**
     * The add method, append a GUIComponent to this paragraph.
	 * @param GUIComponent  $component
     * @param int  $index	 
     * @access public
     * @return Void
     */	
	public function add(GUIComponent $component, $index = -1){
		parent::add($component, $index);
	    if($component instanceof Comment) $this->comments->append($component);		
	}
	
	/**
     * Magic method __toString for Paragraph class, it reveals that the class is a Paragraph.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is The Paragraph class.");
	}
}
?>