<?php

use Resource\Native\Integer;
use Resource\Native\Mystring;
use Resource\Native\Mynull;
use Resource\Collection\LinkedList;

class BreedingController extends AppController{

    public function __construct(){
        parent::__construct("member");
		$mysidia = Registry::get("mysidia");		
		$userStatus = $mysidia->user->getstatus();
        if($userStatus->canbreed == "no") throw new NoPermissionException("permission");		
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$settings = new BreedingSetting($mysidia->db);
        if($settings->system != "enabled") throw new InvalidActionException("system");
		
	    if($mysidia->input->post("submit")){
		    if($mysidia->input->post("female") == "none" or $mysidia->input->post("male") == "none"){
  			    throw new InvalidIDException("none_select");
			}
			
			try{
			    $female = new OwnedAdoptable($mysidia->input->post("female"), $mysidia->user->username);
				$male = new OwnedAdoptable($mysidia->input->post("male"), $mysidia->user->username);
				$breeding = new Breeding($female, $male, $settings); 
                $validator = $breeding->getValidator("all");
				$validator->validate();
			}
			catch(AdoptNotfoundException $ane){
                throw new InvalidIDException("none_exist");
			}
			catch(BreedingException $bre){                
			    $status = $bre->getmessage();
                $validator->setStatus($status);
			    throw new InvalidActionException($status);
			}
			
			if($settings->method == "advanced") $species = $breeding->getBabySpecies();
			$breeding->getBabyAdopts($species);
			$breeding->breed($adopts);
			$num = $breeding->countOffsprings();
						
			if($num > 0){
                $offsprings = $breeding->getOffsprings();
                $offspringID = $mysidia->db->select("owned_adoptables", array("aid"), "1 ORDER BY aid DESC LIMIT 1")->fetchColumn() - $num + 1;
				$links = new LinkedList;
				foreach($offsprings as $offspring){
                    $image = $offspring->getEggImage("gui");
                    $links->add(new Link("myadopts/manage/{$offspringID}", $image));
                    $offspringID++;
                }
				$this->setField("links", $links);
			}
            else $this->setField("links", new Mynull);
            $this->setField("breeding", $breeding);		
			return;
		}

		$this->setField("cost", new Integer($settings->cost));
		$current = new DateTime;
		$lasttime = $current->getTimestamp() - (($settings->interval) * 24 * 60 * 60);
				
	    $stmt = $mysidia->db->select("owned_adoptables", array("name", "aid"), "owner = '{$mysidia->user->username}' AND gender = 'f' AND currentlevel >= {$settings->level} AND lastbred <= '{$lasttime}'");
        $female = ($stmt->rowcount() == 0)?new Mynull:$mysidia->db->fetchMap($stmt);
		$this->setField("femaleMap", $female);
  
        $stmt = $mysidia->db->select("owned_adoptables", array("name", "aid"), "owner = '{$mysidia->user->username}' AND gender = 'm' AND currentlevel >= {$settings->level} AND lastbred <= '{$lasttime}'");
		$male = ($stmt->rowcount() == 0)?new Mynull:$mysidia->db->fetchMap($stmt);
		$this->setField("maleMap", $male);
	}
}
?>