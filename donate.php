<?php

use Resource\Native\Integer;
use Resource\Native\String;

class DonateController extends AppController{

    public function __construct(){
        parent::__construct("member");
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("recipient") and $mysidia->input->post("amount")){
		    $recipient = preg_replace("/[^a-zA-Z0-9\\040]/", "", $mysidia->input->post("recipient"));
            $amount = $mysidia->input->post("amount");
	        $recipient = new Member($recipient);			
	 	    if($amount < 0) throw new DonationException("negative");
	        elseif($mysidia->user->money < $amount) throw new DonationException("funds");
            elseif($recipient->username == $mysidia->user->username) throw new DonationException("user");
			else{
			    $mysidia->user->donate($recipient, $amount);
				$this->setField("recipient", new String($recipient->username));
				$this->setField("amount", new Integer($amount));
			}	
			return;
		}
	}
}
?>