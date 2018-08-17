<?php

use Resource\Collection\LinkedList;

class Itemshop extends Model{

    public $sid;
    public $category;
    public $shopname;
    public $shoptype;
    public $description;
    public $imageurl;
    public $status;
    public $restriction;
    public $salestax;
    public $items;
    protected $total = 0;
  
    public function __construct($shopname){
        // Fetch the database info into object property	  
	    $mysidia = Registry::get("mysidia");
	    $row = $mysidia->db->select("shops", array(), "shopname ='{$shopname}'")->fetchObject();
	    if(!is_object($row)) throw new Exception("Invalid Shopname specified");
	  
	    // loop through the anonymous object created to assign properties
        foreach($row as $key => $val){
            $this->$key = $val;		 
        }
        $this->items = $this->getitemnames();
	    $this->total = (is_array($this->items))?count($this->items):0;
    }

    public function getcategory(){
	    $mysidia = Registry::get("mysidia");
	    $stmt = $mysidia->db->select("shops", array(), "category ='{$this->category}'");
        $cate_exist = ($row = $stmt->fetchObject())?TRUE:FALSE;     
	    return $cate_exist;
    }
  
    public function getshop(){  
	    $mysidia = Registry::get("mysidia");
	    if(empty($this->shopname)) $shop_exist = FALSE;
	    else{
	        $stmt = $mysidia->db->select("shops", array(), "shopname ='{$this->shopname}'");
		    $shop_exist = ($row = $stmt->fetchObject())?TRUE:FALSE;    
	    }
	    return $shop_exist;
    }
  
    public function getitemnames(){
  	    if(!$this->items){
		    $mysidia = Registry::get("mysidia");		
		    $stmt = $mysidia->db->select("items", array("itemname"), "shop ='{$this->shopname}'");
		    $items = array();
		
		    while($item = $stmt->fetchColumn()){
		        $items[] = $item;
		    }
		    return $items;
	    }
	    else return $this->items;
    }
  
    public function gettotal(){  
	    return $this->total;
    }
  
    public function display(){
	    $mysidia = Registry::get("mysidia");
	    $document = $mysidia->frame->getDocument();			  
	    $document->addLangvar($mysidia->lang->select_item);
	  
        if($this->gettotal() == 0){
            $document->addLangvar($mysidia->lang->empty);
		    return FALSE;
        }	 
	  
	    $itemList = new TableBuilder("shop");
	    $itemList->setAlign(new Align("center", "middle"));
        $itemList->buildHeaders("Image", "Category", "Name", "Description", "Price", "Buy");	
	    $itemList->setHelper(new ShopTableHelper);
	  
	    foreach($this->items as $stockitem){
	  	    $item = $this->getitem($stockitem);
		    $cells = new LinkedList;		 
	        $cells->add(new TCell(new Image($item->imageurl)));
		    $cells->add(new TCell($item->category));
		    $cells->add(new TCell($item->itemname));
		    $cells->add(new TCell($item->description));
		    $cells->add(new TCell($item->price));
		    $cells->add(new TCell($itemList->getHelper()->getItemPurchaseForm($this, $item)));
		    $itemList->buildRow($cells);
        }	  
	    $document->add($itemList);  
    }
  
    public function getitem($itemname){
	  return new StockItem($itemname);
    }
  
    public function purchase(Item $item){
        $mysidia = Registry::get("mysidia");
	    if($item->owner != $mysidia->user->username) Throw new NoPermissionException('Something is very very wrong, please contact an admin asap.');
	    else{
            $item->quantity = $mysidia->input->post("quantity");
	        $cost = $item->getcost($this->salestax, $item->quantity);
		    $moneyleft = $mysidia->user->money - $cost;
		    if($moneyleft >= 0 and $item->quantity > 0){	
                $purchase = $item->append($item->quantity, $item->owner);
                $mysidia->db->update("users", array("money" => $moneyleft), "username = '{$item->owner}'");			
                $status = TRUE;
            }			
	        else throw new InvalidActionException($mysidia->lang->money);
	    }
	    return $status;
    }
  
    public function rent($item, $period){

    }
  
    public function execute($action){
	
    }
  
  	protected function save($field, $value){
		$mysidia = Registry::get("mysidia");
		$mysidia->db->update("shops", array($field => $value), "sid='{$this->sid}' and shoptype = 'adoptshop'");
	}  
}
?> 