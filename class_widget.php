<?php

/**
 * The Widget Class, which defines standard placeholders for a collection of Mysidia Module Blocks.
 * A widget is a subclass of GUIContainer, although its functionality is somewhat different from a GUI component.
 * @category Resource
 * @package Widget
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Widget extends GUI implements Renderable{

	/**
	 * The wid property, it defines the unique ID of a given Widget.
	 * @access protected
	 * @var Int
    */
    protected $wid = 0;

	/**
	 * The name property, it specifies the name of the Widget.
	 * @access protected
	 * @var String
    */
    protected $name;

	/**
	 * The division property, holds an division object of the entired rendered menu.
	 * @access protected
	 * @var Division
    */
    protected $division;

	/**
	 * The modules property, it stores an array of modules used in the placeholder.
	 * @access protected
	 * @var ArrayList
    */
    protected $modules;

	/**
     * Constructor of Widget Class, it initializes basic widget properties     
     * @access public
     * @return Void
     */
    public function __construct($wid, $name){
	    $mysidia = Registry::get("mysidia");
        $this->wid = $wid;
        $this->name = $name;
        $userLevel = ($mysidia->user->isloggedin)?"member":"visitor";

        $stmt = $mysidia->db->select("modules", array(), "widget = '{$this->name}' and (userlevel = '{$userLevel}' or userlevel = 'user') and status = 'enabled' ORDER BY `order`");

        while($module = $stmt->fetchObject()){
            $method = "set{$module->name}";
            if($this->hasMethod($method)) $this->$method();
            else $this->loadModule($module);     
        }
    }

	/**
     * The getID method, getter method for property $wid. 
     * @access public
     * @return String
     */
    public function getID(){
        return $this->wid;
    }

	/**
     * The getName method, getter method for property $name. 
     * @access public
     * @return String
     */
    public function getName(){
        return $this->name;
    }
		
	/**
     * The getModules method, getter method for property $modules. 
     * @access public
     * @return ArrayList
     */
    public function getModules(){
		return $this->modules;
    }
	
	/**
     * The addModules method, append a Module to the Widget. 
     * @access public
     * @return Void
     */
    public function addModules(Module $module){
		if(!$this->modules) $this->modules = new ArrayList;
		$this->modules->add($module);
    }

	/**
     * The loadModules method, autoload modules from database to the Widget. 
     * @access public
     * @return Void
     */	
    public function loadModule($module){
	    $mysidia = Registry::get("mysidia");
        $moduleContainer = new Paragraph();
        if($module->subtitle) $moduleContainer->add(new Comment($module->subtitle, TRUE, "b"));
        if($module->php) eval($module->php);
        if($module->html) $moduleContainer->add(new Comment($module->html));
		$this->setDivision($moduleContainer);     
    }
	

	/**
     * The getDivision method, getter method for property $division.
     * @access public
     * @return Division
     */
    public function getDivision(){
		return $this->division;
    }
	
	/**
     * The setDivision method, setter method for property $division.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param GUIComponent  $module
     * @access protected
     * @return Void
     */
    protected function setDivision(GUIComponent $module){
	    if(!$this->division){
		    $this->division = new Division;
		    $this->division->setClass($this->name);
		}	
		$this->division->add($module);
    }

	/**
     * The clear method, erase all modules inside this widget. 
     * @access public
     * @return Void
     */
    public function clear(){
		$this->modules = new ArrayList;
    }
	
	/**
     * The render method for Widget class, it loops through its modules and render them all.
     * @access public
     * @return GUIRenderer
     */
    public function render(){
        if(!$this->division) return;
        return $this->division->render();
    }
}
?>