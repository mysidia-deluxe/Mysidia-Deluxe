<?php

/**
 * The UserTableHelper Class, extends from TableHelper class.
 * It is a specialized helper class to manipulate user related tables.
 * @category Resource
 * @package Helper
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class UserTableHelper extends TableHelper{

    /**
     * Constructor of UserTableHelper Class, it simply serves as a wrap-up.
     * @access public
     * @return Void
     */
	public function __construct(){
	    parent::__construct();       
	}

	/**
     * The getUsername method, wraps up the table cell with the appropriate Username.   
     * @param String  $param
     * @access protected
     * @return String
     */
	protected function getUsername($param){
	    if(!$param) return "Guest";
        else return $param;
	}
	
	/**
     * The getProfileLink method, wraps up the table cell with a user profile link.   
     * @param String  $param
     * @access protected
     * @return Link
     */
	protected function getProfileLink($param){
	    $path = Registry::get("path");
	    $url = new URL("{$path->getAbsolute()}profile/view/{$param}");
		return new Link($url, $param);
	}
		
	/**
     * The getProfileImage method, wraps up the table cell with a user profile image.   
     * @param String  $param
     * @access protected
     * @return Comment|Link
     */
	protected function getProfileImage($param){
	    if($param == "Guest") return new Comment("N/A", FALSE);
	    $path = Registry::get("path");
	    $url = new URL("{$path->getAbsolute()}profile/view/{$param}");
		$image = new Image("templates/buttons/profile.gif");
		return new Link($url, $image);
	}
	
	/**
     * The getPMImage method, wraps up the table cell with a user pm image.   
     * @param String  $param
     * @access protected
     * @return Comment|Link
     */
	protected function getPMImage($param){
	    if($param == "Guest") return new Comment("N/A", FALSE);
	    $path = Registry::get("path");
	    $url = new URL("messages/newpm/{$param}");
		$image = new Image("templates/buttons/pm.gif");
		return new Link($url, $image);
	}

	/**
     * Magic method __toString for UserTableHelper class, it reveals that the object is a user table helper.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia UserTableHelper class.");
	}    
} 
?>