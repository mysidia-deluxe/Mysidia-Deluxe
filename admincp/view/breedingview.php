<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPBreedingView extends View{

    public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();		
		$document = $this->document;		
        $fields = new LinkedHashMap;
		$fields->put(new Mystring("bid"), NULL);
		$fields->put(new Mystring("offspring"), NULL);
		$fields->put(new Mystring("parent"), new Mystring("getAdopt"));
		$fields->put(new Mystring("mother"), new Mystring("getAdopt"));	
		$fields->put(new Mystring("father"), new Mystring("getAdopt"));			
		$fields->put(new Mystring("bid::edit"), new Mystring("getEditLink"));
		$fields->put(new Mystring("bid::delete"), new Mystring("getDeleteLink"));		
						
		$breedAdoptTable = new TableBuilder("breedadopt");
		$breedAdoptTable->setAlign(new Align("center", "middle"));
		$breedAdoptTable->buildHeaders("Breed ID", "Offspring", "Parents", "Mother", "Father", "Edit", "Delete");
		$breedAdoptTable->setHelper(new AdoptTableHelper);	
		$breedAdoptTable->buildTable($stmt, $fields);
        $document->add($breedAdoptTable);	
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
		$breedAdoptForm = new FormBuilder("addform", "add", "post");
		$breedAdoptForm->buildComment("<u><strong>Create A New Baby Adoptable:</strong></u>")
		               ->buildComment("Baby Adoptable: ", FALSE)->buildTextField("offspring")
					   ->buildComment("Parent Adoptable(s): ", FALSE)->buildTextField("parent")
					   ->buildComment("<b>If both parents are specified in the above field, separate them by comma.</b>")
					   ->buildComment("Mother Adoptable: ", FALSE)->buildTextField("mother")
		               ->buildComment("Father Adoptable: ", FALSE)->buildTextField("father")
					   ->buildComment("<b>The two fields above should be left empty if the parent field is entered.</b>")
					   ->buildComment("Probability for Baby Adoptable to appear: ", FALSE)->buildTextField("probability")
					   ->buildComment("<b>The total probability for all baby possible adoptables is normalized to 100, so this number can be any positive integers.</b>")
					   ->buildComment("Baby Adoptable Survival Rate(0-100 scale): ", FALSE)->buildTextField("survival")
					   ->buildComment("Level Requirement: ", FALSE)->buildTextField("level")
					   ->buildCheckBox(" Make this baby adopt available now.", "available", "yes")
					   ->buildButton("Create a Baby Adopt", "submit", "submit");
		$document->add($breedAdoptForm);		
    }

    public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("bid")){
		    $this->index();
			return;
        } 
		
	    if($mysidia->input->post("submit")){
      		$document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		
        $breedAdopt = $this->getField("breedAdopt");		
	    $document->setTitle($this->lang->edit_title);
		$document->addLangvar($this->lang->edit);
        $breedAdoptForm = new FormBuilder("addform", "", "post");
		$breedAdoptForm->buildComment("<u><strong>Create A New Baby Adoptable:</strong></u>")
		               ->buildComment("Baby Adoptable: ", FALSE)->buildTextField("offspring", $breedAdopt->getOffspring())
					   ->buildComment("Parent Adoptable(s): ", FALSE)->buildTextField("parent", $breedAdopt->getParent())
					   ->buildComment("<b>If both parents are specified in the above field, separate them by comma.</b>")
					   ->buildComment("Mother Adoptable: ", FALSE)->buildTextField("mother", $breedAdopt->getMother())
		               ->buildComment("Father Adoptable: ", FALSE)->buildTextField("father", $breedAdopt->getFather())
					   ->buildComment("<b>The two fields above should be left empty if the parent field is entered.</b>")
					   ->buildComment("Probability for Baby Adoptable to appear: ", FALSE)->buildTextField("probability", $breedAdopt->getProbability())
					   ->buildComment("<b>The total probability for all baby possible adoptables is normalized to 100, so this number can be any positive integers.</b>")
					   ->buildComment("Baby Adoptable Survival Rate(0-100 scale): ", FALSE)->buildTextField("survival", $breedAdopt->getSurvivalRate())
					   ->buildComment("Level Requirement: ", FALSE)->buildTextField("level", $breedAdopt->getRequiredLevel())
					   ->buildCheckBox(" Make this baby adopt available now.", "available", "yes", $breedAdopt->isAvailable())
					   ->buildButton("Update Baby Adopt", "submit", "submit");
		$document->add($breedAdoptForm);				
    }

    public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("bid")){
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
        header("Refresh:3; URL='../index'");
    }
	
	public function settings(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
		if($mysidia->input->post("submit")){
			$document->setTitle($this->lang->settings_changed_title);
            $document->addLangvar($this->lang->settings_changed);
		    return;
		}
		
        $breedingSettings = $this->getField("breedingSettings");			
		$document->setTitle($this->lang->settings_title);
		$document->addLangvar($this->lang->settings);
		$settingsForm = new FormBuilder("settingsform", "settings", "post");
		$breedingSystem = new LinkedHashMap;
		$breedingSystem->put(new Mystring("Enabled"), new Mystring("enabled"));
		$breedingSystem->put(new Mystring("Disabled"), new Mystring("disabled"));
		$breedingMethod = new LinkedHashMap;
		$breedingMethod->put(new Mystring("Heuristic"), new Mystring("heuristic"));
		$breedingMethod->put(new Mystring("Advanced"), new Mystring("advanced"));		

		$settingsForm->buildComment("Breeding System Enabled:   ", FALSE)->buildRadioList("system", $breedingSystem, $breedingSettings->system)
					 ->buildComment("Breeding Method(heuristic or advanced):   ", FALSE)->buildRadioList("method", $breedingMethod, $breedingSettings->method)
					 ->buildComment("Ineligible Species(separate by comma):   ", FALSE)->buildTextField("species", ($breedingSettings->species)?implode(",", $breedingSettings->species):"")
		             ->buildComment("Interval/wait-time(days) between successive attempts:	 ", FALSE)->buildTextField("interval", $breedingSettings->interval)
					 ->buildComment("Minimum Level Requirement:	 ", FALSE)->buildTextField("level", $breedingSettings->level)
					 ->buildComment("Maximum Breeding Attempts for each adopt:	", FALSE)->buildTextField("capacity", $breedingSettings->capacity)
					 ->buildComment("Maximum Number of Offsprings per Breeding attempt:   ", FALSE)->buildTextField("number", $breedingSettings->number)
					 ->buildComment("Chance for successful Breeding attempt:   ", FALSE)->buildTextField("chance", $breedingSettings->chance)
		             ->buildComment("Cost for each Breeding attempt:	 ", FALSE)->buildTextField("cost", $breedingSettings->cost)
					 ->buildComment("Usergroup(s) permitted to breed(separate by comma):	", FALSE)->buildTextField("usergroup", ($breedingSettings->usergroup == "all")?$breedingSettings->usergroup:implode(",", $breedingSettings->usergroup))
					 ->buildComment("Item(s) required to breed(separate by comma):	", FALSE)->buildTextField("item", ($breedingSettings->item)?implode(",", $breedingSettings->item):"")
					 ->buildButton("Change Breeding Settings", "submit", "submit");
		$document->add($settingsForm);	
	}
}
?>