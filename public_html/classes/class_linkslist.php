<?php

/**
 * The LinksList Class(not to be confused with LinkedList), extends from abstract GUIContainer class.
 * It defines standard list that contains links. Can be used to construct menu.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class LinksList extends GUIContainer
{

    /**
     * The type property, determines the type of the Commentlist.
     * @access protected
     * @var Boolean
    */
    protected $type = "li";
        
    /**
     * Constructor of LinksList Class, sets up basic list properties.
     * The parameter $component can be a single link or a collection of links.
     * @param String  $type
     * @param Comment|ArrayObject  $components
     * @param String  $name
     * @param String  $event
     * @access publc
     * @return Void
     */
    public function __construct($type = "li", $components = "", $name = "", $event = "")
    {
        parent::__construct($components);
        if (!empty($name)) {
            $this->setName($name);
            $this->setID($name);
        }
        if (!empty($type)) {
            $this->setType($type);
        }
        if (!empty($event)) {
            $this->setEvent($event);
        }
        $this->lineBreak = false;
        $this->renderer = new ListRenderer($this);
    }
    
    /**
     * The getType method, getter method for property $type.
     * @access public
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * The setType method, setter method for property $type.
     * @param String  $type
     * @access public
     * @return Void
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * Magic method __toString for LinksList class, it reveals that the class is a LinksList.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is The CommentList class.");
    }
}
