<?php

//This file creates a new admin user for Max Volume
define("SUBDIR", "Install");
include("../inc/config.php");

//Now connecting to the adoptables database
try{
    $dsn = "mysql:host=".constant("DBHOST").";dbname=".constant("DBNAME");
    $prefix = constant("PREFIX");
    $adopts = new PDO($dsn, DBUSER, DBPASS);
}
catch(PDOException $pe){
    die("Could not connect to database, the following error has occurred: <br><b>{$pe->getmessage()}</b>");  
}

//The grabanysetting function needs to be defined here

function codegen($length, $symbols = 0){
	$set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
	$str = '';
	
	if($symbols == 1){
	  $symbols = array("~","`","!","@","$","#","%","^","+","-","*","/","_","(","[","{",")","]","}");
	  $set = array_merge($set, $symbols);
	}

	for($i = 1; $i <= $length; ++$i)
	{
		$ch = mt_rand(0, count($set)-1);
		$str .= $set[$ch];
	}

	return $str;
}

$username = $_POST["username"];
$pass1 = $_POST["pass1"];
$pass2 = $_POST["pass2"];
$birthday = $_POST["birthday"];
$email = $_POST["email"];
$salt = codegen(15, 0);
$username = preg_replace("/[^a-zA-Z0-9\\040.]/", "", $username);
$email = preg_replace("/[^a-zA-Z0-9@._-]/", "", $email);

if($username == "" or $pass1 == "" or $pass2 == "" or $email == ""){
die("Something important was left blank.  Please try again!");
}

if($pass1 != $pass2){
die("Passwords do not match.  Please go back and correct this.");
}

$date = date('Y-m-d');
$adopts->query("INSERT INTO {$prefix}users (uid, username, salt, password, email, ip, usergroup, birthday, membersince, money, friends)
VALUES ('', '$username', '$salt', '$pass1','$email','{$_SERVER['REMOTE_ADDR']}','1','$birthday', '$date', '1000','')");
    
$adopts->query("INSERT INTO {$prefix}users_contacts (uid, username, website, facebook, twitter, aim, yahoo, msn, skype)
VALUES ('', '$username', '', '', '', '', '', '', '')");

$adopts->query("INSERT INTO {$prefix}users_options (uid, username, newmessagenotify, pmstatus, vmstatus, tradestatus, theme)
VALUES ('', '$username', '1', '0', '0', '0', 'main')");

$adopts->query("INSERT INTO {$prefix}users_profile (uid, username, avatar, bio, color, about, favpet, gender, nickname)
VALUES ('', '$username', 'templates/icons/default_avatar.gif', '', '', '', '0', 'unknown', '')");
	
$adopts->query("INSERT INTO {$prefix}users_status (uid, username, canlevel, canvm, canfriend, cantrade, canbreed, canpound, canshop)
VALUES ('', '$username', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes')");


//Now it's time for our new admin to configure their basic site settings...

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<title>Mysidia PHP Adoptables Installation Wizard</title>
<style type='text/css'>
<!--
body,td,th {
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	background-color: #ffff00;
}
a:link {
	color: #000000;
}
a:visited {
	color: #000000;
}
a:hover {
	color: #000000;
}
a:active {
	color: #000000;
}
.style1 {
	font-size: 18px;
	color: #FFFFFF;
}
.style2 {font-size: 14px}
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables Installation Wizard <br>
        <span class='style2'>Step 5: Configure Site Settings </span></span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
      <span class='style2'>This page allows you to configure basic site settings such as site name, slogan and default theme...</span></p>
      <form name='form1' method='post' action='sitesetting.php'>
        <p class='style2'>Default Theme: 
          <input name='theme' type='text' id='theme' maxlength='20' value='main'>
</p>
        <p class='style2'>The default theme can be changed anytime through the usage of admincp, you may also do this with Style switcher. </p>
        <p class='style2'>Browser Title: 
        <input name='browsertitle' type='text' id='browsertitle' maxlength='50' value='Mysidia Adoptables v1.3.4'>
</p>
        <p><span class='style2'>Now it is time to give your site a brand new name!</span></p>
        <p><span class='style2'>Site Name: 
        <input name='sitename' type='text' id='sitename' maxlength='50' value='My Adoptables Site'>
</span></p>
        <p><span class='style2'>The Slogan of your site is: 
        <input name='slogan' type='text' id='slogan' maxlength='50' value='Your Site Slogan'>
</span></p>
        <p><span class='style2'>The Pepper Code of your site is:</p>
           <p>(The salt is a random code that can be generated from the url below:) </p>
           <p>(http://strongpasswordgenerator.com/)</p>  
        <input name='peppercode' type='text' id='peppercode' maxlength='50' value='6QoE5En82U8I91N'>
</span></p>
           <p><span class='style2'>Security Question:(This can be used to stop bots from registering!) 
        <input name='securityquestion' type='text' id='securityquestion' maxlength='50' value='2+1=?'>
           </span></p>
           <p><span class='style2'>The Answer of Security Question is: 
        <input name='securityanswer' type='text' id='securityanswer' maxlength='50' value='3'>
           </span></p>
  <p>
    <input name='usealtbbcode' type='checkbox' id='usealtbbcode' value='yes' checked> 
    Enable Alternative bbcodes on your Site </p>
        <p><span class='style2'>The Cash Name of your site: 
        <input name='cost' type='text' id='cost' maxlength='50' value='Mysidian dollar'>
</span></p>
        <p><span class='style2'>User's Starting Money: 
        <input name='startmoney' type='text' id='startmoney' maxlength='6' value='1000'>
</span></p>
		<input name='username' type='hidden' id='username' value='{$username}'>
        <input name='pass1' type='hidden' id='pass1' value='{$pass1}'>
        <input name='salt' type='hidden' id='salt' value='{$salt}'>		
        <p>
          <input type='submit' name='Submit' value='Submit and Continue Installation'>
</p>
        <p>&nbsp;</p>
      </form>      
      <p align='left'>&nbsp;</p>
      <p align='right'><br>
        </p></td>
  </tr>
</table>
</center>
</body>
</html>";


?>