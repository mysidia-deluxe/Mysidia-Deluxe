<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPModuleView extends View{

	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();		
		$document = $this->document;		

        $fields = new LinkedHashMap;
		$fields->put(new String("moid"), NULL);
		$fields->put(new String("widget"), NULL);
		$fields->put(new String("name"), NULL);
		$fields->put(new String("order"), NULL);	
		$fields->put(new String("status"), NULL);	
		$fields->put(new String("moid::edit"), new String("getEditLink"));
		$fields->put(new String("moid::delete"), new String("getDeleteLink"));	
		
		$moduleTable = new TableBuilder("modules");
		$moduleTable->setAlign(new Align("center", "middle"));
		$moduleTable->buildHeaders("ID", "Widget", "Name", "Order", "Status", "Edit", "Delete");
		$moduleTable->setHelper(new TableHelper);
		$moduleTable->buildTable($stmt, $fields);
		$document->add($moduleTable);
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");
        $document = $this->document;		
	    if($mysidia->input->post("submit")){
		    $document->setTitle($mysidia->lang->added_title);
			$document->addLangvar($mysidia->lang->added);
            return;          
		}
		
	    $document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);
		$widgets = $this->getField("widgets");
	   	$widgetList = new DropdownList("widget");            
        $widgetList->fill($widgets);
        $widgetList->select("sidebar");

		$moduleForm = new FormBuilder("addform", "add", "post");
		$moduleForm->add(new Comment("Parent Widget: ", FALSE));
        $moduleForm->add($widgetList);
		$moduleForm->add(new Comment("<b>You may browse a list of available widgets to decide what to enter here.</b>"));
		$moduleForm->buildComment("Module Name: ", FALSE)->buildTextField("name")
				   ->buildComment("Module Subtitle: ", FALSE)->buildTextField("subtitle")
				   ->buildComment("Required Userlevel: ", FALSE)->buildTextField("userlevel")
 				   ->buildComment("<b>You may enter 'member', 'visitor' or leave the above field blank.</b>")
				   ->buildComment("Module HTML Code: ")->buildTextArea("html")
				   ->buildComment("Module PHP Code: ")->buildTextArea("php")
				   ->buildComment("<b>Be cautious with the PHP code for your module, it may or may not work!</b>")
				   ->buildComment("Module Order: ", FALSE)->buildTextField("order", 0)
				   ->buildComment("Module Status:(enabled or disabled) ", FALSE)->buildTextField("status", "enabled")
		           ->buildButton("Create Module", "submit", "submit");
		$document->add($moduleForm);
	}
	
	public function edit(){
	   	$mysidia = Registry::get("mysidia");
		$document = $this->document;
	  
  	   if(!$mysidia->input->get("mid")){
		    // A module has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		else{
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);
			$module = $this->getField("module")->get();
		    $widgets = $this->getField("widgets");
	   	    $widgetList = new DropdownList("widget");            
            $widgetList->fill($widgets);
            $widgetList->select($module->widget);

			$moduleForm = new FormBuilder("editform", $mysidia->input->get("mid"), "post");
		    $moduleForm->add(new Comment("Parent Widget: ", FALSE));
            $moduleForm->add($widgetList);
		    $moduleForm->add(new Comment("<b>You may browse a list of available widgets to decide what to enter here.</b>"));
		    $moduleForm->buildComment("Module Name: ", FALSE)->buildTextField("name", $module->name)
				       ->buildComment("Module Subtitle: ", FALSE)->buildTextField("subtitle", $module->subtitle)
				       ->buildComment("Required Userlevel: ", FALSE)->buildTextField("userlevel", $module->userlevel)
 				       ->buildComment("<b>You may enter 'member', 'visitor' or leave the above field blank.</b>")
				       ->buildComment("Module HTML Code: ")->buildTextArea("html", $module->html)
				       ->buildComment("Module PHP Code: ")->buildTextArea("php", $module->php)
				       ->buildComment("<b>Be cautious with the PHP code for your module, it may or may not work!</b>")
				       ->buildComment("Module Order: ", FALSE)->buildTextField("order", $module->order)
				       ->buildComment("Module Status:(enabled or disabled) ", FALSE)->buildTextField("status", $module->status)
		               ->buildButton("Change Module", "submit", "submit");
		    $document->add($moduleForm);		 
		}
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("mid")){
		    // A module has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
	}
}
?>