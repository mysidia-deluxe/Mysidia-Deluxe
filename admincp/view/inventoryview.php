<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPInventoryView extends View{

	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();
        $document = $this->document;
		
        $fields = new LinkedHashMap;
		$fields->put(new String("iid"), NULL);
		$fields->put(new String("itemname"), NULL);
		$fields->put(new String("owner"), NULL);
		$fields->put(new String("quantity"), NULL);		
		$fields->put(new String("iid::edit"), new String("getEditLink"));
		$fields->put(new String("iid::delete"), new String("getDeleteLink"));	
		
		$inventoryTable = new TableBuilder("inventory");
		$inventoryTable->setAlign(new Align("center", "middle"));
		$inventoryTable->buildHeaders("ID", "Item", "Owner", "Quantity", "Edit", "Delete");
		$inventoryTable->setHelper(new TableHelper);
		$inventoryTable->buildTable($stmt, $fields);
        $document->add($inventoryTable);	
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
		$inventoryForm = new Form("additem", "add", "post");
		$title = new Comment("Give an Item to User:");
		$title->setBold();
		$title->setUnderlined();
		$inventoryForm->add($title);
		
		$inventoryForm->add(new Comment("Item Name: ", FALSE));
		$inventoryForm->add(new TextField("itemname"));
		$inventoryForm->add(new Comment("<br>(This may contain only letters, numbers and spaces)"));
		$inventoryForm->add(new Comment("Item Owner: ", FALSE));
		$inventoryForm->add(new TextField("owner"));
		$inventoryForm->add(new Comment("Item Quantity: ", FALSE));
		$inventoryForm->add(new TextField("quantity", 1, 6));
		$inventoryForm->add(new Button("Give Item", "submit", "submit"));
		$document->add($inventoryForm);
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
		
	    if(!$mysidia->input->get("iid")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){		
		    $document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		else{
		    $inventory = $this->getField("inventory")->get();
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);
		    $title = new Comment("Edit User's Items:");
		    $title->setBold();
		    $title->setUnderlined();
			
			$inventoryForm = new Form("edititem", $mysidia->input->get("iid"), "post");			
		    $inventoryForm->add($title);		
		    $inventoryForm->add(new Comment("Item Name: ", FALSE));
		    $inventoryForm->add(new TextField("itemname", $inventory->itemname));
		    $inventoryForm->add(new Comment("<br>(This may contain only letters, numbers and spaces)"));
		    $inventoryForm->add(new Comment("Item Owner: ", FALSE));
		    $inventoryForm->add(new TextField("owner", $inventory->owner));
		    $inventoryForm->add(new Comment("Item Quantity: ", FALSE));
		    $inventoryForm->add(new TextField("quantity", $inventory->quantity, 6));
		    $inventoryForm->add(new Button("Edit Item", "submit", "submit"));
		    $document->add($inventoryForm); 
	    }
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("iid")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
    }
}	
?>