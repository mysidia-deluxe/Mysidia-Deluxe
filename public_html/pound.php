<?php

use Resource\Native\Integer;
use Resource\Collection\HashMap;

class PoundController extends AppController{

    const PARAM = "aid";
    const PARAM2 = "confirm";
	private $settings;
	private $adopt;

    public function __construct(){
        parent::__construct("member");
		$mysidia = Registry::get("mysidia");				
		$status = $mysidia->user->getstatus();		
		if($status->canpound == "no"){            
		    throw new NoPermissionException("denied");
		}
		
		$this->settings = $this->getSettings();
		if($this->settings->system->active == "no"){
		    throw new InvalidActionException("pound_disabled");
		}
		if($this->settings->adopt->active == "no" and $mysidia->input->action() == "index"){
            throw new InvalidActionException("readopt_disabled");
        }
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$pounds = new HashMap;
		$stmt = $mysidia->db->select("pounds", array("aid"), "currentowner='SYSTEM'");
        while($poid = $stmt->fetchColumn()){
		    $adopt = new OwnedAdoptable($poid);
			$pounds->put($adopt, new Integer($this->getCost($adopt)));
		}
		$this->setField("pounds", $pounds);
	}
	
	public function pound(){
		$mysidia = Registry::get("mysidia");
		$this->adopt = new OwnedAdoptable($mysidia->input->get("aid"));	
		if($mysidia->input->get("confirm") == "confirm"){
	        $poundAdopt = new Pound($this->adopt->getAdoptID(), "pound", $this->settings);
			if($poundAdopt->validate()){
			    $poundAdopt->dopound();
				if($this->settings->cost->active == "yes"){        
		            $cost = $this->getCost($this->adopt, "pound");
			        $mysidia->user->changecash(-$cost);
					$this->setField("cost", new Integer($cost));
			    }
			}
			else throw new InvalidActionException("global_action");
			return;
		}
		$this->setField("adopt", $this->adopt);
	}
	
	public function adopt(){
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("submit")){
		    try{
		        $pound = new Pound($mysidia->input->post("aid"), "adopt", $this->settings);
	            $pound->validate();
		        $pound->doadopt();
			}
			catch(InvalidIDException $iie){
			    $this->setFlags("global_id", $iie->getmessage());
				return;
			}
			catch(NoPermissionException $npe){
			    $this->setFlags("global_action", $npe->getmessage());
				return;
			}	
					
			if($this->settings->cost->active == "yes"){
			    $adopt = new OwnedAdoptable($pound->aid);       
		        $cost = $this->getCost($adopt);
			    $mysidia->user->changecash(-$cost);
				$this->setField("cost", new Integer($cost));
			}
			return;
		}
		throw new InvalidIDException("global_id");
	}
	
	protected function getSettings(){
	    $mysidia = Registry::get("mysidia");
	    $settings = new stdclass; 
   	    $stmt = $mysidia->db->select("pound_settings", array());
	    while($setting = $stmt->fetchObject()){
            $property = $setting->varname;
            foreach($setting as $key => $val) @$settings->$property->$key = $val;
	    }
	    return $settings;
	}
	
	protected function getCost(OwnedAdoptable $adopt, $action = ""){
	    $action = ($action == "pound")?0:1;
	    if($this->settings->cost->active == "yes"){
            $costs = explode(",", $this->settings->cost->value);         	 
	        switch($this->settings->cost->advanced){
	            case "percent": 
			        $cost = $adopt->getCost() * (1 + (0.01 * $costs[$action]));
                    break;
                default:
			        $cost = $adopt->getCost() + $this->settings->$costs[$action];
            }	  
	    }
	    if($this->settings->levelbonus->active == "yes"){
	     switch($this->settings->levelbonus->advanced){
	        case "increment": 
		       $cost = $adopt->getCost() + ($this->settings->levelbonus->value * $adopt->getCurrentLevel());
			   break;
            default:
			   $cost = $adopt->getCost() * $adopt->getCurrentLevel();
         }	 
	  }
	  return $cost;
	}
}
?>