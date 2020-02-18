<?php

/**
 * The Abstract GUIElement Class, extends from abstract GUI class.
 * It is parent to all GUI elements classes, such as font, color, link, image.
 * These ain't GUIComponents, instead they serve as properties of GUIComponents.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 * @abstract
 *
 */
 
abstract class GUIElement extends GUI implements Renderable
{
    
    /**
     * The component property, specifies which component this element belongs to.
     * @access protected
     * @var Array
    */
    protected $component;
    
    /**
     * Constructor of GUIAccessory Class, assigns the proper renderer object.
     * @access public
     * @return Void
     */
    public function __construct($id = "")
    {
        if (!empty($id)) {
            $this->id = $id;
        }
        $this->renderer = new ElementRenderer($this);
    }
    
    /**
     * The getComponent method, getter method for property $component
     * @access public
     * @return Array
     */
    public function getComponent()
    {
        return $this->component;
    }
    
    /**
     * The setComponent method, setter method for property $component
     * @param GUIComponent  $component
     * @access public
     * @return Array
     */
    public function setComponent(GUIComponent $component)
    {
        $this->component = $component;
    }
    
    /**
     * Magic method __toString for GUIElement class, it reveals that the class is a GUIElement.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is the GUIElement Class.");
    }
    
    /**
     * The render method for GUIElement class, it renders element data field into html readable format.
     * @access public
     * @return Void
     */
    public function render()
    {
        if (!$this->renderer->getRender()) {
            $iterator = $this->attributes->iterator();
            while ($iterator->hasNext()) {
                $renderMethod = "render{$iterator->next()}";
                $this->renderer->$renderMethod();
            }
        }
        return $this->renderer->getRender();
    }
}
