<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class TradeView extends View{
	
	public function index(){
		$document = $this->document;
		$document->setTitle($this->lang->title);
		$document->addLangvar($this->lang->default.$this->lang->section);	
		
		$tax = $this->getField("tax");
		$additionalList = $this->getField("additional");
		$additionalIterator = $additionalList->iterator();
		while($additionalIterator->hasNext()){
		    $additional = $additionalIterator->next()->getValue();
            $document->add(new Image("templates/icons/yes.gif"));
		    $document->addLangvar($this->lang->{$additional});
		}
 
        $document->addLangvar($this->lang->section2);
        $document->add(new Image("templates/icons/warning.gif"));
		$document->addLangvar($this->lang->tax.$tax.$this->lang->tax2);
        $document->add(new Image("templates/icons/next.gif"));
		$document->addLangvar($this->lang->start);
		$document->add(new Link("trade/offer", "Let's start a trade now!", TRUE));
        $document->add(new Image("templates/icons/next.gif"));
		$document->addLangvar($this->lang->start2);
        $document->add(new Link("trade/privates", "Revise my Private Trade Offers"));     
	}
	
	public function offer(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->offered_title);
			$document->addLangvar($this->lang->offered);
            $settings = $this->getField("settings");
            if($settings->moderate == "enabled"){
                $document->add(new Image("templates/icons/warning.gif"));
                $document->addLangvar($this->lang->moderated);
            }
            return;
        }		
		
		$document->setTitle($this->lang->offer_title);
		$document->addLangvar($this->lang->offer);
        $params = $this->getField("params");
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);

		$tradeForm = new Form("tradeform", "", "post");
        $tradeForm->add($tradeHelper->getRecipient());	
        $tradeForm->add($tradeHelper->getAdoptOffered($params));
        $tradeForm->add($tradeHelper->getAdoptWanted($params));			
        $tradeForm->add($tradeHelper->getItemOffered($params));
        $tradeForm->add($tradeHelper->getItemWanted($params));
        $tradeForm->add(new Comment($this->lang->cash_offered));
        $tradeForm->add(new TextField("cashOffered"));
        $tradeForm->add(new Comment($this->lang->message));
        $tradeForm->add(new TextArea("message", "Enter your trade message here, make sure it is brief."));
        $tradeForm->add($tradeHelper->getPublicOffer());
        $tradeForm->add($tradeHelper->getPartialOffer());
		$tradeForm->add(new Button("Submit Trade Offer!", "submit", "submit"));
        $document->add($tradeForm);		
	}
	
	public function publics(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->offered_title);
			$document->addLangvar($this->lang->offered);	
			return;
        }		

		$document->setTitle($this->lang->view_public_title);
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);		
		
		if($mysidia->input->get("id")){
			$offer = $this->getField("offer");			
			$document->addLangvar($this->lang->view_public2);	
			$tradeForm = new Form("tradeform", "", "post");
            $tradeForm->add(new Image("templates/icons/warning.gif"));
            $tradeForm->add(new Comment($this->lang->recipient.$offer->getSender(), TRUE, "b"));
            $tradeForm->add($tradeHelper->getAdoptOfferedPublic());
            $tradeForm->add($tradeHelper->getAdoptWantedPublic());			
            $tradeForm->add($tradeHelper->getItemOfferedPublic());
            $tradeForm->add($tradeHelper->getItemWantedPublic());

            $tradeForm->add(new Comment($this->lang->message));
            $tradeForm->add(new TextArea("message", "Enter your trade message here, make sure it is brief."));
            $tradeForm->add(new PasswordField("hidden", "recipient", $offer->getSender()));	
            $tradeForm->add(new PasswordField("hidden", "cashOffered", 0));	
            $tradeForm->add(new PasswordField("hidden", "publics", $mysidia->input->get("id")));
		    $tradeForm->add(new Button("Submit Trade Offer!", "submit", "submit"));
            $document->add($tradeForm);				
		    return;
		}
		
		$document->addLangvar($this->lang->view_public);	
		$stmt = $this->getField("stmt")->get();
		if($stmt->rowCount() == 0){
		    $document->addLangvar($this->lang->view_public_empty);
		    return;
		}		
		$tradeTable = new TableBuilder("tradetable", 700);
		$tradeTable->setAlign(new Align("center", "middle"));
		$tradeTable->buildHeaders("ID", "Sender", "Adopt Offered", "Adopt Wanted", "Item Offered", "Item Wanted", "Message", "View");
		
		while($tid = $stmt->fetchColumn()){
		    $trade = new TradeOffer($tid);
			$cells = new LinkedList;
		    $cells->add(new TCell($tid));
			$cells->add(new TCell($trade->getSender()));
			$cells->add(new TCell($tradeHelper->getAdoptImages($trade->getAdoptOffered())));
			$cells->add(new TCell($tradeHelper->getAdoptList($trade->getAdoptWanted())));
			$cells->add(new TCell($tradeHelper->getItemImages($trade->getItemOffered())));
			$cells->add(new TCell($tradeHelper->getItemList($trade->getItemWanted())));
			$cells->add(new TCell($trade->getMessage()));
			$cells->add(new Link("trade/publics/tid/{$tid}", new Image("templates/icons/next.gif")));
			$tradeTable->buildRow($cells);
		}		
		$document->add($tradeTable);		
	}
	
	public function privates(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->revise_title);
			$document->addLangvar($this->lang->revise);	
			return;
        }

		$document->setTitle($this->lang->view_private_title);
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);		
		
		if($mysidia->input->get("id")){
			$offer = $this->getField("offer");			
			$document->addLangvar($this->lang->view_private2);	
			$tradeForm = new Form("tradeform", "", "post");
            $tradeForm->add($tradeHelper->getRecipient());	
            $tradeForm->add($tradeHelper->getAdoptOffered($offer->getAdoptOffered()));
            $tradeForm->add($tradeHelper->getAdoptWanted($offer->getAdoptWanted()));			
            $tradeForm->add($tradeHelper->getItemOffered($offer->getItemOffered()));
            $tradeForm->add($tradeHelper->getItemWanted($offer->getItemWanted()));
            $tradeForm->add(new Comment($this->lang->cash_offered));
            $tradeForm->add(new TextField("cashOffered", $offer->getCashOffered()));
            $tradeForm->add(new Comment($this->lang->message));
            $tradeForm->add(new TextArea("message", $offer->getMessage()));
		    $tradeForm->add(new CheckBox("Cancel this trade offer?", "cancel", "yes"));	
            $tradeForm->add(new PasswordField("hidden", "recipient", $offer->getRecipient()));		
		    $tradeForm->add(new Button("Revise Trade Offer!", "submit", "submit"));
            $document->add($tradeForm);				
		    return;
		}
		
		$document->addLangvar($this->lang->view_private);	
		$stmt = $this->getField("stmt")->get();
		if($stmt->rowCount() == 0){
		    $document->addLangvar($this->lang->view_private_empty);
		    return;
		}		
		$tradeTable = new TableBuilder("tradetable", 700);
		$tradeTable->setAlign(new Align("center", "middle"));
		$tradeTable->buildHeaders("ID", "Sender", "Adopt Offered", "Adopt Wanted", "Item Offered", "Item Wanted", "Cash Offered", "Message", "Revise");
		
		while($tid = $stmt->fetchColumn()){
		    $trade = new TradeOffer($tid);
			$cells = new LinkedList;
		    $cells->add(new TCell($tid));
			$cells->add(new TCell($trade->getSender()));
			$cells->add(new TCell($tradeHelper->getAdoptImages($trade->getAdoptOffered())));
			$cells->add(new TCell($tradeHelper->getAdoptImages($trade->getAdoptWanted())));			
			$cells->add(new TCell($tradeHelper->getItemImages($trade->getItemOffered())));
			$cells->add(new TCell($tradeHelper->getItemImages($trade->getItemWanted())));	
			$cells->add(new TCell($trade->getCashOffered()));			
			$cells->add(new TCell($trade->getMessage()));
			$cells->add(new TCell(new Link("trade/privates/tid/{$tid}", new Image("templates/icons/cog.gif"))));
			$tradeTable->buildRow($cells);
		}		
		$document->add($tradeTable);		
	}

	public function partials(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->revise_title);
			$document->addLangvar($this->lang->revise);	
			return;
        }

		$document->setTitle($this->lang->view_partial_title);
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);		
		
		if($mysidia->input->get("id")){
			$offer = $this->getField("offer");		
			$document->addLangvar($this->lang->view_partial2);	
			$tradeForm = new Form("tradeform", "", "post");
            $tradeForm->add($tradeHelper->getRecipient());	
            $tradeForm->add($tradeHelper->getAdoptOffered($offer->getAdoptWanted()));
            $tradeForm->add($tradeHelper->getAdoptWanted($offer->getAdoptOffered()));			
            $tradeForm->add($tradeHelper->getItemOffered($offer->getItemWanted()));
            $tradeForm->add($tradeHelper->getItemWanted($offer->getItemOffered()));
            $tradeForm->add(new Comment($this->lang->cash_offered));
            $tradeForm->add(new TextField("cashOffered", 0));
            $tradeForm->add(new Comment($this->lang->message));
            $tradeForm->add(new TextArea("message", $offer->getMessage()));
		    $tradeForm->add(new CheckBox("Decline this trade offer?", "decline", "yes"));
            $tradeForm->add(new Comment);
            $tradeForm->add(new CheckBox("This is a partial trade offer", "partial", "yes", "yes"));
            $tradeForm->add(new PasswordField("hidden", "sender", $offer->getRecipient()));		
            $tradeForm->add(new PasswordField("hidden", "recipient", $offer->getSender()));		
		    $tradeForm->add(new Button("Submit Trade Offer!", "submit", "submit"));
            $document->add($tradeForm);				
		    return;
		}
		
		$document->addLangvar($this->lang->view_partial);	
		$stmt = $this->getField("stmt")->get();
		if($stmt->rowCount() == 0){
		    $document->addLangvar($this->lang->view_partial_empty);
		    return;
		}		
		$tradeTable = new TableBuilder("tradetable", 700);
		$tradeTable->setAlign(new Align("center", "middle"));
		$tradeTable->buildHeaders("ID", "Sender", "Adopt Offered", "Adopt Wanted", "Item Offered", "Item Wanted", "Cash Offered", "Message", "View");
		
		while($tid = $stmt->fetchColumn()){
		    $trade = new TradeOffer($tid);
			$cells = new LinkedList;
		    $cells->add(new TCell($tid));
			$cells->add(new TCell($trade->getSender()));
			$cells->add(new TCell($tradeHelper->getAdoptImages($trade->getAdoptOffered())));
			$cells->add(new TCell($tradeHelper->getAdoptImages($trade->getAdoptWanted())));			
			$cells->add(new TCell($tradeHelper->getItemImages($trade->getItemOffered())));
			$cells->add(new TCell($tradeHelper->getItemImages($trade->getItemWanted())));	
			$cells->add(new TCell($trade->getCashOffered()));			
			$cells->add(new TCell($trade->getMessage()));
			$cells->add(new TCell(new Link("trade/partials/tid/{$tid}", new Image("templates/icons/cog.gif"))));
			$tradeTable->buildRow($cells);
		}		
		$document->add($tradeTable);		
	}
}
?>