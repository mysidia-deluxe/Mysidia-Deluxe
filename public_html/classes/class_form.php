<?php

/**
 * The Form Class, extends from abstract GUIContainer class.
 * It is a flexible PHP form class, can perform a series of operations.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class Form extends GUIContainer{
	
	/**
	 * The action property, it specifies where form will be sent to.
	 * @access protected
	 * @var String
    */
	protected $action;
	
	/**
	 * The enctype property, a property required for upload forms.
	 * @access protected
	 * @var String
    */
	protected $enctype;
	
	/**
	 * The method property, defines whether the form is a get or post form.
	 * The default form method is post, with URL Rewrite get forms are not recommended.
	 * @access protected
	 * @var String
    */
	protected $method = "post";
	
		/**
	 * The target property, it specifies where to display the response.
	 * @access protected
	 * @var String
    */
	protected $target;
	
	/**
	 * The accept property, specifies the acceptable characters.
	 * @access protected
	 * @var String
    */
	protected $accept;
	
	/**
     * Constructor of Form Class, sets up basic form properties.   
	 * @param String  $name
	 * @param String  $action
	 * @param String  $method
	 * @param String  $event
	 * @param ArrayList  $components
     * @access public
     * @return Void
     */
	public function __construct($name = "", $action = "", $method = "", $event = "", $components = ""){
        parent::__construct($components); 
        if(!empty($name)){
		    $this->setName($name);
			$this->setID($name);
		}
		if(!empty($action)) $this->setAction($action);
		if(!empty($method)) $this->setMethod($method);
		if(!empty($event)) $this->setEvent($event);
        $this->renderer = new FormRenderer($this);				
	}
	
	/**
     * The getAction method, getter method for property $action.    
     * @access public
     * @return String
     */
	public function getAction(){
	    return $this->action;    
	}

	/**
     * The setAction method, setter method for property $action.
	 * @param String  $action    
     * @access public
     * @return Void
     */
	public function setAction($action){
	    $this->action = $action;
		$this->setAttributes("Action");
	}
	
	/**
     * The getMethod method, getter method for property $method.    
     * @access public
     * @return String
     */
	public function getMethod(){
	    return $this->method;    
	}

	/**
     * The setMethod method, setter method for property $method.
	 * @param String  $method    
     * @access public
     * @return Void
     */
	public function setMethod($method){
	    if($method != "post" and $method != "get") throw new GUIException("The form method is invalid.");
	    $this->method = $method;
		$this->setAttributes("Method");
	}
	
	/**
     * The getEnctype method, getter method for property $enctype.    
     * @access public
     * @return String
     */
	public function getEnctype(){
	    return $this->enctype;    
	}

	/**
     * The setEnctype method, setter method for property $enctype.
	 * @param String  $enctype  
     * @access public
     * @return Void
     */
	public function setEnctype($enctype){
	    $this->enctype = $enctype;
		$this->setAttributes("Enctype");
	}
	
	/**
     * The getTarget method, getter method for property $target.    
     * @access public
     * @return String
     */	
	public function getTarget(){
	    return $this->target;
	}
	
	/**
     * The setTarget method, setter method for property $target.
	 * @param String  $target  
     * @access public
     * @return Void
     */
	public function setTarget($target){
	    $targets = array("blank", "parent", "self", "top");
		if(!in_array($target, $targets)) throw new GUIException("The link target is invalid...");
		$this->target = $target;
		$this->setAttributes("Target");
	}
	
	/**
     * The getAccept method, getter method for property $accept.    
     * @access public
     * @return String
     */	
	public function getAccept(){
	    return $this->accept;
	}
	
	/**
     * The setAccept method, setter method for property $accept.    
	 * @param String  $accept
     * @access public
     * @return Void
     */	
	public function setAccept($accept){
	    $this->accept = $accept;
		$this->setAttributes("Accept");
	}
	
	/**
     * Magic method __toString for Form class, it reveals that the class is a Form.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is The Form class.");
	}
}
?>