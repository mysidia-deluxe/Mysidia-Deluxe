<?php

use Resource\Native\Object;
use Resource\Native\Mystring;
use Resource\Collection\MapEntry;

/**
 * The Abstract Controller Class, extends from abstract object class.
 * It is parent to all controller type classes, including front, app and sub controllers.
 * @category Controller
 * @package Controller
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2 
 * @todo Not much at this point.
 * @abstract
 *
 */
 
abstract class Controller extends Object{

	/**
	 * The action property, defines the action for this controller.
	 * @access protected
	 * @var String
    */
	protected $action;

  	/**
	 * The flags property, it defines the error flags for the controller to pass onto view. 
	 * @access protected
	 * @var MapEntry
    */			
	protected $flags;
	
 	/**
	 * The model property, specifies the default model class for this app-controller.
	 * @access protected
	 * @var Model
    */
	protected $model = "Model"; 	
	
	/**
	 * The name property, specifies the name for the current controller.
	 * @access protected
	 * @var String
    */
	protected $name;	
	
  	/**
	 * The view property, it stores a reference to the view object for this controller.
	 * @access protected
	 * @var View
    */			
	protected $view;	

	/**
     * The getAction method, getter method for property $action.
     * @access public
     * @return String
     */	
	public function getAction(){
	    return $this->action;
	}	
	
	/**
     * The getFlags method, getter method for property flags.
     * @access public
     * @return MapEntry
     */			
	public function getFlags(){
	    return $this->flags;  
	}

	/**
     * The getFields method, getter method for property fields.
     * @access public
     * @return NULL
     */		
	public function getFields(){
        return NULL;
	}	

	/**
     * The getModel method, getter method for property $model.
     * @access public
     * @return Model
     */	
	public function getModel(){
	    if(!$this->model) $this->$model = new $model;
	    return $this->model;
	}		
	
	/**
     * The getName method, getter method for property name.
     * @access public
     * @return MapEntry
     */			
	public function getName(){
	    return $this->name;  
	}	

	/**
     * The index method, construct a default index page.
	 * Actual view construction is delegated to view class itself.
	 * As a consequence, this method exists for the sole purpose for reflection method to work.
	 * Child classes may override this method if business logic is involved with index page.
     * @access public
     * @return Void
     */		
	public function index(){
		
	}	

	/**
     * The loadModel method, it loads the corresponding view for the controller.
	 * @param String  $name
     * @access public
     * @return View
     */	
	public function loadModel($name){
	    $model = $name;
		$this->$model = new $model;
	}	
	
	/**
     * The loadView method, it loads the corresponding view for the controller.
	 * @param String  $name
     * @access public
     * @return View
     */	
	public function loadView(mystring $name){
		$view = $name->capitalize()->concat("View")->getValue();
		$this->view = new $view($this);
	}

	/**
     * The setFields method, setter method for property $fields.
	 * @param HashMap  $fields
     * @access protected
     * @return Void
     */	
	protected function setFields(HashMap $fields){
	    $this->fields = $fields;
	}
	
	/**
     * The setFlags method, setter method for property flags.
	 * @param String  $param
	 * @param String  $param2
     * @access public
     * @return Void
     */		
	public function setFlags($param, $param2 = NULL){
	    if(!$param2) $param2 = $param;
        $this->flags = new MapEntry(new Mystring($param), new Mystring($param2));
	}
	
	/**
     * Magic method __toString for Controller class, it reveals the class name of this controller.
	 * With this method, it is possible to use the controller class easily in string context.
     * @access public
     * @return String
     */
    public function __toString(){
	    return (mystring)$this->name;
	}
		
	/**
     * The abstract getView method, must be implemented by child classes.
     * @access public
     * @return Void
     * @abstract
     */		
	public abstract function getView();
}
?>