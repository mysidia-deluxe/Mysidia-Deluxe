<?php

//Language variables used for Shop Page

$lang['access'] = "Welcome to the shop";
$lang['denied'] = "It appears that you have been banned from shopping. Please contact an administrator for assistance.";
$lang['none'] = "<br>Currently there is no active shop available, please come back later.";
$lang['select'] = "Please select a shop for you to visit:<br>";
$lang['empty'] = "<br>The shop is currently empty, please contact an admin if you believe this is a mistake.";
$lang['welcome'] = "Welcome to {$mysidia->input->get("shop")}";
$lang['select_item'] = "Please select the items to buy:";
$lang['select_adopt'] = "Please select an adoptable to buy:";
$lang['invalid_quantity'] = "You have yet to specify the quantity of items to buy...<br>";
$lang['full_quantity'] = "It seems that you are trying to purchase too many items, the new quantity has exceeded the cap specified by admin...<br>";
$lang['purchase_item'] = "You have purchased Item {$mysidia->input->post("quantity")} {$mysidia->input->post("itemname")} at a cost of: ";
$lang['purchase_adopt'] = "You have purchased Adoptable {$mysidia->input->post("adopttype")} at a cost of: ";
$lang['money'] = "It seems that you either do not have enough money to afford this transaction, or that you have entered an invalid value for the field quantity...<br>";
