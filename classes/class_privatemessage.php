<?php

class PrivateMessage extends Model implements Message{

    public $mid; 
    public $fromuser;
    public $touser;
    public $folder = "inbox";
    public $status;
    public $datesent;
    public $messagetitle;
    public $messagetext;
    public $postbar;

    public function __construct($mid = 0, $folder = "inbox", $notifier = FALSE){	 
	    $mysidia = Registry::get("mysidia");	  
	    if($mid == 0){
	        //This is a new private message not yet exist in database
		    $this->mid = $mid;
		    $this->fromuser = $mysidia->user->username;
		    $this->folder = ($folder == "inbox")?$this->folder:$folder;
	    }
	    else{
	        // The private message is not being composed, so fetch the information from database
		    switch($folder){
		        case "inbox":
	            $row = $mysidia->db->select("messages", array(), "id ='{$mid}'")->fetchObject();
		        if(!is_object($row)) throw new MessageNotfoundException;
                $this->mid = $row->id;		   
		        break;
		        default:
		        $row = $mysidia->db->select("folders_messages", array(), "mid ='{$mid}'")->fetchObject();
		        if(!is_object($row)) throw new MessageNotfoundException;
		        $this->mid = $row->mid;
		    }	    		
		
            foreach($row as $key => $val){
	            // For field usergroup, instantiate a Usergroup Object
		        $idarray = array("id", "mid");
	            if(!in_array($key, $idarray)) $this->$key = $val;
                if($notifier == TRUE) $this->getnotifier();			
            }
	    }
    }
  
    public function gettitle(){
        if(!empty($this->messagetitle)) return $this->messagetitle;
	    else return FALSE;
    }
  
    public function getcontent(){
        if(!empty($this->messagetext)) return $this->messagetext;
	    else return FALSE;
    }

    public function getnotifier(){
        if(is_object($this->notifier)) throw new MessageException("A PM Notifier already exists...");
	    else $this->notifier = new PmNotifier;
    }

    public function getEditor(){
        $mysidia = Registry::get("mysidia");
	    if (defined("SUBDIR") and SUBDIR == "AdminCP") include_once("../inc/ckeditor/ckeditor.php"); 
        else include_once ("inc/ckeditor/ckeditor.php"); 
	    $editor = new CKEditor;
        $editor->basePath = "{$mysidia->path->getAbsolute()}/inc/ckeditor/";
        return $editor;	
    }
  
    public function getPostbar(){
        if($this->mid == 0) return FALSE;
        $sender = new Member($this->fromuser);
	    $sender->getprofile();
	    $this->postbar = new Table("postbar", "100%", FALSE);
        $postHeader = new TRow;
	    $postHeader->add(new TCell(new Image($sender->profile->getAvatar())));
	    $postHeader->add(new TCell("<b>Member Since: </b><br>{$sender->membersince}<br> <b>Bio:</b><br>{$sender->profile->getBio()}<br> "));
	    $postHeader->add(new TCell("<b>Nickname:</b> {$sender->profile->getNickname()}<br><b>Gender:</b> {$sender->profile->getGender()}<br><b>Cash:</b> <a href='../../donate'>{$sender->money}</a><br>"));
	    $this->postbar->add($postHeader); 
        return $this->postbar; 			 
    }
  
    public function setsender($username){
        $this->fromuser = $username;
    }
  
    public function setrecipient($username){
        $this->touser = $username;
    }

    public function setmessage($title, $text){
        if(empty($title) or empty($text)) throw new Exception("Cannot set an empty private message");
	    else{
	        $this->messagetitle = $title;
		    $this->messagetext = $text;
	    }
    }
  
    public function getMessage(){
        if($this->mid == 0) return FALSE;
	    else{
	        // We are reading this PM now!		
		    $mysidia = Registry::get("mysidia");
		    $pmformat = "<table width='100%' border='4' cellpadding='3' cellspacing='0' bordercolor='1'>
					     <td><table width='100%' border='3' cellpadding='3' cellspacing='0' bordercolor='1'>
					     <tr><td width='100%' class='tr><strong>Date Received: {$this->datesent}</strong></td>
					     </tr></table>
					     <table width='100%' border='2' cellpadding='3' cellspacing='0' bordercolor='1'>
					     <tr><td class='trow'><center><a href='../../profile.php/{$this->fromuser}' target='_blank'>{$this->fromuser}</a> sent you this PM.</center><br />{$this->getPostbar()->render()}</td></tr>
					     <tr><td class='trow'><center><strong>{$this->messagetitle}<br />_______________________________</strong></center><br /><strong><center>{$this->format($this->messagetext)}</strong></center></td>
					     </tr></table>
					     <table width='100%' border='1' cellpadding='3' cellspacing='0' bordercolor='1'>
					     <tr><td width='100%' colspan='2' class='tr'><strong><b><a href='../../messages'><img src='{$mysidia->path->getAbsolute()}templates/icons/next.gif' border=0> Return to Inbox</a> | <a href='../../messages/newpm/{$this->fromuser}'><img src='{$mysidia->path->getAbsolute()}templates/icons/comment.gif' border=0> Reply to this Message</a> | <a href='../../messages/report/{$this->mid}'><img src='{$mysidia->path->getAbsolute()}templates/icons/next.gif' border=0> Report this member</a></b></strong></td>
					     </tr></table>
					     </td></table><br />";
	        $message = new Division("message");
		    $message->add(new Comment($pmformat));			 
            return $message;		 
	    }
    }
  
