<?php

//Language variables used for Trade Page

$lang['title'] = "The Trade Station";
$lang['default'] = "Welcome to the Trade Station.  Here you can trade your adoptables or items with someone else.  
                    If you do not have any clues, use the search feature to browse for available adoptables and items from other users.<br>";
$lang['section'] = "<br><br><b><u>The trade station offers the following additional services!</u></b><br>"; 
$lang['section2'] = "<br><br><b><u>Sounds Interesting? Wanna start a trade offer now? Oh wait!</u></b><br>";
$lang['tax'] = "Note that a trade offer will incur a tax of: ";
$lang['tax2'] = " {$mysidia->settings->cost}. Make sure you do have sufficient funds to complete a trade request.<br><br>";
$lang['moderate'] = "The site requires all trade offers be moderated before they are made available.<br>";
$lang['multiple'] = "The site allows multiple adopts/items trade between users, simply press the ctrl button while clicking on the options from selection list.<br>";
$lang['partial'] = "The site allows partial/incomplete trade offers to be made, in this way you can send a trade request to your partner asking for what he/she wants from you.<br>
                    You can view all available partial trade offers by visiting the link below: <br>
                    <a href='trade/partials'>View Partial Trade Offers</a><br><br>";
$lang['partial_disabled'] = "It seems that the admin has disabled partial trade offers from this site.";
$lang['public'] = "The site allows public trade offers to be made, which do not target a specific user but can be received and revised by any users browsing Trade Station.
                   You can view all available public trade offers by visiting the link below: <br>
                   <a href='trade/publics'>View Public Trade Offers</a><br><br>";
$lang['public_disabled'] = "It seems that the admin has disabled public trade offers from this site.";
$lang['start'] = "To begin a trade offer, click the link below or use the search function to specify your target:<br>";
$lang['start2'] = "Alternatively, you may revise your own trade offers by clicking this url:<br>";
$lang['offer_title'] = "Make a Trade Offer";
$lang['offer'] = "Here you can send out trade offers for adoptables and items, please fill in the form below to complete your request.";
$lang['recipient'] = "You are trading with ";
$lang['recipient_none'] = "You have not selected a trade partner yet<br>
                           Search for a recipient to initiate a trade offer, this will make the process easier and faster as you can use the selection box to pick his/her adoptables and items.<br>
                           <a href='../search/user'>Click here to search for trade partner!</a><br>";
$lang['adopt_offered'] = "Please Select the adoptable(s) you'd like to provide for your trade partner:<br>";
$lang['adopt_offered_none'] = "You currently do not have any available adoptables to offer in a trade request.<br>";
$lang['adopt_wanted'] = "Please Select the adoptable(s) you'd like to have from your trade partner:<br>";
$lang['adopt_wanted_none'] = "Your recipient currently do not have any available adoptables to provide in a trade request.<br>";
$lang['adopt_wanted_public'] = "Your recipient has offered the following adoptables.<br>";
$lang['item_offered'] = "Please Select the item(s) you'd like to provide for your trade partner:<br>";
$lang['item_offered_none'] = "You currently do not have any available item(s) to offer in a trade request.<br>";
$lang['item_wanted'] = "Please Select the item(s) you'd like to have from your trade partner:<br>";
$lang['item_wanted_none'] = "Your recipient currently do not have any available items to provide in a trade request.<br>";
$lang['item_wanted_public'] = "Your recipient has offered the following items.<br>";
$lang['cash_offered'] = "The Mysidian dollar amount you wish to trade for this adoptable: ";
$lang['message'] = "You can leave a short (100 character) message to the user about this trade: <br>";
$lang['public_offer'] = "To make a public offer, select the checkbox above and make sure to select the adoptables species or item types you are expecting from potential recipients.
                         The trade offer will appear in the url yoursite.com/trade/publics, it will be viewable by all users looking for possible trades.
                         <b><u>Note that your trade offer MUST be public if you do not specify a trade partner/recipient!</u></b>";
$lang['partial_offer'] = "To make a partial offer, select the checkbox above and make sure not to include any target adoptables/items from a trade recipient.
                         <b><u>Note that your trade offer MUST NOT be partial if you do not specify a trade partner/recipient(it will be Public instead)!</u></b>";
$lang['offered_title'] = "Your Trade Offer Has Been Sent";
$lang['offered'] = "Your trade offer has been sent successfully!  If you need to cancel this trade request you can do this on the My Trades page.
	                You will be notified via PM when this trade is either accepted or rejected.<br>";
