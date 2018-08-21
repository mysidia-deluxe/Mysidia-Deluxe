<?php

use Resource\Native\Integer;
use Resource\Native\Mystring;
use Resource\Collection\HashMap;

class FriendsController extends AppController{

    const PARAM = "id";
    const PARAM2 = "confirm";
	private $friendlist;

    public function __construct(){
        parent::__construct("member");
		$mysidia = Registry::get("mysidia");			            
	    $mysidia->user->getstatus();	
		if($mysidia->user->status->canfriend == "no"){
		    throw new NoPermissionException("banned");
		}
		$this->friendlist = new Friendlist($mysidia->user); 
    }
	
	public function index(){
	    throw new InvalidActionException("global_action");
	}
	
	public function request(){
		$mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("id")) throw new InvalidIDException("friend_id");
		$friend = new Friend(new Member($mysidia->input->get("id")), $this->friendlist);
		
        if(!$friend->isfriend){	  
	        if($friend->sendrequest()) $this->setField("friend", new Mystring($friend->username));
			else throw new DuplicateIDException("<br>Invalid Action! This is a duplicate friend request between you and {$friend->username}.");
		}
        else throw new InvalidIDException("<br>Invalid Action! The user {$friend->username} is already on your friendlist.");
	}
			
	public function option(){
		$mysidia = Registry::get("mysidia");
	    $options = $mysidia->user->getoptions();			
		if($mysidia->input->post("submit")){
		    $currentUser = new Friend($mysidia->user, $this->friendlist);
		    $currentUser->setprivacy();	
		    return;
		}
		
		$optionsMap = new HashMap;
		$optionsMap->put(new Mystring("pmoption"), new Integer($options->pmstatus));
		$optionsMap->put(new Mystring("vmoption"), new Integer($options->vmstatus));
		$optionsMap->put(new Mystring("tradeoption"), new Integer($options->tradestatus));		
		$this->setField("optionsMap", $optionsMap);	
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		
	    switch($mysidia->input->get("confirm")){
            case "accept":	
 				$friendrequest = new FriendRequest($mysidia->input->get("id"));	
		        $friendrequest->setstatus("accepted");			       
                $sender = new Friend(new Member($friendrequest->fromuser), $this->friendlist);
		        $sender->append($mysidia->user->uid);				
		        $recipient = new Friend($mysidia->user, $sender->getfriendlist());     
		        $recipient->append($sender->uid);	
                $this->setField("fromuser", new Mystring($friendrequest->fromuser));				
	            break;
	        case "decline":
				$friendrequest = new FriendRequest($mysidia->input->get("id"));	
		        $friendrequest->setstatus("declined");
                $this->setField("fromuser", new Mystring($friendrequest->fromuser));					
                break;
	        default:
			    $stmt = $mysidia->db->select("friend_requests", array(), "touser='{$mysidia->user->username}' and status='pending'");
				if($stmt->rowCount() == 0) throw new InvalidIDException("request_empty");
				$this->setField("stmt", new DatabaseStatement($stmt));
        }
	}
	
	
	public function delete(){
		$mysidia = Registry::get("mysidia");        
	    if(!$mysidia->input->get("id")) throw new InvalidIDException("friend_id");
		$friend = new Friend(new Member($mysidia->input->get("id")), $this->friendlist);
        $friend->remove($mysidia->user->uid);   
        $currentUser = new Friend($mysidia->user, $friend->getfriendlist()); 
        $currentUser->remove($mysidia->input->get("id"));          
	}
}
?>