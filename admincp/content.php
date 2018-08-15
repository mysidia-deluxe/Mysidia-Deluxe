<?php

class ACPContentController extends AppController{

    const PARAM = "pageurl";
	private $editor;
	
	public function __construct(){	
	    parent::__construct();
		include_once("../inc/ckeditor/ckeditor.php"); 	
		$mysidia = Registry::get("mysidia");
	    $this->editor = new CKEditor;	
	    $this->editor->basePath = '../../inc/ckeditor/';
		if($mysidia->usergroup->getpermission("canmanagecontent") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage users.");
		}
	}
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("content");
        $num = $stmt->rowCount();
        if($num == 0) throw new InvalidIDException("default_none");
		$this->setField("stmt", new DatabaseStatement($stmt));
	}
	
	public function add(){
        $mysidia = Registry::get("mysidia");
        if($mysidia->input->post("submit")){
		    if(!$mysidia->input->post("pageurl")) throw new BlankFieldException("url");
			if(!$mysidia->input->post("pagetitle")) throw new BlankFieldException("title");
			if(!$mysidia->input->post("pagecontent")) throw new BlankFieldException("content");
		    $date = new DateTime;
            $content = $this->format($mysidia->input->post("pagecontent"));
            $group = ($mysidia->input->post("group") == "none")?"":$mysidia->input->post("group");
			$mysidia->db->insert("content", array("cid" => NULL, "page" => $mysidia->input->post("pageurl"), "title" => $mysidia->input->post("pagetitle"), "date" => $date->format('Y-m-d'), "content" => $content, 
                                                  "level" => NULL, "code" => $mysidia->input->post("promocode"), "item" => $mysidia->input->post("item"), "time" => $mysidia->input->post("time"), "group" => $group));
			return;
		}
		$editor = $this->editor->editor("pagecontent", "CKEditor for Mys v1.3.4");
		$this->setField("editor", new DataObject($editor));
	}
	
	public function edit(){
        $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("pageurl") ){
		    // A page has yet been selected, return to the index page.
		    $this->index();
			return;
		}		
		$content = $mysidia->db->select("content", array(), "page = '{$mysidia->input->get("pageurl")}'")->fetchObject();
		
		if(!is_object($content)) throw new InvalidIDException("nonexist");		
		elseif($mysidia->input->post("submit")){
			if(!$mysidia->input->post("pagetitle")) throw new BlankFieldException("title");
			if(!$mysidia->input->post("pagecontent")) throw new BlankFieldException("content");			
		    $content = $this->format($mysidia->input->post("pagecontent"));
			$stmt = $mysidia->db->select("content", array(), "page='{$mysidia->input->get("pageurl")}'");
            if($page = $stmt->fetchObject()){
                $group = ($mysidia->input->post("group") == "none")?"":$mysidia->input->post("group");
                $mysidia->db->update("content", array("content" => $content, "title" => $mysidia->input->post("pagetitle"), "code" => $mysidia->input->post("promocode"), "item" => $mysidia->input->post("item"), 
                                                      "time" => $mysidia->input->post("time"), "group" => $group), "page='{$mysidia->input->get("pageurl")}'");
                return;
			}
            else throw new InvalidIDException("nonexist");			
		}
		else{
		    $this->editor->basePath = '../../../inc/ckeditor/';			
			$editor = $this->editor->editor("pagecontent", $this->format($content->content));
		    $this->setField("editor", new DataObject($editor));
		    $this->setField("content", new DataObject($content));			 
		}
	}
	
	public function delete(){
		$mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("pageurl")){
		    // A user has yet been selected, return to the index page.
		    $this->index();
			return;
		}		
		if($mysidia->input->get("pageurl") == "index" or $mysidia->input->get("pageurl") == "tos") throw new InvalidIDException("special");
		$mysidia->db->delete("content", "page='{$mysidia->input->get("pageurl")}'");
	}

    private function format($text){
         $text = html_entity_decode($text);
         $text = stripslashes($text);
         $text = str_replace("rn","",$text);
         return $text;
    }
}
?>