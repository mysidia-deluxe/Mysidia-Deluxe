<?php

class LoginView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;

	    if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->success_title);
		    $document->addLangvar("Welcome back {$mysidia->input->post("username")}. {$this->lang->success}");
			return;
		}
		
		$document->setTitle($this->lang->title);
	    $document->addLangvar($this->lang->login);

		$loginForm = $mysidia->frame->getSidebar()->getLoginBar();
        $document->add($loginForm);	
	}
	
	public function logout(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
        $document->setTitle($this->lang->logout_title);
        $document->addLangvar($this->lang->logout);	
	}
}
?>