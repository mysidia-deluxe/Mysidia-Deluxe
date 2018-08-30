<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class FriendsView extends View{
		
	public function request(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$friend = $this->getField("friend");
		
	    $document->setTitle($mysidia->lang->request_title);
	    $document->addLangvar($mysidia->lang->request);
        $document->addLangvar("<br>Congrats! You have successfully sent a friendrequest to {$friend}, you may now wait for his/her response.");		
	}
			
	public function option(){
		$mysidia = Registry::get("mysidia");	
		$document = $this->document;		
		
		if($mysidia->input->post("submit")){
			$document->setTitle($mysidia->lang->option_title);
			$document->addLangvar($mysidia->lang->option);		
		    return;
		}
		
		$document->setTitle($mysidia->lang->privacy_title);
		$document->addLangvar($mysidia->lang->privacy);		
		$optionsMap = $this->getField("optionsMap");		
		$optionForm = new Form("optionform", "option", "post");
		
		$pmoption = new RadioList("pm");
		$pmoption->add(new RadioButton("public", "pm", 0));
		$pmoption->add(new RadioButton("friend-only", "pm", 1));
		$pmoption->check($optionsMap->get(new Mystring("pmoption"))->getValue());
		
		$vmoption = new RadioList("vm");
		$vmoption->add(new RadioButton("public", "vm", 0));
		$vmoption->add(new RadioButton("friend-only", "vm", 1));
		$vmoption->check($optionsMap->get(new Mystring("vmoption"))->getValue());		

		$tradeoption = new RadioList("trade");
		$tradeoption->add(new RadioButton("public", "trade", 0));
		$tradeoption->add(new RadioButton("friend-only", "trade", 1));
		$tradeoption->check($optionsMap->get(new Mystring("tradeoption"))->getValue());				
		
		$optionForm->add(new Comment("PM status: "));
		$optionForm->add($pmoption);
		$optionForm->add(new Comment("VM status: "));
		$optionForm->add($vmoption);	
		$optionForm->add(new Comment("Trade status: "));
		$optionForm->add($tradeoption);
       
		$optionForm->add(new Comment(""));
		$optionForm->add(new Button("Update Friend-Options", "submit", "submit"));
        $document->add($optionForm);		
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$fromuser = $this->getField("fromuser");
		
	    switch($mysidia->input->get("confirm")){
            case "accept":	
                $document->setTitle("Friend Request Accepted");
		        $document->addLangvar("Congrats, you and {$fromuser} are friends now. You may view your friendlist to see this change.");
	            break;
	        case "decline":
                $document->setTitle("Friend Request Declined");
		        $document->addLangvar("You have rejected this friend request from {$fromuser}.");
                break;
	        default:
			    $stmt = $this->getField("stmt");
                $document->setTitle($this->lang->friend_request);				
				$requestTable = new TableBuilder("friendrequest");
			    $requestTable->setAlign(new Align("center", "middle"));
		        $requestTable->buildHeaders("From User", "Status", "Message", "Accept", "Decline");	
                $requestTable->setHelper(new FriendTableHelper);
				
				$fields = new LinkedHashMap;
				$fields->put(new Mystring("fromuser"), new Mystring("getProfileLink"));
				$fields->put(new Mystring("status"), NULL);
				$fields->put(new Mystring("offermessage"), NULL);
				$fields->put(new Mystring("fid::accept"), new Mystring("getAcceptLink"));
				$fields->put(new Mystring("fid::decline"), new Mystring("getDeclineLink"));
                $requestTable->buildTable($stmt->get(), $fields);
				$document->add($requestTable);
        }
	}
	
	
	public function delete(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;  
        $document->setTitle($mysidia->lang->remove_title);
        $document->addLangvar($mysidia->lang->remove);        
	}
}
?>