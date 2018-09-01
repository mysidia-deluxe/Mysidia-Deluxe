<?php

use Resource\Collection\LinkedList;

class VmessageController extends AppController
{
    const PARAM = "id";
    const PARAM2 = "id2";

    public function __construct()
    {
        parent::__construct("member");
    }

    public function index()
    {
        $mysidia = Registry::get("mysidia");
        throw new InvalidActionException($mysidia->lang->global_action);
    }

    public function view()
    {
        $mysidia = Registry::get("mysidia");
        if (!$mysidia->input->get("id") or !$mysidia->input->get("id2")) {
            throw new InvalidIDException($mysidia->lang->user_nonexist);
        }
        if ($mysidia->input->get("id") == $mysidia->input->get("id2")) {
            throw new DuplicateIDException($mysidia->lang->user_same);
        }
        $stmt = $mysidia->db->select("visitor_messages", array("vid"), "(touser = '{$mysidia->input->get("id")}' and fromuser = '{$mysidia->input->get("id2")}') or (touser = '{$mysidia->input->get("id2")}' and fromuser = '{$mysidia->input->get("id")}') ORDER BY vid DESC LIMIT 0, 25");
        $vmessages = new LinkedList;
        while ($vid = $stmt->fetchColumn()) {
            $vmessages->add(new VisitorMessage($vid));
        }
        $this->setField("vmessages", $vmessages);
    }
    
    public function edit()
    {
        $mysidia = Registry::get("mysidia");
        $vmessage = new VisitorMessage($mysidia->input->get("id"));
        if ($vmessage->fromuser != $mysidia->user->username and !($mysidia->user instanceof Admin)) {
            throw new NoPermissionException($mysidia->lang->edit_denied);
        }

        $this->setField("vmessage", $vmessage);
        if ($mysidia->input->post("submit")) {
            $vmessage->edit();
        }
    }

    public function delete()
    {
        $mysidia = Registry::get("mysidia");
        $vmessage = new VisitorMessage($mysidia->input->get("id"));
        if ($vmessage->fromuser != $mysidia->user->username and !($mysidia->user instanceof Admin)) {
            throw new NoPermissionException($mysidia->lang->delete_denied);
        }
        $vmessage->remove();
    }
}
