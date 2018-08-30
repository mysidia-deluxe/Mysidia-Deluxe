<?php

use Resource\Native\Integer;
use Resource\Native\Mystring;
use Resource\Native\Arrays;
use Resource\Native\Mynull;

class AdoptController extends AppController{

    public function __construct(){
        parent::__construct("member");
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canadopt") != "yes"){
		    throw new NoPermissionException("permission");
		}	
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $this->access = "member";
	        $this->handleAccess();
            $id = $mysidia->input->post("id");
			if($mysidia->session->fetch("adopt") != 1 or !$id) throw new InvalidIDException("global_id");			
			
			$adopt = new Adoptable($id);			    
			$conditions = $adopt->getConditions();
			if(!$conditions->checkConditions()) throw new NoPermissionException("condition");
			
			$name = (!$mysidia->input->post("name"))?$adopt->getType():$mysidia->input->post("name");
		    $alts = $adopt->getAltStatus();
		    $code = $adopt->getCode();
			$gender = $adopt->getGender();
		    $mysidia->db->insert("owned_adoptables", array("aid" => NULL, "type" => $adopt->getType(), "name" => $name, "owner" => $mysidia->user->username, "currentlevel" => 0, "totalclicks" => 0, "code" => $code, 
			                                               "imageurl" => NULL, "usealternates" => $alts, "tradestatus" => 'fortrade', "isfrozen" => 'no', "gender" => $gender, "offsprings" => 0, "lastbred" => 0));
		    			
			$aid = $mysidia->db->select("owned_adoptables", array("aid"), "code='{$code}' and owner='{$mysidia->user->username}'")->fetchColumn();
			$this->setField("aid", new Integer($aid));
            $this->setField("name", new Mystring($name));			
			$this->setField("eggImage", new Mystring($adopt->getEggImage()));
		    return;
		}
		
		$mysidia->session->assign("adopt", 1, TRUE);
        $ids = $mysidia->db->select("adoptables", array("id"), "shop='none'")->fetchAll(PDO::FETCH_COLUMN);
        $total = ($ids)?count($ids):0;
		
		if($total == 0) $adopts = new Mynull;
		else{		
		    $adopts = new Arrays($total);
			$available = 0;
			
		    foreach($ids as $id){
                $adopt = new Adoptable($id);
			    $conditions = $adopt->getConditions();	
      			if($conditions->checkConditions()) $adopts[$available++] = $adopt;	
            }
			
            if($available == 0) $adopts = new Mynull;
            else $adopts->setSize($available);			
		}		
		if($adopts instanceof Mynull) throw new InvalidActionException("adopt_none");
		$this->setField("adopts", $adopts);
	}
}
?>