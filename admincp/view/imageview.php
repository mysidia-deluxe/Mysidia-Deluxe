<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPImageView extends View{

	public function upload(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
		
	    if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->uploaded_title);
		    $document->addLangvar($this->lang->uploaded);
			$document->addLangvar($this->lang->next);
			return;
		}	
		
		$document->setTitle($this->lang->upload_title);
		$document->addLangvar($this->lang->upload);
		$imageForm = new Form("uploadform", "upload", "post");
		$imageForm->setEnctype("multipart/form-data");
		$imageForm->add(new Comment("Friendly Name: ", FALSE));
		$imageForm->add(new TextField("ffn"));
		$imageForm->add(new Comment($this->lang->explain));
		$imageForm->add(new Comment("File to Upload: ", FALSE));
		$imageForm->add(new FileField("uploadedfile"));
		$imageForm->add(new Comment("<br><br>"));
		$imageForm->add(new Button("Upload File", "submit", "submit"));
		$document->add($imageForm);
	}

	public function manage(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
		$document->setTitle($this->lang->manage_title);
		$document->addLangvar($this->lang->manage);
		
		$imageForm = new Form("manageform", "delete", "post");		
		$filesMap = $this->getField("filesMap");
		$iterator = $filesMap->iterator();
        while ($iterator->hasNext()){
		    $file = $iterator->next();
			$fileID = $file->getKey();
			$fileImage = $file->getValue();			
			$fileImage->setLineBreak(TRUE);
			
		    $action = new RadioButton("Delete this Image", "iid", $fileID->getValue());
			$action->setLineBreak(TRUE);
			$imageForm->add($fileImage);
			$imageForm->add($action);
		}
        $imageForm->add(new Button("Submit", "submit", "submit"));
		$document->add($imageForm);
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
        if(!$mysidia->input->post("iid")){
		    // A promocode has yet been selected, return to the index page.
		    $this->manage();
			return;
		}
		else{
		    $document->setTitle($this->lang->delete_title);
		    $document->addLangvar($this->lang->delete);
		}
	}
	
	public function settings(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
	    if($mysidia->input->post("submit")){
			$document->setTitle($this->lang->settings_updated_title);
		    $document->addLangvar($this->lang->settings_updated);
            return;
		}
		
		$document->setTitle($this->lang->settings_title);
		$document->addLangvar($this->lang->settings);		
		$settingsForm = new Form("settingsform", "settings", "post");		
		$settingsForm->add(new CheckBox(" Enable GD Signature Image for GIF Files", "enablegd", "yes", $mysidia->settings->gdimages));
		$settingsForm->add(new Comment($this->lang->gd_explain));
		$settingsForm->add(new CheckBox(" Enable Alternate Friendly Signature BBCode", "altbb", "yes", $mysidia->settings->usealtbbcode));
		$settingsForm->add(new Comment($this->lang->altbb_explain));
		$settingsForm->add(new Button("Change Settings", "submit", "submit"));
		$document->add($settingsForm);
	}	
}	
?>