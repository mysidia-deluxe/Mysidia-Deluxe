<?php

/**
 * The LevelSetting Class, extending from the abstract Setting class.
 * It acts as a wrapper for all settings for the Adopt-Level system.
 * LevelSetting is a final class, no child class shall derive from it.
 * @category Helper
 * @package Settings
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 */
 
final class LevelSetting extends Setting
{
  
    /**
     * The system property, defines if the adopt-level system is enabled.
     * @access public
     * @var String
    */
    public $system;
    
    /**
     * The method property, specifies the adoptables level-clicks mechanism.
     * @access public
     * @var String
    */
    public $method;
    
    /**
     * The maximum property, determines the max level an adoptable can reach.
     * @access public
     * @var Int
    */
    public $maximum;
    
    /**
     * The clicks property, stores the standard/template clicks required for each level.
     * @access public
     * @var Array
    */
    public $clicks;
    
    /**
     * The number property, the maximum number of times a member can click on an adoptable.
     * @access public
     * @var Int
    */
    public $number;
    
    /**
     * The reward property, it specifies the max and min amount of money that can be received through clicking on adoptables.
     * @access public
     * @var Array
    */
    public $reward;
    
    /**
     * The owner property, it determines whether users can click on their own adoptables.
     * @access public
     * @var String
    */
    public $owner;
  
    /**
     * Constructor of LevelSetting Class, it initializes basic setting parameters.
     * @param Database  $db
     * @access public
     * @return Void
     */
    public function __construct(Database $db = null)
    {
        if (!$db) {
            $db = Registry::get("database");
        }
        parent::__construct($db);
        $this->clicks = explode(",", $this->clicks);
        $this->reward = explode(",", $this->reward);
    }

    /**
     * The fetch method, returns all fields of LevelSetting object by fetching information from database.
     * @access public
     * @return Void
     */
    public function fetch($db)
    {
        $stmt = $db->select("levels_settings", array());
        while ($row = $stmt->fetchObject()) {
            $property = $row->name;
            $this->$property = $row->value;
        }
    }
  
    /**
     * The set method, set a field of LevelSetting object with a specific value.
     * @param String  $property
     * @param String|Number  $value
     * @access public
     * @return Void
     */
    public function set($property, $value)
    {
        $this->$property = $value;
    }
}
