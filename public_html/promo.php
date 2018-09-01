<?php

class PromoController extends AppController
{
    public function __construct()
    {
        parent::__construct("member");
    }
    
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        
        if ($mysidia->input->post("promocode")) {
            $mysidia->session->validate("promo");
            $promo = new Promocode($mysidia->input->post("promocode"));
            switch ($promo->pid) {
                case 0:
                    throw new PromocodeException("fail");
                    break;
                default:
                    if ($promo->validate($mysidia->input->post("promocode"))) {
                        $promo->execute();
                    }
            }
            $mysidia->session->terminate("promo");
            return;
        }
        $mysidia->session->assign("promo", 1);
    }
}
