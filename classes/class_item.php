<?php

use Resource\Native\Object;

class Item extends Model{
  // The item class.

    public $id;
    public $category;
    public $itemname;
    public $description;
    public $imageurl;
    public $function;
    public $target;
    public $shop;
    public $price;
    public $chance;
    public $cap;
    public $tradable;
    public $consumable;

    public function __construct($iteminfo){
	    // Fetch the database info into object property
	    $mysidia = Registry::get("mysidia");
	    $whereclause = (is_numeric($iteminfo))?"id ='{$iteminfo}'":"itemname ='{$iteminfo}'";
	    $row = $mysidia->db->select("items", array(), $whereclause)->fetchObject();
	    // loop through the anonymous object created to assign properties
	    if(!is_object($row)) throw New ItemException("The item specified is invalid...");
        foreach($row as $key => $val){
            $this->$key = $val;		 
        }	    
    }

    public function getcategory(){
        // This method checks if the item category exists in items database or not
	    $mysidia = Registry::get("mysidia");
	    $stmt = $mysidia->db->select("items", array(), "category ='{$this->category}'");
        $cate_exist = ($row = $stmt->fetchObject())?TRUE:FALSE;     
	    return $cate_exist;
    }
 
    public function getitem(){
        // This method checks if the item exists in items database or not
	    $mysidia = Registry::get("mysidia");
	    $stmt = $mysidia->db->select("items", array(), "itemname ='{$this->itemname}'");
        $item_exist = ($row = $stmt->fetchObject())?TRUE:FALSE;     
	    return $item_exist;
    }

    protected function save($field, $value){
	    return FALSE;
    }	 
}
?> 