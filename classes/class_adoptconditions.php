<?php

class AdoptConditions extends Model{

	protected $adopt;
	protected $freqcond;
    protected $number;
    protected $datecond;
    protected $date;
 	protected $adoptscond;
 	protected $moreless;
 	protected $morelessnum;
	protected $levelgrle;
	protected $grlelevel;
  
    public function __construct(Adoptable $adopt){	  
	    $mysidia = Registry::get("mysidia");
	    $fields = array("freqcond", "number", "datecond", "date", "adoptscond", "moreless", "morelessnum", "levelgrle", "grlelevel");
	    $row = $mysidia->db->select("adoptables_conditions", $fields, "id = '{$adopt->getID()}'")->fetchObject();
        if(!is_object($row)) throw new AdoptNotfoundException("Adoptable {$adoptinfo} does not exist...");
		
		$this->adopt = $adopt;
        foreach($row as $key => $val){
            $this->$key = $val;     		 
        }	  
    }

    public function getAdopt(){
        return $this->adopt;
    }
  
    public function hasFreqCondition(){
        return $this->freqcond;
    }
	
	public function getFreqCondition(){
	    return $this->number;
	}
	
	protected function checkFreqCondition(){
	    if($this->freqcond == "enabled"){
		    $mysidia = Registry::get("mysidia");
		    $freq = $mysidia->db->select("owned_adoptables", array("aid"), "type='{$this->adopt->getType()}'")->rowCount();
			if($freq >= $this->number) throw new AdoptConditionsException("Freq Condition Not met.");
		}
	}
	
	public function hasDateCondition(){
	    return $this->datecond;
	}
	
	public function getDateCondition($fetchMode = ""){
	    if($flag == Model::OBJ) return new DateTime($this->date);
	    else return $this->date;
	}
	
	protected function checkDateCondition(){
		if($this->datecond == "enabled"){
		    $today = new DateTime;
			if($this->date != $today->format('Y-m-d')) throw new AdoptConditionsException("Date Condition Not met.");
		}
	}
	
	public function hasAdoptConditions(){
	    return $this->adoptscond;
	}
  
    public function hasNumberCondition(){
	    return $this->moreless;
    }
  
  	public function getNumberCondition(){
	    return $this->morelessnum;
	}
	
	protected function checkNumberCondition(){
		if($this->moreless == "enabled"){
		    $mysidia = Registry::get("mysidia");
		    $num = $mysidia->db->select("owned_adoptables", array("aid"), "owner='{$mysidia->user->username}' and type='{$this->adopt->getType()}'")->rowCount();
			if($num >= $this->morelessnum) throw new AdoptConditionsException("Number Condition Not met.");
		}
	}
	
    public function hasGroupCondition(){
	    return $this->levelgrle;
    }
  
  	public function getGroupCondition(){
	    return $this->grlelevel;
	}

    protected function checkGroupCondition(){
		if($this->levelgrle == "enabled"){
		    $mysidia = Registry::get("mysidia");		    
			if($mysidia->user->usergroup->gid != $this->grlelevel) throw new AdoptConditionsException("Group Condition Not met.");
		}
	}
  
    public function checkConditions(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->user->isloggedin) return FALSE;
        if(cando($mysidia->user->usergroup, "canadopt") != "yes") return FALSE;	
		
		switch($this->adopt->getWhenAvailable()){
		    case "always":
			    return TRUE;
			case "conditions":
	            try{
			        $this->checkFreqCondition();
			        $this->checkDateCondition();
		            $this->checkNumberCondition();
		            $this->checkGroupCondition();
				    return TRUE;
		        }
                catch(AdoptConditionsException $ace){
                    return FALSE;   
                }             
            default:
                return FALSE;			
		}	
    }
	
	protected function save($field, $value){
		$mysidia = Registry::get("mysidia");
		$mysidia->db->update("adoptables_conditions", array($field => $value), "id='{$this->adopt->getID()}'");
	}
}
?>