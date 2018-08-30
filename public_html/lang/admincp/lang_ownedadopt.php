<?php

//Language variables used for AdminCP/Ownedadopt Page

$lang['default_title'] = "Manage Owned Adoptables";
$lang['default'] = "This page allows you to manage each adoptable owned by users registered on your site. 
					Only admins who can edit users and usergroups can carry out this task.
					Use the table below to edit existing adoptables, or click the link below to create a new adoptable for a user.
					<br /><br />";
$lang['empty'] = "At this point there is no owned adoptables available.";					
$lang['add_title'] = "Create an adoptable for a user";
$lang['add'] = "Here you can create an owned adoptable using the form below.<br />";
$lang['added_title'] = "Adoptable Added Successfully";
$lang['added'] = "A new adoptable, {$mysidia->input->post("name")}, has been added for user {$mysidia->input->post("owner")} successfully.
                  </br><a href='edit'>Click Here</a> to return to the adoptables manager.";
$lang['edit_title'] = "Owned Adoptables Editor - Editing {$mysidia->input->post("aid")}'s Data";
$lang['edit'] = "Here you can edit info and images for existing adoptables.  
				 Please select the adoptable you wish to edit.<br />";
$lang['edited_title'] = "Adoptable Edited Successfully";
$lang['edited'] = "The data of adoptable {$mysidia->input->post("name")} has been edited for user {$mysidia->input->post("owner")} successfully.
                   </br><a href='../edit'>Click Here</a> to return to the adoptables manager. ";				
$lang['edit_adopt'] = "Editing Adoptable {$mysidia->input->post("aid")}";
$lang['delete_title'] = "Adoptable Deleted"; 
$lang['delete'] = "This owned adoptable has been deleted successfully.";	

?>