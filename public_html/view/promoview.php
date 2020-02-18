<?php

class PromoView extends View
{
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        
        if ($mysidia->input->post("promocode")) {
            $document->setTitle($this->lang->success);
            $document->addLangvar($this->lang->avail, true);
            return;
        }

        $document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default, true);
        
        $promoForm = new FormBuilder("promoform", "", "post");
        $promoForm->buildComment("Your Promo Code: ", false)
                  ->buildTextField("promocode")
                  ->buildButton("Enter Code", "submit", "submit");
        $document->add($promoForm);
    }
}
