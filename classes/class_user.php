<?php

use Resource\Native\Object;

abstract class User extends Object{
  // The abstract class User
  public $uid = 0;
  public $username;
  public $ip;
  public $usergroup;
  public $lastactivity;
  
  public function getid(){
     return $this->uid;
  }

  public function getusername(){
     return $this->username;
  }
  
  public function getcurrentip(){
     return $this->ip;
  }
  
  public function getgroupid(){
     if(is_numeric($this->usergroup)) return $this->usergroup;
     else return $this->usergroup->gid;
  }
  
  public function getgroup(){
     return $this->usergroup;
  }
  
  public function lastactivity(){
     return $this->lastactivity;
  }
  
  public function logincheck(){
     // will be added later
  }
  
  public function isbanned(){
     // will be added later
  }
  
  public abstract function register();
  public abstract function login($username);
  public abstract function logout();
}
?>