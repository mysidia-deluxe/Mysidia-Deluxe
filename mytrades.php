<?php

use Resource\Native\Mystring;

class MytradesController extends AppController{

    const PARAM = "tid";
    const PARAM2 = "confirm";
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
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("trade", array("tid"), " type='private' AND recipient='{$mysidia->user->username}' AND status='pending'");	
		if($stmt->rowCount() == 0) throw new InvalidIDException($mysidia->lang->empty);
        $this->setField("stmt", new DatabaseStatement($stmt));
		$this->setField("tradeHelper", new TradeHelper($this->settings, $this));
	}
			
	public function accept(){
		$mysidia = Registry::get("mysidia");
		if(!(string)$mysidia->input->get("tid")) throw new TradeNotfoundException("accept_none");
	    $offer = new TradeOffer($mysidia->input->get("tid"));		
		$this->trade = new Trade($offer, $this->settings);
		
		if((string)$mysidia->input->get("confirm")){
		    try{
		        if(!$mysidia->session->fetch("tid")) die("Session already expired");
		        $validator = $this->trade->getValidator("private");
				$validator->validate();				
                $this->trade->accept();
                $this->trade->syncronize();			
                $mysidia->session->terminate("tid");
            }
            catch(TradeInvalidException $tie){
                throw new InvalidActionException($tie->getmessage());
            }			
		    return;
		}
	
		$this->setField("tradeOffer", $offer);
		$this->setField("tradeHelper", new TradeHelper($this->settings, $this));		
        $mysidia->session->assign("tid", $mysidia->input->get("tid"), TRUE);	
	}
	
	public function decline(){
		$mysidia = Registry::get("mysidia");
		if(!(string)$mysidia->input->get("tid")) throw new TradeNotfoundException("decline_none");
		if((string)$mysidia->input->get("confirm")){
		    if(!$mysidia->session->fetch("tid")) die("Session already expired");		
		    $offer = new TradeOffer($mysidia->input->get("tid"));
		    $this->trade = new Trade($offer, $this->settings);
		    $this->trade->decline();
	        $mysidia->session->terminate("tid");			
            return;			
		}
		$mysidia->session->assign("tid", $mysidia->input->get("tid"), TRUE);
	}
}
?>