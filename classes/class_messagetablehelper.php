<?php

use Resource\Collection\ArrayList as ArrayList;

/**
 * The MessageTableHelper Class, extends from the TableHelper class.
 * It is a specific helper for tables that involves operations on messages.
 * @category Resource
 * @package Helper
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class MessageTableHelper extends TableHelper{

    /**
     * Constructor of MessageTableHelper Class, it initializes basic helper properties.
     * @access public
     * @return Void
     */
	public function __construct(){
	    parent::__construct();    
	}
	
	/**
     * The getProfile method, generates the sender/recipient profile field for the message table.
     * @param String  $param 
     * @access protected
     * @return Link|String
     */
    protected function getProfile($param){
	    if($param == "SYSTEM") return $param;
		return new Link("profile/view/{$param}", $param);
    }
	
	/**
     * The getRecipient method, generates the recipient field for the message table.
     * @param String  $param 
     * @access protected
     * @return Link|String
     */
    protected function getRecipient($param){
	    if($param == "SYSTEM") return $param;
		return new Link("profile/view/{$param}", $param);
    }
	
	/**
     * The getStatus method, gets the status of the message for the message table.
     * @param String  $param 
     * @access protected
     * @return Comment
     */
    protected function getStatus($param = ""){
	    $status = new Comment($param);
	    if($param == "unread") $status->setBold();
        return $status;		
    }
	
	/**
     * The getReadLink method, wraps up the inbox table cell with a read image/link.   
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getReadLink($param){
	    $path = Registry::get("path");
        $image = new Image("{$path->getAbsolute()}templates/icons/next.gif");
        $url = new URL("messages/read/{$param}", FALSE, FALSE);
        return new Link($url, $image);
    }
	
	/**
     * The getDeleteLink method, wraps up the inbox table cell with a delete image/link.   
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getDeleteLink($param){
	    $path = Registry::get("path");
        $image = new Image("{$path->getAbsolute()}templates/icons/delete.gif");
        $url = new URL("messages/delete/{$param}", FALSE, FALSE);
        return new Link($url, $image);
    }
	
	/**
     * The getOutboxReadLink method, wraps up the outbox table cell with a read image/link.   
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getOutboxReadLink($param){
	    $path = Registry::get("path");
        $image = new Image("{$path->getAbsolute()}templates/icons/next.gif");
        $url = new URL("messages/outboxread/{$param}", FALSE, FALSE);
        return new Link($url, $image);
    }
	
	/**
     * The getOutboxDeleteLink method, wraps up the outbox table cell with a delete image/link.   
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getOutboxDeleteLink($param){
	    $path = Registry::get("path");
        $image = new Image("{$path->getAbsolute()}templates/icons/delete.gif");
        $url = new URL("messages/outboxdelete/{$param}", FALSE, FALSE);
        return new Link($url, $image);
    }
	
	/**
     * The getDraftReadLink method, wraps up the draft table cell with a read image/link.   
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getDraftReadLink($param){
	    $path = Registry::get("path");
        $image = new Image("{$path->getAbsolute()}templates/icons/next.gif");
        $url = new URL("messages/draftedit/{$param}", FALSE, FALSE);
        return new Link($url, $image);
    }
	
	/**
     * The getDraftDeleteLink method, wraps up the draft table cell with a delete image/link.   
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getDraftDeleteLink($param){
	    $path = Registry::get("path");
        $image = new Image("{$path->getAbsolute()}templates/icons/delete.gif");
        $url = new URL("messages/draftdelete/{$param}", FALSE, FALSE);
        return new Link($url, $image);
    }

	/**
     * The getAvatarImage method, returns the avatar image suitable for VMlist.   
     * @param String  $avatar
     * @access protected
     * @return Image
     */
    public function getAvatarImage($avatar){
        return new Image($avatar, "avatar", 40);
    }

	/**
     * The getAvatarImage method, returns the avatar image suitable for VMlist.   
     * @param VisitorMessage  $vmessage
     * @access protected
     * @return ArrayList
     */
    public function getVisitorMessage($vmessage){
	    $date = substr_replace($vmessage->datesent," at ",10,1);
		$vmField = new ArrayList;
        $vmField->add(new Link("profile/view/{$vmessage->fromuser}", $vmessage->fromuser));
        $vmField->add(new Comment("({$date})", FALSE));
        $vmField->add(new Link("vmessage/view/{$vmessage->touser}/{$vmessage->fromuser}", new Image("templates/icons/status.gif"), TRUE));
        $vmField->add(new Comment($vmessage->vmtext));
        return $vmField;
    }

    /** The getManageActions method, retrieves the links of managing visitor messages.   
     * @param Int  $vid
     * @access protected
     * @return ArrayList
     */
    public function getManageActions($vid){
	    $action = new ArrayList;
	    $action->add(new Link("vmessage/edit/{$vid}", new Image("templates/icons/cog.gif")));
        $action->add(new Link("vmessage/delete/{$vid}", new Image("templates/icons/delete.gif"), TRUE));
        return $action;
    }
	
	/**
     * Magic method __toString for MessageTableHelper class, it reveals that the object is a message table helper.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia ItemTableHelper class.");
	}    
} 
?>