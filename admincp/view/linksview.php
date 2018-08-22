<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPLinksView extends View{
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$LinksTable = new TableBuilder("links");
		$LinksTable->setAlign(new Align("center", "middle"));
		$LinksTable->buildHeaders("ID", "Link Type", "Link Text", "Link Url", "Link Parent", "Link Order", "Edit", "Delete");
				
		$stmt = $this->getField("stmt")->get();	
		while($links = $stmt->fetchObject()){
		    $parentid=($links->linkparent != 0)?$links->linkparent:"N/A";
			$parenttext = ($parentid == "N/A")?$parentid:$mysidia->db->select("links", array("linktext"), "id='{$parentid}'")->fetchColumn();
			$cells = new LinkedList;
			$cells->add(new TCell($links->id));
            $cells->add(new TCell($links->linktype));
            $cells->add(new TCell($links->linkurl));
			$cells->add(new TCell($links->linktext));
			$cells->add(new TCell($parenttext));
            $cells->add(new TCell($links->linkorder));
			$cells->add(new TCell(new Link("admincp/links/edit/{$links->id}", new Image("templates/icons/cog.gif"))));
			$cells->add(new TCell(new Link("admincp/links/delete/{$links->id}", new Image("templates/icons/delete.gif"))));
			$LinksTable->buildRow($cells);
		}
		$document->add($LinksTable);
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    if($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->added_title);
			$document->addLangvar($this->lang->added); 
            return;          
		}
		
	    $document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);
        $linkTypes = new LinkedHashMap;
		$linkTypes->put(new Mystring("Navlink"), new Mystring("navlink"));
		$linkTypes->put(new Mystring("Sidelink"), new Mystring("sidelink"));

		$LinksForm = new FormBuilder("addform", "add", "post");
        $LinksForm->add(new Comment("Link Type: ", FALSE));
        $LinksForm->buildRadioList("linktype", $linkTypes, "navlink");
		$LinksForm->add(new Comment("Link Text: ", FALSE));
		$LinksForm->add(new TextField("linktext"));
		$LinksForm->add(new Comment($this->lang->text));
		$LinksForm->add(new Comment("Link URL: ", FALSE));
		$LinksForm->add(new TextField("linkurl"));
		$LinksForm->add(new Comment($this->lang->url));
		$LinksForm->add(new Comment("Link parent:", FALSE));
		$LinksForm->buildDropdownList("linkparent", "ParentLinkList");
		$LinksForm->add(new Comment("Link Order: ", FALSE));
		$LinksForm->add(new TextField("linkorder", 0));
		$LinksForm->add(new Button("Add Link", "submit", "submit"));
		$document->add($LinksForm);
	}
	
	public function edit(){
	   	$mysidia = Registry::get("mysidia");
		$document = $this->document;	  
  	   if(!$mysidia->input->get("lid")){
		    // A link has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		else{
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);
			$link = $this->getField("link")->get();
            $linkTypes = new LinkedHashMap;
		    $linkTypes->put(new Mystring("Navlink"), new Mystring("navlink"));
		    $linkTypes->put(new Mystring("Sidelink"), new Mystring("sidelink"));
			
			$LinksForm = new FormBuilder("editform", $mysidia->input->get("lid"), "post");
            $LinksForm->add(new Comment("Link Type: ", FALSE));
            $LinksForm->buildRadioList("linktype", $linkTypes, $link->linktype);
			$LinksForm->add(new Comment("Link Text: ", FALSE));
		    $LinksForm->add(new TextField("linktext", $link->linktext));
		    $LinksForm->add(new Comment($this->lang->text));
		    $LinksForm->add(new Comment("Link URL: ", FALSE));
		    $LinksForm->add(new TextField("linkurl", $link->linkurl));
		    $LinksForm->add(new Comment($this->lang->url));
		    $LinksForm->add(new Comment("Link parent:", FALSE));
		  	$LinksForm->buildDropdownList("linkparent", "ParentLinkList", $link->linkparent);
	    	$LinksForm->add(new Comment("Link Order: ", FALSE));
		    $LinksForm->add(new TextField("linkorder", $link->linkorder));
			$LinksForm->add(new Button("Edit Link", "submit", "submit"));
			$document->add($LinksForm);			 
		}
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("lid")){
		    // A link has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
	}
}
?>