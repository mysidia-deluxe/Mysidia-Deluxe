<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPContentView extends View{
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();
		$document = $this->document;	
        $fields = new LinkedHashMap;
		$fields->put(new String("page"), NULL);
		$fields->put(new String("title"), NULL);		
		$fields->put(new String("page::edit"), new String("getEditLink"));
		$fields->put(new String("page::delete"), new String("getDeleteLink"));	
		
        $pagesTable = new TableBuilder("ads");
		$pagesTable->setAlign(new Align("center", "middle"));
		$pagesTable->buildHeaders("URL", "Title", "Edit", "Delete"); 		
		$pagesTable->setHelper(new TableHelper);
        $pagesTable->buildTable($stmt, $fields);
        $document->add($pagesTable);
	}
	
	public function add(){
        $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->added_title);
		    $document->addLangvar($this->lang->added);
			return;
		}
		
		$editor = $this->getField("editor")->get();			
		$document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);	
		$pageForm = new Form("addpage", "add", "post");
		
		$basic = new FieldSet;
        $basic->add(new Legend("Basic Settings"));		
		$basic->add(new Comment("Page URL: ", FALSE));
		$basic->add(new TextField("pageurl"));
		$basic->add(new Comment($this->lang->explain));
		$basic->add(new Comment("Page Title: ", FALSE));
		$basic->add(new TextField("pagetitle"));
		$basic->add(new Comment("Page Content: ", FALSE));
		$basic->add(new Comment($editor));
		$pageForm->add($basic);
		
        $accessibility = new FieldSetBuilder("Accessibility Settings");
		$accessibility->add(new Comment($this->lang->accessibility));
		$accessibility->add(new Comment("Code: (The promocode required to access this page) ", FALSE));
		$accessibility->add(new TextField("promocode"));
		$accessibility->add(new Comment("Item: (The item necessary to access this page) ", FALSE));
		$accessibility->add(new TextField("item"));
		$accessibility->add(new Comment("Date: (The time available to access this page, format: y-m-d) ", FALSE));
		$accessibility->add(new TextField("time"));
		$accessibility->add(new Comment("Group: (The usergroup allowed to access this page) ", FALSE));
		$accessibility->buildDropdownList("group", "UsergroupList")
                      ->buildButton("Create New Page", "submit", "submit");
        $pageForm->add($accessibility);
	    $document->add($pageForm);	
	}
	
	public function edit(){
        $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("pageurl") ){
		    // A page has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		
		$content = $mysidia->db->select("content", array(), "page = '{$mysidia->input->get("pageurl")}'")->fetchObject();
		
		if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->edited_title);
		    $document->addLangvar($this->lang->edited);
            return;		
		}
		else{
			$editor = $this->getField("editor")->get();
            $content = $this->getField("content")->get();			
			$document->setTitle($this->lang->edit_title);
		    $document->addLangvar($this->lang->edit);					
			$pageForm = new Form("editpage", $mysidia->input->get("pageurl"), "post");
			
		    $basic = new FieldSet;
            $basic->add(new Legend("Basic Settings"));
            $basic->add(new Comment($this->lang->editing));			
		    $basic->add(new Comment("Page Title: ", FALSE));
		    $basic->add(new TextField("pagetitle", $content->title));
		    $basic->add(new Comment("Page Content: ", FALSE));
		    $basic->add(new Comment($editor));
		    $pageForm->add($basic);
		
            $accessibility = new FieldSetBuilder("Accessibility Settings");
		    $accessibility->add(new Comment($this->lang->accessibility));
		    $accessibility->add(new Comment("Code: (The promocode required to access this page) ", FALSE));
	     	$accessibility->add(new TextField("promocode", $content->code));
	    	$accessibility->add(new Comment("Item: (The item necessary to access this page) ", FALSE));
		    $accessibility->add(new TextField("item", $content->item));
		    $accessibility->add(new Comment("Date: (The time available to access this page, format: y-m-d) ", FALSE));
		    $accessibility->add(new TextField("time", $content->time));
	    	$accessibility->add(new Comment("Group: (The usergroup allowed to access this page) ", FALSE));
            $accessibility->buildDropdownList("group", "UsergroupList", $content->group)
                          ->buildButton("Edit this Page", "submit", "submit");	
            $pageForm->add($accessibility);
	        $document->add($pageForm);		 
		}
	}
	
	public function delete(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("pageurl")){
		    // A user has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
	}
}
?>