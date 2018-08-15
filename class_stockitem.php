<?php

class StockItem extends Item{
  // The StockItem class, which defines items currently in Itemshop and thus is not owned by any users

  public $iid = 0;
  public $owner;
  public $quantity;
  public $status;
  
  public function __construct($iteminfo, $itemquantity = 0){     
      // the item is a new item to be added or used, and does not belong to anyone at this very moment.
	  
      parent::__construct($iteminfo);
      $this->quantity = $itemquantity;
      $this->status = "Available";           
 
      // the stock item object is successfully created with appropriate properties assigned.	
  }
 
  public function assign($owner){
      // This method assigns an owner to the stock item, which will soon appear in his/her inventory
	  $this->owner = $owner;
  }
  
  public function getoldquantity($owner = ""){
      // This method returns the quantity of items the owner already has, do not call unless both old and new quantities need to be used in script
      $mysidia = Registry::get("mysidia");
	  $this->owner = (empty($this->owner))?$owner:$this->owner;
	  $oldquantity = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$this->itemname}' and owner ='{$this->owner}'")->fetchColumn();
      return $oldquantity;	  
  }
  
  public function getcost($salestax = 0, $quantity = ""){
      // Get the total cost of this stock item
      $mysidia = Registry::get("mysidia");
      if(empty($quantity)) $quantity = $mysidia->input->post("quantity");
	  $cost = $this->price*$quantity*(1+$salestax/100);
	  return $cost;
  }
  
  public function append($quantity= 1, $owner = ""){
      // This method adds items to user inventory
  
      $mysidia = Registry::get("mysidia");
      $this->owner = (!empty($owner))?$owner:$this->owner;
	  $oldquantity = $this->getoldquantity();	  
      if($oldquantity > 0){
	     // the item already exists, update the row for user's inventory
	     $newquantity = $oldquantity + $quantity;
		 $mysidia->db->update("inventory", array("quantity" => $newquantity), "itemname ='{$this->itemname}' and owner='{$this->owner}'");  
	  }
	  else{	     
		 // the item does not exist yet, insert a new row into user's inventory
		 $mysidia->db->insert("inventory", array("iid" => NULL, "category" => $this->category, "itemname" => $this->itemname, "owner" => $this->owner, "quantity" => $quantity, "status" => 'Available'));
	  }
	  
	  $state = "success";
	  return $state;
  }
    
}
?>