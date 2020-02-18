<?php

/**
 * The TRow Class, extends from abstract TableContainer class.
 * It defines a standard table row with the tag <tr>, can be added to container Table.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class TRow extends TableContainer
{

    /**
     * The char property, specifies the alignment char for the table row.
     * @access protected
     * @var String
    */
    protected $char;
    
    /**
     * Constructor of TRow Class, sets up basic table properties and calls parent constructor.
     * @param String  $name
     * @param String  $width
     * @param String  $event
     * @param ArrayObject  $components
     * @access publc
     * @return Void
     */
    public function __construct($name = "", $width = "", $event = "", $components = "")
    {
        parent::__construct($name, $width, $event, $components);
    }
    
    /**
     * The getChar method, getter method for property $char.
     * @access public
     * @return String
     */
    public function getChar()
    {
        return $this->char;
    }

    /**
     * The setChar method, setter method for property $char.
     * @param String  $char
     * @access public
     * @return Void
     */
    public function setChar($char)
    {
        $this->char = $char;
        $this->setAttributes("Char");
    }
    
    /**
     * The fill method, fill in this table row with table cells.
     * @param ArrayList  $cells
     * @param Int  $index
     * @access public
     * @return Void
     */
    public function fill($cells, $index = -1)
    {
        if ($index != -1) {
            $this->currentIndex = $index;
        }
        $iterator = $cells->iterator();
        while ($iterator->hasNext()) {
            $cell = $iterator->next();
            if ($cell instanceof TCell) {
                $this->add($cell, $index);
            } else {
                $this->add(new TCell($cell->getValue()), $index);
            }
            if ($index != -1) {
                $index++;
            }
        }
    }
    
    /**
     * Magic method __toString for TRow class, it reveals that the class is a Table Row.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is The Table Row class.");
    }
}
