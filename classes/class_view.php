<?php

use Resource\Native\Object;
use Resource\Native\Mystring;
use Resource\Collection\MapEntry;

/**
 * The Abstract View Class, extends from abstract object class.
 * It is parent to all view type classes, it handles the presentation layer of the main document.
 * @category View
 * @package View
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 * @abstract
 *
 */
 
abstract class View extends Object{

 	/**
	 * The action property, it stores the view action to execute.
	 * @access protected
	 * @var String
    */
	protected $action;
	
 	/**
	 * The controller property, it stores the name of controller that manipulates this view.
	 * @access protected
	 * @var Controller
    */	
	protected $controller;
	
 	/**
	 * The css property, it specifies if additional css is available for this view. 
	 * @access protected
	 * @var File
    */		
	protected $css;
	
 	/**
	 * The document property, it stores a reference to the document object to manipulate.
	 * @access protected
	 * @var Document
    */		
	protected $document;	

 	/**
	 * The fields property, it defines a map of key-value pairs passed from controller.
	 * @access protected
	 * @var HashMap
    */		
    protected $fields;	

 	/**
	 * The helper property, it specifies the view helper responsible for this View Class.
	 * @access protected
	 * @var ViewHelper
    */		
	protected $helper;

 	/**
	 * The js property, it specifies if additional javascript is available for this view. 
	 * @access protected
	 * @var File
    */		
	protected $js;		
	
 	/**
	 * The lang property, it specifies the local lang vars available to this view.
	 * @access protected
	 * @var Language
    */		
	protected $lang;
	
 	/**
	 * The plugins property, it defines a list of plugins that will be executed before view rendering.
	 * @access protected
	 * @var LinkedList
    */		
	protected $plugins;
	
 	/**
	 * The template property, it stores the template object for finalizing view rendering.
	 * @access protected
	 * @var Template
    */		
	protected $template;	
	
 	/**
	 * The theme property, it specifies the theme for the client user.
	 * @access protected
	 * @var String
    */		
	protected $theme;		
	
	/**
     * Constructor of View Class, which simply serves as a marker for child classes.
	 * @param Controller  $controller
     * @access public
     * @return Void
     */
	public function __construct(Controller $controller){
		$this->controller = $controller;
		$this->action = $controller->getAction();
        $this->fields = $controller->getFields();		
		$this->helper = new ViewHelper($this);
		
        $this->getCSS();
		$this->getDocument();
        $this->getJS();
        $this->getLangvars();
        $this->getPlugins();	
        $this->getTemplate();
        $this->getTheme();
	}	
	
	/**
     * The getAction method, getter method for property action.
     * @access public
     * @return String
     */		
	public function getAction(){
        return $this->action;   
	}	

	/**
     * The getController method, getter method for property controller.
     * @access public
     * @return Controller
     */		
	public function getController(){
        return $this->controller;   
	}	
	
	/**
     * The getCSS method, loads an additional css stylesheet if the file exists.
     * @access public
     * @return File
     */	
	public function getCSS(){
	    if(!$this->css) $this->css = $this->helper->getCSS();
		return $this->css;	
	}

	/**
     * The getDocument method, obtains the document object stored in the registry.
     * @access public
     * @return Document
     */		
	public function getDocument(){
        if(!$this->document) $this->document = $this->helper->getDocument();
        return $this->document;	    
	}

	/**
     * The getField method, acquires a certain field available in this view.
	 * @param String  $key
     * @access public
     * @return Objective
     */		
	public function getField($key){
        return $this->fields->get(new Mystring($key)); 
	}	
	
	/**
     * The getFields method, getter method for property $fields.
     * @access public
     * @return HashMap
     */		
	public function getFields(){
        return $this->fields; 
	}	

	/**
     * The getJS method, loads an additional javascript file if the file exists.
     * @access public
     * @return File
     */	
	public function getJS(){
	    if(!$this->js) $this->js = $this->helper->getJS();
		return $this->js;	
	}	
	
	/**
     * The getLangvars method, retrieves the local lang vars specific to this view.
     * @access public
     * @return Language
     */		
	public function getLangvars(){
        if(!$this->lang) $this->lang = $this->helper->getLangvars();
        return $this->lang;	    
	}

	/**
     * The getPlugins method, assigns and executes the plugins for the view object.
     * @access public
     * @return LinkedList
     */		
	public function getPlugins(){
	    // Not available now, so return Void for now.
		return;
	}
	
	/**
     * The getTemplate method, getter method for property $template.
     * @access public
     * @return Template
     */		
	public function getTemplate(){
        if(!$this->template) $this->template = $this->helper->getTemplate();
        return $this->template;	 
	}	

	/**
     * The getTheme method, getter method for property $theme.
     * @access public
     * @return Theme
     */		
	public function getTheme(){
        if(!$this->theme) $this->theme = $this->helper->getTheme();
        return $this->theme;		
	}		
	
	/**
     * The index method, displays default index page to the client user.
     * @access public
     * @return Void
     */	
	public function index(){
	    $document = $this->document;
	    $document->setTitle($this->lang->default_title);
        $document->addLangvar($this->lang->default);	
	}	
	
	/**
     * The loadPlugin method, assigns and executes the plugins for this view.
     * @access public
     * @return Void
     */		
	public function loadPlugin(){
	    // Not available now, so return Void for now.
		return;
	}

	/**
     * The redirect method, redirect the user to a certain page after a few secs.
     * @param Int  $time
     * @param String  $location
     * @access public
     * @return Void
     */	
    public function redirect($time, $location){
        header("Refresh:{$time}; URL='{$location}'");
    }

	/**
     * The refresh method, refresh the page after a few secs.
     * @param Int  $time
     * @access public
     * @return Void
     */	
    public function refresh($time){
        $this->redirect($time, $_SERVER['REQUEST_URI']);
    }
	
	/**
     * The render method, renders the view to display the message on the screen.
	 * The script execution ends after this method is called.
     * @access public
     * @return Void
     */		
	public function render(){
	    if(!$this->template) throw new ViewException("Template engine not found, view cannot be rendered.");
		$this->template->setTheme($this->theme);
		$this->template->render();
        $this->template->output();
	}	
	
	/**
     * The trigerError method, shows a mild error message to the screen.
	 * The method is only supposed to be called by the front controller class.
     * @access public
     * @return Void
     */		
	public function triggerError(MapEntry $flag){
	    $title = (string)$flag->getKey();
		$message = (string)$flag->getValue();
		$document = $this->document;
		try{
	        $document->setTitle($this->lang->{$title});
		    $document->addLangvar($this->lang->{$message});
        }
		catch(LanguageException $lge){
	        $document->setTitle($this->lang->global_error);	
		    $document->addLangvar($message);	    
		}
	}	
	
	/**
     * Magic method __toString for View class, it reveals that the class belong to core view package.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is an instance of Mysidia View class.");
	}
}
?>