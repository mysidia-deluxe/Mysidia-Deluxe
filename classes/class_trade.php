<?php

use Resource\Native\Object;
use Resource\Native\Mystring;
use Resource\Collection\ArrayList;

final class Trade extends Object{

    private $offer;
    private $settings;
	private $validator;
  
    public function __construct(TradeOffer $offer, TradeSetting $settings){
        $this->offer = $offer;
	    $this->settings = $settings;	
    }
	
	public function getValidator(){
	    if(func_num_args() == 0) throw new InvalidActionException("global_action");
        $validations = $this->getValidations(func_get_arg(0), func_get_args());
		$validationList = new ArrayList;
		foreach($validations as $validation) $validationList->add(new Mystring($validation));		
	    $this->validator = new TradeValidator($this->offer, $this->settings, $validationList);
		return $this->validator;
	}

    private function getValidations($type, $default){
        switch($type){
            case "public": 
                $validations = $validations = new ArrayObject(array("public", "offered", "wanted", "adoptOffered", "adoptPublic", "itemOffered", "itemPublic", "cashOffered", "species", "interval", "number", "duration", "status", "usergroup", "item"));
                break;
            case "private":
                $validations = new ArrayObject(array("recipient", "offered", "wanted", "adoptOffered", "adoptWanted", "itemOffered", "itemWanted", "cashOffered", "species", "interval", "number", "duration", "status", "usergroup", "item")); 
                break;
            case "partial":
                $validations = new ArrayObject(array("recipient", "partial", "adoptOffered", "adoptWanted", "itemOffered", "itemWanted", "cashOffered", "species", "interval", "number", "duration", "usergroup", "item")); 
                break;
            default:
                $validations = new ArrayObject($default);                             
        }
        return $validations;	
    } 
	
	public function offer(){
	    $mysidia = Registry::get("mysidia");
		$adoptOffered = $this->getOfferInfo($this->offer->getAdoptOffered());
		$adoptWanted = $this->getOfferInfo($this->offer->getAdoptWanted());
		$itemOffered = $this->getOfferInfo($this->offer->getItemOffered());
		$itemWanted = $this->getOfferInfo($this->offer->getItemWanted());
		$mysidia->db->insert("trade", array("tid" => NULL, "type" => $this->offer->getType(), "sender" => $this->offer->getSender(), "recipient" => $this->offer->getRecipient(), 
		                                    "adoptoffered" => $adoptOffered, "adoptwanted" => $adoptWanted, "itemoffered" => $itemOffered, "itemwanted" => $itemWanted, 
											"cashoffered" => $this->offer->getCashOffered(), "message" => stripslashes($this->offer->getMessage()), "status" => $this->offer->getStatus(), "date" => $this->offer->getDate()));
		
        if($this->settings->moderate != "enabled"){
            $this->sendTradeMessage($this->offer->getSender(), $this->offer->getRecipient(),
                                    "You have received a trade request from {$this->offer->getSender()}!", 
			                        "You have received a trade request from {$this->offer->getSender()}! To see the details of this trade request and to accept or reject it, please visit your trade requests page to check out your trade offer.");
        }	
	}
		
	private function getOfferInfo(ArrayList $list = NULL){
        if(!$list) return NULL;
	    $info = $list->toArray();
		return implode(",", $info);
	}

    public function associate($publicID, $privateID){
        $mysidia = Registry::get("mysidia");
        $mysidia->db->insert("trade_associations", array("taid" => NULL, "publicid" => $publicID, "privateid" => $privateID));  
    }

    public function syncronize(){
        $mysidia = Registry::get("mysidia");
        $publicID = $mysidia->db->select("trade_associations", array("publicid"), "privateid = '{$this->offer->getID()}'")->fetchColumn();
        if($publicID){
            $publicOffer = new TradeOffer($publicID);
            $publicOffer->setStatus("complete", "update");
            $privateIDs = $mysidia->db->select("trade_associations", array("privateid"), "publicid = '{$publicID}' AND privateid != '{$this->offer->getID()}'")->fetchAll(PDO::FETCH_COLUMN);
            
            foreach($privateIDs as $privateID){
                $privateOffer = new TradeOffer($privateID);
                $status = $privateOffer->getStatus();
                if($status == "pending"){
                    $privateOffer->setStatus("canceled", "update");
                    $this->sendTradeMessage($privateOffer->getRecipient(), $privateOffer->getSender(),
                                            "Your trade offer has been canceled.",
                                            "The public trade you have subscribed to has become unavailable, and thus your trade offer id:{$privateOffer->getID()} has been canceled.");
                }	
            } 
        }
    }	

