<?php

class ACPAdsController extends AppController
{
    const PARAM = "aid";
    
    public function __construct()
    {
        parent::__construct();
        $mysidia = Registry::get("mysidia");
        if ($mysidia->usergroup->getpermission("canmanageads") != "yes") {
            throw new NoPermissionException("You do not have permission to manage ads.");
        }
    }
    
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $stmt = $mysidia->db->select("ads");
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
            if (!$mysidia->input->post("adname")) {
                throw new BlankFieldException("name");
            }
            if (!$mysidia->input->post("description")) {
                throw new BlankFieldException("text");
            }
            $date = new DateTime;
            $mysidia->db->insert("ads", array("id" => null, "adname" => $mysidia->input->post("adname"), "text" => $mysidia->input->post("description"), "page" => $mysidia->input->post("adpage"),
                                              "impressions" => $mysidia->input->post("impressions"),  "actualimpressions" => 0, "date" => $date->format('Y-m-d'), "status" => 'active', "user" => null, "extra" => null));
        }
    }
    
    public function edit()
    {
        $mysidia = Registry::get("mysidia");
        if (!$mysidia->input->get("aid")) {
            // An Ad has yet been selected, return to the index page.
            $this->index();
            return;
        } elseif ($mysidia->input->post("submit")) {
            $mysidia->db->update("ads", array("adname" => $mysidia->input->post("adname"), "text" => $mysidia->input->post("description"), "page" => $mysidia->input->post("adpage"), "impressions" => $mysidia->input->post("impressions")), "id='{$mysidia->input->get("aid")}'");
            if ($mysidia->input->post("aimp") >= $mysidia->input->post("impressions") and $mysidia->input->post("impressions") != 0) {
                $mysidia->db->update("ads", array("status" => 'inactive'), "id='{$mysidia->input->get("aid")}'");
            } else {
                $mysidia->db->update("ads", array("status" => 'active'), "id='{$mysidia->input->get("aid")}'");
            }
            return;
        } else {
            $ad = $mysidia->db->select("ads", array(), "id = '{$mysidia->input->get("aid")}' LIMIT 1")->fetchObject();
            if (!is_object($ad)) {
                throw new InvalidIDException("nonexist");
            }
            $this->setField("ad", new DataObject($ad));
        }
    }
    
    public function delete()
    {
        $mysidia = Registry::get("mysidia");
        if (!$mysidia->input->get("aid")) {
            // An Add has yet been selected, return to the index page.
            $this->index();
            return;
        }
        $mysidia->db->delete("ads", "id='{$mysidia->input->get("aid")}'");
    }
}
