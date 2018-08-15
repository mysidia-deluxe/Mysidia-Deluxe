<?php

use Resource\Collection\ArrayList;

class ACPBreedingController extends AppController{

	const PARAM = "bid";
	
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
		$stmt = $mysidia->db->select("breeding");
		if($stmt->rowCount() == 0) throw new InvalidIDException("empty");
		$this->setField("stmt", new DatabaseStatement($stmt));
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();
			$availability = ($mysidia->input->post("available") == "yes")?"yes":"no";
			$mysidia->db->insert("breeding", array("bid" => NULL, "offspring" => $mysidia->input->post("offspring"), "parent" => $mysidia->input->post("parent"), "mother" => $mysidia->input->post("mother"), "father" => $mysidia->input->post("father"), 
			                                       "probability" => $mysidia->input->post("probability"), "survival" => $mysidia->input->post("survival"), "level" => $mysidia->input->post("level"), "available" => $availability));
		}	
    }

    public function edit(){
	    $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("bid")){
		    $this->index();
			return;
        } 
		
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();
			$availability = ($mysidia->input->post("available") == "yes")?"yes":"no";
			$mysidia->db->update("breeding", array("offspring" => $mysidia->input->post("offspring"), "parent" => $mysidia->input->post("parent"), "mother" => $mysidia->input->post("mother"), "father" => $mysidia->input->post("father"), "probability" => $mysidia->input->post("probability"), 
												   "survival" => $mysidia->input->post("survival"), "level" => $mysidia->input->post("level"), "available" => $availability), "bid='{$mysidia->input->get("bid")}'");
		    return;
		}
		
		try{
		    $breedAdopt = new BreedAdoptable($mysidia->input->get("bid"));
			$this->setField("breedAdopt", $breedAdopt);
		}
		catch(AdoptNotfoundException $ane){
		    throw new InvalidIDException($ane->getmessage());
		}			
    }

    public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("bid")){
		    $this->index();
			return;
		}
        $mysidia->db->delete("breeding", "bid='{$mysidia->input->get("bid")}'");		
    }
	
	public function settings(){
	    $mysidia = Registry::get("mysidia");
        $breedingSettings = new BreedingSetting($mysidia->db);				
		if($mysidia->input->post("submit")){
		    $settings = array('system', 'method', 'species', 'interval', 'level', 'capacity', 
			                  'number', 'chance', 'cost', 'usergroup', 'item');
			foreach($settings as $name){			
				if($mysidia->input->post($name) != ($breedingSettings->$name)) $mysidia->db->update("breeding_settings", array("value" => $mysidia->input->post($name)), "name='{$name}'");	 
			}
		    return;
		}
		$this->setField("breedingSettings", $breedingSettings);
	}

    private function dataValidate(){
        $mysidia = Registry::get("mysidia");
		if(!$mysidia->input->post("offspring")) throw new BlankFieldException("offspring");
		if(!$mysidia->input->post("parent") and !$mysidia->input->post("mother") and !$mysidia->input->post("father")) throw new BlankFieldException("parent");
		if($mysidia->input->post("parent") and ($mysidia->input->post("mother") or $mysidia->input->post("father"))) throw new BlankFieldException("parents");
		
		if(!is_numeric($mysidia->input->post("probability"))) throw new BlankFieldException("probability");
		if(!is_numeric($mysidia->input->post("survival"))) throw new BlankFieldException("survival");
		if(!is_numeric($mysidia->input->post("level"))) throw new BlankFieldException("level");		
		return TRUE;
    }	
}
?>