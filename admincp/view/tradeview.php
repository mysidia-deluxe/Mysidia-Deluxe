<?php

use Resource\Native\String;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPTradeView extends View{
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();		
		$document = $this->document;
        $fields = new LinkedHashMap;
		$fields->put(new String("tid"), NULL);
		$fields->put(new String("type"), NULL);
		$fields->put(new String("sender"), NULL);
		$fields->put(new String("recipient"), new String("getText"));
		$fields->put(new String("message"), NULL);			
		$fields->put(new String("status"), NULL);		
		$fields->put(new String("tid::edit"), new String("getEditLink"));
		$fields->put(new String("tid::delete"), new String("getDeleteLink"));	
		
		$tradeTable = new TableBuilder("trade");
		$tradeTable->setAlign(new Align("center", "middle"));
		$tradeTable->buildHeaders("ID", "Type", "Sender", "Recipient", "Message", "Status", "Edit", "Delete");
		$tradeTable->setHelper(new TableHelper);
		$tradeTable->buildTable($stmt, $fields);
        $document->add($tradeTable);
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
		$tradeForm = new FormBuilder("addform", "add", "post");
        $tradeTypes = new LinkedHashMap;
		$tradeTypes->put(new String("Private"), new String("private"));
		$tradeTypes->put(new String("Public"), new String("public"));
		$tradeTypes->put(new String("Partial"), new String("partial"));			
        $date = new DateTime;
		
        $tradeForm->add(new Comment("<hr>Basic Information:", TRUE, "b"));		
		$tradeForm->add(new Comment("Sender: ", FALSE, "i"));
		$tradeForm->add(new TextField("sender"));
		$tradeForm->add(new Comment($this->lang->sender_explain));
		$tradeForm->add(new Comment("Recipient: ", FALSE, "i"));
		$tradeForm->add(new TextField("recipient"));
		$tradeForm->add(new Comment($this->lang->recipient_explain));
		$tradeForm->add(new Comment("Adopt Provided: ", FALSE, "i"));
		$tradeForm->add(new TextField("adoptOffered"));
		$tradeForm->add(new Comment($this->lang->adopt_offered_explain));		
		$tradeForm->add(new Comment("Adopt Requested: ", FALSE, "i"));
		$tradeForm->add(new TextField("adoptWanted"));
		$tradeForm->add(new Comment($this->lang->adopt_wanted_explain));		
		$tradeForm->add(new Comment("Item Provided: ", FALSE, "i"));
		$tradeForm->add(new TextField("itemOffered"));
		$tradeForm->add(new Comment($this->lang->item_offered_explain));		
		$tradeForm->add(new Comment("Item Requested: ", FALSE, "i"));
		$tradeForm->add(new TextField("itemWanted"));
		$tradeForm->add(new Comment($this->lang->item_wanted_explain));	
		$tradeForm->add(new Comment("Cash Offered: ", FALSE, "i"));
		$tradeForm->add(new TextField("cashOffered", 0));
		$tradeForm->add(new Comment($this->lang->cash_offered_explain));	

        $tradeForm->add(new Comment("<hr>Additional Information:", TRUE, "b"));
		$tradeForm->add(new Comment("Trade Type: ", FALSE, "i"));	
		$tradeForm->buildRadioList("type", $tradeTypes, "private");
		$tradeForm->add(new Comment($this->lang->type_explain));
		$tradeForm->add(new Comment("Trade Message: ", TRUE, "i"));
		$tradeForm->add(new TextArea("message", "Enter a short message here."));
		$tradeForm->add(new Comment($this->lang->message_explain));
        $tradeForm->add(new Comment("Trade Status: ", FALSE, "i"));
		$tradeForm->add(new TextField("status", "pending"));
		$tradeForm->add(new Comment($this->lang->status_explain));
		$tradeForm->add(new Comment("Trade DateTime: ", FALSE, "i"));
		$tradeForm->add(new TextField("date", $date->format("y-m-d")));
		$tradeForm->add(new Comment($this->lang->date_explain));		
		$tradeForm->add(new Button("Initiate Trade Offer", "submit", "submit"));
		$document->add($tradeForm);
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
	    if(!$mysidia->input->get("tid")){
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
		    $trade = $this->getField("trade")->get();			
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);
		    $tradeForm = new FormBuilder("editform", $mysidia->input->get("tid"), "post");
            $tradeTypes = new LinkedHashMap;
		    $tradeTypes->put(new String("Private"), new String("private"));
		    $tradeTypes->put(new String("Public"), new String("public"));
		    $tradeTypes->put(new String("Partial"), new String("partial"));			
		
            $tradeForm->add(new Comment("<hr>Basic Information:", TRUE, "b"));		
		    $tradeForm->add(new Comment("Sender: ", FALSE, "i"));
		    $tradeForm->add(new TextField("sender", $trade->sender));
		    $tradeForm->add(new Comment($this->lang->sender_explain));
		    $tradeForm->add(new Comment("Recipient: ", FALSE, "i"));
		    $tradeForm->add(new TextField("recipient", $trade->recipient));
		    $tradeForm->add(new Comment($this->lang->recipient_explain));
		    $tradeForm->add(new Comment("Adopt Provided: ", FALSE, "i"));
		    $tradeForm->add(new TextField("adoptOffered", $trade->adoptoffered));
		    $tradeForm->add(new Comment($this->lang->adopt_offered_explain));		
		    $tradeForm->add(new Comment("Adopt Requested: ", FALSE, "i"));
		    $tradeForm->add(new TextField("adoptWanted", $trade->adoptwanted));
		    $tradeForm->add(new Comment($this->lang->adopt_wanted_explain));		
		    $tradeForm->add(new Comment("Item Provided: ", FALSE, "i"));
		    $tradeForm->add(new TextField("itemOffered", $trade->itemoffered));
		    $tradeForm->add(new Comment($this->lang->item_offered_explain));		
		    $tradeForm->add(new Comment("Item Requested: ", FALSE, "i"));
		    $tradeForm->add(new TextField("itemWanted", $trade->itemwanted));
		    $tradeForm->add(new Comment($this->lang->item_wanted_explain));	
		    $tradeForm->add(new Comment("Cash Offered: ", FALSE, "i"));
		    $tradeForm->add(new TextField("cashOffered", $trade->cashoffered));
		    $tradeForm->add(new Comment($this->lang->cash_offered_explain));	

            $tradeForm->add(new Comment("<hr>Additional Information:", TRUE, "b"));
		    $tradeForm->add(new Comment("Trade Type: ", FALSE, "i"));	
		    $tradeForm->buildRadioList("type", $tradeTypes, $trade->type);
		    $tradeForm->add(new Comment($this->lang->type_explain));
		    $tradeForm->add(new Comment("Trade Message: ", TRUE, "i"));
		    $tradeForm->add(new TextArea("message", $trade->message));
		    $tradeForm->add(new Comment($this->lang->message_explain));
            $tradeForm->add(new Comment("Trade Status: ", FALSE, "i"));
		    $tradeForm->add(new TextField("status", $trade->status));
		    $tradeForm->add(new Comment($this->lang->status_explain));
		    $tradeForm->add(new Comment("Trade DateTime: ", FALSE, "i"));
		    $tradeForm->add(new TextField("date", $trade->date));
		    $tradeForm->add(new Comment($this->lang->date_explain));		
		    $tradeForm->add(new Button("Update Trade Offer", "submit", "submit"));
		    $document->add($tradeForm);				 
		}
	}

	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
        if(!$mysidia->input->get("tid")){
		    // A trade offer has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
	}
	
	public function moderate(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if($mysidia->input->get("tid")){
		    // A trade offer has been selected for moderation, let's go over it!
		    if($mysidia->input->post("submit")){
			    $status = (string)$this->getField("status", new String("status"));
				$document->setTitle($this->lang->moderated_title);
				$document->addLangvar($this->lang->{$status});
                return;				
			}
			
			$trade = $this->getField("trade");
            $tradeHelper = $this->getField("tradeHelper");
            $tradeHelper->setView($this);
            $statusTypes = new LinkedHashMap;
		    $statusTypes->put(new String("Approve"), new String("pending"));
		    $statusTypes->put(new String("Disapprove"), new String("canceled"));			
			
			$document->setTitle($this->lang->moderate_title);
			$document->addLangvar($this->lang->review);
			$document->add(new Comment("<br>Type: {$trade->getType()}"));			
			$document->add(new Comment("<br>Sender: {$trade->getSender()}"));
			$document->add(new Comment("<br>Recipient: {$trade->getRecipient()}"));
			
			$document->add(new Comment("<br>AdoptOffered: "));
			$document->add($tradeHelper->getAdoptImages($trade->getAdoptOffered(), FALSE));
			$document->add(new Comment("<br>AdoptWanted: "));
			$document->add(($trade->getType() == "public")?$tradeHelper->getAdoptList($trade->getAdoptWanted()):$tradeHelper->getAdoptImages($trade->getAdoptWanted(), FALSE));			
			$document->add(new Comment("<br>ItemOffered: "));
			$document->add($tradeHelper->getItemImages($trade->getItemOffered(), FALSE));	
			$document->add(new Comment("<br>ItemWanted: "));
			$document->add(($trade->getType() == "public")?$tradeHelper->getItemList($trade->getItemWanted()):$tradeHelper->getItemImages($trade->getItemWanted(), FALSE));				
			$document->add(new Comment("<br>CashOffered: {$trade->getCashOffered()} {$mysidia->settings->cost}"));
            $document->add(new Comment("<br>Message: "));
            $document->add(new Paragraph(new Comment($trade->getMessage(), TRUE, "i"), "message"));
			
            $tradeForm = new FormBuilder("moderateform", $mysidia->input->get("tid"), "post");
			$tradeForm->add(new Comment("<br>You can now approve or disapprove this trade offer: "));
            $tradeForm->buildRadioList("status", $statusTypes, "pending");
		    $tradeForm->add(new Button("Moderate Trade Offer", "submit", "submit"));
            $document->add($tradeForm);			
			return;
		}				
		
		$document->setTitle($this->lang->moderate_title);
		$document->addLangvar($this->lang->moderate);
		$stmt = $this->getField("stmt")->get();
        $fields = new LinkedHashMap;
		$fields->put(new String("tid"), NULL);
		$fields->put(new String("type"), NULL);
		$fields->put(new String("sender"), NULL);
		$fields->put(new String("recipient"), new String("getText"));
		$fields->put(new String("message"), NULL);			
		$fields->put(new String("status"), NULL);		
		$fields->put(new String("tid::moderate"), new String("getModerateLink"));	
		
		$tradeTable = new TableBuilder("item");
		$tradeTable->setAlign(new Align("center", "middle"));
		$tradeTable->buildHeaders("ID", "Type", "Sender", "Recipient", "Message", "Status", "Moderate");
		$tradeTable->setHelper(new TableHelper);
		$tradeTable->buildTable($stmt, $fields);
        $document->add($tradeTable);
	}
	
	public function settings(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;			
		if($mysidia->input->post("submit")){
			$document->setTitle($this->lang->settings_changed_title);
            $document->addLangvar($this->lang->settings_changed);
		    return;
		}
		
        $tradeSettings = $this->getField("tradeSettings");			
		$document->setTitle($this->lang->settings_title);
		$document->addLangvar($this->lang->settings);
		$settingsForm = new FormBuilder("settingsform", "settings", "post");
		$tradeSystem = new LinkedHashMap;
		$tradeSystem->put(new String("Enabled"), new String("enabled"));
		$tradeSystem->put(new String("Disabled"), new String("disabled"));
        $tradeMultiple = clone $tradeSystem;
		$tradePartial = clone $tradeSystem;		
		$tradePublic = clone $tradeSystem;	
        $tradeModerate = clone $tradeSystem;			
		
		$settingsForm->buildComment("Trade System Enabled:   ", FALSE)->buildRadioList("system", $tradeSystem, $tradeSettings->system)
					 ->buildComment("Multiple Adopts/Items Enabled:   ", FALSE)->buildRadioList("multiple", $tradeMultiple, $tradeSettings->multiple)
                     ->buildComment("Partial Trade Enabled:   ", FALSE)->buildRadioList("partial", $tradePartial, $tradeSettings->partial)
					 ->buildComment("Public Trade Enabled:   ", FALSE)->buildRadioList("public", $tradePublic, $tradeSettings->public)					 
					 ->buildComment("Ineligible Species(separate by comma):   ", FALSE)->buildTextField("species", ($tradeSettings->species)?implode(",", $tradeSettings->species):"")
		             ->buildComment("Interval/wait-time(days) between successive trade offers:	 ", FALSE)->buildTextField("interval", $tradeSettings->interval)
					 ->buildComment("Maximum Number of adoptables/items allowed:   ", FALSE)->buildTextField("number", $tradeSettings->number)
					 ->buildComment("Number of days till Trade is still valid(or expiring):   ", FALSE)->buildTextField("duration", $tradeSettings->duration)
		             ->buildComment("Tax for each Trade Offer:	 ", FALSE)->buildTextField("tax", $tradeSettings->tax)
					 ->buildComment("Usergroup(s) permitted to trade(separate by comma):	", FALSE)->buildTextField("usergroup", ($tradeSettings->usergroup == "all")?$tradeSettings->usergroup:implode(",", $tradeSettings->usergroup))
					 ->buildComment("Ineligible/non-tradable Item(s)(separate by comma):	", FALSE)->buildTextField("item", ($tradeSettings->item)?implode(",", $tradeSettings->item):"")
					 ->buildComment("Moderation Required:   ", FALSE)->buildRadioList("moderate", $tradeModerate, $tradeSettings->moderate)						 
					 ->buildButton("Change Trade Settings", "submit", "submit");
		$document->add($settingsForm);	
	}
}
?>