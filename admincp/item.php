<?php

class ACPItemController extends AppController{

    const PARAM = "id";
	
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage items.");
		}		
    }
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");		
		$stmt = $mysidia->db->select("items");
        $num = $stmt->rowCount();
        if($num == 0) throw new InvalidIDException("default_none");
		$this->setField("stmt", new DatabaseStatement($stmt));	
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();
			$imageurl = ($mysidia->input->post("existingimageurl") == "none")?$mysidia->input->post("imageurl"):$mysidia->input->post("existingimageurl");
			$value = (!$mysidia->input->post("value"))?0:$mysidia->input->post("value");
			$price = (!$mysidia->input->post("price"))?0:$mysidia->input->post("price");
			
		    $mysidia->db->insert("items", array("category" => $mysidia->input->post("category"), "itemname" => $mysidia->input->post("itemname"), "description" => $mysidia->input->post("description"), "imageurl" => $imageurl, "function" => $mysidia->input->post("function"), "target" => $mysidia->input->post("target"), "value" => $value,  
			                                    "shop" => $mysidia->input->post("shop"), "price" => $price, "chance" => $mysidia->input->post("chance"), "cap" => $mysidia->input->post("cap"), "tradable" => $mysidia->input->post("tradable"), "consumable" => $mysidia->input->post("consumable")));		
		}
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");		
	    if(!$mysidia->input->get("id")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $this->dataValidate();
            $imageurl = ($mysidia->input->post("existingimageurl") == "none")?$mysidia->input->post("imageurl"):$mysidia->input->post("existingimageurl");
			$mysidia->db->update("items", array("category" => $mysidia->input->post("category"), "itemname" => $mysidia->input->post("itemname"), "imageurl" => $imageurl, "function" => $mysidia->input->post("function"), "target" => $mysidia->input->post("target"), "value" => $mysidia->input->post("value"),  
			                                    "shop" => $mysidia->input->post("shop"), "price" => $mysidia->input->post("price"), "chance" => $mysidia->input->post("chance"), "cap" => $mysidia->input->post("cap"), "tradable" => $mysidia->input->post("tradable"), "consumable" => $mysidia->input->post("consumable")), "id='{$mysidia->input->get("id")}'");		
            $this->update();
		    return;
		}
		else{
		    $item = $mysidia->db->select("items", array(), "id='{$mysidia->input->get("id")}'")->fetchObject();		
		    if(!is_object($item)) throw new InvalidIDException("nonexist");			
		    $this->setField("item", new DataObject($item));	 
		}
	}

	public function delete(){
	    $mysidia = Registry::get("mysidia");	
        if(!$mysidia->input->get("id")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
        $mysidia->db->delete("items", "id='{$mysidia->input->get("id")}'");
	}
	
	public function functions(){
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("items_functions");	
        $this->setField("stmt", new DatabaseStatement($stmt));
	}
	
	private function dataValidate(){
	    $mysidia = Registry::get("mysidia");
		if(!$mysidia->input->post("category")) throw new BlankFieldException("category");
		if(!$mysidia->input->post("itemname")) throw new BlankFieldException("itemname");	
		if(!$mysidia->input->post("imageurl") and $mysidia->input->post("existingimageurl") == "none") throw new BlankFieldException("images"); 		
		if($this->action == "add"){
		    $item = $mysidia->db->select("items", array(), "itemname = '{$mysidia->input->post("itemname")}'")->fetchObject();
		    if(is_object($item)) throw new DuplicateIDException("duplicate");
		}	
		return TRUE;
	}

    private function update(){
	    $mysidia = Registry::get("mysidia");
		if($mysidia->input->post("itemname") != $mysidia->input->post("originame")){
            // Update itemnames in user inventory
            $num = $mysidia->db->select("inventory", array(), "itemname='{$mysidia->input->post("originame")}'")->rowCount();
            while($num > 0){
  		  	    $mysidia->db->update("inventory", array("itemname" => $mysidia->input->post("itemname")), "itemname='{$mysidia->input->post("originame")}'");                  
                $num--;
            }
        }
		if($mysidia->input->post("category") != $mysidia->input->post("origincat")){
            // Update itemnames in user inventory
            $num = $mysidia->db->select("inventory", array(), "category='{$mysidia->input->post("origincat")}'")->rowCount();
            while($num > 0){
  		  	    $mysidia->db->update("inventory", array("category" => $mysidia->input->post("category")), "itemname='{$mysidia->input->post("origincat")}'");                  
                $num--;
            }
        }

        return TRUE;
    }
}
?>