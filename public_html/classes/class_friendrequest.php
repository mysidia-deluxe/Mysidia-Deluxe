<?php

class FriendRequest implements Message
{
    // The core class for Mysidia Adoptables, it loads basic site/user info to initiate the script
  
    public $fid;
    public $fromuser;
    public $offermessage;
    public $touser;
    public $status;
    public $notifier;

    public function __construct($fid = 0, $notifier = false)
    {
        // Fetch the basic member properties for private messages
     
        $mysidia = Registry::get("mysidia");
        if ($fid == 0) {
            //This is a new friend request not yet exist in database
            $this->fid = $fid;
            $this->fromuser = $mysidia->user->username;
        } else {
            // The friend request exists in database, let's load its information
            $row = $mysidia->db->select("friend_requests", array(), "fid='{$fid}'")->fetchObject();
        
            if (!is_object($row)) {
                $mysidia->page->settitle($mysidia->lang->request_invalid);
                $mysidia->page->addcontent($mysidia->lang->request_none);
                return false;
            }
        
            foreach ($row as $key => $val) {
                // For field usergroup, instantiate a Usergroup Object
                $this->$key = $val;
            }
            if ($notifier == true) {
                $this->getnotifier();
            }
        }
        // End of this tricky constructor
    }
  
    public function gettitle()
    {
        // This is a Friend Request, so there is not a title property for now. May consider adding in future.
        return false;
    }
  
    public function getcontent()
    {
        if (!empty($this->offermessage)) {
            return $this->offermessage;
        } else {
            return false;
        }
    }

    public function getnotifier()
    {
        if (is_object($this->notifier)) {
            throw new Exception("A FR Notifier already exists...");
        } else {
            $this->notifier = new FrNotifier;
        }
    }
  
    public function setsender($username)
    {
        $this->fromuser = $username;
    }
  
    public function setrecipient($username)
    {
        $this->touser = $username;
    }

    public function setmessage($offer)
    {
        if (empty($offer)) {
            throw new Exception("The offer message cannot be empty.");
        } else {
            $this->offermessage = $offer;
        }
    }
  
    public function view()
    {
        if ($this->fid == 0) {
            return false;
        } else {
            return $this->offermessage;
        }
    }
  
    public function post($user = "")
    {
        $mysidia = Registry::get("mysidia");
        if (!empty($user)) {
            $this->touser = $user;
        }
        if ($fid != 0) {
            return false;
        }
        $mysidia->db->insert("friend_requests", array("fid" => null, "fromuser" => $this->fromuser, "offermessage" => $this->offermessage, "touser" => $this->touser, "status" => 'pending'));
        return true;
    }
  
    public function edit()
    {
        // This feature is currently not available...
        return false;
    }
  
    public function remove()
    {
        // For a friend request, this method works slightly different than it otherwisw should
        $this->setstatus("canceled");
    }
  
    public function setstatus($status)
    {
        $mysidia = Registry::get("mysidia");
        $validstatus = array("pending", "accepted", "declined", "canceled");
        if (!in_array($status, $validstatus)) {
            throw new Exception("Cannot set an empty status.");
        } else {
            $this->status = $status;
            $mysidia->db->update("friend_requests", array("status" => $this->status), "fid='{$this->fid}'");
        }
        return true;
    }
}
