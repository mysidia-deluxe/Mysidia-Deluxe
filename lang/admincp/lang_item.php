<?php

//Language variables used for AdminCP/Item Page

$lang['default_title'] = "Manage Items";
$lang['default'] = "Here you can add or edit the items that are available to your site's visitors.
				    This is a list of items available";
$lang['default_none'] = "Currently there is no item available.";
$lang['add_title'] = "Create a new item";
$lang['add'] = "This page allows you to create a new item that will be available to your site's visitors.
				Please fill in the form below and hit the <i>Create Item</i> button below when you're ready.";
$lang['itemname_explain'] = "(This may contain only letters, numbers and spaces)";
$lang['category_explain'] = "(The item category is used to identify items of the same type)";
$lang['image_explain'] = "(Use a full image path, beginning with http://)";
$lang['target_explain'] = "Now lets decide what adoptables(id) can use the very item you are creating, each adoptable's id should be separated by comma, an example is: 1,5,9,13<br>
                           Enter <strong>all</strong> if you want your item applicable to all adoptables, or leave it blank if no adoptable can use it.";
$lang['value_explain'] = "(This is important for item functions such as Level and Click, since you will need to specify how many points of levels/clicks an item can raise)";
$lang['shop_explain'] = "(Leave this field blank if you do not want users to buy it from itemshops)";
$lang['price_explain'] = "(Enter a non-negative value for the price set on your item)<hr>";
$lang['chance_explain'] = "(Enter an integer value between 0 to 100 to determine the item's chance to take effect. 100 means the item will always work)";
$lang['limit_explain'] = "(Enter the maximum quantity a user can own this very item you are creating)";
$lang['added_title'] = "Item created Successfully";
$lang['added'] = "A new item, {$mysidia->input->post("itemname")}, has been added to the database successfully. You may <a href='../index'>go back to the Admin CP index page</a>.";
$lang['edit_title'] = "Edit item";
$lang['edit'] = "This page allows you to edit an item that you have created.
				 Please fill in the form below and hit the <i>Edit Item</i> button below when you're ready.";
$lang['nonexist'] = "The Item does not exist in database.";		 
$lang['edited_title'] = "Item edited Successfully";
$lang['edited'] = "The item {$mysidia->input->post("itemname")}, has been edit successfully. You may <a href='../index'>go back to the Admin CP index page</a>.";
$lang['delete_title'] = "Item Deleted";
$lang['delete'] = "You have successfully removed this item from database.";
$lang['functions_title'] = "Item Functions";
$lang['functions'] = "Here is a list of item functions available on your site, please make good use of them.";
$lang['category'] = "You did not specify a category for the item. Please go back and try again.";
$lang['itemname'] = "You did not enter in a name for the item. Please go back and try again.";	
$lang['images'] = "You did not select an image for this item. Please go back and make sure an image is selected for this item.";
$lang['duplicate'] = "An item with the same name has already existed, please go back and change its name.";

?>