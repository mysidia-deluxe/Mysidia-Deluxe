<?php

/**
 * The THeader Class, extends from TCell class.
 * It defines a standard table header with the tag <th>, can be added to container Row. 
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class THeader extends TCell{

	/**
	 * The scope property, it defines the scope of this table header.
	 * @access protected
	 * @var String
    */
	protected $scope;
	
	/**
	 * The scopes property, it stores a list of available table header scopes.
	 * @access protected
	 * @var Array
    */
	protected $scopes = array("col", "colgroup", "row", "rowgroup");
	
	/**
     * Constructor of THeader Class, sets up basic table properties and calls parent constructor.  
	 * @param ArrayObject|String  $components
	 * @param String  $name
	 * @param String  $headers
	 * @param String  $width
	 * @param String  $event
     * @access publc
     * @return Void
     */
	public function __construct($components = "", $name = "", $headers = "", $width = "", $event = ""){
        parent::__construct($components, $name, $headers, $width, $event);		
	}
	
	/**
     * The getScope method, getter method for property $scope.    
     * @access public
     * @return String
     */
	public function getScope(){
	    return $this->scope;    
	}

	/**
     * The setScope method, setter method for property $scope.
	 * @param String  $scope    
     * @access public
     * @return Void
     */
	public function setScope($scope){
	    $this->scope = $scope;
		$this->setAttributes("Scope");
	}
	
	/**
     * Magic method __toString for THeader class, it reveals that the class is a Table Header.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new String("This is The Table Cell class.");
	}
}
?>