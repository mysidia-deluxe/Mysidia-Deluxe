<?php

use Resource\Native\Integer;

class OnlineController extends AppController
{
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $wol = new Online("members");
        $stmt = $mysidia->db->select("online", array("username"), "username != 'Visitor'");
        $this->setField("total", new Integer($wol->gettotal()));
        $this->setField("stmt", new DatabaseStatement($stmt));
    }
}
