<?php

use Resource\Collection\ArrayList;

class TradeValidator extends Validator{

    private $trade;
    private $settings;
	private $validations;
	private $status;

    public function __construct(TradeOffer $trade, TradeSetting $settings, ArrayList $validations){
	    $this->trade = $trade;	
	    $this->settings = $settings;
		$this->validations = $validations;
	}
	
	public function getValidations(){
	    return $this->validations;
	}
	
	public function setValidations(ArrayList $validations, $overwrite = FALSE){
	    if($overwrite) $this->validations = $validations;
		else{
		    $iterator = $validations->iterator();
			while($iterator->hasNext()){
			    $this->validations->append($iterator->next());
			}
		}
	}
	
	public function getStatus(){
	    return $this->status;
	}

    public function setStatus($status = ""){
        $this->status = $status;
    }

    public function validate(){
        $iterator = $this->validations->iterator();
        while($iterator->hasNext()){		
		    $validation = $iterator->next();
			$method = "check{$validation->capitalize()}";
		    $this->$method();
		}
		return TRUE;		 
    }
	
	private function checkRecipient(){
	    if(!$this->trade->getRecipient()) throw new TradeInvalidException("recipient_empty");
		else{
		    $sender = $this->trade->getSender("model");
		    $recipient = $this->trade->getRecipient("model");
            if($sender->username == $recipient->username) throw new TradeInvalidException("recipient_duplicate");
			$options = $recipient->getoptions();
			if($options->tradestatus == 1){
			    $friendlist = new FriendList($recipient);
				$friend = new Friend($sender, $friendlist); 
				if(!$friend->isfriend) throw new TradeInvalidException("recipient_privacy");
			}
			return TRUE;
		}
	}

    private function checkPublic(){
	    if($this->trade->getRecipient()) throw new TradeInvalidException("recipient_public");
        return TRUE;
    }

    private function checkPartial(){
        if(!$this->trade->hasAdoptOffered() and !$this->trade->hasAdoptWanted() and
           !$this->trade->hasItemOffered() and !$this->trade->hasItemWanted() and !$this->trade->hasCashOffered()){
            throw new TradeInvalidException("recipient_partial");
        }
        return TRUE;
    }
  
    private function checkOffered(){
	    if(!$this->trade->hasAdoptOffered() and !$this->trade->hasItemOffered() and !$this->trade->hasCashOffered()){
		    throw new TradeInvalidException("offers");
		}
		return TRUE;
    }
	
    private function checkWanted(){
	    if(!$this->trade->hasAdoptWanted() and !$this->trade->hasItemWanted()){
		    throw new TradeInvalidException("wanted");
		}
		return TRUE;
    }
	
    private function checkAdoptOffered(){
	    if(!$this->trade->hasAdoptOffered()) return TRUE; 
        try{		    
		    $adoptOffered = $this->trade->getAdoptOffered();
			$adoptIterator = $adoptOffered->iterator();
			while($adoptIterator->hasNext()){
			    $aid = $adoptIterator->next()->getValue();
				$adopt = new OwnedAdoptable($aid, $this->trade->getSender());
			}
		}
		catch(AdoptNotfoundException $ane){
		    throw new TradeInvalidException("adoptoffered"); 
		}
		return TRUE;
    }	
	
    private function checkAdoptWanted(){
	    if(!$this->trade->hasAdoptWanted()) return TRUE;  
        try{		    
		    $adoptWanted = $this->trade->getAdoptWanted();
			$adoptIterator = $adoptWanted->iterator();
			while($adoptIterator->hasNext()){
			    $aid = $adoptIterator->next()->getValue();
				$adopt = new OwnedAdoptable($aid, $this->trade->getRecipient());
			}
		}
		catch(AdoptNotfoundException $ane){
		    throw new TradeInvalidException("adoptwanted"); 
		}
		return TRUE;
    }

    private function checkAdoptPublic(){
	    if(!$this->trade->hasAdoptWanted()) return TRUE;
        try{		    
		    $adoptWanted = $this->trade->getAdoptWanted();
			$adoptIterator = $adoptWanted->iterator();
			while($adoptIterator->hasNext()){
			    $id = $adoptIterator->next()->getValue();
				$adopt = new Adoptable($id);
			}
		}
		catch(AdoptNotfoundException $ane){
		    throw new TradeInvalidException("public_adopt"); 
		}
		return TRUE;  
    }

    private function checkItemOffered(){
	    if(!$this->trade->hasItemOffered()) return TRUE; 
        $itemOffered = $this->trade->getItemOffered();
		$itemIterator = $itemOffered->iterator();
		while($itemIterator->hasNext()){
			$iid = $itemIterator->next()->getValue();
			$item = new PrivateItem($iid, $this->trade->getSender());
			if($item->iid = 0) throw new TradeInvalidException("itemoffered"); 
		}
		return TRUE;
    }	
	
