<?php

use Resource\Native\Object;

abstract class UserContainer extends Object implements Container
{
    // The abstract UserContainer class
     
    public function getcreator($fetchmode = "Members")
    {
        // The UserContainer usually consists of users
     
        switch ($fetchmode) {
        case "Members":
          return new MemberCreator();
          break;
        case "Visitors":
          return new VisitorCreator();
          break;
        default:
          return false;
     }
    }
  
    abstract public function gettotal();
}
