<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPSettingsController extends AppController{

	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage promocodes.");
		}	
    }
	
	public function globals(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
		    $settings = array('theme', 'sitename', 'browsertitle', 'cost',  'slogan', 'admincontact', 
			                  'systemuser', 'systememail', 'startmoney');
			foreach($settings as $name){			
				if($mysidia->input->post($name) != ($mysidia->settings->{$name})) $mysidia->db->update("settings", array("value" => $mysidia->input->post($name)), "name='{$name}'");	 
			}	
		}
	}
	
	public function theme(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit") == "install"){
		    if ($mysidia->input->post("themename") and $mysidia->input->post("themefolder")){
			    $mysidia->db->insert("themes", array("id" => NULL, "themename" => $mysidia->input->post("themename"), "themefolder" => $mysidia->input->post("themefolder")));
                return;
			}
			else throw new InvalidActionException("themes_install_failed");
		}
		if($mysidia->input->post("submit") == "update" and $mysidia->input->post("theme") != "none"){
			$stmt = $mysidia->db->select("themes", array(), "themefolder='{$mysidia->input->post("theme")}'");
			if($theme = $stmt->fetchObject()){
			    $mysidia->db->update("settings", array("value" => $mysidia->input->post("theme")), "name='theme'");
				return;
			}
			else throw new InvalidIDException("themes_update_failed");
		}
	}
	
	public function pound(){
	    $mysidia = Registry::get("mysidia");
		if($mysidia->input->post("submit")){
		    $active = array();
		    $simplerb = array("system", "adopt", "date", "owner", "rename");
			$poundsettings = array('system', 'adopt', 'specieslimit', 'cost', 'levelbonus', 'number',
								   'date', 'duration', 'owner', 'recurrence', 'rename');
			
			foreach($poundsettings as $varname){
                if($mysidia->input->post($varname) != ""){
				   if(!$mysidia->input->post($varname) and !in_array($varname, $simplerb)) $active[$varname] = "no";
				   elseif(in_array($varname, $simplerb)) $active[$varname] = $mysidia->input->post($varname); 
				   else $active[$varname] = "yes";
				   $mysidia->db->update("pound_settings", array("active" => $active[$varname], "value" => $mysidia->input->post($varname)), "varname='{$varname}'");	 
				}
            }
			
			if($mysidia->input->post("costtype")) $mysidia->db->update("pound_settings", array("advanced" => $mysidia->input->post("costtype")), "varname='cost'");
			if($mysidia->input->post("leveltype")) $mysidia->db->update("pound_settings", array("advanced" => $mysidia->input->post("leveltype")), "varname='levelbonus'");
			if($mysidia->input->post("dateunit")) $mysidia->db->update("pound_settings", array("advanced" => $mysidia->input->post("dateunit")), "varname='duration'");
			return;
		}
			
		$poundsettings = $mysidia->db->select("pound_settings", array())->fetchAll(PDO::FETCH_OBJ);	
		$enabled = new LinkedHashMap;
		$enabled->put(new Mystring(" Yes"), new Mystring("yes"));
		$enabled->put(new Mystring(" No"), new Mystring("no"));
		$cost = new LinkedHashMap;
		$cost->put(new Mystring(" Increment"), new Mystring("increment"));
		$cost->put(new Mystring(" Percent"), new Mystring("percent"));
		$level = new LinkedHashMap;
		$level->put(new Mystring(" Increment"), new Mystring("increment"));
		$level->put(new Mystring(" Multiply"), new Mystring("multiply"));
		$rename = new LinkedHashMap;
		$rename->put(new Mystring(" Original Owner Only"), new Mystring("yes"));
		$rename->put(new Mystring(" Everyone"), new Mystring("no"));
        $this->setField("poundsettings", new DataObject($poundsettings));
        $this->setField("enabled", $enabled);		
		$this->setField("cost", $cost);
		$this->setField("level", $level);
		$this->setField("rename", $rename);  
	}
	
	public function plugin(){
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("acp_hooks");		
        if($stmt->rowCount() == 0) throw new InvalidIDException($mysidia->lang->no_plugins);
        $plugins = new LinkedList;
        while($plugin = $stmt->fetchObject()){
            $plugins->add(new DataObject($plugins));			
        } 
		$this->setField("plugins", $plugins);
	}
}
?>