$lang['moderated'] = "Since the site requires all trade offers be moderated before they become available, you will have to wait till your trade request is approved by an admin.";
$lang['view_public_title'] = "Public Trade Offers";
$lang['view_public'] = "Here you can view a list of public trade offers available, click on one of them to send a revised trade offer in private to the sender.<br>";
$lang['view_public2'] = "Here you can make a trade request based on the very public trade offer you have selected.<br>";
$lang['view_public_empty'] = "<br>Currently there is no public trade offer, please come back later.<br>";
$lang['view_private_title'] = "Private Trade Offers";
$lang['view_private'] = "Here you can go over your own trade requests and revise them if necessary.<br>";
$lang['view_private2'] = "Here you can revise the trade request you've sent to the recipient previously.<br>";
$lang['view_private_empty'] = "<br>Currently there is no private trade offer, please come back later.";
$lang['view_partial_title'] = "Partial Trade Offers";
$lang['view_partial'] = "Here you can go over partial trade requests.<br>";
$lang['view_partial2'] = "Here you can work on partial trade requests sent to you.<br>";
$lang['view_partial_empty'] = "<br>Currently there is no partial trade offer, please come back later.";
$lang['revise_title'] = "Trade Offer Revised";
$lang['revise'] = "You have successfully revised your trade offer id: {$mysidia->input->get("id")}."; 

$lang['disabled_title'] = "Trading Not Enabled";
$lang['disabled'] = "Trading is either not enabled or not currently available for this site.";
$lang['permission'] = "You do not have permission to trade";
$lang['banned'] = "It appears that an admin has banned your right to trade on this site, send him/her a PM to learn the details.";
$lang['recipient_empty'] = "The trade does not seem to have a recipient.";
$lang['recipient_duplicate'] = "Invalid action specified, you cannot make a trade with yourself!";
$lang['recipient_privacy'] = "It appears that the recipient has trade privacy setting that restricts his/her trade options to friends only.<br> 
                              In order to complete a trade offer with this user, you will need to become friends first.";
$lang['recipient_public'] = "A public trade offer can NOT have a recipient!";
$lang['recipient_partial'] = "A partial trade offer must have at least one of the asset(adopts, items or cash) included to be valid!";
$lang['offers'] = "A trade offer is invalid if its sender offers nothing to the recipient, please include at least an adoptable, an item or some cash to continue.";							  
$lang['wanted'] = "A trade offer is invalid if its sender requests nothing in return, please include at least an adoptable or an item to continue.";
$lang['publics'] = "A public trade offer isn invalid if the sender requests nothing in return, please include at least an adoptable species or an item type to continue.";
$lang['public_adopt'] = "A fatal error has occurred, the species offered do not exist in database!";
$lang['public_item'] = "A fatal error has occurred, the items offered do not exist in database!";
$lang['adoptoffered'] = "The adoptables offered are invalid, they may not belong to the trade sender or may not even exist in the database at all.";
$lang['adoptwanted'] = "The adoptables requested are invalid, they may not belong to the trade recipient or may not even exist in the database at all.";
$lang['itemoffered'] = "The items offered are invalid, they may not belong to the trade sender or may not even exist in the database at all.";
$lang['itemwanted'] = "The items requested are invalid, they may not belong to the trade recipient or may not even exist in the database at all.";
$lang['cashoffered'] = "It seems that the trade sender does not have enough cash to complete the trade";
$lang['status'] = "A serious error has occurred, the trade status is not 'pending'. Please contact the admin for assistance immediately!";
$lang['species'] = "It appears that this trade offer involves un-tradable species, please remove them to proceed.";
$lang['interval'] = "The site admin has specified that successive trade offers cannot be made until after a certain time interval(say 2-3 days).";
$lang['number'] = "Looks like the trade has too many adoptables and/or items that exceeding the limiting conditions.";
$lang['duration'] = "The trade has expired, it will need to be proposed again to continue.";
$lang['usergroup'] = "It seems that you belong to the usergroup(s) that are disallowed to trade, contact the admin if you have questions about this";
$lang['item'] = "It appears that this trade offer involves un-tradable items, please remove them to proceed.";
$lang['error'] = "Trade Error";
$lang['invalid_title'] = "Invalid Trade";
$lang['invalid'] = "We couldn't find this trade in the database.  Sorry.";	
?>