    public function revise(){
	    $mysidia = Registry::get("mysidia");
		$adoptOffered = $this->getOfferInfo($this->offer->getAdoptOffered());
		$adoptWanted = $this->getOfferInfo($this->offer->getAdoptWanted());
		$itemOffered = $this->getOfferInfo($this->offer->getItemOffered());
		$itemWanted = $this->getOfferInfo($this->offer->getItemWanted());
		
        $mysidia->db->update("trade", array("adoptoffered" => $adoptOffered, "adoptwanted" => $adoptWanted, "itemoffered" => $itemOffered, "itemwanted" => $itemWanted, 
											"cashoffered" => $this->offer->getCashOffered(), "message" => stripslashes($this->offer->getMessage()), "status" => $this->offer->getStatus(), 
											"date" => $this->offer->getDate()), "tid = {$mysidia->input->get("id")}");		        
        $this->sendTradeMessage($this->offer->getSender(), $this->offer->getRecipient(),
                                "Your Trade Offer from {$this->offer->getSender()} has been updated!",
                                "The trade offer with {$this->offer->getSender()} has been modified by the sender! Wanna take a look and see what have been changed?");	 			    
	}

    public function cancel(){
	    $this->offer->setStatus("canceled", "update");
        $this->sendTradeMessage($this->offer->getSender(), $this->offer->getRecipient(),
                                "Your trade request from {$this->offer->getSender()} is canceled.",
                                "Unfortunately, your trade offer from {$this->offer->getSender()} has been canceled by the sender, you will have to give up on it...");	        		
    }
	
    public function accept(){
		if($this->offer->hasCashOffered()) $this->tradeCashOffered();		
		if($this->offer->hasAdoptOffered()) $this->tradeAdoptOffered();
		if($this->offer->hasAdoptWanted()) $this->tradeAdoptWanted();
		if($this->offer->hasItemOffered()) $this->tradeItemOffered();
		if($this->offer->hasItemWanted()) $this->tradeItemWanted();
		$this->validator->setStatus("complete");
        
		$this->offer->setStatus("complete", "update");
        $this->sendTradeMessage($this->offer->getRecipient(), $this->offer->getSender(),
                                "Your trade request to {$this->offer->getRecipient()} is sucessful.",
                                "Congratulations, your trade offer sent to {$this->offer->getRecipient()} has been accepted! You may now manage your new adoptables and items!");	
    }
	
	public function decline(){
		$this->offer->setStatus("declined", "update");
        if($this->offer->getType() == "partial"){
            $this->sendTradeMessage($this->offer->getSender(), $this->offer->getRecipient(), 
                                    "Your trade request to {$this->offer->getRecipient()} was declined.",
                                    "We're sorry, but {$this->offer->getRecipient()} declined your recent trade request. Don't worry, there are lots of other users willing to trade. You may now search for users to trade with.");
            
        }
        else{
            $this->sendTradeMessage($this->offer->getRecipient(), $this->offer->getSender(), 
                                    "Your trade request to {$this->offer->getRecipient()} was declined.",
                                    "We're sorry, but {$this->offer->getRecipient()} declined your recent trade request. Don't worry, there are lots of other users willing to trade. You may now search for users to trade with.");
        }					
	}

