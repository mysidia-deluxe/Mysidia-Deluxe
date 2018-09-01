<?php

//Language variables used for AdminCP/Inventory Page

$lang['default_title'] = "Manage User Inventory";
$lang['default'] = "Here is a list of owned items from your members<br><br>";
$lang['default_none'] = "Currently there is no item owned by any users.";
$lang['nonexist'] = "The item does not exist in user inventory.";
$lang['add_title'] = "Give an Item to User";
$lang['add'] = "This page allows you to give an item to a certain user.
			    Please fill in the form below and hit the <i>Give Item</i> button below when you're ready.<br>";
$lang['added_title'] = "Item generated Successfully";
$lang['added'] = "A new item, {$mysidia->input->post("itemname")}, has been generated for user {$mysidia->input->post("owner")}. You may <a href='../index'>go back to the Admin CP index page</a>.";
$lang['edit_title'] = "Edit User's Inventory";
$lang['edit'] = "This page allows you to edit an owned item for certain users.
				 Please fill in the form below and hit the <i>Edit User's Item</i> button below when you're ready.";
$lang['edited_title'] = "Owned Item edited Successfully";
$lang['edited'] = "The item {$mysidia->input->post("itemname")} owned by {$mysidia->input->post("owner")}, has been edit successfully. You may <a href='../../index'>go back to the Admin CP index page</a>.";
$lang['delete_title'] = "Items Deleted";
$lang['delete'] =  "You have successfully deleted this user owned item from inventory.";
$lang['itemname'] = "You did not enter in a name for the item. Please go back and try again.";
$lang['owner'] = "You did not name the owner of the item. Please go back and try again.";
$lang['quantity'] = "You did not specify the quantity of the item. Please go back and try again.";
