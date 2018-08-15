<?php

class PromoView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		
	    if($mysidia->input->post("promocode")){
		    $document->setTitle($this->lang->success);
		    $document->addLangvar($this->lang->avail, TRUE);		   
			return;
		}

        $document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default, TRUE);
		
        $promoForm = new FormBuilder("promoform", "", "post");
        $promoForm->buildComment("Your Promo Code: ", FALSE)
		          ->buildTextField("promocode")	
                  ->buildButton("Enter Code", "submit", "submit");
        $document->add($promoForm);				  
	}              
}
?>