    public function reverse(){
	    $mysidia = Registry::get("mysidia");
		$adoptOffered = $this->getOfferInfo($this->offer->getAdoptOffered());
		$adoptWanted = $this->getOfferInfo($this->offer->getAdoptWanted());
		$itemOffered = $this->getOfferInfo($this->offer->getItemOffered());
		$itemWanted = $this->getOfferInfo($this->offer->getItemWanted());

        $mysidia->db->update("trade", array("type" => $this->offer->getType(), "sender" => $this->offer->getSender(), "recipient" => $this->offer->getRecipient(), "adoptoffered" => $adoptOffered, "adoptwanted" => $adoptWanted, "itemoffered" => $itemOffered, "itemwanted" => $itemWanted, 
											"cashoffered" => $this->offer->getCashOffered(), "message" => stripslashes($this->offer->getMessage()), "status" => $this->offer->getStatus(), 
											"date" => $this->offer->getDate()), "tid = {$mysidia->input->get("id")}");		        
        $this->sendTradeMessage($this->offer->getSender(), $this->offer->getRecipient(),
                                "Your Trade Offer to {$this->offer->getSender()} has been returned!",
                                "The trade offer with {$this->offer->getSender()} has been modified by the recipient! Now the sender/recipient roles have been reversed, wanna take a look and see what have been changed? Note the new trade's type is {$this->offer->getType()}");	
    }
	
	public function moderate($status){
	    $mysidia = Registry::get("mysidia");
        $this->offer->setStatus($status, "update");
        if($status == "pending"){
		    $this->sendTradeMessage($mysidia->user->username, $this->offer->getSender(),
			                        "Your Trade Offer has been approved!",
									"Congratulations, your trade offer has been moderated and it's approved immediately. You may now wait for the response of your recipient(s).");
            $this->sendTradeMessage($this->offer->getSender(), $this->offer->getRecipient(),
                                    "You have received a trade request from {$this->offer->getSender()}!", 
			                        "You have received a trade request from {$this->offer->getSender()}! To see the details of this trade request and to accept or reject it, please visit your trade requests page to check out your trade offer.");
        }
        else{
		    $this->sendTradeMessage($mysidia->user->username, $this->offer->getSender(),
			                        "Your Trade Offer has been disapproved!",
									"Unfortunately, your trade offer has been moderated and it cannot be approved. We are terribly sorry about this, perhaps you should consider modifying your trade proposal a bit?");
        }		
	}
	
    public function sendTradeMessage($sender, $recipient, $title, $context){
		$pm = new PrivateMessage;
	    $pm->setsender($sender);
	    $pm->setrecipient($recipient);
	    $pm->setmessage($title, $context);
	    $pm->post();
    }	
	
	private function tradeAdoptOffered(){
	    $adoptOffered = $this->offer->getAdoptOffered();
		$adoptIterator = $adoptOffered->iterator();
		while($adoptIterator->hasNext()){
		    $aid = $adoptIterator->next();
			$adopt = new OwnedAdoptable($aid->getValue(), $this->offer->getSender());
			$adopt->setOwner($this->offer->getRecipient(), "update");
		}
	}
	
	private function tradeAdoptWanted(){
	    $adoptWanted = $this->offer->getAdoptWanted();
		$adoptIterator = $adoptWanted->iterator();
		while($adoptIterator->hasNext()){
		    $aid = $adoptIterator->next();
			$adopt = new OwnedAdoptable($aid->getValue(), $this->offer->getRecipient());
			$adopt->setOwner($this->offer->getSender(), "update");
		}
	}

	private function tradeItemOffered(){
	    $itemOffered = $this->offer->getItemOffered();
		$itemIterator = $itemOffered->iterator();
		while($itemIterator->hasNext()){
		    $iid = $itemIterator->next();
			$item = new PrivateItem($iid->getValue(), $this->offer->getSender());
			$item->remove();
			$newItem = new StockItem($item->itemname);
			$newItem->append(1, $this->offer->getRecipient());
		}
	}
	
	private function tradeItemWanted(){
	    $itemWanted = $this->offer->getItemWanted();
		$itemIterator = $itemWanted->iterator();
		while($itemIterator->hasNext()){
		    $iid = $itemIterator->next();
			$item = new PrivateItem($iid->getValue(), $this->offer->getRecipient());
			$item->remove();
			$newItem = new StockItem($item->itemname);
			$newItem->append(1, $this->offer->getSender());
		}
	}	
	
	private function tradeCashOffered(){
	    $cashOffered = $this->offer->getCashOffered();
		$sender = new Member($this->offer->getSender());
		$sender->changecash(-($cashOffered + $this->settings->tax));
		$recipient = new Member($this->offer->getRecipient());
		$recipient->changecash($cashOffered);
	}
}
?> 