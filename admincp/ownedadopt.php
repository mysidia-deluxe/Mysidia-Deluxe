<?php

class ACPOwnedadoptController extends AppController{

	const PARAM = "aid";
	
    public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanageadopts") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage adoptables.");
		}		
    }

    public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("owned_adoptables");
		if($stmt->rowCount() == 0) throw new InvalidIDException("empty");
		$this->setField("stmt", new DatabaseStatement($stmt));		
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();
            $useAlternates = ($mysidia->input->post("usealternates") == "yes")?"yes":"no";
			$mysidia->db->insert("owned_adoptables", array("aid" => NULL, "type" => $mysidia->input->post("type"), "name" => $mysidia->input->post("name"), "owner" => $mysidia->input->post("owner"), "currentlevel" => $mysidia->input->post("level"), "totalclicks" => $mysidia->input->post("clicks"), 
			                                               "code" => codegen(10, 0), "imageurl" => NULL, "usealternates" => $useAlternates, "tradestatus" => 'fortrade', "isfrozen" => 'no', "gender" => $mysidia->input->post("gender"), "offsprings" => 0, "lastbred" => 0));
		}	
    }

    public function edit(){
	    $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("aid")){
		    $this->index();
			return;
        } 		
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();
            $useAlternates = ($mysidia->input->post("usealternates") == "yes")?"yes":"no";
			$mysidia->db->update("owned_adoptables", array("type" => $mysidia->input->post("type"), "name" => $mysidia->input->post("name"), "owner" => $mysidia->input->post("owner"), "totalclicks" => $mysidia->input->post("clicks"), 
			                                               "currentlevel" => $mysidia->input->post("level"), "usealternates" => $useAlternates, "gender" => $mysidia->input->post("gender")), "aid='{$mysidia->input->get("aid")}'");
		    return;
		}
		
		$stmt = $mysidia->db->select("owned_adoptables", array(), "aid='{$mysidia->input->get("aid")}'");		
		if($ownedadopt = $stmt->fetchObject()){
		    $this->setField("ownedadopt", new DataObject($ownedadopt));			
		}
		else throw new InvalidIDException("global_id");
    }

    public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("aid")){
		    $this->index();
			return;
		}
        $mysidia->db->delete("owned_adoptables", "aid='{$mysidia->input->get("aid")}'");		
    }

    private function dataValidate(){
        $mysidia = Registry::get("mysidia");
		$fields = array("type" => $mysidia->input->post("type"), "name" => $mysidia->input->post("name"), "owner" => $mysidia->input->post("owner"), "clicks" => $mysidia->input->post("clicks"), 
			            "level" => $mysidia->input->post("level"), "usealternates" => $mysidia->input->post("usealternates"), "gender" => $mysidia->input->post("gender"));
        foreach($fields as $field => $value){
			if(!$value){
                if($field == "clicks" and $value == 0) continue;
                if($field == "usealternates") continue;
                if($field == "level" and $value == 0) continue;
				throw new BlankFieldException("You did not enter in {$field} for the adoptable.  Please go back and try again.");
            }
	    }
		return TRUE;
    }	
}
?>