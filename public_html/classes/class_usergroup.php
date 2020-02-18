<?php

use Resource\Native\Object;

class Usergroup extends Object
{
    // The usergroup class, what should I say? umm... Its temporary anyway as the usergroup system will be revised in Mys v1.4.0's new ACP project.

    public $gid = 0;
    public $groupname;
    protected $canadopt;
    protected $canpm;
    protected $cancp;
    protected $canmanageadopts;
    protected $canmanagecontent;
    protected $canmanageads;
    protected $canmanagesettings;
    protected $canmanageusers;
  
  
    public function __construct($group)
    {
        // Fetch the basic properties for usergroup
      
        $mysidia = Registry::get("mysidia");
        if (empty($group)) {
            $group = "visitors";
        }
        $whereclause = (is_numeric($group))?"gid ='{$group}'":"groupname ='{$group}'";
        $row = $mysidia->db->select("groups", array(), $whereclause)->fetchObject();
        // loop through the anonymous object created to assign properties
        foreach ($row as $key => $val) {
            $this->$key = $val;
        }
        // Successfully instantiate the usergroup object, it usually is assigned as a property to user object, but can exist on its own
    }
  
    public static function fetchgroup($groupname)
    {
        $mysidia = Registry::get("mysidia");
        $usergroup = $mysidia->db->select("groups", array(), "groupname ='{$groupname}'")->fetchObject();
        return $usergroup;
    }
  
    public function getpermission($perms)
    {
        if (isset($this->$perms)) {
            return $this->$perms;
        } else {
            throw new Exception('The permission name does not exist, something must be very very wrong');
        }
    }
  
    public function setpermission($fields = array())
    {
        $mysidia = Registry::get("mysidia");
        if (!is_assoc($perm)) {
            throw new Exception('The parameter must be an associative array...');
        }
        $mysidia->db->update("groups", $field, "gid ='{$this->gid}'");
    }
  
    public function deletegroup()
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->db->delete("groups", "gid ='{$this->gid}'");
    }

    public function __toString()
    {
        return $this->groupname;
    }
}