    public function setRead($status){
        $mysidia = Registry::get("mysidia");
	    $mysidia->db->update("messages", array("status" => 'read'), "id='{$this->mid}'");
    }
  
    public function post($user = ""){
        $mysidia = Registry::get("mysidia");
	    $date = new DateTime;
        if(!$this->messagetitle) $this->messagetitle = $mysidia->input->post("mtitle");
	    if(!$this->messagetext) $this->messagetext = $this->format($mysidia->input->post("mtext")); 
	    $mysidia->db->insert("messages", array("id" => NULL, "fromuser" => $this->fromuser, "touser" => $this->touser, "status" => "unread", "datesent" => $date->format("Y-m-d"), "messagetitle" => $this->messagetitle, "messagetext" => $this->messagetext));     
	  
	    if($mysidia->input->post("outbox") == "yes"){
	        $mysidia->db->insert("folders_messages", array("mid" => NULL, "fromuser" => $mysidia->user->username, "touser" => $mysidia->input->post("recipient"), "folder" => "outbox", "datesent" => $date->format("Y-m-d"), "messagetitle" => $mysidia->input->post("mtitle"), "messagetext" => $this->format($mysidia->input->post("mtext"))));
	    }
        if(is_numeric($mysidia->input->post("draftid"))){
            $mysidia->db->delete("folders_messages", "mid='{$mysidia->input->post("draftid")}' and fromuser='{$mysidia->user->username}'");
        } 
	    return TRUE;
    }
  
    public function postDraft($user = ""){
        $mysidia = Registry::get("mysidia");
	    $date = new DateTime;
        if(!$this->messagetitle) $this->messagetitle = $mysidia->input->post("mtitle");
	    if(!$this->messagetext) $this->messagetext = $this->format($mysidia->input->post("mtext")); 
	    $mysidia->db->insert("folders_messages", array("mid" => NULL, "fromuser" => $mysidia->user->username, "touser" => $mysidia->input->post("recipient"), "folder" => $this->folder, "datesent" => $date->format("Y-m-d"), "messagetitle" => $mysidia->input->post("mtitle"), "messagetext" => $this->format($mysidia->input->post("mtext"))));     
	    return TRUE;
    }
  
    public function editDraft($user = ""){
        $mysidia = Registry::get("mysidia");
	    $date = new DateTime;
        if(!$this->messagetitle) $this->messagetitle = $mysidia->input->post("mtitle");
        if(!$this->messagetext) $this->messagetext = $this->format($mysidia->input->post("mtext")); 
	    $mysidia->db->update("folders_messages", array("fromuser" => $this->fromuser, "touser" => $this->touser, "folder" => "draft", "datesent" => $date->format("Y-m-d"), "messagetitle" => $this->messagetitle, "messagetext" => $this->messagetext), "fromuser='{$mysidia->user->username}' and mid='{$mysidia->input->post("id")}'");
        return TRUE;
    }
  
    public function remove(){
        $mysidia = Registry::get("mysidia");
	    if($this->mid == 0) return FALSE;
	    if($this->folder == "inbox") $mysidia->db->delete("messages", "touser='{$mysidia->user->username}' and id='{$this->mid}'");
        else $mysidia->db->delete("folders_messages", "fromuser='{$mysidia->user->username}' and mid='{$this->mid}' and folder='{$this->folder}'");
	    return TRUE;
    }
  
    public function report(){
        $mysidia = Registry::get("mysidia");
	    $date = new DateTime;	 
        if(!$this->messagetitle) $this->messagetitle = $mysidia->input->post("mtitle");
	    if(!$this->messagetext) $this->messagetext = $this->format($mysidia->input->post("mtext")); 
        $mysidia->db->insert("messages", array("id" => NULL, "fromuser" => $mysidia->user->username, "touser" => $mysidia->input->post("recipient"), "status" => "unread", "datesent" => $date->format("Y-m-d"), "messagetitle" => $this->messagetitle, "messagetext" => $this->messagetext));     
	    return TRUE; 	
    }

    public function format($text){
        $text = html_entity_decode($text);
        $text = stripslashes($text);
        $text = str_replace("&nbsp;","",$text);
        return $text;
    }
  
	protected function save($field, $value){
		$mysidia = Registry::get("mysidia");
		$mysidia->db->update("messages", array($field => $value), "id='{$this->mid}'");
	}  
}
?>