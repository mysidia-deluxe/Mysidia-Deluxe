<?php

//Language variables used for AdminCP/Adopt Page

$lang['default_title'] = "Add / Edit / Manage Adoptables";
$lang['default'] = "Here you can add or edit the adoptables that are available to your site's visitors.  
				  Please choose an option below...<br /><br />";				 
$lang['add_title'] = "Create a new adoptable";
$lang['add'] = "This page allows you to create a new adoptable that will be available to your site's visitors.
			    Please fill in the form below and hit the <i>Create Adoptable</i> button below when you're ready to create the adoptable.";
$lang['added_title'] = "Adoptable Added Successfully";
$lang['added'] = "Your adoptable, {$mysidia->input->post("type")}, has been added to the database successfully. You can now <a href='../level/add'>Add a Level</a> to this adoptable. 
                  You can also <a href='../index'>go back to the Admin CP index page</a>.";
$lang['edit_title'] = "Edit an existing adoptable";
$lang['edit'] = "Here you can edit info and images for existing adoptables.  
				Please select the adoptable you wish to edit.<br />";
$lang['edit_adopt'] = "Editing {$mysidia->input->get("type")}";
$lang['edited_title'] = "Adoptable Updated";
$lang['edited'] = "Your changes have been saved. <a href='../adopt/edit'>Click Here</a> to manage your adoptables.";
$lang['notexist_title'] = "Adoptable Does Not Exist"; 
$lang['notexist'] = "The specified adoptable does not exist in the database.  Try going back and trying again.";
$lang['type'] = "You did not enter in a type for the adoptable. Please go back and try again."; 
$lang['class'] = "You did not enter in a category for the adoptable. Please go back and try again.";
$lang['image'] =  "You did not select an image for this adoptable. Please go back and make sure an image is selected for this adopt.";
$lang['image2'] = "You selected two images for the adoptable's egg image. Please go back and make sure that either the image textbox is blank or the image dropdown box is set to No Exising Image.";
$lang['condition'] = "You did not choose a valid scenario when this adoptable can be adopted. Please go back and either select the Always option, the Promo option or the Conditions option.";
$lang['condition_freq'] = "The condition Freq is enabled but is blank or has an incorrect value. Please go back and double check your conditions and that they contain valid input.";
$lang['condition_date'] = "The condition Date is enabled but is blank or has an incorrect value. Please go back and double check your conditions and that they contain valid input.";
$lang['condition_moreandlevel'] = "The condition MoreandLevel is enabled but is blank or has an incorrect value. Please go back and double check your conditions and that they contain valid input.";
$lang['condition_maxnum'] = "The condition Max Number is enabled but is blank or has an incorrect value. Please go back and double check your conditions and that they contain valid input.";
$lang['condition_group'] = "The condition Usergroup is enabled but is blank or has an incorrect value. Please go back and double check your conditions and that they contain valid input.";
$lang['alternate'] = "There has been an error with the adoptable's alternate settings you selected. Please go back and make sure the alternate values are filled in correctly.";
$lang['exist'] = "An adoptable with this name already exists in your database. Please go back and rename the adoptable to something different.";
$lang['freeze_comment'] = "Freeze Deletion - This will not delete the adoptable, 
						   but will freeze it to all new adoptions by members of your site. 
						   You can undo this by checking the <em>Remove all adoption conditions from this adoptable</em> 
						   checkbox the next time you edit this adoptable."; 
$lang['freeze_title'] = "Adoptable Frozen Successfully";
$lang['freeze'] = "This adoptable will no longer appear available for new adoptions. 
				   To reverse this you can manage this adoptable again and choose to remove all restrictions on its adoption.
				   <a href='../adopt/edit'>Click Here</a> to manage your adoptables.";
$lang['soft_comment'] = "Soft Delete (Adoptable Retirement) - This option will do a 
						 soft delete of this adoptable from your system. 
						 Selecting this option will remove the egg image level for this adoptable from your system. 
						 Any users who have this type of adoptable as an egg will have them automatically 
						 leveled up to Level 1 for this adoptable type. 
						 This option closes the adoptable to new adoptions, but will not affect 
						 users who already adopted this creature. 
						 Note that once you do a soft delete you will no longer be able to edit 
						 the levels associated with that adoptable, 
						 so think about this carefully."; 
$lang['soft_title'] = "Adoptable Deleted Successfully";
$lang['soft'] = "A soft delete was performed successfully. <a href='../adopt/edit'>Click Here</a> to manage your adoptables.";
$lang['hard_comment'] = "Hard Deletion (Purge) - This option will permanentally delete this adoptable from your site. 
						 Any users currently using this adoptable will have it deleted by the system. 
						 All levels for this adoptable will be purged. <strong>This cannot be undone! </strong>";
$lang['hard_title'] =  "Adoptable Deleted Successfully";
$lang['hard'] = "The adoptable was deleted successfully and was purged from the system. All traces have been removed.
				 <a href='../adopt/edit'>Click Here</a> to manage adoptables.";
$lang['condition_comment'] = "<strong>Remove all adoption conditions from this adoptable. </strong>
						      - This will remove all restrictions on the adoption of this creature, including promo codes.";
$lang['condition'] = "You did not choose a valid scenario when this adoptable can be adopted. Please go back and either select the Always option, the Promo option or the Conditions option.";
$lang['date_comment'] = "This setting allows you to change the date that an adoptable is available to a new date. 
					     This is handy if you only want the adoptable to be available certain times in a given year.";

?>