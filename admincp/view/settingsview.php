<?php

class ACPSettingsView extends View{

	public function globals(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if($mysidia->input->post("submit")){
			$document->setTitle($this->lang->basic_update_title);
            $document->addLangvar($this->lang->basic_update);
            return;		
		}
		
	    $document->setTitle($this->lang->basic_title);
		$document->addLangvar($this->lang->basic);
		$globalsForm = new FormBuilder("globalsform", "globals", "post");
		$globalsForm->buildComment("Default Theme:   ", FALSE)->buildTextField("theme", $mysidia->settings->theme)
					->buildComment("Site Name:   ", FALSE)->buildTextField("sitename", $mysidia->settings->sitename)
					->buildComment("Site Title:   ", FALSE)->buildTextField("browsertitle", $mysidia->settings->browsertitle)
		            ->buildComment("Currency Name:	 ", FALSE)->buildTextField("cost", $mysidia->settings->cost)
					->buildComment("Start Money:	", FALSE)->buildTextField("startmoney", $mysidia->settings->startmoney)
					->buildComment("Site Slogan:	", FALSE)->buildTextField("slogan", $mysidia->settings->slogan)
					->buildComment("Admin Email:   ", FALSE)->buildTextField("admincontact", $mysidia->settings->admincontact)
				    ->buildComment("System User:   ", FALSE)->buildTextField("systemuser", $mysidia->settings->systemuser)
           	        ->buildComment("System Email:   ", FALSE)->buildTextField("systememail", $mysidia->settings->systememail)
					->buildButton("Change Global Settings", "submit", "submit");
		$document->add($globalsForm);
	}
	
	public function theme(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if($mysidia->input->post("submit") == "install"){
		    $document->setTitle($this->lang->themes_install_title);
		    $document->addLangvar($this->lang->themes_install_success);
            return;
		}
		elseif($mysidia->input->post("submit") == "update" and $mysidia->input->post("theme") != "none"){
			$document->setTitle($this->lang->themes_update_title);
		    $document->addLangvar($this->lang->themes_update_success);
		}
		else{
	        $document->setTitle($this->lang->themes_title);
		    $document->addLangvar($this->lang->themes);
			$themesUpdateForm = new FormBuilder("themesupdateform", "theme", "post");
			$themesUpdateForm->buildDropdownList("theme", "ThemeList", $mysidia->settings->theme)
			                 ->buildButton("Set Default Theme", "submit", "update");
		    $document->add($themesUpdateForm);
		    
			$document->addLangvar($this->lang->themes_install);
			$themesInstallForm = new FormBuilder("themesinstallform", "theme", "post");
			$themesInstallForm->buildComment("Theme Name: ", FALSE)->buildTextField("themename")
			                  ->buildComment($this->lang->themes_update_name)
					          ->buildComment("Theme Folder: ", FALSE)->buildTextField("themefolder")
					          ->buildComment($this->lang->themes_update_folder)
					          ->buildButton("Install new Theme", "submit", "install");
			$document->add($themesInstallForm);			 
		}
	}
	
	public function pound(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		if($mysidia->input->post("submit")){
			$document->setTitle($this->lang->pound_edited_title);
		    $document->addLangvar($this->lang->pound_edited);
			return;
		}
			
        $poundsettings = $this->getField("poundsettings")->get();
        $enabled = $this->getField("enabled");		
		$cost = $this->getField("cost");
		$level = $this->getField("level");
		$rename = $this->getField("rename");  		
		
	    $document->setTitle($this->lang->pound_title);
		$document->addLangvar($this->lang->pound);			
		$poundForm = new FormBuilder("poundform", "pound", "post");
		$poundForm->add(new Comment("Enable Pound System:", FALSE, "b"));
		$poundForm->buildRadioList("system", $enabled, $poundsettings[0]->active);
		$poundForm->add(new Comment("Enable Readoption:", FALSE, "b"));
		$poundForm->buildRadioList("adopt", $enabled, $poundsettings[1]->active);
		$poundForm->add(new Comment($this->lang->pound_adopt));
		$poundForm->add(new Comment("Species immune to Pound(separated by comma):", TRUE, "b"));
		$poundForm->add(new TextField("specieslimit", $poundsettings[2]->value));
		$poundForm->add(new Comment("Cost to pound/adopt(the format is 'poundcost, adoptcost', make sure to separate them by comma!):", TRUE, "b"));
		$poundForm->add(new TextField("cost", $poundsettings[3]->value));
		$poundForm->add(new Comment("Select the type of cost(Incremental or Percentage):", TRUE, "b"));
		$poundForm->buildRadioList("costtype", $cost, $poundsettings[3]->advanced);
		$poundForm->add(new Comment("Cost per additional level:", FALSE, "b"));
		$poundForm->add(new TextField("levelbonus", $poundsettings[4]->value));
		$poundForm->add(new Comment("Select the type of Level Bonus(Incremental or Multiple):", TRUE, "b"));
		$poundForm->buildRadioList("leveltype", $level, $poundsettings[4]->advanced);
		$poundForm->add(new Comment("Number-based Restriction(How many pets a user can pound or adopt, separated by comma):", TRUE, "b"));
		$poundForm->add(new TextField("number", $poundsettings[5]->value));
		$poundForm->add(new Comment("Number-date Integration(the above limit will be number per day if turned on):", TRUE, "b"));
		$poundForm->buildRadioList("date", $enabled, $poundsettings[6]->active);
		
		$poundForm->add(new Comment("Pound/Adopt Lag(Define how many days it takes for pounded pets to be allowed for re-adoption):", TRUE, "b"));
		$duration = new TextField("duration", $poundsettings[7]->value);
		$duration->setLineBreak(FALSE);
		$unit = new DropdownList("dateunit");
		$unit->add(new Option("Days", "days"));
		$unit->add(new Option("Hours", "hours"));
		$unit->add(new Option("Minutes", "minutes"));
		$unit->add(new Option("Months", "months"));
		$unit->select($poundsettings[7]->advanced);
		$poundForm->add($duration);
		$poundForm->add($unit);
		
		$poundForm->add(new Comment("Forbid previous owners to re-adopt: ", FALSE, "b"));
		$poundForm->buildRadioList("owner", $enabled, $poundsettings[8]->active);
		$poundForm->add(new Comment("Maximum times a pet can be pounded: ", FALSE, "b"));
		$poundForm->add(new TextField("recurrence", $poundsettings[9]->value));
		$poundForm->add(new Comment("Pets Rename Constraint: ", FALSE, "b"));
		$poundForm->buildRadioList("rename", $rename, $poundsettings[10]->active);
		$poundForm->add(new Button("Edit Pound Settings", "submit", "submit"));
		$document->add($poundForm);		  
	}
	
	public function plugin(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->plugins_title);
        $document->addLangvar($this->lang->plugins);
		$plugins = $this->getField("plugins");
		$iterator = $plugins->iterator();
		while($iterator->hasNext()){
		    $plugin = $iterator->next()->get();
            $document->add(new Link($plugin->linkurl, $plugin->linktext, TRUE));
            $document->add(new Comment("- Generated by the <b>{$plugin->pluginname}</b> plugin"));					
		}
	}
}
?>