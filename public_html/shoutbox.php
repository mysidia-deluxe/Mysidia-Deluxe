<?php

class ShoutboxController extends AppController
{
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $shoutbox = new Shoutbox;
        $stmt = $mysidia->db->select("shoutbox", array(), "1 ORDER BY id DESC LIMIT 0, {$shoutbox->limit}");
        $this->setField("shoutbox", $shoutbox);
        $this->setField("stmt", new DatabaseStatement($stmt));
        
        if ($mysidia->input->post("comment")) {
            if (!$mysidia->user->isloggedin) {
                throw new GuestNoaccessException($mysidia->lang->guest);
            }
            $shoutbox->post();
        }
    }
}