    private function checkItemWanted(){
	    if(!$this->trade->hasItemWanted()) return TRUE; 
        $itemWanted = $this->trade->getItemWanted();
		$itemIterator = $itemWanted->iterator();
		while($itemIterator->hasNext()){
			$iid = $itemIterator->next()->getValue();
			$item = new PrivateItem($iid, $this->trade->getRecipient());
			if($item->iid = 0) throw new TradeInvalidException("itemwanted"); 
		}
		return TRUE;
    }

    private function checkItemPublic(){
	    if(!$this->trade->hasItemWanted()) return TRUE; 
        try{		    
            $itemWanted = $this->trade->getItemWanted();
		    $itemIterator = $itemWanted->iterator();
		    while($itemIterator->hasNext()){
			    $id = $itemIterator->next()->getValue();
			    $item = new Item($id);
		    }
		}
		catch(ItemException $ine){
		    throw new TradeInvalidException("public_item"); 
		}
		return TRUE;
    }

    private function checkCashOffered(){
	    if(!$this->trade->hasCashOffered()) return TRUE; 
        $cashOffered = $this->trade->getCashOffered();
		$cashLeft = $this->trade->getSender("model")->getcash() - ($cashOffered + $this->settings->tax);
		if($cashLeft < 0) throw new TradeInvalidException("cashoffered");
		return TRUE;
    }	
 
    private function checkStatus(){
	    $status = $this->trade->getStatus();
		if($status != "pending" and $status != "moderate") throw new TradeInvalidException("status");
		return TRUE;
    }
 
    private function checkSpecies(){
	    if(empty($this->settings->species)) return TRUE;
		if($this->trade->hasAdoptOffered()) $this->checkMultipleSpecies($this->trade->getAdoptOffered());
		if($this->trade->hasAdoptWanted()) $this->checkMultipleSpecies($this->trade->getAdoptWanted());
		return TRUE;
    }
	
	private function CheckMultipleSpecies(ArrayList $adopts){
		foreach($this->settings->species as $type){
			$adoptIterator = $adopts->iterator();
		    while($adoptIterator->hasNext()){
			    $aid = $adoptIterator->next()->getValue();
		        $adopt = new OwnedAdoptable($aid);
			    if($adopt->getType() == $type) throw new TradeInvalidException("species");
		    }			
		}
		return TRUE;
	}
	
	private function checkInterval(){
        $mysidia = Registry::get("mysidia");
        if($mysidia->input->action() != "offer") return TRUE;	
	    $current = new DateTime;
		$validTime = $current->getTimestamp() - ($this->settings->interval * 60 * 60 * 24);
        $lastDate = $mysidia->db->select("trade", array("date"), "sender ='{$this->trade->getSender()}' ORDER BY date DESC LIMIT 3")->fetchColumn();		
		$lastDate = new DateTime($lastDate);
        $lastTime = $lastDate->getTimestamp();        
        if($lastTime > $validTime) throw new TradeInvalidException("interval");      	
        return TRUE;
	}
	 
    private function checkNumber(){	  
        if($this->settings->number == 0) throw new TradeInvalidException("number");
		if($this->trade->hasAdoptOffered()) $this->checkNumbers($this->trade->getAdoptOffered());
        if($this->trade->hasAdoptWanted()) $this->checkNumbers($this->trade->getAdoptWanted());
		if($this->trade->hasItemOffered()) $this->checkNumbers($this->trade->getItemOffered());	
        if($this->trade->hasItemWanted()) $this->checkNumbers($this->trade->getItemWanted());		
        return TRUE;		
    }
	
	private function checkNumbers(ArrayList $list){
	    if($this->settings->number < $list->size()) throw new TradeInvalidException("number");
		return TRUE;
	}

	private function checkDuration(){
	    $current = new DateTime;
		$expirationTime = $current->getTimestamp() - (($this->settings->duration) * 24 * 60 * 60);		
		if($this->trade->getDate() > $expirationTime) throw new TradeInvalidException("duration");      
		return TRUE;
	}
	
    private function checkUsergroup(){
		if($this->settings->usergroup == "all") return TRUE;		
		foreach($this->settings->usergroup as $usergroup){
		    if($this->trade->getSender()->usergroup == $usergroup or $this->trade->getRecipient()->usergroup == $usergroup) return TRUE;   
		}
		throw new TradeInvalidException("usergroup");
    }
    
    private function checkItem(){
	    if(!$this->settings->item) return TRUE;	
		if($this->trade->hasItemOffered()) $this->checkMultipleItem($this->trade->getItemOffered());	
        if($this->trade->hasItemWanted()) $this->checkMultipleItem($this->trade->getItemWanted());			
		return TRUE;
    }
	
	private function checkMultipleItem(ArrayList $items){
		foreach($this->settings->item as $item){
			$itemIterator = $items->iterator();
		    while($itemIterator->hasNext()){
			    $iid = $itemIterator->next()->getValue();
		        $item = new PrivateItem($iid);
			    if($item->iid == 0 or $item->tradable != "yes") throw new TradeInvalidException("item");
		    }				
		}
        return TRUE;		
	}
}
?>