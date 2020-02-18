<?php

use Resource\Collection\LinkedList;

class VisitorMessage extends Model implements Message
{
    // The core class for Mysidia Adoptables, it loads basic site/user info to initiate the script
  
    public $vid;
    public $fromuser;
    public $touser;
    protected $datesent;
    protected $vmtext;
    public $notifier;

    public function __construct($vid = 0, $notifier = false)
    {
        // Fetch the basic member properties for visitor messages
     
        $mysidia = Registry::get("mysidia");
        if ($vid == 0) {
            //This is a new visitor message not yet exist in database
            $this->vid = $vid;
            $this->fromuser = $mysidia->user->username;
        } else {
            // The visitor message is not being composed, so fetch the information from database
            $row = $mysidia->db->select("visitor_messages", array(), "vid ='{$vid}'")->fetchObject();
            if (!is_object($row)) {
                throw new InvalidIDException($mysidia->lang->view_nonexist);
            }

            // loop through the anonymous object created to assign properties
            foreach ($row as $key => $val) {
                // For field usergroup, instantiate a Usergroup Object
                $this->$key = $val;
                if ($notifier == true) {
                    $this->getnotifier();
                }
            }
        }
        // End of this tricky constructor
    }
  
    public function gettitle()
    {
        // This is a Visitor Message, so there is not a title property for now. May consider adding in future.
        return false;
    }
  
    public function getcontent()
    {
        if (!empty($this->vmtext)) {
            return $this->vmtext;
        } else {
            return false;
        }
    }

    public function getnotifier()
    {
        if (is_object($this->notifier)) {
            throw new Exception("A VM Notifier already exists...");
        } else {
            $this->notifier = new VmNotifier;
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

    public function view()
    {
        if ($this->vid == 0) {
            throw new InvalidIDException($mysidia->lang->view_none);
        } else {
            $mysidia = Registry::get("mysidia");
            $this->datesent = substr_replace($this->datesent, " at ", 10, 1);
            $sender = new Member($this->fromuser);
        
            $avatar = new TCell($sender->getavatar());
            $message = new TCell(new Link("profile/view/{$sender->username}", $this->fromuser));
            $message->add(new Comment("({$this->datesent})"));
            $message->add(new Comment($this->vmtext));
            $cells = new LinkedList;
            $cells->add($avatar);
            $cells->add($message);
        
            if (($mysidia->user instanceof Admin) or ($mysidia->user->username == $this->fromuser)) {
                $action = new TCell(new Link("vmessage/edit/{$this->vid}", new Image("templates/icons/cog.gif")));
                $action->add(new Link("vmessage/delete/{$this->vid}", new Image("templates/icons/delete.gif"), true));
                $cells->add($action);
            }
            return $cells;
        }
    }
  
    public function post($user = "")
    {
        $mysidia = Registry::get("mysidia");
        if ($this->vid != 0) {
            return false;
        } else {
            $date = new DateTime;
            $mysidia->db->insert("visitor_messages", array("vid" => null, "fromuser" => $this->fromuser, "touser" => $this->touser, "datesent" => $date->format("Y-m-d H:i:s"), "vmtext" => $mysidia->input->post("vmtext")));
        }
        return true;
    }
  
    public function edit()
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->db->update("visitor_messages", array("vmtext" => $mysidia->input->post("vmtext")), "vid='{$this->vid}' and fromuser='{$this->fromuser}'");
    }
  
    public function remove()
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->db->delete("visitor_messages", "vid='{$this->vid}' and touser='{$this->touser}'");
    }
    
    protected function save($field, $value)
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->db->update("visitor_messages", array($field => $value), "id='{$this->vid}'");
    }
}
