<?php

use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class BreedingView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    if($mysidia->input->post("submit")){
		    $links = $this->getField("links"); 
			if($links instanceof LinkedList){
                $breeding = $this->getField("breeding");
			    $document->setTitle("Breeding is Successful!");
                $document->add(new Comment("Congratulations! Breeding is successful, you have acquired {$breeding->countOffsprings()} baby adoptables from breeding center."));
                $document->add(new Comment("Click on one of the links below to manage your adoptables now!"));
                $iterator = $links->iterator();
				while($iterator->hasNext()) $document->add($iterator->next());			
			}
            else{
                $document->setTitle($this->lang->fail_title);
				$document->addLangvar($this->lang->fail);
            }			
			return;
		}
		
		$cost = $this->getField("cost")->getValue();
		$femaleMap = $this->getField("femaleMap");
		$maleMap = $this->getField("maleMap");
		$document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default.$this->lang->money);
        $document->addLangvar("{$settings->cost} {$mysidia->settings->cost}");
        $document->addLangvar($this->lang->warning.$this->lang->select);
		
		$breedingForm = new Form("breedingform", "breeding", "post");	    
        $breedingForm->add(new Comment("Female: ", FALSE));
        if($femaleMap instanceof LinkedHashMap){
	   	    $female = new DropdownList("female");
            $female->add(new Option("None Selected", "none"));            
            $female->fill($femaleMap);
        }
        else $female = new Comment($this->lang->female, FALSE);
		$breedingForm->add($female);  
    
        $breedingForm->add(new Comment("Male: ", FALSE));
        if($maleMap instanceof LinkedHashMap){
		    $male = new DropdownList("male");
            $male->add(new Option("None Selected", "none"));
            $male->fill($maleMap);
        }
        else $male = new Comment($this->lang->male, FALSE);

	    $breedingForm->add($male);		
		$breedingForm->add(new PasswordField("hidden", "breed", "yes"));
        $breedingForm->add(new Button("Let's breed!", "submit", "submit"));
        $document->add($breedingForm);	
	}
}
?>