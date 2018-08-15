<?php

use Resource\Native\String;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPItemView extends View{
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();		
		$document = $this->document;
        $fields = new LinkedHashMap;
		$fields->put(new String("imageurl"), new String("getImage"));
		$fields->put(new String("itemname"), NULL);
		$fields->put(new String("description"), NULL);
		$fields->put(new String("function"), NULL);			
		$fields->put(new String("id::edit"), new String("getEditLink"));
		$fields->put(new String("id::delete"), new String("getDeleteLink"));	
		
		$itemTable = new TableBuilder("item");
		$itemTable->setAlign(new Align("center", "middle"));
		$itemTable->buildHeaders("Image", "Item", "Description", "Function", "Edit", "Delete");
		$itemTable->setHelper(new TableHelper);
		$itemTable->buildTable($stmt, $fields);
        $document->add($itemTable);
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
		$itemForm = new FormBuilder("addform", "add", "post");
		$title = new Comment("Create a New Item:");
		$title->setBold();
		$title->setUnderlined();
		$itemForm->add($title);
		
		$itemForm->add(new Comment("Basic Info: ", TRUE, "b"));
		$itemForm->add(new Comment("Item Name: ", FALSE));
		$itemForm->add(new TextField("itemname"));
		$itemForm->add(new Comment($this->lang->itemname_explain));
		$itemForm->add(new Comment("Item Category: ", FALSE));
		$itemForm->add(new TextField("category"));
		$itemForm->add(new Comment($this->lang->category_explain));
		$itemForm->add(new Comment("Item Description: "));
		$itemForm->add(new TextArea("description", "Here you can enter a description for your item", 4, 45));
		$itemForm->add(new Comment("Item Image: ", FALSE));
		$itemForm->add(new TextField("imageurl"));
		$itemForm->add(new Comment($this->lang->image_explain));	
		$itemForm->add(new Comment("Or select an existing image: ", FALSE));
		$itemForm->buildDropdownList("existingimageurl", "ImageList"); 
		
        $itemForm->add(new Comment("<hr>Items Functions and Intents:", TRUE, "b"));
        $itemForm->add(new Comment("Choose an item function from the list below, this will determine what happens to this item if used in inventory:"));
		$itemForm->buildDropdownList("function", "ItemFunctionList"); 				
        $itemForm->add(new Comment($this->lang->target_explain));
		$itemForm->add(new TextField("target", "all"));
		$itemForm->add(new Comment($this->lang->value_explain));
		$itemForm->add(new TextField("value"));
		$itemForm->add(new Comment("<hr>Item Shop Settings:", TRUE, "b"));
		$itemForm->add(new Comment("Item Shop: ", FALSE));
		$itemForm->add(new TextField("shop"));
		$itemForm->add(new Comment($this->lang->shop_explain));
		$itemForm->add(new Comment("Item Price: ", FALSE));
		$itemForm->add(new TextField("price"));
		$itemForm->add(new Comment($this->lang->price_explain));
		
		$itemForm->add(new Comment("Miscellaneous Settings:", TRUE, "b"));
		$itemForm->add(new Comment("Chance for item to take effect", FALSE));
		$itemForm->add(new TextField("chance", 100));
		$itemForm->add(new Comment($this->lang->chance_explain));
		$itemForm->add(new Comment("Upper Limit to Purchasable Amount: ", FALSE));
		$itemForm->add(new TextField("cap", 99));
		$itemForm->add(new Comment($this->lang->limit_explain));
		$itemForm->add(new CheckBox("<b>The item can be traded.</b>", "tradable", "yes"));
		$itemForm->add(new CheckBox("<b>The item can be consumed(thus its quantity decreases by 1 each time used)</b>", "consumable", "yes"));
		$itemForm->add(new Button("Create Item", "submit", "submit"));
		$document->add($itemForm);
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
	    if(!$mysidia->input->get("id")){
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
		    $item = $this->getField("item")->get();			
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);
			$itemForm = new FormBuilder("editform", $mysidia->input->get("id"), "post");
		    $title = new Comment("Edit an Item:");
		    $title->setBold();
		    $title->setUnderlined();
		    $itemForm->add($title);
			
			$itemForm->add(new Comment("Basic Info: ", TRUE, "b"));
		    $itemForm->add(new Comment("Item Name: ", FALSE));
		    $itemForm->add(new TextField("itemname", $item->itemname));
		    $itemForm->add(new Comment($this->lang->itemname_explain));
		    $itemForm->add(new Comment("Item Category: ", FALSE));
		    $itemForm->add(new TextField("category", $item->category));
		    $itemForm->add(new Comment("Item Image: ", FALSE));
		    $itemForm->add(new TextField("imageurl", $item->imageurl));
		    $itemForm->add(new Comment($this->lang->image_explain));	
		    $itemForm->add(new Comment("Or select an existing image: ", FALSE));
			$itemForm->buildDropdownList("existingimageurl", "ImageList", $item->imageurl); 
            $itemForm->add(new Comment("<hr>Items Functions and Intents:", TRUE, "b"));
            $itemForm->add(new Comment("Choose an item function from the list below, this will determine what happens to this item if used in inventory:"));
		    $itemForm->buildDropdownList("function", "ItemFunctionList", $item->function); 	
		
            $itemForm->add(new Comment($this->lang->target_explain));
		    $itemForm->add(new TextField("target", $item->target));
            $itemForm->add(new Comment("You may also assign a unique value to the item:", FALSE));
		    $itemForm->add(new TextField("value", $item->value));
		    $itemForm->add(new Comment($this->lang->value_explain));
		    $itemForm->add(new Comment("<hr>Item Shop Settings:", TRUE, "b"));
		    $itemForm->add(new Comment("Item Shop: ", FALSE));
		    $itemForm->add(new TextField("shop", $item->shop));
		    $itemForm->add(new Comment($this->lang->shop_explain));
		    $itemForm->add(new Comment("Item Price: ", FALSE));
		    $itemForm->add(new TextField("price", $item->price));
		    $itemForm->add(new Comment($this->lang->price_explain));
		
		    $itemForm->add(new Comment("Miscellaneous Settings:", TRUE, "b"));
		    $itemForm->add(new Comment("Chance for item to take effect", FALSE));
		    $itemForm->add(new TextField("chance", $item->chance));
		    $itemForm->add(new Comment($this->lang->chance_explain));
		    $itemForm->add(new Comment("Upper Limit to Purchasable Amount: ", FALSE));
		    $itemForm->add(new TextField("cap", $item->cap));
		    $itemForm->add(new Comment($this->lang->limit_explain));
		    $itemForm->add(new CheckBox("<b>The item can be traded.</b>", "tradable", "yes", $item->tradable));
		    $itemForm->add(new CheckBox("<b>The item can be consumed(thus its quantity decreases by 1 each time used)</b>", "consumable", "yes", $item->consumable));
		    $itemForm->add(new Button("Edit Item", "submit", "submit"));
		    $document->add($itemForm);			 
		}
	}

	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
        if(!$mysidia->input->get("id")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
	}
	
	public function functions(){
		$stmt = $this->getField("stmt")->get();
		$document = $this->document;
		$document->setTitle($this->lang->functions_title);
		$document->addLangvar($this->lang->functions);

		$fields = new LinkedList;
		$fields->add(new String("ifid"));
		$fields->add(new String("function"));
		$fields->add(new String("intent"));
		$fields->add(new String("description"));
		
		$functionsTable = new TableBuilder("functions");
		$functionsTable->setAlign(new Align("center", "middle"));
		$functionsTable->buildHeaders("ID", "Function", "Intent", "Description");
		$functionsTable->setHelper(new TableHelper);
		$functionsTable->buildTable($stmt, $fields);
        $document->add($functionsTable);
	}
}
?>