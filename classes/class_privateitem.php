<?php

use Resource\Native\Mystring;

class PrivateItem extends Item{
  // The PrivateItem class, which defines functionalities for items that belong to specific users

  public $iid;
  public $owner;
  public $quantity;
  public $status;
  
  public function __construct($iteminfo, $itemowner = ""){     
	  // the item is an owned item in user inventory, so retrieve database info to assign properties
	  $mysidia = Registry::get("mysidia");
	  
	  $fetchmode = (is_numeric($iteminfo))?"iid":"itemname";
      $whereclause = ($fetchmode == "iid")?"{$fetchmode} = '{$iteminfo}'":"{$fetchmode} ='{$iteminfo}' and owner = '{$itemowner}'";		  
      $row = $mysidia->db->select("inventory", array(), $whereclause)->fetchObject();
	  if(is_object($row)){
	     // loop through the anonymous object created to assign properties
	     foreach($row as $key => $val){
            $this->$key = $val;
         }
	     parent::__construct($this->itemname);
      }
      else $this->iid = 0;	  
  }
 
  public function getitem(){
      // This method checks if the item exists in inventory or not, not to be confused with parent class' getitem() class.
	  $mysidia = Registry::get("mysidia");
	  $stmt = $mysidia->db->select("inventory", array(), "itemname ='{$this->itemname}' and owner ='{$this->owner}'"); 
	  return $stmt->fetchObject();
  }
 
  public function getvalue($quantity = 0, $discount = 0.5){
      // This method returns the cost of items.
	  
      $value = $this->price*$quantity*$discount;
	  return $value;
  }
  
  public function apply($adopt = "", $user = ""){
      // This method uses 
      $mysidia = Registry::get("mysidia");
	  require_once("functions/functions_items.php");
	  
      if(is_numeric($adopt)) $owned_adoptable = $mysidia->db->select("owned_adoptables", array(), "aid ='{$adopt}'")->fetchObject();
      if(!empty($user)) $theuser = $mysidia->db->select("users", array(), "username ='{$user}'")->fetchObject();
	  
      // Now we decide which function to call...
      switch($this->function){
         case "Valuable": 
            $message = items_valuable($this, $owned_adoptable);
            break;
         case "Level1":
            $message = items_level1($this, $owned_adoptable);
            break;
         case "Level2":
            $message = items_level2($this, $owned_adoptable);
            break;
         case "Level3":
            $message = items_level3($this, $owned_adoptable);
            break;
         case "Click1":
            $message = items_click1($this, $owned_adoptable);
            break;
         case "Click2":
            $message = items_click2($this, $owned_adoptable);
            break;
         case "Breed1":
            $message = items_breed1($this, $owned_adoptable);
            break;
         case "Breed2":
            $message = items_breed2($this, $owned_adoptable);
            break;
         case "Alts1":
            $message = items_alts1($this, $owned_adoptable);
            break;
         case "Alts2":
            $message = items_alts2($this, $owned_adoptable);
            break;
         case "Name1":
            $message = items_name1($this, $theuser);
            break;
         case "Name2":
            $message = items_name2($this, $theuser);
            break;
		 default:
            throw new ItemException("The item function is invalid");		 
      }
	  return new Mystring($message);
  }  

  public function add($quantity = 1, $owner){

  }

  public function sell($quantity = 1, $owner = ""){
      // This method sells items from user inventory
	  $mysidia = Registry::get("mysidia");
	  
      $this->owner = (!empty($owner))?$owner:$this->owner;
      $earn = $this->getvalue($quantity);      
      $newamount = $mysidia->user->money + $earn;
	  
      if($this->remove($quantity)){
         $mysidia->db->update("users", array("money" => $newamount), "username = '{$this->owner}'");
	     return TRUE;
      }
      else return FALSE; 	 
  }
  
  public function toss($owner = ""){
	  $this->remove($this->quantity);
	  return TRUE;
  }
  
  public function remove($quantity = 1, $owner = ""){
      // This method removes items from user inventory
  
      $mysidia = Registry::get("mysidia");
      $this->owner = (!empty($owner))?$owner:$this->owner;
      $newquantity = $this->quantity - $quantity;
	  if(empty($this->quantity) or $newquantity < 0) return FALSE;
	  else{
	     switch($newquantity){
		    case 0:
			   $mysidia->db->delete("inventory", "itemname='{$this->itemname}' and owner='{$this->owner}'");
			   break;
			default:
			   $mysidia->db->update("inventory", array("quantity" => $newquantity), "itemname ='{$this->itemname}' and owner='{$this->owner}'");
		 }
	     return TRUE;
	  }
  }
  
  public function checktarget($aid){
      // This method checks if the item is usable
	  $adopt = new OwnedAdoptable($aid);
      $id = $adopt->getID();
	  $item_usable = FALSE;
	  switch($this->target){
         case "all":
		    $item_usable = TRUE;
		    break;
         case "user":
		    $item_usable = TRUE;
		    break;
		 default:
		    $target = explode(",",$this->target);
            if(in_array($id, $target)) $item_usable = TRUE;			
	  }
	  return $item_usable;
  }
  
  public function randomchance(){
      // This method returns the item image in standard html form
	  $mysidia = Registry::get("mysidia");
	  switch($this->chance){
	     case 100:
            $item_usable = TRUE;
		    break;
         default:
		    $temp = mt_rand(0,99);
			$item_usable = ($temp < $this->chance)?TRUE:FALSE;
	  }
      return $item_usable;	  
  }
}
?>