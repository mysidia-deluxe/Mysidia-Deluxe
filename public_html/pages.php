<?php

class PagesController extends AppController
{
    const PARAM = "document";

    public function __construct()
    {
        parent::__construct();
        $mysidia = Registry::get("mysidia");
        if (!$mysidia->input->get("document")) {
            throw new InvalidIDException("global_id");
        }
    }
    
    public function index()
    {
        throw new InvalidIDException("global_id");
    }

    public function view()
    {
        $mysidia = Registry::get("mysidia");
        try {
            $document = $mysidia->frame->getDocument($mysidia->input->get("document"));
        } catch (NoPermissionException $npe) {
            $this->setFlags("error", $npe->getmessage());
        } catch (PageNotFoundException $pne) {
            $this->setFlags("error", $pne->getmessage());
        }
    }
}
