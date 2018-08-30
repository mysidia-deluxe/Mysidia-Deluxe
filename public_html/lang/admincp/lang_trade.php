<?php

//Language variables used for AdminCP/Trade Page

$lang['default_title'] = "Manage Trade Offers";
$lang['default'] = "Here you can add or edit the trade offers that are made by your site's members. 
				    Below is a list of trade offers available";
$lang['default_none'] = "Currently there is no trade offers available.";
$lang['add_title'] = "Create a new trade offer";
$lang['add'] = "This page allows you to create a new trade offers that will be available to either a certain user or the public.
				Please fill in the form below and hit the <i>Initiate Trade</i> button below when you're ready.";
$lang['sender_explain'] = "(This field cannot be left empty, the user must be valid!)<br>";
$lang['recipient_explain'] = "(Leave it empty if the trade is public.)<br>";
$lang['adopt_offered_explain'] = "(Above is for adoptables provided by the sender. Enter the adoptable ID above, separate by comma if multiple adopts are involved.)<br>";
$lang['adopt_wanted_explain'] = "(Above is for adoptables provided by the recipient. Enter the adoptable ID above, separate by comma if multiple adopts are involved.)<br>";
$lang['item_offered_explain'] = "(Above is for items provided by the sender. Enter the adoptable ID above, separate by comma if multiple adopts are involved.)<br>";
$lang['item_wanted_explain'] = "(Above is for items provided by the recipient. Enter the adoptable ID above, separate by comma if multiple adopts are involved.)<br>";
$lang['cash_offered_explain'] = "(Above is for cash provided by the sender, must be a positive number.)<br>";
$lang['type_explain'] = "(The trade type can be Private, Public or Partial, simply select one of the three radio buttons above.)<br>";
$lang['message_explain'] = "(The message will leave a first impression on the Recipient, make sure it is not longer than 1000 characters though.)<br>";
$lang['status_explain'] = "(The valid trade status are: pending, canceled, declined, complete and moderate.)<br>";
$lang['date_explain'] = "(This may affect whether a trade is expired or not, do not change it unless you have a good reason.)<br>";
$lang['added_title'] = "Trade offer initiated Successfully";
$lang['added'] = "A new trade offer has been added to the database successfully. You may <a href='../index'>go back to the Admin CP index page</a>.";
$lang['edit_title'] = "Edit Trade Offer";
$lang['edit'] = "This page allows you to edit trade offers of your sites.
				 Please fill in the form below and hit the <i>Update Trade</i> button below when you're ready.";
$lang['nonexist'] = "The Trade Offer does not exist in database.";		 
$lang['edited_title'] = "Trade Offer Updated Successfully";
$lang['edited'] = "The trade offer has been edited successfully. You may <a href='../index'>go back to the Admin CP index page</a>.";
$lang['delete_title'] = "Trade Offer Deleted";
$lang['delete'] = "You have successfully removed this trade offer from database.";
$lang['moderate_title'] = "Trade Moderation";
$lang['moderate'] = "Here is a list of trade offers waiting for moderation, please decide on whether they should become available to their recipients.";
$lang['review'] = "You are moderating a trade offer now, please review it before making your decision.<br><br>";
$lang['moderated_title'] = "Trade Offer Moderated";
$lang['pending'] = "You have approved this trade offer, and its status is now pending.";
$lang['canceled'] = "You have disapproved this trade offer, and its status is now canceled.";
$lang['settings_title'] = "Changing Trade Settings";
$lang['settings'] = "Here you can modify settings for the trade system.<br>";
$lang['settings_changed_title'] = "Trade Settings Edited Successfully";
$lang['settings_changed'] = "You have successfully modified the trade system settings.";	
$lang['sender'] = "You did not specify a sender for the trade. Please go back and try again.";
$lang['recipient'] = "You did not enter in a recipient for the trade, while the trade is not public. Please go back and try again.";	
$lang['public'] = "You specified a recipient while the trade is public. Please go back and try again.";
$lang['blank'] = "Invalid action, the trade has no adoptable, item or cash involved at all!";

?>