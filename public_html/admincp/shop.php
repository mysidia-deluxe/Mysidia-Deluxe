<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPShopController extends AppController
{
    const PARAM = "sid";
    
    public function __construct()
    {
        parent::__construct();
        $mysidia = Registry::get("mysidia");
        if ($mysidia->usergroup->getpermission("canmanagesettings") != "yes") {
            throw new NoPermissionException("You do not have permission to manage shops.");
        }
    }
    
    public function index()
    {
        parent::index();
        $mysidia = Registry::get("mysidia");
        $stmt = $mysidia->db->select("shops");
        $num = $stmt->rowCount();
        if ($num == 0) {
            throw new InvalidIDException("default_none");
        }
        $this->setField("stmt", new DatabaseStatement($stmt));
    }
    
    public function add()
    {
        $mysidia = Registry::get("mysidia");
        if ($mysidia->input->post("submit")) {
            $this->dataValidate();
            $imageurl = (!$mysidia->input->post("imageurl"))?$mysidia->input->post("existingimageurl"):$mysidia->input->post("imageurl");
            $salestax = (!$mysidia->input->post("salestax"))?0:$mysidia->input->post("salestax");
            $mysidia->db->insert("shops", array("category" => $mysidia->input->post("category"), "shopname" => $mysidia->input->post("shopname"), "shoptype" => $mysidia->input->post("shoptype"), "imageurl" => $imageurl,
                                                "description" => $mysidia->input->post("description"), "status" => $mysidia->input->post("status"), "restriction" => $mysidia->input->post("restriction"), "salestax" => $salestax));
        }
    }
    
    public function edit()
    {
        $mysidia = Registry::get("mysidia");
        if (!$mysidia->input->get("sid")) {
            $this->index();
            return;
        } elseif ($mysidia->input->post("submit")) {
            $this->dataValidate();
            $imageurl = (!$mysidia->input->post("imageurl"))?$mysidia->input->post("existingimageurl"):$mysidia->input->post("imageurl");
            $salestax = (!$mysidia->input->post("salestax"))?0:$mysidia->input->post("salestax");
            $mysidia->db->update("shops", array("category" => $mysidia->input->post("category"), "shopname" => $mysidia->input->post("shopname"), "description" => $mysidia->input->post("description"), "imageurl" => $imageurl,
                                                "status" => $mysidia->input->post("status"), "restriction" => $mysidia->input->post("restriction"), "salestax" => $salestax), "sid='{$mysidia->input->get("sid")}'");
            return;
        } else {
            $shop = $mysidia->db->select("shops", array(), "sid='{$mysidia->input->get("sid")}'")->fetchObject();
            if (!is_object($shop)) {
                throw new InvalidIDException("nonexist");
            }
            $this->setField("shop", new DataObject($shop));
        }
    }

    public function delete()
    {
        $mysidia = Registry::get("mysidia");
        $document = $mysidia->frame->getDocument();
        if (!$mysidia->input->get("sid")) {
            $this->index();
            return;
        }
        $mysidia->db->delete("shops", "sid='{$mysidia->input->get("sid")}'");
    }

    private function dataValidate()
    {
        $mysidia = Registry::get("mysidia");
        if (!$mysidia->input->post("category")) {
            throw new BlankFieldException("category");
        }
        if (!$mysidia->input->post("shopname")) {
            throw new BlankFieldException("shopname");
        }
        if (!$mysidia->input->post("imageurl") and $mysidia->input->post("existingimageurl") == "none") {
            throw new BlankFieldException("images");
        }
        if (!$mysidia->input->post("status")) {
            throw new BlankFieldException("status");
        }
        if ($mysidia->input->post("salestax") < 0) {
            throw new InvalidActionException("salestax");
        }
        
        $shop = $mysidia->db->select("shops", array(), "shopname = '{$mysidia->input->post("shopname")}'")->fetchObject();
        if ($this->action == "add" and is_object($shop)) {
            throw new DuplicateIDException("duplicate");
        }
        return true;
    }
}
