<?php

/**
 * The DaycareSetting Class, extending from the abstract Setting class.
 * It acts as a wrapper for all settings for the daycare center of the leveling system.
 * DaycareSetting is a final class, no child class shall derive from it.
 * @category Helper
 * @package Settings
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 */
 
final class DaycareSetting extends Setting{
  
	/**
	 * The system property, defines if the daycare center is enabled.
	 * @access public
	 * @var String
    */
    public $system;
	
	/**
	 * The display property, defines the display method.
	 * @access public
	 * @var String
    */	
	public $display;
		
	/**
	 * The number property, the maximum number of adoptables to be displayed on a page.
	 * @access public
	 * @var Int
    */
    public $number;	
	
	/**
	 * The columns property, the maximum columns of adoptables to be displayed on a page.
	 * @access public
	 * @var Int
    */
    public $columns;	
	
	/**
	 * The level property, the maximum level required for daycare center eligibility.
	 * @access public
	 * @var Int
    */
    public $level;
	
	/**
	 * The species property, stores a list of adoptables species not eligible to show up in daycare center.
	 * @access public
	 * @var Array
    */	
	public $species;	
	
	/**
	 * The info property, the stats to be shown in daycare center.
	 * @access public
	 * @var String|Array
    */
    public $info;		
	
	/**
	 * The owned property, specifies if the owner's adoptables will appear in daycare center.
	 * @access public
	 * @var String
	 */
	public $owned;
  
    /**
     * Constructor of DaycareSetting Class, it initializes basic setting parameters.
	 * @param Database  $db
     * @access public
     * @return Void
     */
    public function __construct(Database $db){
	    parent::__construct($db);		
	    if($this->species) $this->species = explode(",", $this->species);	
		if($this->info) $this->info = explode(",", $this->info);
    }

	/**
     * The fetch method, returns all fields of DaycareSetting object by fetching information from database.
     * @access public
     * @return Void
     */
    public function fetch($db){
        $stmt = $db->select("daycare_settings", array());
	    while($row = $stmt->fetchObject()){
	        $property = $row->name;
	        $this->$property = $row->value;
	    }	 
    }
  
  	/**
     * The set method, set a field of DaycareSetting object with a specific value.
	 * @param String  $property    
	 * @param String|Number  $value    
     * @access public
     * @return Void
     */
    public function set($property, $value){
        $this->$property = $value;
    }
}
?>