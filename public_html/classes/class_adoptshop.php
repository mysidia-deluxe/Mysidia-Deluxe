<?php

use Resource\Collection\LinkedList;

class Adoptshop extends AdoptContainer
{
    public $sid;
    public $category;
    public $shopname;
    public $shoptype;
    public $description;
    public $imageurl;
    public $status;
    public $restriction;
    public $salestax;
    public $adopts;
    protected $total = 0;
  
    public function __construct($shopname)
    {
        // Fetch the database info into object property
        $mysidia = Registry::get("mysidia");
        $row = $mysidia->db->select("shops", array(), "shopname ='{$shopname}'")->fetchObject();
        if (!is_object($row)) {
            throw new Exception("Invalid Shopname specified");
        }
       
        // loop through the anonymous object created to assign properties
        foreach ($row as $key => $val) {
            $this->$key = $val;
        }

        $this->adopts = $this->getadopttypes();
        $this->total = (is_array($this->adopts))?count($this->adopts):0;
    }

    public function getcategory()
    {
        $mysidia = Registry::get("mysidia");
        $stmt = $mysidia->db->select("shops", array(), "category ='{$this->category}'");
        $cate_exist = ($row = $stmt->fetchObject())?true:false;
        return $cate_exist;
    }
  
    public function getshop()
    {
        $mysidia = Registry::get("mysidia");
        if (empty($this->shopname)) {
            $shop_exist = false;
        } else {
            $stmt = $mysidia->db->select("shops", array(), "shopname ='{$this->shopname}'");
            $shop_exist = ($row = $stmt->fetchObject())?true:false;
        }
        return $shop_exist;
    }
  
    public function getadopttypes()
    {
        if (!$this->adopts) {
            $mysidia = Registry::get("mysidia");
            $stmt = $mysidia->db->join("adoptables_conditions", "adoptables_conditions.id = adoptables.id")
                            ->select("adoptables", array(), constant("PREFIX")."adoptables.shop ='{$this->shopname}'");
            $adopts = array();
            while ($adopt = $stmt->fetchObject()) {
                $aid = $row->id;
                $promocode = "";
                if (canadopt($aid, "showing", $promocode, $row)) {
                    $adopts[] = $adopt;
                }
            }
            return $adopts;
        } else {
            return $this->adopts;
        }
    }
  
    public function gettotal()
    {
        return $this->total;
    }
  
    public function display()
    {
        $mysidia = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
        $document->addLangvar($mysidia->lang->select_adopt);
        if ($this->gettotal() == 0) {
            $document->addLangvar($mysidia->lang->empty);
            return;
        }
      
        $adoptList = new TableBuilder("shop");
        $adoptList->setAlign(new Align("center", "middle"));
        $adoptList->buildHeaders("Image", "Class", "Type", "Description", "Price", "Buy");
        $adoptList->setHelper(new ShopTableHelper);
        $this->adopts = $this->getadopttypes();
      
        foreach ($this->adopts as $stockadopt) {
            $adopt = $this->getadopt($stockadopt->type);
            $cells = new LinkedList;
            $cells->add(new TCell($this->getadoptimage($adopt->eggimage)));
            $cells->add(new TCell($adopt->class));
            $cells->add(new TCell($adopt->type));
            $cells->add(new TCell($adopt->description));
            $cells->add(new TCell($adopt->cost));
            $cells->add(new TCell($adoptList->getHelper()->getAdoptPurchaseForm($this, $adopt)));
            $adoptList->buildRow($cells);
        }
        $document->add($adoptList);
    }
  
    public function getadopt($id)
    {
        return new StockAdopt($id);
    }
  
    public function purchase($adopt)
    {
        $mysidia = Registry::get("mysidia");
        if ($adopt->owner != $mysidia->user->username) {
            throw new NoPermissionException('Something is very very wrong, please contact an admin asap.');
        } else {
            $cost = $adopt->getcost($this->salestax);
            $moneyleft = $mysidia->user->money - $cost;
            if ($moneyleft >= 0) {
                $purchase = $adopt->append($adopt->owner);
                $mysidia->db->update("users", array("money" => $moneyleft), "username = '{$adopt->owner}'");
                $status = true;
            } else {
                throw new InvalidActionException($mysidia->lang->money);
            }
        }
        return $status;
    }
  
    public function rent($adopt, $period)
    {
    }
  
    public function execute($action)
    {
    }
  
    protected function save($field, $value)
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->db->update("shops", array($field => $value), "sid='{$this->sid}' and shoptype = 'adoptshop'");
    }
}
?> 