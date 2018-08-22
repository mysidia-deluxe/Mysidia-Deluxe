<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPThemeView extends View{

	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();		
		$document = $this->document;		

        $fields = new LinkedHashMap;
		$fields->put(new Mystring("id"), NULL);
		$fields->put(new Mystring("themename"), NULL);
		$fields->put(new Mystring("themefolder"), NULL);	
		$fields->put(new Mystring("id::edit"), new Mystring("getEditLink"));
		$fields->put(new Mystring("id::delete"), new Mystring("getDeleteLink"));	
		
		$themeTable = new TableBuilder("themes");
		$themeTable->setAlign(new Align("center", "middle"));
		$themeTable->buildHeaders("ID", "Theme", "Folder", "Edit", "Delete");
		$themeTable->setHelper(new TableHelper);
		$themeTable->buildTable($stmt, $fields);
		$document->add($themeTable);
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
		$themeForm = new FormBuilder("addform", "add", "post");
		$themeForm->buildComment("Theme Name: ", FALSE)->buildTextField("theme")
		          ->buildComment("Theme Folder: ", FALSE)->buildTextField("folder")
 				  ->buildComment("The theme folder will appear inside the template folder.")
				  ->buildComment("Header HTML: ")->buildTextArea("header", "", 8, 85)
				  ->buildComment("Body HTML: ")->buildTextArea("body", "", 8, 85)			  
				  ->buildComment("The Header and Body HTML will be used in the two generated files header.tpl and template.tpl")
				  ->buildComment("Style CSS: ")->buildTextArea("css", "", 8, 85)
 				  ->buildComment("The Style css will be created as style.css file inside the appropriate theme folder.")                 				  
				  ->buildCheckBox("The style has been uploaded to the site, and is pending for installation", "install", "yes")
		          ->buildButton("Create/Install Theme", "submit", "submit");
		$document->add($themeForm);
	}
	
	public function edit(){
	   	$mysidia = Registry::get("mysidia");
		$document = $this->document;
	  
  	   if(!$mysidia->input->get("tid")){
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
			$theme = $this->getField("theme")->get();
			$themeForm = new FormBuilder("editform", $mysidia->input->get("tid"), "post");
		    $themeForm->buildComment("Theme Name: ", FALSE)->buildTextField("theme", $theme->themename)
				      ->buildComment("Theme Folder: ", FALSE)->buildTextField("folder", $theme->themefolder)
 				      ->buildComment("The theme folder will appear inside the template folder.")
				      ->buildComment("Header HTML: ")->buildTextArea("header", $theme->header, 8, 85)
				      ->buildComment("Body HTML: ")->buildTextArea("body", $theme->body, 8, 85)
				      ->buildComment("Style CSS: ")->buildTextArea("css", $theme->css, 8, 85)					  
		              ->buildButton("Update Theme", "submit", "submit");
		    $document->add($themeForm);		 
		}
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("tid")){
		    // A module has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
	}
	
	public function css(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    if($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->additional_title);
		    $document->addLangvar($this->lang->additional);
			return;          
		}		
		
		$document->setTitle($this->lang->css_title);		
		$document->addLangvar($this->lang->css);	
        $cssForm = new Form("cssform", "css", "post");		
        $cssTable = new TableBuilder("csstable");
		$cssTable->setAlign(new Align("center", "middle"));
		$cssTable->buildHeaders("Select", "File", "CSS");
		
		$cssIterator = $this->getField("cssMap")->iterator();
		while($cssIterator->hasNext()){
		    $cssEntry = $cssIterator->next();
			$css = $cssEntry->getKey()->remove("{$mysidia->path->getRoot()}css/")->remove(".css")->getValue();
		    $cells = new LinkedList;			
			$cssButton = new RadioButton("", "file", $css);	
			$cssContent = new TextArea($css, $cssEntry->getValue(), 6, 65);

			$cells->add(new TCell($cssButton));
			$cells->add(new TCell($css));			
			$cells->add(new TCell($cssContent));
			$cssTable->buildRow($cells);
        }
		
        $notice = new Comment($this->lang->css_notice);
        $notice->setHeading(3);		
		$cssForm->add($cssTable);
		$cssForm->add($notice);
	
		$cssForm->add(new CheckBox("Create a new additional css", "new", "yes"));
        $cssForm->add(new Comment("CSS file name: "));	
		$cssForm->add(new TextField("newfile", "blank"));
        $cssForm->add(new Comment("CSS file content: "));	
		$cssForm->add(new TextArea("newcontent"));
		$cssForm->add(new Button("Add/Update Additional CSS", "submit", "submit"));
		$document->add($cssForm);		
	}
}
?>