<?php

use Resource\Native\Integer;
use Resource\Native\String;
use Resource\Collection\ArrayList;

class TradeOffer extends Model{

    protected $tid;
	protected $type;
	protected $sender;
	protected $recipient;
	protected $adoptoffered;
	protected $adoptwanted;
	protected $itemoffered;
	protected $itemwanted;
	protected $cashoffered;
	protected $message;
	protected $status;  
    protected $date;
  
    public function __construct($tid, $new = FALSE){	  
	    $mysidia = Registry::get("mysidia");
        if($new) $this->tid = $tid;		
		else{
	        $row = $mysidia->db->select("trade", array(), "tid ='{$tid}'")->fetchObject();
            if(!is_object($row)) throw new TradeNotfoundException("Trade Offer id:{$tid} does not exist...");
            foreach($row as $key => $val){
                $this->$key = $val;     		 
            }	 
		}				
    }

    public function getID(){
        return $this->tid;
    }

    public function getType(){
        return $this->type;
    }
	
	public function setType($type){
	    $this->type = $type;
	}

    public function getSender($fetchMode = ""){
	    if($fetchMode == Model::MODEL) return new Member($this->sender);	    
        return $this->sender;
    }
	
	public function setSender($sender, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("sender", $sender);
	    $this->sender = $sender;
	}

    public function getRecipient($fetchMode = ""){
	    if($fetchMode == Model::MODEL) return new Member($this->recipient);	    
        return $this->recipient;
    }
	
	public function setRecipient($recipient, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("recipient", $recipient);
	    $this->recipient = $recipient;
	}		
  
    public function hasAdoptOffered(){
        return ($this->adoptoffered != NULL);
    }  
  
    public function getAdoptOffered(){
	    if(!($this->adoptoffered instanceof ArrayList)){
		    if(!$this->hasAdoptOffered()) return NULL;
            $adoptOffered = (is_string($this->adoptoffered))?explode(",", $this->adoptoffered):$this->adoptoffered;
			$this->adoptoffered = new ArrayList;
			foreach($adoptOffered as $aid){
			    $this->adoptoffered->add(new Integer($aid));    
			}
		}
        return $this->adoptoffered;
    }

	public function setAdoptOffered($adoptOffered, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("adoptoffered", $adoptOffered);
	    $this->adoptoffered = $adoptOffered;
	}		
	
    public function hasAdoptWanted(){
        return ($this->adoptwanted != NULL);
    }  
  
    public function getAdoptWanted(){
	    if(!($this->adoptwanted instanceof ArrayList)){
		    if(!$this->hasAdoptWanted()) return NULL;
            $adoptWanted = (is_string($this->adoptwanted))?explode(",", $this->adoptwanted):$this->adoptwanted;
			$this->adoptwanted = new ArrayList;
			foreach($adoptWanted as $aid){
			    $this->adoptwanted->add(new Integer($aid));    
			}
		}	
        return $this->adoptwanted;
    }

	public function setAdoptWanted($adoptWanted, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("adoptwanted", $adoptWanted);
	    $this->adoptwanted = $adoptWanted;
	}

    public function hasItemOffered(){
        return ($this->itemoffered != NULL);
    }  
  
    public function getItemOffered(){
	    if(!($this->itemoffered instanceof ArrayList)){
		    if(!$this->hasItemOffered()) return NULL;
		    $itemOffered = (is_string($this->itemoffered))?explode(",", $this->itemoffered):$this->itemoffered;
			$this->itemoffered = new ArrayList;
			foreach($itemOffered as $iid){
			    $this->itemoffered->add(new Integer($iid));    
			}
		}	
        return $this->itemoffered;
    }

	public function setItemOffered($itemOffered, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("itemoffered", $itemOffered);
	    $this->itemoffered = $itemOffered;
	}		
	
    public function hasItemWanted(){
        return ($this->itemwanted != NULL);
    }  
  
    public function getItemWanted(){
	    if(!($this->itemwanted instanceof ArrayList)){
		    if(!$this->hasItemWanted()) return NULL;
		    $itemWanted = (is_string($this->itemwanted))?explode(",", $this->itemwanted):$this->itemwanted;
			$this->itemwanted = new ArrayList;
			foreach($itemWanted as $iid){
			    $this->itemwanted->add(new Integer($iid));    
			}
		}		
        return $this->itemwanted;
    }

	public function setItemWanted($itemWanted, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("itemwanted", $itemWanted);
	    $this->itemwanted = $itemWanted;
	}			
	
    public function hasCashOffered(){
        return ($this->cashoffered != NULL);
    }  
  
    public function getCashOffered(){
        return $this->cashoffered;
    }

	public function setCashOffered($cashOffered, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("cashoffered", $cashOffered);
	    $this->cashoffered = $cashOffered;
	}	
  
    public function getMessage($fetchMode = ""){
	    if($fetchMode == Model::MODEL) return new PrivateMessage($this->message);	    
        return $this->message;
    }

	public function setMessage($message, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("message", $message);
	    $this->message = $message;
	}

    public function getStatus(){   
        return $this->status;
    }

	public function setStatus($status, $assignMode = ""){
		if($assignMode == Model::UPDATE) $this->save("status", $status);
	    $this->status = $status;
	}		
  
    public function getDate(){   
        return $this->date;
    }
   
    public function setDate(DateTime $date){
        $this->date = $date->format("Y-m-d");
    }	
	
	protected function save($field, $value){
		$mysidia = Registry::get("mysidia");
		$mysidia->db->update("trade", array($field => $value), "tid='{$this->tid}'");
	}
}
?>