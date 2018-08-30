<?php

class StockAdopt{
  // The StockItem class, which defines items currently in Itemshop and thus is not owned by any users
  
  public $id = 0;
  public $type;
  public $class;
  public $description;
  public $eggimage;
  public $whenisavail;
  public $alternates; 	
  public $altoutlevel;	
  public $altchance; 	
  public $cost;
  public $owner;
  
  public function __construct($adopttype){     
      // the adoptable is a new adoptable to be purchased, and does not belong to anyone at this very moment.
	  
      $mysidia = Registry::get("mysidia");
	  $row = $mysidia->db->select("adoptables", array(), "type ='{$adopttype}'")->fetchObject();
	  // loop through the anonymous object created to assign properties
	  if(!is_object($row)) throw New Exception("The adoptable specified is invalid...");
      foreach($row as $key => $val){
         $this->$key = $val;		 
      }
      $this->owner = "SYSTEM";	  
 
      // the stock adopt object is successfully created with appropriate properties assigned.	
  }
 
  public function assign($owner){
      // This method assigns an owner to the stock item, which will soon appear in his/her inventory
	  $this->owner = $owner;
  }
  
  public function getcost($salestax = 0){
      // Get the total cost of this stock item
	  $cost = $this->cost*(1+$salestax/100);
	  return $cost;
  }
  
  protected function getaltstatus($level) {
	  // This method determines if we will use alternate images...
	  $altstatus = "no";
	  $run = "no";
	   
	  // Let's see if the level we are on is the level that requires alternates
	  if($this->alternates == "enabled" and $level == $this->altoutlevel) $run = "yes";
	  if($run == "yes") {
		 $randnum = rand(1, $row->altchance);
		 if($randnum == 1) $altstatus = "yes"; // If we pull a 1 as the random number, we use the alternate images :)
	  }
	  return $altstatus;
  }
  
  public function append($owner = ""){
      // This method adds items to user inventory
  
      $mysidia = Registry::get("mysidia");
      $this->owner = (!empty($owner))?$owner:$this->owner;
      $alts = $this->getaltstatus(0);
	  $code = codegen(10, 0);
	  $genders = array('f', 'm');
	  $rand = rand(0,1);
	  $mysidia->db->insert("owned_adoptables", array("aid" => NULL, "type" => $this->type, "name" => $this->type, "owner" => $this->owner,
	                                                 "currentlevel" => 0, "totalclicks" => 0, "code" => $code, "imageurl" => "", "usealternates" => $alts, 
													 "tradestatus" => "fortrade", "isfrozen" => "no", "gender" => $genders[$rand],
													 "offsprings" => 0, "lastbred" => 0));	  
	  $state = "success";
	  return $state;
  }
    
}
?>