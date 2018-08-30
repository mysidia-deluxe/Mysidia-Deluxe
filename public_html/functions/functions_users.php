<?php

// File ID: functions_users.php
// Purpose: Provides specific functions defined for users

function getgroup() {
    $mysidia = Registry::get("mysidia");

	if($mysidia->user->isloggedin){
        $usergroup = $mysidia->db->select("users", array("usergroup"), "username='{$mysidia->user->username}'")->fetchColumn();
		return $usergroup;
	}
	else {
		return 0;
	}
}

function cancp($usergroup) {
	//This function determines if a usergroup is allowed to access the Admin CP
    $mysidia = Registry::get("mysidia");
    $cancp = $mysidia->db->select("groups", array("cancp"), "gid = '{$usergroup}'")->fetchColumn();

	if($cancp == "" or $usergroup == 0) $cancp = "no";	
	return $cancp;
}


function cando($usergroup, $do) {
	//This function determines if a usergroup is allowed to do a specific task
    $mysidia = Registry::get("mysidia");
	$cando = $usergroup->getpermission($do);
	if($cando == "" or $usergroup == 0) $cando = "no";
	return $cando;
}

function canadopt($aid, $cond, $promocode, $row) {
	// This function determines if a user can adopt a specific adoptable...
    $mysidia = Registry::get("mysidia");

	if(!$mysidia->user->isloggedin and $cond != "showing") {
		return "no";
	}

	// Now we check if our usergroup has permission to adopt the adoptable...
	$group = getgroup();
	$dbcanadpt = cando($mysidia->user->usergroup, "canadopt");

	if($dbcanadpt != "yes" and $cond != "showing") {
		return "no";
	}

	// Now we check if the adoptable requires a promo code and if the promo code submitted is correct...
	if($row->whenisavail == "promo" and $promocode != $row->promocode) {
		return "no";
	}

	// Now we check those three conditions we have in the Admin CP
	if($row->whenisavail == "conditions") {
		// If we have a restriction on the number of times this can be adopted...
		if($row->freqcond == "enabled") {
			// Select from the database and determine how many times this adoptable type has been adopted
			$num = 0;

            $num = $mysidia->db->select("owned_adoptables", array("aid", "type"), "type='{$type}'")->fetchAll();
			if(count($num) > $number) {
				return "no";
			}
		}

		// Begin the date restriction check
		$today = date('Y-m-d');

		if($row->datecond == "enabled" and $row->date != $today) {
			return "no";
		}

		// We are checking to see how many of this adoptable a user owns
		// If they own more than the specifed number, they cannot adopt...
		if($row->moreless == "enabled") {
			$num = 0;
            $num = $mysidia->db->select("owned_adoptables", array("aid", "type"), "owner='{$loggedinname}' and type='{$type}'")->fetchAll();
			if(count($num) > $row->morelessnum) {
				return "no";
			}
		}


		// Check if the user is of a specified usergroup...
		if($row->levelgrle == "enabled") {

			// If the two numbers do not match, do not allow the adoption...
			if($mysidia->user->usergroup->gid != $row->grlelevel) {
				return "no";
			}	
		}
	} // end conditions
	return "yes";
}

function isbanned($user){
    $mysidia = Registry::get("mysidia");
    $banstatus = 0;
    $usergroup = $mysidia->db->select("users", array("usergroup"), "username='{$user}'")->fetchColumn();	
    if($usergroup == 5) $banstatus = 1;
    return $banstatus;
}

function banuser($user){
    // Set the usergroup to 5, the banned usergroup
    $mysidia = Registry::get("mysidia");
    $mysidia->db->update("users", array("usergroup" => 5), "username = '{$user}'");

    // Then update all user permissions to no
    $mysidia->db->update("users_status", array("canlevel" => 'no', "canvm" => 'no', "canfriend" => 'no', "cantrade" => 'no', "canbreed" => 'no', "canpound" => 'no', "canshop" => 'no'), "username = '{$user}'");
    return TRUE;
}

function unbanuser($user){
    // Set the usergroup to 3, the banned usergroup
    $mysidia = Registry::get("mysidia");
	$mysidia->db->update("users", array("usergroup" => 3), "username = '{$user}'");

    // Then update all user permissions to no
	$mysidia->db->update("users_status", array("canlevel" => 'yes', "canvm" => 'yes', "canfriend" => 'yes', "cantrade" => 'yes', "canbreed" => 'yes', "canpound" => 'yes', "canshop" => 'yes'), "username = '{$user}'");
    return TRUE;
}

function deleteuser($user) {
	//This function deletes a user from the system...
    $mysidia = Registry::get("mysidia");

    //Delete from table users...
    $mysidia->db->delete("users", "username = '{$user}'");
    $mysidia->db->delete("users_contacts", "username = '{$user}'");
	$mysidia->db->delete("users_options", "username = '{$user}'");
	$mysidia->db->delete("users_profile", "username = '{$user}'");
	$mysidia->db->delete("users_status", "username = '{$user}'");

    //Delete user's owned adoptables...
    $mysidia->db->delete("owned_adoptables", "owner = '{$user}'");	
}
?>