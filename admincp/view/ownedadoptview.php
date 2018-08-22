<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPOwnedadoptView extends View{

    public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();
		$document = $this->document;
		
        $fields = new LinkedHashMap;
		$fields->put(new Mystring("aid"), NULL);
		$fields->put(new Mystring("type"), NULL);
		$fields->put(new Mystring("name"), NULL);
		$fields->put(new Mystring("owner"), NULL);	
		$fields->put(new Mystring("gender"), new Mystring("getGenderImage"));			
		$fields->put(new Mystring("aid::edit"), new Mystring("getEditLink"));
		$fields->put(new Mystring("aid::delete"), new Mystring("getDeleteLink"));		
		
		$ownedAdoptTable = new TableBuilder("ownedadopt");
		$ownedAdoptTable->setAlign(new Align("center", "middle"));
		$ownedAdoptTable->buildHeaders("ID", "Type", "Name", "Owner", "Gender", "Edit", "Delete");
		$ownedAdoptTable->setHelper(new AdoptTableHelper);
		$ownedAdoptTable->buildTable($stmt, $fields);
        $document->add($ownedAdoptTable);	
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->added_title);
			$document->addLangvar($this->lang->added);
			return;
		}
		
		$document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);
		$genders = new LinkedHashMap;
		$genders->put(new Mystring("female"), new Mystring("f"));
		$genders->put(new Mystring("male"), new Mystring("m"));
		
		$ownedAdoptForm = new FormBuilder("addform", "add", "post");
		$ownedAdoptForm->buildComment("<u><strong>Create A New Adoptable For a User:</strong></u>")
		               ->buildComment("Adoptable Type: ", FALSE)->buildTextField("type")
					   ->buildComment("Adoptable Name: ", FALSE)->buildTextField("name")
					   ->buildComment("Adoptable Owner: ", FALSE)->buildTextField("owner")
		               ->buildComment("Adoptable Clicks: ", FALSE)->buildTextField("clicks")
					   ->buildComment("Adoptable Level: ", FALSE)->buildTextField("level")
					   ->buildCheckBox(" Use Alternate Image", "usealternates", "yes")
					   ->buildComment("Adoptable Gender: ", FALSE)
					   ->buildRadioList("gender", $genders)
					   ->buildButton("Give it to User", "submit", "submit");
		$document->add($ownedAdoptForm);		
    }

    public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("aid")){
		    $this->index();
			return;
        } 		
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();
            $useAlternates = ($mysidia->input->post("usealternates") == "yes")?"yes":"no";
			$mysidia->db->update("owned_adoptables", array("type" => $mysidia->input->post("type"), "name" => $mysidia->input->post("name"), "owner" => $mysidia->input->post("owner"), "totalclicks" => $mysidia->input->post("clicks"), 
			                                               "currentlevel" => $mysidia->input->post("level"), "usealternates" => $useAlternates, "gender" => $mysidia->input->post("gender")), "aid='{$mysidia->input->get("aid")}'");
      		$document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		
		$ownedadopt = $this->getField("ownedadopt")->get();
		$document->setTitle($this->lang->edit_title);
		$document->addLangvar($this->lang->edit);
		$genders = new LinkedHashMap;
		$genders->put(new Mystring("female"), new Mystring("f"));
	    $genders->put(new Mystring("male"), new Mystring("m"));
			
		$ownedAdoptForm = new FormBuilder("editform", $mysidia->input->get("aid"), "post");
		$ownedAdoptForm->buildComment("<u><strong>Edit User's Owned Adoptable:</strong></u>")
		               ->buildComment("Adoptable Type: ", FALSE)->buildTextField("type", $ownedadopt->type)
					   ->buildComment("Adoptable Name: ", FALSE)->buildTextField("name", $ownedadopt->name)
					   ->buildComment("Adoptable Owner: ", FALSE)->buildTextField("owner", $ownedadopt->owner)
		               ->buildComment("Adoptable Clicks: ", FALSE)->buildTextField("clicks", $ownedadopt->totalclicks)
					   ->buildComment("Adoptable Level: ", FALSE)->buildTextField("level", $ownedadopt->currentlevel)
					   ->buildCheckBox(" Use Alternate Image", "usealternates", "yes", $ownedadopt->usealternates)
					   ->buildComment("Adoptable Gender: ", FALSE)
					   ->buildRadioList("gender", $genders, $ownedadopt->gender)
					   ->buildButton("Edit this Adoptable", "submit", "submit");
		$document->add($ownedAdoptForm);			
    }

    public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("aid")){
		    $this->index();
			return;
		}	
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
        header("Refresh:3; URL='../index'");
    }

    private function dataValidate(){
        $mysidia = Registry::get("mysidia");
		$fields = array("type" => $mysidia->input->post("type"), "name" => $mysidia->input->post("name"), "owner" => $mysidia->input->post("owner"), "clicks" => $mysidia->input->post("clicks"), 
			            "level" => $mysidia->input->post("level"), "usealternates" => $mysidia->input->post("usealternates"), "gender" => $mysidia->input->post("gender"));
        foreach($fields as $field => $value){
			if(!$value){
                if($field == "clicks" and $value == 0) continue;
                if($field == "usealternates") continue;
                if($field == "level" and $value == 0) continue;
				throw new BlankFieldException("You did not enter in {$field} for the adoptable.  Please go back and try again.");
            }
	    }
		return TRUE;
    }	
}

?>