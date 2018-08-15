<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPUsergroupController extends AppController{

	const PARAM = "group";

    public function __construct(){
	    parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanageusers") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage users.");
		}	
    }

    public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("groups");		
        $this->setField("stmt", new DatabaseStatement($stmt));
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");
        if($mysidia->input->post("submit") and $mysidia->input->post("group")){
		    $stmt = $mysidia->db->select("groups", array(), "groupname='{$mysidia->input->post("group")}'");	 
			if($usergroup = $stmt->fetchObject()) throw new DuplicateIDException("duplicate");
			
			$mysidia->db->insert("groups", array("gid" => NULL, "groupname" => $mysidia->input->post("group"), "canadopt" => 'yes', "canpm" => 'yes', "cancp" => 'no', "canmanageadopts" => 'no',
			                                     "canmanagecontent" => 'no', "canmanageads" => 'no', "canmanagesettings" => 'no', "canmanageusers" => 'no'));		
		}
    }

    public function edit(){
        $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("group")){
		    $this->index();
			return;
		}		
		$usergroup = $mysidia->db->select("groups", array(), "gid='{$mysidia->input->get("group")}'")->fetchObject();		
		if(!is_object($usergroup)) throw new InvalidIDException("global_id");				
		$permissions = array("canadopt", "canpm", "cancp", "canmanageusers", "canmanageadopts", "canmanagecontent", "canmanagesettings", "canmanageads");
		
		if($mysidia->input->post("submit")){		    
			foreach($permissions as $perm){
			    $$perm = ($mysidia->input->post($perm) != "yes")?"no":$mysidia->input->post($perm);
			}
			
			$mysidia->db->update("groups", array("canadopt" => $canadopt, "canpm" => $canpm, "cancp" => $cancp, "canmanageadopts" => $canmanageadopts, "canmanagecontent" => $canmanagecontent, 
			                                     "canmanageads" => $canmanageads, "canmanagesettings" => $canmanagesettings, "canmanageusers" => $canmanageusers), "gid='{$mysidia->input->get("group")}'");
		}
		else{
            $checkBoxes = new LinkedHashMap; 			
			foreach($permissions as $permission){ 
				$checkBoxes->put(new String($permission), new CheckBox($mysidia->lang->{$permission}, $permission, "yes", $usergroup->$permission == "yes"));
			}
			$this->setField("checkBoxes", $checkBoxes);	 
		}
    }
 
    public function delete(){
	    $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("group")){
		    $this->index();
			return;
		}		
        $mysidia->db->delete("groups", "gid='{$mysidia->input->get("group")}'");
    }

    public function admin(){
        throw new InvalidActionException("global_action");		
    }	
}
?>