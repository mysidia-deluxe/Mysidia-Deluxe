<?php

class TosView extends View{

	public function index(){
	    if($this->flags) $this->redirect(3, "index");	
	}
}	