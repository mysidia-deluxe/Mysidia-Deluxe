<?php

class Shoutbox extends MessageContainer
{
    // The shoutbox class, which implements the container interface
  
    public $editor;
    public $purifier;
    public $limit;
  
    public function __construct($ckeditor = true, $limit = 10)
    {
        // Fetch the basic member properties for private messages
     
        $mysidia = Registry::get("mysidia");
        if (!$ckeditor) {
            // The shoutbox will not use CKEditor, for now this is not possible.
            return false;
        } else {
            // Initiate the amazing CKEditor
            if (defined("SUBDIR") and SUBDIR == "AdminCP") {
                include_once("../inc/ckeditor/ckeditor.php");
            } else {
                include_once("inc/ckeditor/ckeditor.php");
            }
            $this->editor = new CKEditor();
            $this->editor->basePath = "{$mysidia->path->getAbsolute()}/inc/ckeditor/";
        }
        $this->limit = $limit;
    }
  
    public function display()
    {
    }
  
    public function post()
    {
        $mysidia = Registry::get("mysidia");
        $date = new DateTime;
        $comment = $this->format($mysidia->input->post("comment"));
        $mysidia->db->insert("shoutbox", array("id" => null, "user" => $mysidia->user->username, "date" => $date->format("Y-m-d H:i:s"), "comment" => $comment));
    }
}
