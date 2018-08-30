<?php

//Language variables used for AdminCP/Usergroup Page

$lang['default_title'] = "Manage Usergroups";
$lang['default'] = "This page allows you to manage the usergroups available to you and your site's users.  
					Usergroups are a powerful feature as they determine who can access what parts of 
				    the site and which functions they can use. Here you can create and manage administrative user groups, 
					artist user groups, donator user groups, custom user groups, and more.
					Use the table below to edit existing usergroups, or click the link below to create a custom usergroup.
					<br /><br /><b><a href='add'><img src='../../templates/icons/add.gif' border=0> Create a New Usergroup</a></b>";
$lang['add_title'] = "Make a New Usergroup";
$lang['add'] = "This page allows you to make a new usergroup.  Type in the desired name of the new usergroup in the box below to get started.
				Your usergroup will be created based on the registered usergroup's template. 
				You can then edit the group's settings as desired.<br />";			
$lang['added_title'] = "Group Created Successfully";
$lang['added'] = "A usergroup with the name {$mysidia->input->post("group")} has been created successfully. 
				  Please <a href='edit'>click here</a> to return to the group manager and edit this group";
$lang['edit_title'] = "Editing usergroup ID {$mysidia->input->get("group")}";
$lang['edit'] = "Here you can edit the settings for the usergroup {$mysidia->input->get("group")}.  Use the checkboxes below to
				 specify what parts of your site members of this group may access.  A checked value is a YES value.<br />";
$lang['edited_title'] = "Usergroup Permissions Updated";
$lang['edited'] = "Your usergroup permissions have been updated successfully. 
									<a href='../edit'>Click Here</a> to return to the usergroup manager.";	
$lang['delete_title'] = "Usergroup Deleted";
$lang['delete'] = "The usergroup has been deleted successfully.";
$lang['canadopt'] = " Users May Adopt Pets";
$lang['canpm'] = " Users May Use PM System / Message System";
$lang['cancp'] = " Users May Access the Admin CP (Required for any of the checkboxes below to take effect)";
$lang['canmanageadopts'] = " Users May Create / Edit / Delete Adoptables and Upload Adoptable Images";
$lang['canmanageads'] = " Users May Create / Edit / Delete sitewide advertisements";
$lang['canmanagecontent'] = " Users May Create / Edit / Delete site pages and content";
$lang['canmanagesettings'] = " Users May Change / Alter site settings";
$lang['canmanageusers'] = " Users May Edit / Delete / Alter user accounts and passwords";
$lang['notice'] = "<img src='../../../templates/icons/warning.gif'> <b>WARNING:</b> Allowing users to access the adoptables settings also allows users to upload files to your server.  
				   Mysidia Adoptables Adoptables restricts the type of files a user may upload to this server, however enabling a user to upload even image files should only be given to users 
				   you trust as all images uploaded to your server count towards your web host's total storage quota for your account.<br>";
$lang['warning'] = "<br><img src='../../../templates/icons/warning.gif'><b>WARNING:</b> Allowing users to access the user accounts portion of the 
					Admin CP may allow them to delete admin accounts, 
				    so only give this privledge to users you trust."; 
$lang['duplicate'] = "The usergroup already exists.";

?>