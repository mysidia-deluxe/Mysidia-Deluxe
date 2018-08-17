<?php

use Resource\Native\Integer;
use Resource\Native\Mystring;
use Resource\Collection\ArrayList;
use Resource\Collection\LinkedHashMap;

class TradeController extends AppController{

    const PARAM = "param";
	const PARAM2 = "id";
	private $trade;
	private $settings;
	private $attributer;

    public function __construct(){
        parent::__construct("member");
		$this->settings = new TradeSetting;	
        $this->attributer = new TradeAttributer($this->settings, $this);		
		if($this->settings->system != "enabled"){
            throw new NoPermissionException("disabled");
        }

		$mysidia = Registry::get("mysidia");	
		$mysidia->user->getstatus();
        if($mysidia->user->status->cantrade == "no"){
            throw new NoPermissionException("permission"); 
        }		
    }
	
	public function index(){
	    $additional = new ArrayList;
		if($this->settings->moderate == "enabled") $additional->add(new Mystring("moderate"));
		if($this->settings->multiple == "enabled") $additional->add(new Mystring("multiple"));
		if($this->settings->partial == "enabled") $additional->add(new Mystring("partial"));
		if($this->settings->public == "enabled") $additional->add(new Mystring("public"));
		$this->setField("tax", new Integer($this->settings->tax));
		$this->setField("additional", $additional);
	}
	
	public function offer(){
        $mysidia = Registry::get("mysidia");
		$this->setField("tradeHelper", new TradeHelper($this->settings, $this));
		if($mysidia->input->post("submit")){
		    try{
			    $offer = $this->attributer->getOffer();
				$this->trade = new Trade($offer, $this->settings);			
		        $validator = $this->trade->getValidator($offer->getType());
				$validator->validate();
				$this->trade->offer();
                $this->setField("settings", $this->settings);
				return;
			}
            catch(TradeInvalidException $tie){
                throw new InvalidActionException($tie->getmessage());
            }		
		}
		
		$mysidia->session->assign("offer", 1, TRUE);
		$this->attributer->setAttributes();
	}
	
	public function publics(){
        $mysidia = Registry::get("mysidia");
        if($this->settings->public == "disabled") throw new InvalidActionException("public_disabled");
		$this->setField("tradeHelper", new TradeHelper($this->settings, $this));
		if($mysidia->input->post("submit")){
		    try{
			    $offer = $this->attributer->getOffer($mysidia->input->get("id"));
				$this->trade = new Trade($offer, $this->settings);			
		        $validator = $this->trade->getValidator("private");
				$validator->validate();
				$this->trade->offer();

                $publicID = $mysidia->input->get("id");
                $privateID = $mysidia->db->select("trade", array("tid"), "1 ORDER BY tid DESC LIMIT 1")->fetchColumn();
                $this->trade->associate($publicID, $privateID);
				return;
			}
            catch(TradeInvalidException $tie){
                throw new InvalidActionException($tie->getmessage());
            }					
		}

		if($mysidia->input->get("id")){
		    $offer = new TradeOffer($mysidia->input->get("id"));
			$this->setField("offer", $offer);
		    $this->attributer->setAttributes();	
			return;
		}
		$stmt = $mysidia->db->select("trade", array("tid"), "type = 'public' and status = 'pending'");
		$this->setField("stmt", new DatabaseStatement($stmt));		
	}
	
	public function privates(){
        $mysidia = Registry::get("mysidia");
		$this->setField("tradeHelper", new TradeHelper($this->settings, $this));
		if($mysidia->input->post("submit")){
		    try{
				$offer = $this->attributer->getOffer($mysidia->input->get("id"));
			    $this->trade = new Trade($offer, $this->settings);
                if($mysidia->input->post("cancel") == "yes") $this->trade->cancel();
                else{				
		            $validator = $this->trade->getValidator("private");
				    $validator->validate();
				    $this->trade->revise();
				}	
				return;
			}
            catch(TradeInvalidException $tie){
                throw new InvalidActionException($tie->getmessage());
            }					
		}
		
		if($mysidia->input->get("id")){
		    $offer = new TradeOffer($mysidia->input->get("id"));
			$this->setField("offer", $offer);
		    $this->attributer->setAttributes();		
			return;
		}		
		$stmt = $mysidia->db->select("trade", array("tid"), "sender = '{$mysidia->user->username}' and status = 'pending'");
		$this->setField("stmt", new DatabaseStatement($stmt));	
	}

	public function partials(){
        $mysidia = Registry::get("mysidia");
        if($this->settings->partial == "disabled") throw new InvalidActionException("partial_disabled");
		$this->setField("tradeHelper", new TradeHelper($this->settings, $this));
		if($mysidia->input->post("submit")){
		    try{
				$offer = $this->attributer->getOffer($mysidia->input->get("id"));
			    $this->trade = new Trade($offer, $this->settings);
                if($mysidia->input->post("decline") == "yes") $this->trade->decline();
                else{				
		            $validator = $this->trade->getValidator("private");
				    $validator->validate();
				    $this->trade->reverse();
				}	
				return;
			}
            catch(TradeInvalidException $tie){
                throw new InvalidActionException($tie->getmessage());
            }					
		}
		
		if($mysidia->input->get("id")){
		    $offer = new TradeOffer($mysidia->input->get("id"));
			$this->setField("offer", $offer);
		    $this->attributer->setAttributes();		
			return;
		}		
		$stmt = $mysidia->db->select("trade", array("tid"), "type = 'partial' AND recipient = '{$mysidia->user->username}' AND status = 'pending'");
		$this->setField("stmt", new DatabaseStatement($stmt));	
	}
}
?>