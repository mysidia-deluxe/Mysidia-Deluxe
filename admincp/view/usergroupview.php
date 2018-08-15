<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPUsergroupView extends View{

    public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$stmt = $this->getField("stmt")->get();
		
        $fields = new LinkedHashMap;
		$fields->put(new String("gid"), NULL);
		$fields->put(new String("groupname"), NULL);
		$fields->put(new String("canadopt"), new String("getPermissionImage"));
		$fields->put(new String("canpm"), new String("getPermissionImage"));	
		$fields->put(new String("cancp"), new String("getPermissionImage"));			
		$fields->put(new String("gid::edit"), new String("getEditLink"));
		$fields->put(new String("gid::delete"), new String("getDeleteLink"));	
		
		$usergroupTable = new TableBuilder("user");
		$usergroupTable->setAlign(new Align("center", "middle"));
		$usergroupTable->buildHeaders("ID", "Usergroup", "Can Adopt Pets", "Can Use PM", "Can Access ACP", "Edit", "Delete");
		$usergroupTable->setHelper(new GroupTableHelper);
		$usergroupTable->buildTable($stmt, $fields);
        $document->add($usergroupTable);	
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if($mysidia->input->post("submit") and $mysidia->input->post("group")){
		    $document->setTitle($this->lang->added_title);
            $document->addLangvar($this->lang->added);
            return;		
		}
		
		$document->setTitle($this->lang->add_title);
        $document->addLangvar($this->lang->add);
		$usergroupForm = new FormBuilder("addform", "add", "post");
		$usergroupForm->buildComment("New Usergroup Name: ")
		              ->buildTextField("group")
					  ->buildButton("Create new Usergroup", "submit", "submit");
		$document->add($usergroupForm);		
    }

    public function edit(){
        $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("group")){
		    $this->index();
			return;
		}		

		if($mysidia->input->post("submit")){		    
			$document->setTitle($this->lang->edited_title);
		    $document->addLangvar($this->lang->edited);
		}
		else{
		    $checkBoxes = $this->getField("checkBoxes");
			$document->setTitle($this->lang->edit_title);
		    $document->addlangvar($this->lang->edit); 			
			
			$usergroupForm = new Form("editform", $mysidia->input->get("group"), "post");
			$usergroupForm->add($checkBoxes->get(new String("canadopt")));
			$usergroupForm->add($checkBoxes->get(new String("canpm")));
			$usergroupForm->add(new Comment("<u>Admin Settings: </u>", TRUE, "b"));
			$usergroupForm->add($checkBoxes->get(new String("cancp")));
			$usergroupForm->add($checkBoxes->get(new String("canmanageadopts")));
			$usergroupForm->add(new Comment($this->lang->notice));
			$usergroupForm->add($checkBoxes->get(new String("canmanageads")));
			$usergroupForm->add($checkBoxes->get(new String("canmanagecontent")));
			$usergroupForm->add($checkBoxes->get(new String("canmanagesettings")));
			$usergroupForm->add($checkBoxes->get(new String("canmanageusers")));
			$usergroupForm->add(new Comment($this->lang->warning));
			$usergroupForm->add(new Button("Edit Usergroup", "submit", "submit"));
			$document->add($usergroupForm);		 
		}
    }
 
    public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if(!$mysidia->input->get("group")){
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
    }	
}
?>