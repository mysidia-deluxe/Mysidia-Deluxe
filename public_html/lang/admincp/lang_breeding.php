<?php

//Language variables used for AdminCP/Breeding Page

$lang['default_title'] = "Manage Breed Adoptables";
$lang['default'] = "This page allows you to manage each adoptable owned by users registered on your site. 
					Only admins who can edit users and usergroups can carry out this task.
					Use the table below to edit existing adoptables, or click the link below to create a new adoptable for a user.
					<br><br>";
$lang['empty'] = "At this point there is no breed adoptables available.";					
$lang['add_title'] = "Create a Breed Adopt";
$lang['add'] = "Here you can create a new breed adopt entry using the form below.<br>";
$lang['added_title'] = "Breed Adopt Created Successfully";
$lang['added'] = "A new breed adopt, {$mysidia->input->post("offspring")}, has been added into the database successfully.
                  <br>It can be produced by breeding two appropriate parent adoptables";
$lang['edit_title'] = "Editing a Breed Adopt";
$lang['edit'] = "Here you can edit information for existing breed adopt.  
				 Please select the entry you wish to edit.<br>";
$lang['edited_title'] = "Adoptable Edited Successfully";
$lang['edited'] = "The data of breed adopt {$mysidia->input->post("offspring")} has been edited successfully.
                   <br><a href='../edit'>Click Here</a> to return to breed adopt manager. ";				
$lang['delete_title'] = "Breed Adopt Deleted"; 
$lang['delete'] = "This breed adoptable has been deleted successfully.";
$lang['settings_title'] = "Changing Breeding Settings";
$lang['settings'] = "Here you can modify settings for the breeding system.<br>";
$lang['settings_changed_title'] = "Settings Changed Successfully";
$lang['settings_changed'] = "You have successfully modified the breeding system settings.";	
$lang['offspring'] = "The data field offspring is invalid, please return to the previous page.";
$lang['parent'] = "You have yet to specify a parent adoptable for this offspring.";
$lang['parents'] = "The data for parent adoptables is invalid. Please note that the field parent and the two fields mother/father cannot be entered at the same time.";
$lang['probability'] = "The data field probability is not numeric, please specify an appropriate positive integer.";
$lang['survival'] = "The data field survival is invalid, it must be an integer between 0 to 100.";
$lang['level'] = "The data field level is not numeric, please specify an appropriate positive integer.";

?>