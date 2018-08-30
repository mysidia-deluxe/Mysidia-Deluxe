<?php

use Resource\Collection\LinkedList as LinkedList;

class Friendlist extends UserContainer{
  // The Friendlist class, which is a container
  
  public $user;  
  protected $fids;  
  protected $fnum;
  protected $privacy = "public";
  
  public function __construct(User $user){
     // Fetch the basic properties of friendlist
     
     $this->user = $user->username;	
     $fids = $user->getfriends(); 
     $this->fids = empty($fids)?"":explode(",", $fids); 
	 $this->fnum = empty($fids)?0:count($this->fids);
  }
  
  public function getids(){
     // Return an ArrayObject of ids in the friendlist
	 return $this->fids;
  }
  
  public function gettotal(){
     // Return the total number of friends
     return $this->fnum;
  }
  
  public function isfriend($uid){
     // Check if the specific user is on this friendlist
	 if(is_array($this->fids) and in_array($uid, $this->fids)) return TRUE;
	 else return FALSE;
  }
  
  public function display(){
     // Display the user's friendlist	 
	 $mysidia = Registry::get("mysidia");
	 $document = $mysidia->frame->getDocument();

	 if(!$this->isfriend($mysidia->user->uid) and $this->privacy == "protected") return FALSE;
	 elseif(!$this->fids) return FALSE;
	 else{
	    // The friendlist can be displayed, so let's show the content        
		$friendTable = new TableBuilder("friends", "", FALSE);
		$friendTable->setHelper(new FriendTableHelper);
 
		foreach($this->fids as $fid){
		   $friend = new Member($fid);	
	       $friend->getprofile();
		   $friend->getcontacts();	   
		   $avatar = new TCell($friend->getavatar(60));
		   $avatar->setAlign(new Align("left"));
		   $info = new TCell($friendTable->getHelper()->getFriendInfo($friend));
		   $cells = new LinkedList;
		   $cells->add($avatar);
		   $cells->add($info);
		   
		   if(!empty($mysidia->user->username) and $this->user == $mysidia->user->username){
		       $action = new TCell;
			   $action->setAlign(new Align("right"));
			   $action->add(new Comment("<br><br><br><br>"));
			   $action->add(new Link("friends/delete/{$friend->uid}", "Break Friendship"));
               $cells->add($action);
		   }
		   $friendTable->buildRow($cells);
        }
        $document->add($friendTable);		
	 }
	 // End of the display method
  }
}
?>