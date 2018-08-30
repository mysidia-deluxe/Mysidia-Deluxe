<?php

class ACPAdoptView extends View{

    public function index(){
		parent::index();
		$document = $this->document;
		$document->add(new Link("admincp/adopt/add", "Add a new adoptable",TRUE));	
		$document->add(new Link("admincp/adopt/edit", "Edit an Existing Adoptable",TRUE));
		$document->add(new Link("admincp/adopt/delete", "Delete an Adoptable"));
    }

    public function add(){
        // The action of creating a new adoptable!
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		
		if($mysidia->input->post("submit")){		    
			$document->setTitle($this->lang->added_title);
			$document->addLangvar($this->lang->added);
		    return;
		}
		
		$document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);				
		$adoptForm = new Form("addform", "", "post");
		$title = new Comment("Create a New Adoptable:");
		$title->setBold();
		$title->setUnderlined();
		$adoptForm->add($title);
		
		$basicInfo = new FieldSetBuilder("Basic Information");
		$basicInfo->add(new Comment("Adoptable Species: ", FALSE));
		$basicInfo->add(new TextField("type"));
		$basicInfo->add(new Comment("(This may contain only letters, numbers and spaces)"));
		$basicInfo->add(new Comment("Adoptable Class: ", FALSE));
		$basicInfo->add(new TextField("class"));
		$basicInfo->add(new Comment("(The adoptable class is a category that determines if two adoptables can interbreed or not)"));
		$basicInfo->add(new Comment("Adoptable Description:"));
		$basicInfo->add(new TextArea("description", "", 4, 45));
		$basicInfo->add(new Comment("Adoptable's Egg(initial) Image: ", FALSE));
		$basicInfo->add(new TextField("imageurl"));
		$basicInfo->add(new Comment("(Use a full image path, beginning with http://)"));
		$basicInfo->add(new Comment("OR select an existing image: ", FALSE));
		$basicInfo->buildDropdownList("existingimageurl", "ImageList");  
        
		$shopSettings = new FieldSetBuilder("Shop Settings");
        $shopSettings->add(new Comment("Shop: ", FALSE));
		$shopSettings->buildDropdownList("shop", "AdoptShopList");
		$shopSettings->add(new Comment("Price: ", FALSE));
		$shopSettings->add(new TextField("cost", 0, 10));		
		
		$conditions = new FieldSetBuilder("Adoptable Conditions");
		$conditions->add(new Comment("When can this adoptable be adopted?"));
		$always = new RadioButton("Always Available ", "cba", "always");
        $always->setLineBreak(TRUE);
		$promo = new RadioButton("Only when users use promo code ", "cba", "promo");
        $promo->setLineBreak(TRUE);
        $cond = new RadioButton("Only when the following conditions are met ", "cba", "conditions");
        $cond->setLineBreak(TRUE);
		$conditions->add($always);
        $conditions->add($promo);
        $conditions->add($cond);
        $conditions->add(new CheckBox("The adoptable has not been adopted more than:", "freqcond", "enabled"));
		$freqField = new TextField("number", "", 6);
        $freqField->setLineBreak(FALSE);
        $conditions->add($freqField);
		$conditions->add(new Comment(" times"));
		$conditions->add(new CheckBox("The date is: (For the date, use this format: Year-Month-Day. So, as an example: 2012-06-28)", "datecond", "enabled"));
		$conditions->add(new TextField("date"));
		$conditions->add(new CheckBox("The user does not have more than: ", "maxnumcond", "enabled"));
		$numField = new TextField("morethannum", "", 4);
        $numField->setLineBreak(FALSE);
        $conditions->add($numField);
		$conditions->add(new Comment(" of this type of adoptable"));
		$conditions->add(new CheckBox("The user is a member of the following usergroup: ", "usergroupcond", "enabled"));
		$conditions->buildDropdownList("usergroups", "UsergroupList");		
		
