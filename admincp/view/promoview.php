<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPPromoView extends View{
  
	public function index(){
	    parent::index();		
		$stmt = $this->getField("stmt")->get();		
		$document = $this->document;		
		$promoTable = new TableBuilder("promocode");
		$promoTable->setAlign(new Align("center", "middle"));
		$promoTable->buildHeaders("ID", "Type", "User", "Code", "Reward", "Edit", "Delete");
		$promoTable->setHelper(new TableHelper);
		
        $fields = new LinkedHashMap;
		$fields->put(new Mystring("pid"), NULL);
		$fields->put(new Mystring("type"), NULL);
		$fields->put(new Mystring("user"), NULL);
		$fields->put(new Mystring("code"), NULL);	
		$fields->put(new Mystring("reward"), NULL);			
		$fields->put(new Mystring("pid::edit"), new Mystring("getEditLink"));
		$fields->put(new Mystring("pid::delete"), new Mystring("getDeleteLink"));				
		$promoTable->buildTable($stmt, $fields);
        $document->add($promoTable);	
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if($mysidia->input->post("submit")){			
		    $document->setTitle($this->lang->added_title);
			$document->addLangvar($this->lang->added);
            header("Refresh:3; URL='../index'");
			return;
		}
		
		$document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);		
		$promoForm = new Form("addform", "add", "post");
		$promoForm->add(new Comment("<br><u>Create A New Promocode:</u><br>", TRUE, "b"));
		$promoForm->add(new Comment("Type:(adoptables or items)"));
		$typesList = new RadioList("type");
		$typesList->add(new RadioButton(" Adoptables", "type", "Adopt"));
		$typesList->add(new RadioButton(" Items", "type", "Item"));
		$typesList->add(new RadioButton(" Pages", "type", "Page"));
		$promoForm->add($typesList);
		
		$promoForm->add(new Comment("User:(leave blank if you want it to be available to everyone)"));
		$promoForm->add(new TextField("user"));
		$promoForm->add(new Comment("Code:(can be of any length, but better be somewhere between 15 and 128)"));
		$promoForm->add(new TextField("promocode"));
		$promoForm->add(new Comment("Availability:(how many times can the promocode be used before it expires)"));
		$promoForm->add(new TextField("availability", 1, 6));
		$promoForm->add(new Comment("Start Date:(the specified date promocode can be used afterwards, leave blank if it is readily available)"));
		$promoForm->add(new TextField("fromdate"));
		$promoForm->add(new Comment("Expiration Date:(the specified date promocode expires, leave blank if it does not have a deadline)"));
		$promoForm->add(new TextField("todate"));
		$promoForm->add(new Comment("Note: Date must follow the format (mm/dd/yyyy)"));
		$promoForm->add(new Comment("Reward:(the adoptable or item your member can obtain by entering this promocode. Enter 'Page' if this is a page promocode.)"));
		$promoForm->add(new TextField("reward"));
		$promoForm->add(new Button("Create Promocode", "submit", "submit"));
		$document->add($promoForm);				
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("pid")){
		    // A promocode has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
            header("Refresh:3; URL='../edit'");
		    return;
		}
		else{
		    $promo = $this->getField("promo")->get();				
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);
			$promoForm = new Form("editform", $mysidia->input->get("pid"), "post");
		    $promoForm->add(new Comment("<br><u>Editing Promocode:</u><br>", TRUE, "b"));
		    $promoForm->add(new Comment("Type:(adoptables or items)"));
		    $typesList = new RadioList("type");
		    $typesList->add(new RadioButton(" Adoptables", "type", "Adopt"));
		    $typesList->add(new RadioButton(" Items", "type", "Item"));
		    $typesList->add(new RadioButton(" Pages", "type", "Page"));
			$typesList->check($promo->type);
		    $promoForm->add($typesList);
		
		    $promoForm->add(new Comment("User:(leave blank if you want it to be available to everyone)"));
		    $promoForm->add(new TextField("user", $promo->user));
		    $promoForm->add(new Comment("Code:(can be of any length, but better be somewhere between 15 and 128)"));
		    $promoForm->add(new TextField("promocode", $promo->code));
		    $promoForm->add(new Comment("Availability:(how many times can the promocode be used before it expires)"));
		    $promoForm->add(new TextField("availability", $promo->availability, 6));
		    $promoForm->add(new Comment("Start Date:(the specified date promocode can be used afterwards, leave blank if it is readily available)"));
		    $promoForm->add(new TextField("fromdate", $promo->fromdate));
		    $promoForm->add(new Comment("Expiration Date:(the specified date promocode expires, leave blank if it does not have a deadline)"));
		    $promoForm->add(new TextField("todate", $promo->todate));
		    $promoForm->add(new Comment("Note: Date must follow the format (mm/dd/yyyy)"));
		    $promoForm->add(new Comment("Reward:(the adoptable or item your member can obtain by entering this promocode. Enter 'Page' if this is a page promocode.)"));
		    $promoForm->add(new TextField("reward", $promo->reward));
		    $promoForm->add(new Button("Modify Promocode", "submit", "submit"));
		    $document->add($promoForm);					 
		}
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("pid")){
		    // A promocode has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
        header("Refresh:3; URL='../edit'");
	}
}
?>