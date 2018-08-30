<?php

//Language variables used for Breeding Page

$lang['title'] = "Breeding Center";
$lang['default'] = "You may breed your adoptables here. They must be at least above the minimum required level to breed.<br>"; 
$lang['system'] = "The admin has disabled the breeding system, please contact him/her if you have any questions.";
$lang['money'] = "You currently have {$mysidia->user->getcash()} {$mysidia->settings->cost}, the cost of breeding is: ";
$lang['warning'] = "<br>Note that breeding may fail for various reasons. The parents may not breed properly, the offsprings may not survive easily, and more...<br><br>";
$lang['banned'] = "It appears that you have been banned from breeding your adoptables. Please contact an administrator for assistance.<br>";   
$lang['select'] = "<br>You may select the two adoptables that you'd like to breed:<br>"; 
$lang['error'] = "Breeding error has occurred!";
$lang['female'] = "None of your female adoptables can breed at the time.<br>";
$lang['male'] = "None of your male adoptables can breed at the time.<br>";
$lang['class'] = "Sorry, it seems that your two adoptables do not belong to the same breeding class.";
$lang['gender'] = "It appears that the female and/or male adoptables gender's have been modified. You have been banned for this action, please contact site administrator for more info.";  
$lang['owner'] = "It appears that at least one of the adoptables selected do not belong to yours. You have been banned for this action, please contact site administrator for more info.";
$lang['species'] = "Sorry, at least one of your adoptables belong to unbreedable species.";
$lang['interval'] = "Sorry, it appears that your adoptables need to wait at least another day to be able to breed again.";
$lang['level'] = "Sorry, one of your adoptables don't have the minimum level to breed. Keep getting clicks for them so they can grow."; 
$lang['capacity'] = "Sorry, at least one of your adoptables have reached their maximum breeding capacity. He/she is no longer capable of breeding offsprings.";
$lang['number'] = "Unfortunately, the admin has set the maximum number of offsprings possible to be 0. Please contact him/her for assistance.";
$lang['chance'] = "Unfortunately, breeding attempt was unsuccessful, please come back another time.";
$lang['cost'] = "It appears that you do not have enough money to pay for the breeding transaction.";
$lang['usergroup'] = "It seems that you do not belong to the certified usergroup to breed adoptables.";
$lang['item'] = "It seems that you lack the necessary item to breed adoptables.";
$lang['permission'] = "It appears that you have been banned for breeding.";
$lang['none_select'] = "You have yet to select a female and a male adoptable for breeding.";
$lang['none_exist'] = "The selected female or male adoptables ID does not seem to exist.";
$lang['fail_title'] = "Breeding has failed...";
$lang['fail'] = "This is too bad. Breeding is attempted but none of the baby adoptables have survived.";
            
?>