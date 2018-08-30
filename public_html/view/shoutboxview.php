<?php

class ShoutboxView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->title);
		$document->addLangvar($this->lang->default);
		
		$shoutbox = $this->getField("shoutbox");
		$this->display($shoutbox);		
		$ckEditor = $shoutbox->editor;        
	    if($mysidia->input->post("comment")){
			$document->addLangvar($this->lang->complete);
			$this->refresh(5);
			return;
		}

		$shoutboxForm = new Form("shoutbox", "shoutbox", "post");
		$shoutboxForm->add(new Comment($mysidia->lang->notice, FALSE));
		$shoutboxForm->add(new Comment($ckEditor->editor("comment", "CKEditor for Mys v1.3.4")));
		$shoutboxForm->add(new Button("Shout It!", "submit", "submit"));
        $document->add($shoutboxForm);
	}
	
	private function display($shoutbox){
        $document = $this->document;
		$stmt = $this->getField("stmt")->get();	
	    if($stmt->rowCount() == 0){
            $document->add(new Comment("Currently no one has ever here yet, wanna be the first to shout a message?"));
            return;
        }

   	    $shoutboxes = new Division;
	    $shoutboxes->setClass("enclosecomments");
	    while($message = $stmt->fetchObject()) {
	        $message->comment = $shoutbox->format($message->comment);
	        $comment = new Division;
	        $comment->setClass("comment");
			$comment->setDimension(new Dimension("94%"));
	        $comment->setPadding(new Padding("", "2%"));
	        $comment->setBackground(new Color("aliceblue"));
	        $comment->setMargin(new Margin("bottom", "5px"));
	   
	        $userdate = new Division;
	        $userdate->setClass("userdate");
			$userdate->setDimension(new Dimension("50%", "25%"));
	        $userdate->setForeground(new Color("red"));
	        $userdate->add(new Comment("{$message->user} - {$message->date}"));
	        $comment->add($userdate);
	        $comment->add(new Comment($message->comment, FALSE));
            $shoutboxes->add($comment);			
        }	 
	    $document->add($shoutboxes);	
	}
}
?>