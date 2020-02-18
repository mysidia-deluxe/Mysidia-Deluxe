<?php

use Resource\Native\Object;
use Resource\Native\Arrays;

class Inventory extends Object
{
    public $owner;
    public $iids;
    protected $total = 0;
    protected $privacy = "public";

    public function __construct(User $user)
    {
        $this->owner = $user->username;
        $this->iids = $this->getiids();
        $this->total = (!$this->iids)?0:$this->iids->length();
    }

    public function getiids()
    {
        if (!$this->iids) {
            $mysidia = Registry::get("mysidia");
            $stmt = $mysidia->db->select("inventory", array("iid"), "owner = '{$this->owner}'");
            $size = $stmt->rowCount();
            if ($size == 0) {
                return null;
            }
            
            $this->iids = new Arrays($size);
            $i = 0;
            while ($iid = $stmt->fetchColumn()) {
                $this->iids[$i] = $iid;
                $i++;
            }
        }
        return $this->iids;
    }
 
    public function gettotal()
    {
        return $this->total;
    }

    public function getitemimage($imageurl = "")
    {
        return new Image($imageurl);
    }
  
    public function getitem($iid)
    {
        return new PrivateItem($iid);
    }

    public function execute($action)
    {
        // Will be added in future
    }
}
