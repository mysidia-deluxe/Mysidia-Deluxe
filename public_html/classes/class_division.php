<?php

/**
 * The Division Class, extends from Paragraph class.
 * It defines a paragraph type container with <div> tag, can be easily styled.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class Division extends Paragraph
{
    
    /**
     * The paragraphs property, it is useful for retrieving paragraphs from this division
     * @access protected
     * @var Paragraph
    */
    protected $paragraphs;
    
    /**
     * The dimension property, determines the dimension of this division block.
     * @access protected
     * @var Dimension
    */
    protected $dimension;
    
    /**
     * The mcol property, specifies the multi-column css attribute for this division.
     * @access protected
     * @var MCol
    */
    protected $mcol;
    
    /**
     * Constructor of Division Class, sets up basic division properties.
     * The parameter $component can be a colleciton of components, a paragraph/comment type GUIComponent, or a simple string.
     * Contrary to other GUIComponents, a div class can be specified upon object instantiation.
     * @param String|Comment|Paragraph|ArrayObject  $components
     * @param String  $name
     * @param String  $class
     * @param String  $event
     * @access publc
     * @return Void
     */
    public function __construct($components = "", $name = "", $class = "", $event = "")
    {
        parent::__construct($components, $name, $event);
        $this->paragraphs = new ArrayObject;
        if ($components instanceof Paragraph) {
            $this->paragraphs->append($components);
        }
        if (!empty($class)) {
            $this->class = $class;
        }
    }
    
    /**
     * The getParagraphs method, getter method for property $paragraphs.
     * @access public
     * @return ArrayObject
     */
    public function getParagraphs()
    {
        return $this->paragraphs;
    }
    
    /**
     * The setParagraph method, setter method for property $paragraphs.
     * @param Paragraph  $paragraph
     * @access public
     * @return Void
     */
    public function setParagraphs(Paragraph $paragraph)
    {
        $this->paragraphs->append($paragraph);
    }
    
    /**
     * The getDimension method, getter method for property $dimension.
     * @access public
     * @return Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }
    
    /**
     * The setDimension method, setter method for property $dimension.
     * @param Dimension  $dimension
     * @access public
     * @return Void
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
        $this->setCSS("Dimension");
    }
    
    /**
     * The getMCol method, getter method for property $mcol.
     * @access public
     * @return MCol
     */
    public function getMcol()
    {
        return $this->mcol;
    }
    
    /**
     * The setMCol method, setter method for property $mcol.
     * @param MCol  $mcol
     * @access public
     * @return Void
     */
    public function setMCol(MCol $mcol)
    {
        $this->mcol = $mcol;
        $this->setCSS("MCol");
    }
    
    /**
     * The add method, append a GUIComponent to this division.
     * @param GUIComponent  $component
     * @param int  $index
     * @access public
     * @return Void
     */
    public function add(GUIComponent $component, $index = -1)
    {
        parent::add($component, $index);
        if ($component instanceof Paragraph) {
            $this->paragraphs->append($component);
        }
    }
    
    /**
     * Magic method __toString for Division class, it reveals that the class is a Division.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is The Division class.");
    }
}
