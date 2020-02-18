<?php

/**
 * The BreedingSetting Class, extending from the abstract Setting class.
 * It acts as a wrapper for all settings for the breeding system.
 * BreedingSetting is a final class, no child class shall derive from it.
 * @category Helper
 * @package Settings
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 */
 
final class BreedingSetting extends Setting
{
  
    /**
     * The system property, defines if the breeding system is enabled.
     * @access public
     * @var String
    */
    public $system;
    
    /**
     * The method property, specifies whether the breeding method is heuristic or advanced.
     * @access public
     * @var String
    */
    public $method;
    
    /**
     * The species property, stores a list of adoptables species not available to breed.
     * @access public
     * @var Array
    */
    public $species;
  
    /**
     * The interval property, the number of days successive breeding can occur for adoptables.
     * @access public
     * @var Int
    */
    public $interval;
    
    /**
     * The level property, the minimum level required for breeding eligibility.
     * @access public
     * @var Int
    */
    public $level;
    
    /**
     * The capacity property, the total number of times an adoptable can breed.
     * @access public
     * @var Int
    */
    public $capacity;
    
    /**
     * The number property, the maximum number of babies an adoptable can produce.
     * @access public
     * @var Int
    */
    public $number;
    
    /**
     * The chance property, the chance for breeding to be successful. Must be somewhere between 0 or 100.
     * @access public
     * @var Int
    */
    public $chance;
    
    /**
     * The cost property, the amount of money required to spend on breeding.
     * @access public
     * @var Int
    */
    public $cost;
    
    /**
     * The usergroup property, the usergroup(s) allowed to breed their adoptables.
     * The default value is 'all', which means no limitation on usergroup.
     * @access public
     * @var String|Array
    */
    public $usergroup;
    
    /**
     * The item property, the item(s) certificate required to breed adoptables.
     * @access public
     * @var String|Array
    */
    public $item;
  
    /**
     * Constructor of BreedingSetting Class, it initializes basic setting parameters.
     * @param Database  $db
     * @access public
     * @return Void
     */
    public function __construct(Database $db)
    {
        parent::__construct($db);
        if ($this->species) {
            $this->species = explode(",", $this->species);
        }
        if ($this->usergroup != "all") {
            $this->usergroup = explode(",", $this->usergroup);
        }
        if ($this->item) {
            $this->item = explode(",", $this->item);
        }
    }

    /**
     * The fetch method, returns all fields of BreedingSetting object by fetching information from database.
     * @access public
     * @return Void
     */
    public function fetch($db)
    {
        $stmt = $db->select("breeding_settings", array());
        while ($row = $stmt->fetchObject()) {
            $property = $row->name;
            $this->$property = $row->value;
        }
    }
  
    /**
     * The set method, set a field of BreedingSetting object with a specific value.
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
