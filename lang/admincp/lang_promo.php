<?php

//Language variables used for AdminCP/Promo Page

$lang['default_title'] = "Manage Promo Codes";
$lang['default'] = "This page allows you to manage the promo codes available to your members 
				    Only admins who can edit adoptables can carry out this task.
					Use the table below to edit a promocode, or click the following link to generate a new promocode for your member.
					<br /><br /><b><a href='add'><img src='../../templates/icons/add.gif' border=0>Create a New Promocode</a></b>";
$lang['add_title'] = "Create a new promocode for user";
$lang['add'] = "This page allows you to create a new promocode for your user to use.
				Please fill in the form below and hit the <i>Create Promocode</i> button below when you're ready to complete this action.";
$lang['added_title'] = "Promocode Created Successfully";
$lang['added'] = "Your Promode has been created successfully. You may go back to the previous page.";
$lang['edit_title'] = "Editing a promocode";
$lang['edit'] = "This page allows you to edit an old promocode from your database.
				 Please fill in the form below and hit the <i>Edit Promocode</i> button below when you're ready to complete this action.";
$lang['edited_title'] = "Promocode Updated";
$lang['edited'] = "You have successfully updated this promocode id: {$mysidia->input->get("pid")}, you may go back to the previous page now.";
$lang['delete_title'] = "Promocode Deleted";
$lang['delete'] = "This promocode has been erased.";
$lang['type'] = "You have not selected the promocode type, please return to previous page and complete this action.";
$lang['code_none'] = "You did not enter the code at all, please go back and fill in this required field.";
$lang['code_duplicate'] = "The code already exists in your database, it is a good practice to make sure each promocode is unique.";
$lang['date'] = "The specified start date is later than expiration date, such action is invalid...";
$lang['availability'] = "The field Availability must be a positive integer...";
$lang['reward'] = "You have not specified the adoptable/item a user can obtain through promocode, way to go being an evil admin.";
$lang['nonexist'] = "The Promocode does not exist in database.";

?>