<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPShopView extends View{
	
	public function index(){
	    parent::index();
		$stmt = $this->getField("stmt")->get();			
		$document = $this->document;
		
        $fields = new LinkedHashMap;
		$fields->put(new Mystring("imageurl"), new Mystring("getImage"));
		$fields->put(new Mystring("shopname"), NULL);
		$fields->put(new Mystring("description"), NULL);
		$fields->put(new Mystring("status"), NULL);			
		$fields->put(new Mystring("sid::edit"), new Mystring("getEditLink"));
		$fields->put(new Mystring("sid::delete"), new Mystring("getDeleteLink"));
		
		$shopTable = new TableBuilder("shop");
		$shopTable->setAlign(new Align("center", "middle"));
		$shopTable->buildHeaders("Image", "Shop", "Description", "Status", "Edit", "Delete");
		$shopTable->setHelper(new ShopTableHelper);
		$shopTable->buildTable($stmt, $fields);
        $document->add($shopTable);		
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
		$shopForm = new FormBuilder("addform", "add", "post");
		$shopForm->add(new Comment("<br><u>Create A New Shop:</u>", TRUE, "b"));
		$shopForm->add(new Comment("Basic Settings", TRUE, "b"));
		$shopForm->add(new Comment("Shop Name: ", FALSE));
		$shopForm->add(new TextField("shopname"));
		$shopForm->add(new Comment($this->lang->shopname_explain));
		$shopForm->add(new Comment("Shop Category: ", FALSE));
		$shopForm->add(new TextField("category"));
		$shopForm->add(new Comment($this->lang->category_explain));
		
		$shopForm->add(new Comment("Shop Type: ", FALSE));
		$typesList = new DropdownList("shoptype");
		$typesList->add(new Option("Itemshop", "itemshop"));
		$typesList->add(new Option("Adoptshop", "adoptshop"));
		$shopForm->add($typesList);
		$shopForm->add(new Comment($this->lang->shoptype_explain));
		$shopForm->add(new Comment("Shop Description:"));
		$shopForm->add(new TextArea("description", "Here you can enter a description for your shop", 4, 50));
		$shopForm->add(new Comment("Shop Image: ", FALSE));
		$shopForm->add(new TextField("imageurl"));
		$shopForm->add(new Comment($this->lang->imageurl_explain));
		$shopForm->add(new Comment("OR select an existing image: ", FALSE));
		$shopForm->buildDropdownList("existingimageurl", "ImageList"); 
		
		$shopForm->add(new Comment("<hr>Miscellaneous Settings:", TRUE, "b"));
		$shopForm->add(new Comment("Shop Status: ", FALSE));
		$shopStatus = new RadioList("status");
		$shopStatus->add(new RadioButton("Open", "status", "open"));
		$shopStatus->add(new RadioButton("Closed", "status", "closed"));
		$shopStatus->add(new RadioButton("Hidden", "status", "invisible"));
        $shopStatus->check("open");
		$shopForm->add($shopStatus);
		$shopForm->add(new Comment("Restriction: ", FALSE));
		$shopForm->add(new TextField("restriction"));
		$shopForm->add(new Comment($this->lang->restrict_explain));
		$shopForm->add(new Comment("Sales Tax: ", FALSE));
		$shopForm->add(new TextField("salestax"));
		$shopForm->add(new Comment($this->lang->salestax_explain));
		$shopForm->add(new Button("Create Shop", "submit", "submit"));
        $document->add($shopForm);		
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
	    if(!$mysidia->input->get("sid")){
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		else{
		    $shop = $this->getField("shop")->get();
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);			
			$shopForm = new FormBuilder("editform", $mysidia->input->get("sid"), "post");
		    $shopForm->add(new Comment("<br><u>Edit an existing Shop:</u>", TRUE, "b"));
		    $shopForm->add(new Comment("Basic Settings", TRUE, "b"));
		    $shopForm->add(new Comment("Shop Name: ", FALSE));
		    $shopForm->add(new TextField("shopname", $shop->shopname));
		    $shopForm->add(new Comment($this->lang->shopname_explain));
		    $shopForm->add(new Comment("Shop Category: ", FALSE));
		    $shopForm->add(new TextField("category", $shop->category));
		    $shopForm->add(new Comment($this->lang->category_explain));	
		    $shopForm->add(new Comment("Shop Description:"));
		    $shopForm->add(new TextArea("description", $shop->description, 4, 50));
		    $shopForm->add(new Comment("Shop Image: ", FALSE));
		    $shopForm->add(new TextField("imageurl", $shop->imageurl));
		    $shopForm->add(new Comment($this->lang->imageurl_explain));
		    $shopForm->add(new Comment("OR select an existing image: ", FALSE));			
			$shopForm->buildDropdownList("existingimageurl", "ImageList", $shop->imageurl);
		
		    $shopForm->add(new Comment("<hr>Miscellaneous Settings:", TRUE, "b"));
		    $shopForm->add(new Comment("Shop Status: ", FALSE));
		    $shopStatus = new RadioList("status");
		    $shopStatus->add(new RadioButton("Open", "status", "open"));
		    $shopStatus->add(new RadioButton("Closed", "status", "closed"));
		    $shopStatus->add(new RadioButton("Hidden", "status", "invisible"));
			$shopStatus->check($shop->status);
		    $shopForm->add($shopStatus);
		    $shopForm->add(new Comment("Restriction: ", FALSE));
		    $shopForm->add(new TextField("restriction", $shop->restriction));
		    $shopForm->add(new Comment($this->lang->restrict_explain));
		    $shopForm->add(new Comment("Sales Tax: ", FALSE));
		    $shopForm->add(new TextField("salestax", $shop->salestax));
		    $shopForm->add(new Comment($this->lang->salestax_explain));
		    $shopForm->add(new Button("Edit Shop", "submit", "submit"));
            $document->add($shopForm);		
	    }
	}

    public function delete(){
	   	$mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("sid")){
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
        header("Refresh:3; URL='../../index'");
    }
}
?>