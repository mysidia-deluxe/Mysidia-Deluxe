<?php

//Language variables used for AdminCP/Level Page

$lang['add_title'] = "Add level(s) to an adoptable";
$lang['add'] = "This page allows you to add new level(s) to an adoptable.  You may add as many levels as you wish up to the maximum limit.  
                Simply select the adoptable from the drop down list below and hit Submit to get started.";
$lang['add_level'] = "Create New Levels";
$lang['reward_explain'] = "Enter a promo code in the box below that will be the user's reward. 
						   This can be used to give the user access to a new exclusive adoptable using the Promo Code system.";
$lang['code_explain'] = "(This can only contain letters and numbers)"; 					   
$lang['reqclicks_explain'] = "<b>(Make sure the required clicks for new level is always greater than its previous level!)</b>";
$lang['added_title'] = "Level(s) Created Successfully";
$lang['added'] = "Your level(s) has been created successfully for {$mysidia->input->post("adoptiename")}.  
                  You can either <a href='../add'>continue to create new levels for {$mysidia->input->post("adoptiename")}</a> 
				  or <a href='../../index'>go to the main Admin CP page</a>.";
$lang['manage_title'] = "Manage an adoptable's levels";
$lang['manage'] = "Here you can edit levels and images for existing adoptables. Please select the adoptable whose levels you wish to edit.<br />";
$lang['nonexist'] = "The selected level does not exist yet";
$lang['manage_level'] = "Managing Levels for {$mysidia->input->post("type")} adoptables";
$lang['manage_explain'] = "This page allows you to edit or delete the levels and images for existing adoptables of this type.
						 There are restrictions on what can be edited or deleted as deleting the wrong thing or changing the 
						 wrong setting could severely break your adoptables.
						 Changing an adoptable level image here will change it for all users with an adoptable of that type at that image.  
						 Listed below are all of the levels for this adoptable type.<br /><br />";						 
$lang['edit_title'] = "Editing level {$mysidia->input->post("level")} for {$mysidia->input->post("type")}";
$lang['edit'] = "Here you can edit this level for this adoptable.<br />";
$lang['edited_title'] = "Level Updated Successfully";
$lang['edited'] = "The adoptable level has been updated successfully. <a href='../../edit'>Click Here</a> to manage levels.";
$lang['name'] = "Some of the default data was not properly sent using the form.  Please try creating the level again.  If problems persist, please visit Mysidia Adoptables Support Forum for help.";
$lang['primary_image'] = "You did not select a primary image to use.  This is required.  Please go back and select a primary image to use.";
$lang['primary_image2'] = "You selected both remote and local primary images.  You cannot use two images.  Please go back and make sure that one of the primary image fields is left blank.";
$lang['alt_image'] = "You selected both remote and local alternate images.  You cannot use two images.  Please go back and make sure that one of the primary image fields is left blank.";
$lang['reward'] = "You specified that this level has a reward, yet you did not enter in a reward code.  Please go back and either uncheck the reward checkbox or enter in a valid reward / promo code.";				
$lang['clicks'] = "You did not enter in a required number of clicks to reach this level.  Please go back and fill this value in!";
$lang['clicks2'] = "The number of clicks you wish to require for this level is less than or equal to the number of clicks required for the previous level.  Please go back and make sure that the number of clicks required for this level is greater than the number required for the previous level.";
$lang['maximum'] = "It appears that this adoptable has reached its maximum level-cap and therefore no new level can be created.";
$lang['delete_title'] = "Deleting level {$mysidia->input->post("level")} for ";
$lang['delete'] = "Here you can delete this level for this adoptable.<br>";
$lang['delete_explain'] = "<b>Note: Deleting a level for adoptables will not only remove the current level, but also all levels above this one due to the sequential nature of adoptable levels!</b>";
$lang['deleted_title'] = "Level(s) Removed Successfully";
$lang['deleted'] = "The adoptable level and above have been deleted successfully. <a href='../../edit'>Click Here</a> to manage levels.";
$lang['settings_title'] = "Changing Level Settings";
$lang['settings'] = "Here you can modify settings for the Adopt-Level system.<br>";
$lang['settings_changed_title'] = "Level Settings Edited Successfully";
$lang['settings_changed'] = "You have successfully modified the Adopt-Level system settings.";
$lang['method_explain'] = "<b>(The method/mechanism of leveling will determine the patterns for required clicks of each level.<br>
                           For 'Incremental', each level requires more clicks than the previous level, but the difference can be random. For 'Multiple', each level requires n times clicks more than the previous, the pattern is easier to follow and define.)</b>"; 				
$lang['clicks_explain'] = "<b>(For 'Incremental' Leveling, separate required clicks for each level by comma. An example is [5,10,15,20] for level [1,2,3,4]. For 'Multiple' Leveling, define the required clicks pattern as (lv.1-clicks:Multiple). For instance, [5,2] means [5,10,20,40] for level[1,2,3,4].)</b>"; 			
$lang['number_explain'] = "<b>(The above field determines how many adoptables a member can click on a given day, this can be used to restrict how much money they can earn through click-spamming.)</b>";
$lang['owner_explain'] = "<b>(If disabled, users(both as logged in user and guest with the same IP) cannot click their own adoptables, this may not work against users with dynamic IPs.)</b>";
$lang['daycare_title'] = "Change Daycare Settings";
$lang['daycare'] = "Here you can modify the settings for your site's daycare center.";
$lang['daycare_changed_title'] = "Daycare Settings Updated";
$lang['daycare_changed'] = "You have successfully modified the daycare center settings on your site.";

?>