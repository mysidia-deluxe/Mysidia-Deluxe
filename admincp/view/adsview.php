<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPAdsView extends View{

	public function index(){
	    parent::index();
		$stmt = $this->getField("stmt")->get();
		$document = $this->document;		
        $fields = new LinkedHashMap;
		$fields->put(new String("adname"), NULL);
		$fields->put(new String("page"), NULL);
		$fields->put(new String("impressions"), NULL);
		$fields->put(new String("actualimpressions"), NULL);	
		$fields->put(new String("date"), NULL);	
		$fields->put(new String("status"), new String("getStatusImage"));				
		$fields->put(new String("id::edit"), new String("getEditLink"));
		$fields->put(new String("id::delete"), new String("getDeleteLink"));		
		
		$adsTable = new TableBuilder("ads");
		$adsTable->setAlign(new Align("center", "middle"));
		$adsTable->buildHeaders("Ad", "Page", "Impressions", "Actual Impressions", "date", "Status", "Edit", "Delete"); 		
		$adsTable->setHelper(new TableHelper);
        $adsTable->buildTable($stmt, $fields);
        $document->add($adsTable);
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
		$adForm = new Form("addads", "add", "post");
		$adForm->add(new Comment("Ad Code:"));
		$adForm->add(new TextArea("description", "", 4, 45));
		$adForm->add(new Comment("Ad Campain Name: ", FALSE));
		$adForm->add(new TextField("adname"));
		$adForm->add(new Comment("Page to run this ad on: ", FALSE));
		$adForm->add(new TextField("adpage"));		
		$adForm->add(new Comment($this->lang->page));
		$adForm->add(new Comment("Max Impressions Allowed: ", FALSE));
		$adForm->add(new TextField("impressions", "", 8));
		$adForm->add(new Comment($this->lang->impressions));
		$adForm->add(new Button("Start Ad Campain", "submit", "submit"));
		$adForm->add(new Button("Reset Ad Campain", "reset", "reset", "reset"));
		$document->add($adForm); 
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("aid")){
		    // An Ad has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		else{
		    $ad = $this->getField("ad")->get();	
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);			
			$adForm = new Form("editads", $mysidia->input->get("aid"), "post");
			$adForm->add(new Comment($this->lang->edit2));
			$adForm->add(new Comment("Ad Code:"));
		    $adForm->add(new TextArea("description", $ad->text, 4, 45));
		    $adForm->add(new Comment("Ad Campain Name: ", FALSE));
		    $adForm->add(new TextField("adname", $ad->adname));
		    $adForm->add(new Comment("Page to run this ad on: "));
			$adForm->add(new TextField("adpage", $ad->page));		
		    $adForm->add(new Comment($this->lang->page));
		    $adForm->add(new Comment("Max Impressions Allowed: ", FALSE));
		    $adForm->add(new TextField("impressions", $ad->impressions, 8));
		    $adForm->add(new Comment($this->lang->impressions));
			$adForm->add(new PasswordField("hidden", "aimp", $ad->actualimpressions));
		    $adForm->add(new Button("Edit Ad Campain", "submit", "submit"));
		    $adForm->add(new Button("Reset Ad Campain", "reset", "reset", "reset"));
		    $document->add($adForm); 						 
		}
	}
	
	public function delete(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("aid")){
		    // An Add has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
	}

}
?>