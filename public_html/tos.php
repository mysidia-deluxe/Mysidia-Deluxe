<?php

class TosController extends AppController{

	public function index(){
	    $mysidia = Registry::get("mysidia");
		try{
		    $document = $mysidia->frame->getDocument("tos");
		}
        catch(PageNotFoundException $pne){
		    $this->setFlags("error", "nonexist");		 
        }        		
	}
}
?>	