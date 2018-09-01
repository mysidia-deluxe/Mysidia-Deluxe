<?php

use Resource\Native\Object;
use Resource\Native\Mystring;

/**
 * The DatabaseStatement Class, it is part of the utility package and extends from the Object Class.
 * It acts as a wrapper for PDOStatement, which cannot be used in Collections Framework.
 * @category Resource
 * @package Utility
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this moment
 */

class DatabaseStatement extends Object
{

    /**
     * The stmt property, it stores the wrapped PDOStatement object.
     * @access protected
     * @var PDOStatement
    */
    protected $stmt;
 
    /**
     * The constructor for DatabaseStatement Class, it creates a DatabaseStatement object and initialize the context.
     * @param PDOStatement  $stmt
     * @access public
     * @return Void
     */
    public function __construct(PDOStatement $stmt = null)
    {
        $this->stmt = $stmt;
    }

    /**
     * Magic method __call for DatabaseStatement class, it delegates all method calls to the inner object.
     * @access public
     * @return Mixed
     */
    public function __call($method, $param)
    {
        return $this->stmt->$method($param);
    }
    
    /**
     * The get method, getter method for property $stmt.
     * @access public
     * @return PDOStatement
     */
    public function get()
    {
        return $this->stmt;
    }
    
    /**
     * The set method, setter method for property $stmt.
     * @param PDOStatement  $stmt
     * @access public
     * @return Void
     */
    public function set(PDOStatement $stmt = null)
    {
        $this->stmt = $stmt;
    }

    /**
     * Magic method __toString for DatabaseStatement class, it prints out the basic class information.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is The DatabaseStatement Class.");
    }
}
