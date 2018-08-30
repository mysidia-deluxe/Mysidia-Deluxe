<?php

use Resource\Native\Object;

class Pound extends Object{
    public $poid = 0;
    public $aid = 0;
    private $firstowner;
    private $lastowner;
    private $currentowner;
    private $recurrence;
    private $datepound;
    private $dateadopt;
    public $settings;
    public $action;
    private $valid;
  
    public function __construct($aid = "", $action = "", $settings = ""){
        // Fetch the database info into object property
	    $mysidia = Registry::get("mysidia");	  
	    $this->settings = $settings;	  
	    switch($action){
	        case "pound":
	            $this->aid = $aid;
		        $this->currentowner = $mysidia->user->username;
		        $this->action = $action;
                $stmt = $mysidia->db->select("pounds", array("firstowner", "recurrence", "dateadopt"), "aid ='{$aid}' and currentowner = '{$this->currentowner}'");
                if($row = $stmt->fetchObject()){
                    $this->firstowner = $row->firstowner;
                    $this->recurrence = $row->recurrence;
                    $this->dateadopt = $row->dateadopt;
                }
			    break;
		    case "adopt":
	            $stmt = $mysidia->db->select("pounds", array(), "aid ='{$aid}' and currentowner = 'SYSTEM'");
                $this->action = $action;
                if($row = $stmt->fetchObject()){
                    // loop through the anonymous object created to assign properties
                    foreach($row as $key => $val){
                        // Assign properties to our promocode instance
                        $this->$key = $val;			
                    }			   
                }
			    else throw new InvalidIDException($mysidia->lang->nonpound);         
                break;
			default:
                throw new InvalidIDException($mysidia->lang->global_action);	
	    }
    }
    
    public function validate($aid = ""){
        // This method checks if the promocode entered by user is valid	  
        $mysidia = Registry::get("mysidia");
	  
        if($this->action == "pound"){
	  	    $adoptvalid = $this->checkadopt();
            $uservalid = $this->checkowner();
		    $numvalid = $this->checknumber();
		    $freqvalid = $this->checkrecurrence();
		    $moneyvalid = $this->checkmoney();
            if($adoptvalid == TRUE and $uservalid == TRUE and $numvalid == TRUE and $freqvalid == TRUE and $moneyvalid == TRUE) $this->valid = TRUE;
            else return FALSE;		 
	    }
	    elseif($this->action == "adopt"){
            $uservalid = $this->checkuser();
		    $numvalid = $this->checknumber();
		    $timevalid = $this->checkduration();
		    $moneyvalid = $this->checkmoney();
            if($uservalid == TRUE and $numvalid == TRUE and $timevalid == TRUE and $moneyvalid == TRUE) $this->valid = TRUE;
            else return FALSE;		 
	    }
	    else $this->valid = FALSE;
	    return $this->valid;      
    }
  
    private function checkadopt($aid = "", $user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$this->user;
	    if($this->settings->specieslimit->active == "yes"){
            $adopt = new OwnedAdoptable($this->aid);
	        $id = $adopt->getID();
		    $species = explode(",", $this->settings->specieslimit->value);
		    if(in_array($id, $species)){
			    throw new NoPermissionException($mysidia->lang->species);
		    }
	    }
	    return TRUE;
    }
  
    private function checkowner($user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$user;
        switch($this->action){
	        case "pound": 
		        $adopt = $mysidia->db->select("owned_adoptables", array("name", "owner"), "aid ='{$this->aid}'")->fetchObject();
	            if($adopt->owner != $user){
	                // User is not the owner of the pet, now this is bad...
		            banuser($mysidia->user->username);
			        throw new NoPermissionException($mysidia->lang->owner);
                }
	            else return TRUE;
		        break;
		    case "adopt":
	            if($user == $this->lastowner) return TRUE;
	            else return FALSE;
			    break;
        }
    }
  
    private function checkuser($user = ""){
        $mysidia = Registry::get("mysidia");
	    $user = (empty($user))?$mysidia->user->username:$user;
        if($this->checkowner($user) == TRUE and $this->settings->owner->active == "yes"){ 
            // The user is pet's previous owner, but our admin has disabled ex-owner to readopt so...	  
		    throw new NoPermissionException($mysidia->lang->readopt2_disabled);
        }		 
	    elseif(!empty($this->dateadopt)){
            if(empty($this->dateadopt)) die("Something is terribly wrong.");
	        // The pet has been adopted from pound center, we need to check if this is a hacking attempt or just two competing users doing the same thing at same time...
            $message = $mysidia->lang->session;
            $allowedtime = strtotime($this->dateadopt) + 86400;
		    $currenttime = time();
		    if($currenttime > $allowedtime){
                // One day has elapsed. A session cannot last this long, so we are sure it is hacking attempt
			    banuser($mysidia->user->username);
			    $message .= $mysidia->lang->user;
            }
			throw new NoPermissionException($message);
  	    }	 
	    return TRUE;
    }
  
    private function checknumber($user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$user;
        $num = explode(",", $this->settings->number->value);
	    $index = ($this->action == "pound")?0:1;
	    $currentdate = date('Y-m-d');
		
	    $field1 = ($this->action == "pound")?"lastowner":"currentowner";
        $field2 = ($this->action == "pound")?"datepound":"dateadopt";
	    $where_clause = ($this->settings->date->active == "yes")?"{$field1}='{$user}' and {$field2} = '{$currentdate}'":"{$field1}='{$user}'";
        $where_clause .= ($this->action == "pound")?" and currentowner = 'SYSTEM'":"";
	    $total = $mysidia->db->select("pounds", array("poid"), $where_clause)->rowCount();	 	  
        
		if($this->settings->number->active == "yes" and $total >= $num[$index]){
	        // The admin has turned on quantity control, we need to take care of it...
		    $message = "It appears that you have {$this->action}ed too many pets today...<br>";
            if($this->settings->date->active == "yes") $message .= $mysidia->lang->time1;
            else $message .= $mysidia->lang->time2;
		    throw new NoPermissionException($message);
	    }
	    else return TRUE;
    }
  
