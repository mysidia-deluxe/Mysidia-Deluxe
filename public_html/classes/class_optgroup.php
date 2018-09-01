<?php

/**
 * The Optgroup Class, extends from abstract GuiContainer class.
 * It specifies a radio button list in which only one button can be selected.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class OptGroup extends GUIContainer
{

    /**
     * The label property, stores the label of this OptGroup.
     * @access protected
     * @var String
    */
    protected $label;
    
    /**
     * Constructor of OptGroup Class, which assigns basic property to this list
     * @access public
     * @return Void
     */
    public function __construct($label = "", $components = "")
    {
        parent::__construct($components);
        if (!empty($label)) {
            $this->label = $label;
        }
        $this->renderer = new ListRenderer($this);
    }
    
    /**
     * The getLabel method, getter method for property $label.
     * @access public
     * @return String
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * The setLabel method, setter method for property $label.
     * @param String  $label
     * @access public
     * @return Void
     */
    public function setLabel($label)
    {
        $this->label = $label;
        $this->setAttributes("Label");
    }

    /**
     * The add method, sets a Option Object to a specific index.
     * @param Option $option
     * @param int  $index
     * @access public
     * @return Void
     */
    public function add(Option $option, $index = -1)
    {
        if ($option->getValue()) {
            throw new GUIException("Cannot add an option without a value to the group.");
        }
        parent::add($option, $index);
    }

    /**
     * Magic method __toString for OptGroup class, it reveals that the object is an OptGroup.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is an instance of Mysidia OptGroup class.");
    }
}
