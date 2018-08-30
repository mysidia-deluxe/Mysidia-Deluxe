<?php

/**
 * The Abstract SubController Class, extends from abstract controller class.
 * It is parent to all inner controllers of an outer appcontroller class.
 * If an action of an AppController has branches, it's usually taken care of by SubControllers.
 * @category Controller
 * @package CoreController
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2 
 * @todo Not much at this point.
 * @abstract
 *
 */
 
abstract class SubController extends Controller{
    
	/**
     * Constructor of SubController Class, which simply serves as a marker for child classes.
     * @access public
     * @return Void
     */
	public function __construct(){
	
	}
	
	/**
     * Magic method __toString for SubController class, it reveals that the class belong to corecontroller package.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia SubController class.");
	}
}
?>