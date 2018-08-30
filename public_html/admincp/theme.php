<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPThemeController extends AppController{

	const PARAM = "tid";
    
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage themes.");
		}	
    }
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("themes");	
        $this->setField("stmt", new DatabaseStatement($stmt));
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    if(!$mysidia->input->post("theme") or !$mysidia->input->post("folder")) throw new BlankFieldException("global_blank");
            $mysidia->db->insert("themes", array("id" => NULL, "themename" => $mysidia->input->post("theme"), "themefolder" => $mysidia->input->post("folder")));            
			if($mysidia->input->post("install") != "yes") $this->updateTheme();
			return;          
		}
	}
	
	public function edit(){
	   $mysidia = Registry::get("mysidia");  
  	   if(!$mysidia->input->get("tid")){
		    // A theme has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $userLevel = (!$mysidia->input->post("userlevel"))?"user":$mysidia->input->post("userlevel");
            $html = $this->format($mysidia->input->post("html"));
			$php = $this->format($mysidia->input->post("php"));
		    $mysidia->db->update("themes", array("themename" => $mysidia->input->post("theme"), "themefolder" => $mysidia->input->post("folder")), "id='{$mysidia->input->get("tid")}'");
	        $this->updateTheme();
			return;
		}
		else{
			$theme = $mysidia->db->select("themes", array(), "id='{$mysidia->input->get("tid")}'")->fetchObject();
			if(!is_object($theme)) throw new InvalidIDException("global_id");
			$header = new SplFileObject("{$mysidia->path->getRoot()}templates/{$theme->themefolder}/header.tpl");
            while (!$header->eof()) {
 			    $theme->header .= $header->fgets();
            }          

			$body = new SplFileObject("{$mysidia->path->getRoot()}templates/{$theme->themefolder}/template.tpl");
            while (!$body->eof()) {
 			    $theme->body .= $body->fgets();
            }    			

			$css = new SplFileObject("{$mysidia->path->getRoot()}templates/{$theme->themefolder}/style.css");
            while (!$css->eof()) {
 			    $theme->css .= $css->fgets();
            }   			
            $this->setField("theme", new DataObject($theme));	 
		}
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("tid")){
		    // A theme has yet been selected, return to the index page.
		    $this->index();
			return;
		}
        $mysidia->db->delete("themes", "id='{$mysidia->input->get("tid")}'");
	}
	
	public function css(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
		    $file = ($mysidia->input->post("new") == "yes")?
		             $mysidia->input->post("newfile"):$mysidia->input->post("file");
            $content = ($mysidia->input->post("new") == "yes")?
			            $mysidia->input->post("newcontent"):$mysidia->input->post($file);					 
			if(!$file) throw new BlankFieldException("global_blank");		
			$this->updateCSS($file, $content);
			return;          
		}
		
		$cssMap = new LinkedHashMap;
        $directory = new DirectoryIterator("{$mysidia->path->getRoot()}css");
        while($directory->valid()){
            if($directory->getExtension() == "css"){
                $key = $directory->getPathname();
                $value = "";
			    $css = new SplFileObject($key);
                while (!$css->eof()) {
 			        $value.= $css->fgets();
                }                  
			    $cssMap->put(new Mystring($key), new Mystring($value));
            }
			$directory->next();			
        }
        $this->setField("cssMap", $cssMap);	 		
	}
	
    private function format($text){
        $text = html_entity_decode($text);
        $text = stripslashes($text);
        return $text;
    }
	
    private function updateTheme(){
	    $mysidia = Registry::get("mysidia");
        $path = "{$mysidia->path->getRoot()}templates/{$mysidia->input->post("folder")}";
        @mkdir($path);	
		$header = new SplFileObject("{$path}/header.tpl", "w");
        $header->fwrite($this->format($mysidia->input->post("header")));			
        $header->fflush();			
		
  		$body = new SplFileObject("{$path}/template.tpl", "w");            	  
        $body->fwrite($this->format($mysidia->input->post("body")));
        $body->fflush();

  		$body = new SplFileObject("{$path}/style.css", "w");            	  
        $body->fwrite($this->format($mysidia->input->post("css")));
        $body->fflush();			
    }

	private function updateCSS($file = "", $content = ""){
	    $mysidia = Registry::get("mysidia");	
	    $css = new SplFileObject("{$mysidia->path->getRoot()}css/{$file}.css", "w");
        $css->fwrite($this->format($content));
        $css->fflush();
	}
}
?>