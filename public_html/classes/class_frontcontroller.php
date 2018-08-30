<?php

/**
 * The Abstract FrontController Class, extends from abstract controller class.
 * It is parent to all frontcontroller type classes, there's one front controller for main site, ACP and installation wizard.
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
 
abstract class FrontController extends Controller{
 
	/**
	 * The appController property, holds a reference to the app-controller available for this front-controller.
	 * @access protected
	 * @var appController
    */
	protected $appController; 

	/**
	 * The metaController property, stores a reference to the root meta-controller object.
	 * @access protected
	 * @var metaController
    */
	protected $metaController;  	

	/**
     * Constructor of FrontController Class, which initializes basic controller properties.
     * @access public
     * @return Void
     */
	public function __construct($access = ""){
	    $mysidia = Registry::get("mysidia");
		$this->name = $mysidia->input->get("frontcontroller");	
	}	
	
	/**
     * The getappController method, getter method for property $appController.
     * @access public
     * @return AppController
     */	
	public function getAppController(){
	    return $this->appController;
	}		
	
	/**
     * The getRequest method, it acquires user request and applies basic operations.
     * @access public
     * @return Boolean
     */
	public function getRequest(){
	    $mysidia = Registry::get("mysidia");
        $dir = ($this->name == "index")?"":"{$this->name}/";
		$file = "{$mysidia->path->getRoot()}{$dir}{$mysidia->input->get("appcontroller")}.php";		
		return $this->hasAppController($file); 
	}

	/**
     * The getView method, getter method for property $view.
     * @access public
     * @return View
     */	
	public function getView(){
	    if(!$this->view){ 
	        if($this->appController instanceof AppController) $this->view = $this->appController->getView();
		    else $this->loadView($this->name);
		}	
		return $this->view;
	}	

	/**
     * The hasAppController method, checks if the app-controller exists in the given directory.
	 * @param String  $file
     * @access private
     * @return Boolean
     */		
	private function hasAppController($file){
	    $mysidia = Registry::get("mysidia");
        if($mysidia->input->get("appcontroller") == "index") $appControllerExist = FALSE;
		elseif(file_exists($file)) $appControllerExist = TRUE;
		else $appControllerExist = FALSE;
        return $appControllerExist;	    
	}

	/**
     * The render method, it loads the corresponding view 
     * @access public
     * @return Void
     */		
	public function render(){
	    if($this->flags) $this->view->triggerError($this->flags);
		else{ 
            $action = ($this->action)?(string)$this->action:"index";
            $this->view->$action();
        }
	    $this->view->render();
	}
	
	/**
     * The appFrontController method, setter method for property $appController.
	 * @param AppController  $appController
     * @access public
     * @return FrontController
     */	
	public function setAppController(AppController $appController){
	    $this->appController = $appController;
	}		

	/**
     * The abstract handleRequest method, must be implemented by child classes.
     * @access public
     * @return Void
     * @abstract
     */	
	public abstract function handleRequest(); 
}
?>