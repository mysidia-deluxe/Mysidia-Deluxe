<?php

class DonateView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    if($mysidia->input->post("recipient") and $mysidia->input->post("amount")){
			$recipient = $this->getField("recipient");
			$amount = $this->getField("amount");
			$document->setTitle($this->lang->success);			
            $document->add(new Comment("You've just donated {$amount} of {$mysidia->settings->cost} to <a href='profile/{$recipient}'>{$recipient}</a>. "));
			$document->add(new Comment("You'll be redirected back to the donation page within 3 seconds. Click "));
		    $document->add(new Link("donate", "here "));
			$document->add(new Comment("if your browser does not automatically redirect you."));
            $this->refresh(3);
			return;
		}

		$document->setTitle($this->lang->title);	
		$document->add(new Comment("This page will allows you to donate your money to other users. "));
		$document->add(new Comment("You currently have {$mysidia->user->getcash()} {$mysidia->settings->cost} left."));
		$document->add(new Paragraph(new Comment("")));
		$donateForm = new FormBuilder("donateform", "donate", "post");
		$donateForm->buildComment("Donate to: ", FALSE)
		           ->buildTextField("recipient")
		           ->buildComment("Amount to donate: ", FALSE)
				   ->buildTextField("amount")
				   ->buildButton("Donate", "submit", "submit");
        $document->add($donateForm);	
	}
}
?>