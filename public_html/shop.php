<?php

use Resource\Native\Integer;

class ShopController extends AppController{

    const PARAM = "shop";

    public function __construct(){
        parent::__construct("member");	
        $mysidia = Registry::get("mysidia");		
        $mysidia->user->getstatus();
		if($mysidia->user->status->canshop == "no"){
		    throw new NoPermissionException($mysidia->lang->denied);
		}
		if($mysidia->input->action() != "index" and !$mysidia->input->get("shop")){
		    throw new InvalidIDException($mysidia->lang->global_id);
		}
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
        $shopList = new Shoplist($mysidia->input->post("shoptype"));
		if($shopList->gettotal() == 0) throw new InvalidIDException("none");
        $this->setField("shopList", $shopList);
	}
	
	public function browse(){
		$mysidia = Registry::get("mysidia");		
		$shoptype = $mysidia->db->select("shops", array("shoptype"), "shopname = '{$mysidia->input->get("shop")}'")->fetchColumn();
        $shoplist = new Shoplist($shoptype);
        $shop = $shoplist->createshop($mysidia->input->get("shop"));
        $this->setField("shop", $shop);
	}
	
	public function purchase(){
        $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->post("buy")) throw new InvalidIDException($mysidia->lang->global_id);
		
	    if($mysidia->input->post("shoptype") == "itemshop") $this->purchaseItem();
		elseif($mysidia->input->post("shoptype") == "adoptshop") $this->purchaseAdopt();
		else throw new InvalidActionException($mysidia->lang->global_action);
	}
	
	private function purchaseItem(){
        $mysidia = Registry::get("mysidia");        
        $shop = new Itemshop($mysidia->input->get("shop"));
        $item = $shop->getitem($mysidia->input->post("itemname"));
	    $item->assign($mysidia->user->username);
        $oldquantity = $item->getoldquantity();
        $newquantity = $oldquantity + $mysidia->input->post("quantity");
			
	    if(!is_numeric($mysidia->input->post("quantity"))){
			throw new InvalidActionException($mysidia->lang->invalid_quantity);
        }
        elseif($newquantity > $item->cap){
			throw new InvalidActionException($mysidia->lang->full_quantity); 
        }
        else{
		    $shop->purchase($item);
			$this->setField("cost", new Integer($item->getcost($shop->salestax)));
		}		
	}
	
	private function purchaseAdopt(){
        $mysidia = Registry::get("mysidia");
		$shop = new Adoptshop($mysidia->input->get("shop"));
        $adopt = $shop->getadopt($mysidia->input->post("adopttype"));
        $adopt->assign($mysidia->user->username);			
        $shop->purchase($adopt);
		$this->setField("cost", new Integer($adopt->getcost($shop->salestax)));	    
	}
}
?>