<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPWidgetController extends AppController{

	const PARAM = "wid";
    
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage widgets.");
		}	
    }
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("widgets");	
        $this->setField("stmt", new DatabaseStatement($stmt));
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    if(!$mysidia->input->post("name")) throw new BlankFieldException("global_blank");
            $userLevel = (!$mysidia->input->post("controllers"))?"main":$mysidia->input->post("controllers");
			$mysidia->db->insert("widgets", array("wid" => NULL, "name" => $mysidia->input->post("name"), "controller" => $mysidia->input->post("controllers"), 
			                                      "order" => $mysidia->input->post("order"), "status" => $mysidia->input->post("status")));	       
		}
	}
	
	public function edit(){
	   	$mysidia = Registry::get("mysidia");  
  	   if(!$mysidia->input->get("wid")){
		    // A widget has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    if(!$mysidia->input->post("name")) throw new BlankFieldException("global_blank");
		    $mysidia->db->update("widgets", array("name" => $mysidia->input->post("name"), "controller" => $mysidia->input->post("controllers"), 
			                                      "order" => $mysidia->input->post("order"), "status" => $mysidia->input->post("status")), "wid='{$mysidia->input->get("wid")}'");
		    return;
		}
		else{
			$widget = $mysidia->db->select("widgets", array(), "wid='{$mysidia->input->get("wid")}'")->fetchObject();
			if(!is_object($widget)) throw new InvalidIDException("global_id");
            $this->setField("widget", new DataObject($widget));	 
		}
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("wid")){
		    // A widget has yet been selected, return to the index page.
		    $this->index();
			return;
		}
        if($mysidia->input->get("wid")->getValue() < 6) throw new InvalidActionException("internal");
        $mysidia->db->delete("widgets", "wid='{$mysidia->input->get("wid")}'");
	}	
}
?>