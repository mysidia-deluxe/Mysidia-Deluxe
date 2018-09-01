<?php

use Resource\Native\Arrays;
use Resource\Native\Mystring;
use Resource\Collection\Collective;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

/**
 * The TableBuilder Class, extends from abstract TableContainer class.
 * It provides shortcut for building tables in quick manner.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class TableBuilder extends Table
{
        
    /**
     * The Helper property, determines the helper class used to process table content.
     * @access protected
     * @var TableHelper
    */
    protected $helper;
    
    /**
     * The methods property, specifies the methods to apply on each column data.
     * @access protected
     * @var LinkedHashMap
    */
    protected $methods;
    
    /**
     * The params property, specifies the additional params to pass to the helper methods.
     * @access protected
     * @var LinkedHashMap
    */
    protected $params;
    
    /**
     * Constructor of TableBuilder Class, it is very similar to Table class.
     * @param String  $name
     * @param String  $width
     * @param Boolean  $border
     * @param String  $event
     * @param ArrayList  $components
     * @access publc
     * @return Void
     */
    public function __construct($name = "", $width = "", $bordered = true, $event = "", $components = "")
    {
        parent::__construct($name, $width, $bordered, $event, $components);
    }
        
    /**
     * The getHelper method, getter method for property $helper.
     * @access public
     * @return TableHelper
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * The setHelper method, setter method for property $helper.
     * @param TableHelper  $helper
     * @access public
     * @return Void
     */
    public function setHelper(TableHelper $helper)
    {
        $this->helper = $helper;
    }
    
    /**
     * The getMethods method, getter method for property $methods.
     * @access public
     * @return LinkedHashMap
     */
    public function getMethods()
    {
        return $this->methods;
    }
    
    /**
     * The setMethod method, setter method for property $methods.
     * It takes care of only specified field.
     * @param String  $field
     * @param String  $method
     * @access public
     * @return Void
     */
    public function setMethod($field, $method)
    {
        if (!$this->methods) {
            $this->methods = new LinkedHashMap;
        }
        $this->methods->put(new Mystring($field), new Mystring($method));
    }

    /**
     * The setMethods method, setter method for property $methods.
     * Different from setMethod method, it attempts to set methods for many fields.
     * @param LinkedHashMap  $methods
     * @param Boolean  $overwrite
     * @access public
     * @return Void
     */
    public function setMethods(LinkedHashMap $methods, $overwrite = false)
    {
        if (!$this->methods) {
            $this->methods = new LinkedHashMap;
        }
        if ($overwrite) {
            $this->methods = $methods;
        } else {
            $iterator = $methods->iterator();
            while ($iterator->hasNext()) {
                $entry = $iterator->next();
                $this->methods->put($entry->getKey(), $entry->getValue());
            }
        }
    }
    
    /**
     * The getParams method, getter method for property $params.
     * @access public
     * @return LinkedHashMap
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * The setParams method, setter method for property $params.
     * @param String  $field
     * @param Mixed  $params
     * @access public
     * @return Void
     */
    public function setParams($field, $params)
    {
        if (!$this->params) {
            $this->params = new LinkedHashMap;
        }
        $this->params->put(new Mystring($field), $params);
    }
    
    /**
     * The buildCell method, build a table cell to the current table row.
     * You can enter a method for the specified helper to process the cell content.
     * @param String|TCell  $cell
     * @param String  $method
     * @access public
     * @return TableBuilder
     */
    public function buildCell($cell, $method = null)
    {
        $row = $this->component[$this->currentIndex];
        if (!($row instanceof TRow)) {
            throw new GUIException("The current table row is invalid.");
        }
        if ($method) {
            $cell = $this->helper->execMethod($cell, $method);
        }
        $row->add($cell);
        return $this;
    }
    
    /**
     * The buildHeaders method, build a row of table headers to the current table.
     * It is usually applied to the very beginning of the table object instantiation.
     * @access public
     * @return TableBuilder
     */
    public function buildHeaders()
    {
        $headers = Arrays::fromArray(func_get_args());
        $size = $headers->getSize();
        $row = new TRow;
        
        for ($i = 0; $i < $size; $i++) {
            if ($headers[$i] instanceof THeader) {
                $row->add($headers[$i]);
            } else {
                $row->add(new THeader($headers[$i]));
            }
        }
        $this->add($row);
        return $this;
    }
    
    /**
     * The buildRow method, build a table row with the given parameters as table cells and methods.
     * If no argument is supplied, it will build an empty row pending for action.
     * @param Collective  $fields
     * @access public
     * @return TableBuilder
     */
    public function buildRow(Collective $fields)
    {
        $row = new TRow;
        $iterator = $fields->iterator();
        
        if ($fields instanceof LinkedList) {
            while ($iterator->hasNext()) {
                $field = $iterator->next();
                if ($field instanceof TCell) {
                    $row->add($field);
                } elseif ($field instanceof Mystring) {
                    $row->add(new TCell($field->getValue()));
                } else {
                    $row->add(new TCell($field));
                }
            }
        } elseif ($fields instanceof LinkedHashMap) {
            while ($iterator->hasNext()) {
                $entry = $iterator->next();
                $field = $entry->getKey();
                $method = $entry->getValue();
                if ($field instanceof TCell) {
                    $row->add($field->getValue());
                } elseif ($this->helper and $method) {
                    $cell = $this->helper->execMethod($field->getValue(), $method->getValue());
                    $row->add(new TCell($cell));
                } else {
                    $row->add(new TCell($field->getValue()));
                }
            }
        } else {
            throw new GUIException("Supplied Collection type is invalid!");
        }
        
        $this->add($row);
        return $this;
    }
    
    /**
     * The buildTable method, build an entire table from sql database.
     * It is possible to specify fields used to construct this table.
     * @param PDOStatement  $stmt
     * @param Collective  $fields
     * @access public
     * @return Void
     */
    public function buildTable(PDOStatement $stmt, Collective $fields)
    {
        while ($dataRow = $stmt->fetchObject()) {
            $tableRow = new TRow;
            $iterator = $fields->iterator();
            if ($fields instanceof LinkedList) {
                while ($iterator->hasNext()) {
                    $field = $iterator->next();
                    if ($field instanceof TCell) {
                        $tableRow->add($dataRow->$field);
                    } elseif ($field instanceof Mystring) {
                        $tableRow->add(new TCell($dataRow->{$field->getValue()}));
                    } else {
                        $tableRow->add(new TCell($dataRow->$field));
                    }
                }
            } elseif ($fields instanceof LinkedHashMap) {
                while ($iterator->hasNext()) {
                    $entry = $iterator->next();
                    $field = $entry->getKey();
                    $method = $entry->getValue();
                    if ($this->helper and $method) {
                        $column = $this->helper->getField($field->getValue());
                        $cell = $this->helper->execMethod($dataRow->$column, $method->getValue());
                    } else {
                        $cell = $dataRow->{$field->getValue()};
                    }
                    $tableRow->add(new TCell($cell));
                }
            } else {
                throw new GUIException("Supplied Collection type is invalid!");
            }
            $this->add($tableRow);
        }
    }
    
    /**
     * Magic method __toString for TableBuilder class, it reveals that the class is a TableBuilder.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is The TableBuilder class.");
    }
}