		$miscellaneous = new FieldSetBuilder("Alternative Outcomes");
		$miscellaneous->add(new Legend("Alternative Outcomes"));
		$miscellaneous->add(new Comment("This section allows you to set if you want to enable alternate outcomes. 
								         This setting allows you to specify what the chances are of a user getting an alternate or special version of this adoptable. 
								         Check the checkbox below to enable this feature and then fill out the information below.."));
		$miscellaneous->add(new CheckBox("<b>Enable Alternate Outcomes</b>", "alternates", "enabled"));	
		$miscellaneous->add(new Comment("Alternate Outcomes Selection Information:"));
		$miscellaneous->add(new Comment("Start using the alternate outcome at level number: ", FALSE));
		$miscellaneous->add(new TextField("altoutlevel", "", 4));
		$miscellaneous->add(new Comment("(Use Level 0 to have the alternate outcome be used from birth. This will not affect the first / egg image.)"));
		$miscellaneous->add(new Comment("The alternate outcome has a chance of 1 in ", FALSE));
	    $chanceField = new TextField("altchance", "", 6);
        $chanceField->setLineBreak(FALSE);
    	$miscellaneous->add($chanceField);
		$miscellaneous->add(new Comment(" of being selected."));
		$miscellaneous->add(new Comment("(Here you can select the chance that the alternate images for this adoptable are used. 
								          So, for an equal chance of using say male or female images, put 2 in the box to have a 1 out of 2 or 50% chance of using the alternate image. 
								          If you want to have the alternate images be rare images, use a higher number, like 100 for a 1 out of 100 chance of using the alternates.)"));
		
		$adoptForm->add($basicInfo);
		$adoptForm->add($shopSettings);
		$adoptForm->add($conditions);
		$adoptForm->add($miscellaneous);
        $adoptForm->add(new Button("Create this Adoptable", "submit", "submit"));
		$document->add($adoptForm);								   
    }

    public function edit(){
        $mysidia = Registry::get("mysidia");
		$document = $this->document;
		
		if(!$mysidia->input->post("choose")){
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);			
			$adoptForm = new FormBuilder("chooseform", "edit", "post");
			$adoptForm->buildDropdownList("type", "AdoptTypeList")
			          ->buildButton("Choose", "choose", "choose");
	        $document->add($adoptForm);		  
		}
		elseif($mysidia->input->post("submit")){
		    // A form has been submitted, time to carry out out action.
			if($mysidia->input->post("delete") == "yes"){
				$contentvar = $mysidia->input->post("deltype");
				$titlevar = "{$contentvar}_title";
				$document->setTitle($this->lang->{$titlevar});
				$document->addLangvar($this->lang->{$contentvar});
			}
			else{
				$document->setTitle($this->lang->edited_title);
				$document->addLangvar($this->lang->edited);
			}
		}
		else{
            $adopt = $this->getField("adopt");
		    $availtext = (string)$this->getField("availtext");
		    $document->setTitle($this->lang->edit_adopt);
			$document->add($adopt->getEggImage("gui"));
			$document->add(new Comment("<br>This page allows you to edit {$mysidia->input->post("type")}.  Use the form below to edit (or delete) {$mysidia->input->post("type")}."));
			
			$adoptForm = new FormBuilder("editform", "edit", "post");  
            $adoptForm->add(new Comment("Egg Image:", TRUE, "b"));
			$adoptForm->add(new Comment("If you wish to change the egg image for this adoptable, you may do so below. "));
			$adoptForm->add(new Comment("Select a new Egg Image: ", FALSE));
			$adoptForm->buildDropdownList("select", "ImageList");
			$adoptForm->add(new Comment("Adoptable Delete Settings:", TRUE, "b"));
			$adoptForm->add(new CheckBox("<b>I want to delete this adoptable </b>", "delete", "yes"));
			$adoptForm->add(new Comment("What sort of deletion do you wish to perform for this adoptable?"));
			
			$soft = new RadioButton($this->lang->soft_comment, "deltype", "soft");
			$soft->setLineBreak(TRUE);
			$hard = new RadioButton($this->lang->hard_comment, "deltype", "hard");
			$hard->setLineBreak(TRUE);
			$adoptForm->add($soft);
			$adoptForm->add($hard);
			
			$adoptForm->add(new Comment("Adoptable Adoption Conditions: ", TRUE, "b"));
			$adoptForm->add(new Comment($availtext));
			$adoptForm->add(new CheckBox($this->lang->condition_comment, "resetconds", "yes"));
			$adoptForm->add(new CheckBox("Reset only the date condition for this adoptable to the following value:", "resetdate", "yes"));
			$adoptForm->add(new TextField("date"));
			$adoptForm->add(new Comment("(Ex: 2012-06-28)"));
			$adoptForm->add(new Comment($this->lang->date_comment));
            $adoptForm->add(new PasswordField("hidden", "type", $mysidia->input->post("type")));
            $adoptForm->add(new PasswordField("hidden", "choose", "choose"));
			$adoptForm->add(new Button("Submit Changes", "submit", "submit"));
			$document->add($adoptForm);		
	    }
    }

    public function delete(){

    }	
}
?>