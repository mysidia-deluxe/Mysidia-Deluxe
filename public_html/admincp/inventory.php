<?php

class ACPInventoryController extends AppController{

    const PARAM = "iid";
	
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage item inventory.");
		}	
    }
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");			
		$stmt = $mysidia->db->select("inventory");
        $num = $stmt->rowCount();
        if($num == 0) throw new InvalidIDException("default_none");
		$this->setField("stmt", new DatabaseStatement($stmt));	
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();			
		    $inventory = $mysidia->db->select("inventory", array(), "itemname = '{$mysidia->input->post("itemname")}' and owner = '{$mysidia->input->post("owner")}'")->fetchObject();	    
			if(is_object($inventory)){
			    $newquantity = $inventory->quantity + $mysidia->input->post("quantity");  
                $mysidia->db->update("inventory", array("quantity" => $newquantity), "itemname='{$mysidia->input->post("itemname")}' and owner='{$mysidia->input->post("owner")}'");	 
			}
			else{
			    $item = $mysidia->db->select("items", array("id","category"), "itemname = '{$mysidia->input->post("itemname")}'")->fetchObject();	
			    $mysidia->db->insert("inventory", array("iid" => NULL, "category" => $item->category, "itemname" => $mysidia->input->post("itemname"),
			                                            "owner" => $mysidia->input->post("owner"), "quantity" => $mysidia->input->post("quantity"), "status" => 'Available'));	
			}
		}
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");		
	    if(!$mysidia->input->get("iid")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $this->dataValidate();
			$mysidia->db->update("inventory", array("itemname" => $mysidia->input->post("itemname"), "owner" => $mysidia->input->post("owner"), "quantity" => $mysidia->input->post("quantity")), "iid='{$mysidia->input->get("iid")}'");			
		    return;
		}
		else{
		    $inventory = $mysidia->db->select("inventory", array(), "iid='{$mysidia->input->get("iid")}'")->fetchObject();		
		    if(!is_object($inventory)) throw new InvalidIDException("nonexist");
			$this->setField("inventory", new DataObject($inventory));
	    }
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("iid")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
        $mysidia->db->delete("inventory", "iid='{$mysidia->input->get("iid")}'");
    }
	
	private function dataValidate(){
	    $mysidia = Registry::get("mysidia");
		if(!$mysidia->input->post("itemname")) throw new BlankFieldException("itemname");	
		if(!$mysidia->input->post("owner")) throw new BlankFieldException("owner"); 
		if(!is_numeric($mysidia->input->post("quantity")) or $mysidia->input->post("quantity") < 0) throw new BlankFieldException("quantity");
		header("Refresh:3; URL='../../index'");
        return TRUE;
	}
}	
?>