<?php

class MemberCreator extends UserCreator{
  // The abstract factory class UserCreator
  protected $userinfo;
  protected $usergroup;
  protected $user;
   
  public function __construct($userinfo){
     if(empty($userinfo)) throw new Exception('User id or Username does not exist...');
     $this->userinfo = $userinfo;
	 $this->usergroup = $this->getgroupid();
  }

  public function getgroupid(){
     $mysidia = Registry::get("mysidia");
     $whereclause = $whereclause = (is_numeric($this->userinfo))?"uid ='{$this->userinfo}'":"username ='{$this->userinfo}'";
     $gid = $mysidia->db->select("users", array("usergroup"), $whereclause)->fetchColumn();
     return $gid;
  }

  public function getgroupcategory(){
     // This feature will be fully implemented in Mys v1.3.3 or v1.3.4.
     if($this->usergroup == 1 or $this->usergroup == 2) return "Admin";
     elseif($this->usergroup == 4 or $this->usergroup == 6) return "Mod";
     elseif($this->usergroup == 3) return "Registered";
     elseif($this->usergroup == 5) return "Banned";
     else throw new Exception('Cannot recognize usergroup category for this user, he/she may be a guest, a bot, or else...');
  }

  public function create(){
     $category = $this->getgroupcategory();
     switch($category){
        case "Admin":
		   $this->user = $this->create_admin();
		   break;
		case "Mod":
           $this->user = $this->create_mod();
           break;
        case "Banned":
           $this->user = $this->create_banned();
		   break;		   
        default:
		   $this->user = $this->create_member();           		
     }
     return $this->user;	 
  }
  
  public function massproduce(){
     return FALSE;
  }
    
  private function create_admin(){
     return new Admin($this->userinfo);
  }
  
  private function create_mod(){
     return new Mod($this->userinfo);
  }
  
  private function create_member(){
     return new Member($this->userinfo);
  }
  
  private function create_banned(){
     return new Banned($this->userinfo);
  }
}
?>