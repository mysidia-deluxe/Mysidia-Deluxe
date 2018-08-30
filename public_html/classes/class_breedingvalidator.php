<?php

class BreedingValidator extends Validator{

    private $female;
    private $male;
    private $settings;
	private $validations;
	private $status;

    public function __construct(OwnedAdoptable $female, OwnedAdoptable $male, BreedingSetting $settings, ArrayObject $validations){
	    $this->female = $female;
        $this->male = $male;		
	    $this->settings = $settings;
		$this->validations = $validations;
	}
	
	public function getValidations(){
	    return $this->validations;
	}
	
	public function setValidations(ArrayObject $validations, $overwrite = FALSE){
	    if($overwrite) $this->validations = $validations;
		else{
		    foreach($validations as $validation){
			    $this->validations->append($validations);
			}
		}
	}
	
	public function getStatus(){
	    return $this->status;
	}

    public function setStatus($status = ""){
        $this->status = $status;

        if($this->status == "chance" or $this->status == "complete"){
	        $mysidia = Registry::get("mysidia");
		    $date = new DateTime;
            $mysidia->user->changecash(-$this->settings->cost); 

            $this->female->setOffsprings($this->female->getOffsprings() + 1, "update");
		    $this->female->setLastBred($date->getTimestamp(), "update");
		    $this->male->setOffsprings($this->male->getOffsprings() + 1 , "update");
		    $this->male->setLastBred($date->getTimestamp(), "update"); 
        }	
    }

    public function validate(){   
		foreach($this->validations as $validation){
			$method = "check".ucfirst($validation);
		    $this->$method();
		}
		return TRUE;		 
    }
  
    private function checkClass(){
	    $femaleClass = explode(",", $this->female->getClass());
		$maleClass = explode(",", $this->male->getClass());
        foreach($femaleClass as $fclass){
            foreach($maleClass as $mclass){
                if($fclass == $mclass) return TRUE;
            }
        }  
        throw new BreedingException("class");
    }
	
	private function checkGender(){
	    $mysidia = Registry::get("mysidia");
		if($this->female->getGender() != "f" or $this->male->getGender() != "m"){
		    banuser($mysidia->user->username);
			throw new BreedingException("gender");
		}
		return TRUE;	    
	}
  
  	private function checkOwner(){
	    $mysidia = Registry::get("mysidia");
		if($this->female->getOwner() != $mysidia->user->username or $this->male->getOwner() != $mysidia->user->username){
		    banuser($mysidia->user->username);
			throw new BreedingException("owner");
		}
		return TRUE;
	}
  
    private function checkSpecies(){
	    if(empty($this->settings->species)) return TRUE;
		foreach($this->settings->species as $type){
		    if($this->female->getType() == $type or $this->male->getType() == $type) throw new BreedingException("species");
		}
		return TRUE;
    }
	
	private function checkInterval(){
	    $current = new DateTime;
		$expirationTime = $current->getTimestamp() - (($this->settings->interval) * 24 * 60 * 60);
		
		if($this->female->getLastBred() > $expirationTime or $this->male->getLastBred() > $expirationTime){
		    throw new BreedingException("interval");      
		}
		return TRUE;
	}
	
	private function checkLevel(){
	    if($this->female->getCurrentLevel() < $this->settings->level or $this->male->getCurrentLevel() < $this->settings->level){
		    throw new BreedingException("level");
		}
		return TRUE;
	}
  
    private function checkCapacity(){
        if($this->female->getOffsprings() >= $this->settings->capacity or $this->male->getOffsprings() >= $this->settings->capacity){
		    throw new BreedingException("capacity");
		}
		return TRUE;
    }
	 
    private function checkNumber(){
        if($this->settings->number == 0) throw new BreedingException("number");
        return TRUE;		
    }

	private function checkChance(){
		$rand = rand(0, 99);
		if($rand < $this->settings->chance) return TRUE;
		throw new BreedingException("chance");
	}

	private function checkCost(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->user->money < $this->settings->cost) throw new BreedingException("cost");
		return TRUE;
	}
	
    private function checkUsergroup(){
		if($this->settings->usergroup == "all") return TRUE;
        $mysidia = Registry::get("mysidia");
		
		foreach($this->settings->usergroup as $usergroup){
		    if($mysidia->user->usergroup == $usergroup) return TRUE;   
		}
		throw new BreedingException("usergroup");
    }
    
    private function checkItem(){
	    if(!$this->settings->item) return TRUE;
        $mysidia = Registry::get("mysidia");
		
		foreach($this->settings->item as $item){
		    $item = new PrivateItem($item, $mysidia->user->username);
            if($item->iid == 0) throw new BreedingException("item");
            if($item->consumable == "yes") $item->remove();			
		}
		return TRUE;
    }
}
?>