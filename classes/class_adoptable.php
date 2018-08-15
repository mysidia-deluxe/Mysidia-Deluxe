<?php

use Resource\Native\String;

class Adoptable extends Model{

    protected $id;
	protected $type;
	protected $class;
	protected $description;
	protected $eggimage;
	protected $whenisavail;
	protected $alternates;
	protected $altoutlevel;
	protected $altchance;
	protected $shop;
	protected $cost;  
    protected $conditions;
    protected $levels;	
  
    public function __construct($adoptinfo){	  
	    $mysidia = Registry::get("mysidia");
	    if($adoptinfo instanceof String) $adoptinfo = $adoptinfo->getValue();		
	    $whereClause = (is_numeric($adoptinfo))?"id ='{$adoptinfo}'":"type ='{$adoptinfo}'";
	    $row = $mysidia->db->select("adoptables", array(), $whereClause)->fetchObject();
        if(!is_object($row)) throw new AdoptNotfoundException("Adoptable {$adoptinfo} does not exist...");
        foreach($row as $key => $val){
            $this->$key = $val;     		 
        }	  
    }

    public function getID(){
        return $this->id;
    }

    public function getType(){
        return $this->type;
    }

    public function getClass(){
        return $this->class;
    }
  
    public function getDescription(){
        return $this->description;
    }
	
	public function getEggImage($fetchMode = ""){
	    if($fetchMode == Model::GUI) return new Image($this->eggimage);
	    return $this->eggimage;
	}
	
	public function getWhenAvailable(){
	    return $this->whenisavail;
	}
	
	public function hasAlternates(){
	    return $this->alternates;
	}
	
	public function getAltLevel(){
	    return $this->altoutlevel;
	}
	
	public function getAltChance(){
	    return $this->altchance;
	}
	
	public function getShop($fetchMode = ""){
	    if($fetchMode == Model::MODEL) return new AdoptShop($this->shop);
	    else return $this->shop;
	}
	
	public function getCost(){
	    return $this->cost;
	}
  
    public function getConditions(){
        if(!$this->conditions) $this->conditions = new AdoptConditions($this);
		return $this->conditions;	 
    }
  
  	public function getLevel($level){
	    if(!$this->levels) return new AdoptLevel($this->type, $level);
		return $this->levels[$level];
	}
  
    public function getLevels(){
	    if(!$this->levels){
		    $mysidia = Registry::get("mysidia");
			$this->levels = new ArrayObject;
			$num = $mysidia->db->select("levels", array("thisislevel"), "adoptiename='{$this->type}'")->rowCount();
            for($i = 0; $i <= $num; $i++){
			    $this->levels->append(new AdoptLevel($this->type, $i));    
			}
		}
        return $this->levels;		
    }
	
	public function getMaxLevel(){
	    return $this->levels->count(); 
	}
	
	public function getCode(){
	    return codegen(10, 0);
	}
	
    public function getAltStatus(){
		if($this->alternates == "enabled" and $this->altoutlevel == 0){
			$rand = mt_rand(1, $this->altchance);
			if($rand == 1) return "yes";			
		}
		return "no";
    }
	
	public function getGender(){
	    $genders = array('f', 'm');
		$rand = rand(0,1);
		return $genders[$rand];
	}
	
	protected function save($field, $value){
		$mysidia = Registry::get("mysidia");
		$mysidia->db->update("adoptables", array($field => $value), "id='{$this->id}'");
	}
}
?>