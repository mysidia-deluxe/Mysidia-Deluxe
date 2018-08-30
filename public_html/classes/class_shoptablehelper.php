<?php

/**
 * The ShopTableHelper Class, extends from the TableHelper class.
 * It is a specific helper for tables that involves operations on shops.
 * @category Resource
 * @package Helper
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class ShopTableHelper extends TableHelper{

    /**
     * Constructor of ShopTableHelper Class, it simply serves as a wrap-up.
     * @access public
     * @return Void
     */
	public function __construct(){
	    parent::__construct();         
	}

	/**
     * The getSalestax method, formats and retrieves the salestax of a shop.
     * @param Int  $salestax
     * @access public
     * @return String
     */
    public function getSalestax($salestax){
		return "{$salestax}%";				
    }
	
	/**
     * The getShopstatus method, returns the shop status with an enter link or a closed message.
     * @param Shop  $shop
     * @access public
     * @return Link|String
     */
    public function getShopStatus($shop){	
	    if($shop->status == "open") return new Link("shop/browse/{$shop->shopname}", new Image("templates/icons/next.gif"));
		else return "Closed";		
    }
	
	/**
     * The getItemPurchaseForm method, constructs a buy form for an itemshop table.
	 * @param Itemshop  $shop
     * @param Item  $item 
     * @access public
     * @return Form
     */
    public function getItemPurchaseForm(Itemshop $shop, Item $item){	
        $mysidia = Registry::get("mysidia");
        $buyForm = new FormBuilder("buyform", "../purchase/{$mysidia->input->get("shop")}", "post");
        $buyForm->setLineBreak(FALSE);
        $buyForm->buildComment("<br>")
                ->buildPasswordField("hidden", "action", "purchase")
		        ->buildPasswordField("hidden", "itemname", $item->itemname)
				->buildPasswordField("hidden", "shopname", $shop->shopname)
                ->buildPasswordField("hidden", "shoptype", "itemshop")
				->buildPasswordField("hidden", "salestax", $shop->salestax);
				
        $quantity = new TextField("quantity");
        $quantity->setSize(3);
        $quantity->setMaxLength(3);
        $quantity->setLineBreak(TRUE);

        $buy = new Button("Buy", "buy", "buy");
        $buy->setLineBreak(FALSE);

		$buyForm->add($quantity);
		$buyForm->add($buy);
        return $buyForm;				
    }
	
	/**
     * The getAdoptPurchaseForm method, constructs a purchase form for an adoptshop table.
	 * @param Adoptshop  $shop
     * @param Adoptable  $adopt 
     * @access public
     * @return Form
     */
    public function getAdoptPurchaseForm(Adoptshop $shop, $adopt){	
        $mysidia = Registry::get("mysidia");
        $buyForm = new FormBuilder("buyform", "../purchase/{$mysidia->input->get("shop")}", "post");
        $buyForm->setLineBreak(FALSE);
        $buyForm->buildComment("<br>")
                ->buildPasswordField("hidden", "action", "purchase")
		        ->buildPasswordField("hidden", "adopttype", $adopt->type)
				->buildPasswordField("hidden", "shopname", $shop->shopname)
                ->buildPasswordField("hidden", "shoptype", "adoptshop")
				->buildPasswordField("hidden", "salestax", $shop->salestax);
				
        $buy = new Button("Buy", "buy", "buy");
        $buy->setLineBreak(FALSE);
		$buyForm->add($buy);
        return $buyForm;				
    }
	
	/**
     * Magic method __toString for ShopTableHelper class, it reveals that the object is a shop table helper.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia ShopTableHelper class.");
	}    
} 
?>