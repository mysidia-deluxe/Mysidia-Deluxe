<?php

class IndexView extends View{
	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$sitename = $mysidia->db->select("settings", array("value"), "name = 'sitename'")->fetchColumn();
		$document = $this->document;	
		$document->setTitle("Home");
		$document->add(new Comment("<title>{$sitename} Home</title>"));
		$document->add(new Comment("This is the homepage!"));
	}
}
?>