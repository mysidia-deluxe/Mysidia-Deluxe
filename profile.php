<?php

use Resource\Native\Integer;
use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ProfileController extends AppController{

    const PARAM = "user";
	private $user;
	private $profile;

    public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");				
		if($mysidia->input->action() != "index"){
		    try{                
		        $this->user = new Member($mysidia->input->get("user"));	       
				$this->profile = $this->user->getprofile();
			}
            catch(MemberNotfoundException $mne){
		        throw new InvalidIDException("nonexist");
            }			
        }		
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$total = $mysidia->db->select("users", array("uid"))->rowCount();		
		$pagination = new Pagination($total, 10, "profile");
        $pagination->setPage($mysidia->input->get("page"));					
		$stmt = $mysidia->db->select("users", array("username", "usergroup"), "1 ORDER BY uid ASC LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}");	
		$users = new LinkedHashMap;
		while($user = $stmt->fetchObject()){
		    $users->put(new String($user->username), new Integer($user->usergroup));  
		}
		$this->setField("pagination", $pagination);
        $this->setField("users", $users);
	}
	
	public function view(){
		include("inc/tabs.php");
		$mysidia = Registry::get("mysidia");

	    $vmessage = new VisitorMessage();		
		$vmessage->setrecipient($this->user->username);		
		if($mysidia->input->post("vmtext")) $vmessage->post();
		
	    $this->profile->formatusername($this->user)->getfavpet();		
	    $mysidia->user->getstatus();
	    $this->user->getcontacts();
	    $this->user->formatcontacts();
		
        $this->setField("user", $this->user);
		$this->setField("profile", $this->profile);
	}
}
?>