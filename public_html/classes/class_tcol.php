<?php

/**
 * The TCol Class, extends from abstract TableContainer class.
 * It defines a standard table column with the tag <col> or <colgroup>, can be added to container Table.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class TCol extends TableContainer
{

    /**
     * The group property, determines if this is a column or a column group.
     * @access protected
     * @var Boolean
    */
    protected $group = false;

    /**
     * The span property, specifies the number of columns a <col> element should span.
     * @access protected
     * @var String
    */
    protected $span;
    
    /**
     * Constructor of TCol Class, sets up basic table properties and calls parent constructor.
     * @param String  $name
     * @param String  $width
     * @param String  $event
     * @param ArrayObject  $components
     * @access public
     * @return Void
     */
    public function __construct($name = "", $span = "", $group = false, $width = "", $event = "", $components = "")
    {
        parent::__construct($name, $width, $event, $components);
        if (!empty($span)) {
            $this->setSpan($span);
        }
        if ($group) {
            $this->group = true;
        }
    }
    
    /**
     * The getSpan method, getter method for property $span.
     * @access public
     * @return Int
     */
    public function getSpan()
    {
        return $this->span;
    }

    /**
     * The setSpan method, setter method for property $span.
     * @param Int  $span
     * @access public
     * @return Void
     */
    public function setSpan($span)
    {
        if (!is_int($span)) {
            throw new GUIException("The specified span for col/colgroup is invalid.");
        }
        $this->span = $span;
        $this->setAttributes("Span");
    }
    
    /**
     * The isGroup method, getter method for property $group.
     * @access public
     * @return Boolean
     */
    public function isGroup()
    {
        return $this->group;
    }

    /**
     * The setGroup method, setter method for property $group.
     * @param Boolean  $group
     * @access public
     * @return Void
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }
    
    /**
     * Magic method __toString for TCol class, it reveals that the class is a Table Column.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is The Table Column class.");
    }
}
