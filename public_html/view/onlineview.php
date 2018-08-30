<?php

class OnlineView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
		$document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default);
		
	    $total = $this->getField("total")->getValue();
		$stmt = $this->getField("stmt")->get();
	    while($username = $stmt->fetchColumn()){
		    $user = new Member($username);
		    $user->getprofile();
			$onlineLink = new Link("profile/view/{$username}");
			$onlineLink->setClass("onlinelist");
			$onlineText = "<span class='onlinelistt'>{$user->username}</span>
						   <span class='onlinelistn'>{$user->profile->getnickname()}</span>
						   <span class='onlinelistj'>{$user->getalladopts()}</span>
						   <span class='onlinelistp'>{$user->money}</span>
						   <span class='onlinelistg'>{$user->profile->getgender()}</span>";						  
			$onlineLink->setText($onlineText);
			$onlineLink->setLineBreak(TRUE);
            $document->add($onlineLink);					 
	    }
		$document->addLangvar($this->lang->visitors.$total);
		$this->refresh(30);
	}
}
?>