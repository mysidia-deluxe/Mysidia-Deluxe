<?php

use Resource\Native\Mystring;

class ACPAdoptController extends AppController{

	const PARAM = "type";
	
    public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanageadopts") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage adoptables.");
		}	
    }

    public function add(){
        // The action of creating a new adoptable!
	    $mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("submit")){
		    // The form has been submitted, it's time to validate data and add a record to database.
			if($mysidia->session->fetch("acpAdopt") != "add"){
                $this->setFlag("global_error", "Session already expired...");
				return;
            }
			
			if(!$mysidia->input->post("type")) throw new BlankFieldException("type");
			elseif(!$mysidia->input->post("class")) throw new BlankFieldException("class");
		    elseif(!$mysidia->input->post("imageurl") and $mysidia->input->post("existingimageurl") == "none") throw new BlankFieldException("image");
		    elseif($mysidia->input->post("imageurl") and $mysidia->input->post("existingimageurl") != "none") throw new BlankFieldException("image2");
		    elseif(!$mysidia->input->post("cba")) throw new BlankFieldException("condition");
		    
			if($mysidia->input->post("cba") == "conditions"){
			    if($mysidia->input->post("freqcond") == "enabled" and !is_numeric($mysidia->input->post("number"))) throw new BlankFieldException("condition_freq");
		        if($mysidia->input->post("datecond") == "enabled" and !$mysidia->input->post("date")) throw new BlankFieldException("condition_date");
			    if($mysidia->input->post("adoptscond") == "enabled"){
				   if(!$mysidia->input->post("moreless") or !is_numeric($mysidia->input->post("morelessnum")) or !$mysidia->input->post("levelgrle") or !is_numeric($mysidia->input->post("grlelevel"))) throw new BlankFieldException("condition_moreandlevel");
			    }

			    if($mysidia->input->post("maxnumcond") == "enabled" and !is_numeric($mysidia->input->post("morethannum"))) throw new BlankFieldException("maxnum");
			    if($mysidia->input->post("usergroupcond") == "enabled" and !is_numeric($mysidia->input->post("usergroups"))) throw new BlankFieldException("group");
		    }

		    if($mysidia->input->post("alternates") == "enabled") {
				if(!is_numeric($mysidia->input->post("altoutlevel")) or !is_numeric($mysidia->input->post("altchance"))) throw new BlankFieldException("alternate");
		    }
            $type_exist = $mysidia->db->select("adoptables", array("type"), "type = '{$name}'")->fetchColumn();
		    if($type_exist) throw new DuplicateIDException("exist");
			
			$eggimage = ($mysidia->input->post("imageurl") and $mysidia->input->post("existingimageurl") == "none")?$mysidia->input->post("imageurl"):$mysidia->input->post("existingimageurl");
			// insert into table adoptables
			$mysidia->db->insert("adoptables", array("id" => NULL, "type" => $mysidia->input->post("type"), "class" => $mysidia->input->post("class"), "description" => $mysidia->input->post("description"), "eggimage" => $eggimage, "whenisavail" => $mysidia->input->post("cba"),
				                                     "alternates" => $mysidia->input->post("alternates"), "altoutlevel" => $mysidia->input->post("altoutlevel"), "altchance" => $mysidia->input->post("altchance"), "shop" => $mysidia->input->post("shop"), "cost" => $mysidia->input->post("cost")));
				
            // insert into table adoptables_conditions	
		    $mysidia->db->insert("adoptables_conditions", array("id" => NULL, "type" => $mysidia->input->post("type"), "whenisavail" => $mysidia->input->post("cba"), "freqcond" => $mysidia->input->post("freqcond"), "number" => $mysidia->input->post("number"), "datecond" => $mysidia->input->post("datecond"),
				                                                "date" => $mysidia->input->post("date"), "adoptscond" => $mysidia->input->post("adoptscond"), "moreless" => $mysidia->input->post("maxnumcond"), "morelessnum" => $mysidia->input->post("morethannum"), "levelgrle" => $mysidia->input->post("usergroupcond"), "grlelevel" => $mysidia->input->post("usergroups")));
				
			// insert our level thing
			$mysidia->db->insert("levels", array("lvid" => NULL, "adoptiename" => $mysidia->input->post("type"), "thisislevel" => 0, "requiredclicks" => 0,
				                                 "primaryimage" => $eggimage, "alternateimage" => NULL, "rewarduser" => NULL, "promocode" => NULL));
			$mysidia->session->terminate("acpAdopt");
		    return;
		}		
	    $mysidia->session->assign("acpAdopt", "add", TRUE);								   
    }

    public function edit(){
        $mysidia = Registry::get("mysidia");
		$document = $mysidia->frame->getDocument();
		
		if(!$mysidia->input->post("choose")) return;
		elseif($mysidia->input->post("submit")){
			if($mysidia->session->fetch("acpAdopt") != "edit"){
                $this->setFlag("global_error", "Session already expired...");
				return;
            }
			elseif($mysidia->input->post("delete") == "yes"){
			    switch($mysidia->input->post("deltype")){
				    case "soft":
 	                    $mysidia->db->update("owned_adoptables", array("currentlevel" => 1), "type='{$mysidia->input->post("type")}' AND currentlevel='0'");
						$mysidia->db->delete("levels", "adoptiename='{$mysidia->input->post("type")}' and thisislevel=0");				    
                        $mysidia->db->update("adoptables", array("whenisavail" => "promo"), "type='{$mysidia->input->post("type")}'");
					    $mysidia->db->update("adoptables_conditions", array("whenisavail" => "promo"), "type='{$mysidia->input->post("type")}'");
						break;
                    case "hard":
                        $mysidia->db->delete("owned_adoptables", "type='{$mysidia->input->post("type")}'");
					    $mysidia->db->delete("levels", "adoptiename='{$mysidia->input->post("type")}'");
					    $mysidia->db->delete("adoptables", "type='{$mysidia->input->post("type")}'");
                        $mysidia->db->delete("adoptables_conditions", "type='{$mysidia->input->post("type")}'");
                        break;
                    default:
					    throw new Exception("database error.");
				}
			}
			else{
			    if($mysidia->input->post("select") != "" and $mysidia->input->post("select") != "none"){
					$mysidia->db->update("adoptables", array("eggimage" => $mysidia->input->post("select")), "type='{$mysidia->input->post("type")}'");
				}
				if($mysidia->input->post("resetconds") == "yes"){
					$mysidia->db->update("adoptables", array("whenisavail" => 'always'), "type='{$mysidia->input->post("type")}'");
                    $mysidia->db->update("adoptables_conditions", array("whenisavail" => 'always'), "type='{$mysidia->input->post("type")}'");
				}
				if($mysidia->input->post("resetdate") == "yes" and $mysidia->input->post("date")){
                    $mysidia->db->update("adoptables", array("whenisavail" => "conditions"), "type='{$mysidia->input->post("type")}'");
					$mysidia->db->update("adoptables_conditions", array("whenisavail" => "conditions", "datecond" => "enabled", "date" => $mysidia->input->post("date")), "type='{$mysidia->input->post("type")}'");
				}
			}
		}
		else{
		    $adopt = new Adoptable($mysidia->input->post("type"));	
            $mysidia->session->assign("acpAdopt", "edit", TRUE);						    
		    if($adopt->getWhenAvailable() != "always" and $adopt->getWhenAvailable() != "") $availtext = "<b>This adoptable currently has adoption restrictions on it.</b>";
			else $availtext = "This adoptable currently does not have adoption restrictions on it.";
            $this->setField("adopt", $adopt);
            $this->setField("availtext", new Mystring($availtext));	
	    }
    }

    public function delete(){

    }	
}
?>