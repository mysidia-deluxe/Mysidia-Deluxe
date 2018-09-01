<?php

class Friend extends UserDecorator
{
    // The abstract class UserDecorator used in Mysidia Adoptables
    public $isfriend;
    protected $friendlist;
  
    public function __construct(User $user, Friendlist $friendlist)
    {
        parent::__construct($user);
        if (!$friendlist->isfriend($user->uid)) {
            // The user is not on the friendlist, therefore we should not instantiate a friend object
            $this->isfriend = false;
            $this->uid = $user->uid;
            $this->username = $user->username;
        } else {
            $this->decorate();
        }
    }
  
    public function decorate()
    {
        // Dynamically assign public properties of the original objects to the decorated object
      
        $this->isfriend = true;
        foreach ($this->user as $key => $val) {
            $this->$key = $val;
        }
        // End of the decorate method
    }
   
    public function getfriendlist()
    {
        // This method generates a friendlist of the friend user
        if (!$this->friendlist) {
            $this->friendlist = new Friendlist($this->user);
        }
        return $this->friendlist;
    }
   
    public function sendrequest()
    {
        // This method processes friend request
      
        $mysidia = Registry::get("mysidia");
        $exist1  = $mysidia->db->select("friend_requests", array("fromuser"), "fromuser='{$mysidia->user->username}' and touser='{$this->username}'")->fetchColumn();
        $exist2 = $mysidia->db->select("friend_requests", array("fromuser"), "touser='{$mysidia->user->username}' and fromuser='{$this->username}'")->fetchColumn();
        if (!$exist1 and !$exist2) {
            // A friend request is not pending, therefore it's time to process the request
            $ftitle = "New Friend Request Received";
            $foffer = "You have received a friendrequest from {$mysidia->user->username}! You may go to your usercp to accept/decline this offer.";
            $frequest = new FriendRequest();
            $frequest->setmessage($foffer);
            $frequest->post($this->username);
         
            // And at the very last, send a PM to the very user receiving this request
            $message = new PrivateMessage();
            $message->setrecipient($this->username);
            $message->setmessage($ftitle, $foffer);
            $message->post();
            return true;
        } else {
            return false;
        }
    }
   
    public function append($uid)
    {
        $mysidia = Registry::get("mysidia");
        $this->getfriendlist();
        $friendsarray = $this->friendlist->getids();
        if (!$this->isfriend) {
            $friendsarray[] = $uid;
        }
        sort($friendsarray);
        $friends = (count($friendsarray) == 1)?$uid:implode(",", $friendsarray);
        $mysidia->db->update("users", array("friends" => $friends), "username='{$this->user->username}'");
    }
   
    public function remove($uid)
    {
        $mysidia = Registry::get("mysidia");
        $this->getfriendlist();
        $friendsarray = array();
        $friendids = $this->friendlist->getids();
        if (empty($friendids)) {
            return false;
        } elseif (is_array($friendids)) {
            foreach ($friendids as $val) {
                if ($val != $uid) {
                    $friendsarray[] = $val;
                }
            }
            sort($friendsarray);
            $friends = implode(",", $friendsarray);
        } else {
            if ($friendids == $uid) {
                $friends = "";
            } else {
                $friends = $uid;
            }
        }
        $mysidia->db->update("users", array("friends" => $friends), "username='{$this->user->username}'");
    }
   
    public function setprivacy()
    {
        $mysidia = Registry::get("mysidia");
        if (empty($user)) {
            $user = $mysidia->user;
        }
        $mysidia->db->update("users_options", array("pmstatus" => $mysidia->input->post("pm"), "vmstatus" => $mysidia->input->post("vm"), "tradestatus" => $mysidia->input->post("trade")), "username='{$user->username}'");
    }
}