    private function checkduration($user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$user;
	    if($this->settings->duration->active == "yes"){
	        // The admin has enabled duration control, we need to take care of it...
	        $datepound = strtotime($this->datepound);
            $currenttime = time();
		    if(!empty($this->settings->duration->advanced)){
		        // Advanced time-setting is enabled, oops!
			    $timeconvert = timeconverter($this->settings->duration->advanced);
			    $duration = $this->settings->duration->value * $timeconvert;
                $allowedtime = $datepound + $duration;
		    }
            else $allowedtime = $datepound + 86400 * $this->settings->duration->value;
 		    if($currenttime < $allowedtime){
			    // The adoptable has not yet passed its 'frozen' period, so nope it cannot be adopted
                $unit = (!empty($this->settings->duration->advanced))?$this->settings->duration->advanced:"days";
			    throw new NoPermissionException("The adoptable has just been pounded recently, please come back {$this->settings->duration->value} {$unit} after {$this->datepound} to see if it is available then.");
		    }
            else return TRUE;		 
	    }
	    else return TRUE;
    }
    
    private function checkrecurrence($user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$user;
	    if($this->settings->recurrence->active == "yes" and $this->recurrence >= $this->settings->recurrence->value){
	        // The adoptable cannot be pounded anymore in normal procedure, a magical item may help though.
		    throw new NoPermissionException("It appears that the adoptables have been pounded {$this->recurrence} times and refuse to suffer another mighty blow...<br>");
	    }
	    else return TRUE;
    }
  
    private function checkmoney($user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$user;
	    $money = $mysidia->user->getcash();
	    $adopt = $mysidia->db->join("adoptables", "adoptables.type = owned_adoptables.type")
				             ->select("owned_adoptables", array(), constant("PREFIX")."owned_adoptables.aid='{$this->aid}' ")->fetchObject();	        
        $cost = $this->getCost($adopt, $this->action);
	    if($this->settings->cost->active = "yes" and $money < $cost){
		    throw new NoPermissionException("It appears that you do not have enough money to {$this->action} this pet, please come back later. ");
	    }
	    else return TRUE;
    }
  
	private function getCost($adopt, $action = ""){
	    $action = ($action == "pound")?0:1;
	    if($this->settings->cost->active == "yes"){
            $costs = explode(",", $this->settings->cost->value);         	 
	        switch($this->settings->cost->advanced){
	            case "percent": 
			        $adopt->cost = $adopt->cost * (1 + (0.01 * $costs[$action]));
                    break;
                default:
			        $adopt->cost = $adopt->cost + $this->settings->$costs[$action];
            }	  
	    }
	    if($this->settings->levelbonus->active == "yes"){
	     switch($this->settings->levelbonus->advanced){
	        case "increment": 
		       $adopt->cost = $adopt->cost + ($this->settings->levelbonus->value * $adopt->currentlevel);
			   break;
            default:
			   $adopt->cost = $adopt->cost * $adopt->currentlevel;
         }	 
	  }
	  return $adopt->cost;
	}
  
    public function dopound($user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$user;
	    $mysidia->db->update("owned_adoptables", array("owner" => "SYSTEM"), "aid ='{$this->aid}'"); 
	    // First check if someone else has taken a step ahead...
	    $date = new DateTime;
	    $stmt = $mysidia->db->select("pounds", array("poid", "recurrence", "dateadopt"), "aid ='{$this->aid}'");
	    $row = $stmt->fetchObject();
	    if(!is_object($row)){
	        // The pet has never been pounded before, insert a new row into the table prefix.pounds.
		    $mysidia->db->insert("pounds", array("poid" => NULL, "aid" => $this->aid, "firstowner" => $user, "lastowner" => $user, 
		                                         "currentowner" => "SYSTEM", "recurrence" => 1, "datepound" => $date->format('Y-m-d'), "dateadopt" => NULL)); 
	    }	 
        else{
            // We are all good, it is time for orphaned adoptable to find his/her new home!
            $recurrence = $row->recurrence + 1; 
		    $mysidia->db->update("pounds", array("lastowner" => $user, "currentowner" => "SYSTEM", "recurrence" => $recurrence, "datepound" => $date->format('Y-m-d'), "dateadopt" => NULL), "aid ='{$this->aid}'");  
        }
    }
  
    public function doadopt($user = ""){
        $mysidia = Registry::get("mysidia");
        $user = (empty($user))?$mysidia->user->username:$user;
	    // First check if someone else has taken a step ahead...
	    $adopt = $mysidia->db->select("pounds", array("poid", "dateadopt"), "aid ='{$this->aid}'")->fetchObject();
	    if(!empty($adopt->dateadopt)) throw new InvalidActionException($mysidia->lang->unlucky);
        else{
            // We are all good, it is time for orphaned adoptable to find his/her new home!
		    $date = new DateTime;
		    $mysidia->db->update("pounds", array("currentowner" => $user, "dateadopt" => $date->format('Y-m-d')), "aid ='{$this->aid}'");
		    $mysidia->db->update("owned_adoptables", array("owner" => $user), "aid ='{$this->aid}'"); 		 	 
        }  
    }
}
?> 