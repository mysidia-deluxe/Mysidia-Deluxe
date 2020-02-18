<?php

//Language variables used for AdminCP/Shop Page

$lang['default_title'] = "Manage Shops";
$lang['default'] = "Here is a list of shops you have created";
$lang['default_none'] = "Currently there is no shop available";
$lang['add_title'] = "Create a new shop";
$lang['add'] = "This page allows you to create a new shop that will be available to your site's visitors.
				Please fill in the form below and hit the <i>Create Shop</i> button below when you're ready.";
$lang['shopname_explain'] = "(This may contain only letters, numbers and spaces)";
$lang['category_explain'] = "(The Shop Category is not the same as other categories)";
$lang['shoptype_explain'] = "(Note: Once chosen, you cannot change a shop's type!)";
$lang['imageurl_explain'] = "(Use a full image path, beginning with http://)";
$lang['restrict_explain'] = "(Enter the usergroup ids that are forbidden to buy items in this shop, separated by comma)";
$lang['salestax_explain'] = "(Enter a non-negative value to determine how much tax users should pay in order to purchase from this shop), the amount is in percentage %.";
$lang['added_title'] = "Shop created Successfully";
$lang['added'] = "A new shop, {$mysidia->input->post("shopname")}, has been added to the database successfully. You may <a href='../index'>go back to the Admin CP index page</a>.";
$lang['edit_title'] = "Edit shop";
$lang['edit'] = "This page allows you to edit a shop that you have already created.
				 Please fill in the form below and hit the <i>Edit Shop</i> button below when you're ready.";
$lang['edited_title'] = "Shop edited Successfully";
$lang['edited'] = "The shop {$mysidia->input->post("shopname")}, has been edit successfully. You may <a href='../../index'>go back to the Admin CP index page</a>.";
$lang['delete_title'] = "Shop Deleted";
$lang['delete'] = "You have successfully removed this shop from database.";
$lang['category'] = "You did not specify a category for the shop. Please go back and try again.";
$lang['shopname'] = "You did not enter in a name for the shop. Please go back and try again.";
$lang['images'] = "You did not select an image for this shop. Please go back and make sure an image is selected for this item.";
$lang['status'] = "You did not specify a shop status. Please enter this field as open, closed or invisible.";
$lang['salestax'] = "You cannot set the value Sales Tax to be a negative number, please go back and change it.";
$lang['duplicate'] = "A shop with the same name has already existed, please go back and change its name.";
$lang['nonexist'] = "The Shop does not exist in database.";
