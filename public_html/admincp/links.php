<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPLinksController extends AppController{

	const PARAM = "lid";
    
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage links.");
		}	
    }
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");	
		$stmt = $mysidia->db->query("SELECT subcat.*,parentcat.linktext as parentname FROM ".constant("PREFIX")."links as subcat LEFT JOIN ".constant("PREFIX")."links as parentcat ON parentcat.id=subcat.linkparent ORDER BY subcat.id ASC");		
        $this->setField("stmt", new DatabaseStatement($stmt));		
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    if(!$mysidia->input->post("linktext") or !$mysidia->input->post("linkurl")) throw new BlankFieldException("global_blank");
            $linkParent = ($mysidia->input->post("linkparent") == "none")?0:$mysidia->input->post("linkparent");
            $mysidia->db->insert("links", array("id" => NULL, "linktype" => $mysidia->input->post("linktype"), "linktext" => $mysidia->input->post("linktext"), "linkurl" => $mysidia->input->post("linkurl"), "linkparent" => $linkParent, "linkorder" => $mysidia->input->post("linkorder")));	        
		}
	}
	
	public function edit(){
	   	$mysidia = Registry::get("mysidia");
  	   if(!$mysidia->input->get("lid")){
		    // A link has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $linkParent = ($mysidia->input->post("linkparent") == "none")?0:$mysidia->input->post("linkparent");
		    $mysidia->db->update("links", array("linktype" => $mysidia->input->post("linktype"), "linktext" => $mysidia->input->post("linktext"), "linkurl" => $mysidia->input->post("linkurl"), "linkparent" => $linkParent, "linkorder" => $mysidia->input->post("linkorder")), "id='{$mysidia->input->get("lid")}'");
		    return;
		}
		else{
			$link = $mysidia->db->select("links", array(), "id='{$mysidia->input->get("lid")}'")->fetchObject();
			if(!is_object($link)) throw new InvalidIDException("global_id");
			$this->setField("link", new DataObject($link));	 
		}
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $mysidia->frame->getDocument();
        if(!$mysidia->input->get("lid")){
		    // A link has yet been selected, return to the index page.
		    $this->index();
			return;
		}
        $mysidia->db->delete("links", "id='{$mysidia->input->get("lid")}'");
	}
}
?>