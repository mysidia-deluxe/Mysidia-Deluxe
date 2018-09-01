<?php

class Admin extends Member
{
    // The Admin class, will be fully utilized by the release date of Mys v1.4.0

    protected $action;
    protected $log;
    protected $notes;
    protected $admpermission;
    protected $acptheme;
    protected $acplogin;
  
    public function __construct($userinfo)
    {
        // Fetch the basic member properties for users
      
        parent::__construct($userinfo);
        $mysidia = Registry::get("mysidia");
        $this->action = $_SERVER['REQUEST_URI'];
        $this->log = $this->getlog();
        $this->notes = $this->getnotes();
        $this->acptheme = $this->getacptheme();
        $this->acplogin = $mysidia->session->fetch("acplogin");
    }

    public function isloggedin()
    {
        return $this->acplogin;
    }
  
    public function acplogin()
    {
        // This method allows admin to log into ACP
      
        $mysidia = Registry::get("mysidia");
        if ($mysidia->session->fetch("acplogin")) {
            $mysidia->page->addcontent("You are already logged into admin control panel...", true);
        } else {
            $mysidia->session->assign("acplogin", true);
        }
    }
  
    public function haspermission($item)
    {
        // This method examines if the admin has permission to access certain portion of ACP
        if (!is_object($this->admpermission)) {
            $this->admpermission = $this->getgroup();
        }
         
        if ($this->admpermission->getpermission($item) == true) {
            return true;
        } else {
            return false;
        }
    }
  
    public function inlineedit()
    {
        // This method enables admins to edit site content without going to ACP
    }

    public function getlog()
    {
        // Will be added in future
    }

    public function getnotes()
    {
        // Will be added in future
    }

    public function getacptheme()
    {
        // Will be added in future
    }
}
