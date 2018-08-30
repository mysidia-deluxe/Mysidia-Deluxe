<?php

class ChangeStyleView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->title);		
	    if($mysidia->input->get("theme")){
		    $document->addLangvar($this->lang->success);
			return;
		}
		
		$document->addLangvar($this->lang->select);
        $paragraph = new Paragraph;
		$themes = $this->getField("themes");
		$iterator = $themes->iterator();
		while($iterator->hasNext()){
		    $theme = $iterator->next();
		    $themeName = (string)$theme->getKey();
            $themeFolder = (string)$theme->getValue();
		    $paragraph->add(new Link("changestyle/index/{$themeFolder}", $themeName, TRUE));		
		}
        $document->add($paragraph);
	}
}
?>