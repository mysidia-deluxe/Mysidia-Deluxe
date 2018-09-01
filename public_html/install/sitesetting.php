<?php

//This file creates a new admin user for Max Volume
define("SUBDIR", "Install");

require_once './_header.php';
require_once APP_ROOT . 'bootstrap.php';

//Now connecting to the adoptables database 
try{
    $dsn = "mysql:host=".constant("DBHOST").";dbname=".constant("DBNAME");
    $prefix = constant("PREFIX");
	$adopts = new PDO($dsn, DBUSER, DBPASS) or die("Cannot connect to database.");
}
catch(PDOException $pe){
    die("Could not connect to database, the following error has occurred: <br><b>{$pe->getmessage()}</b>");  
}

//The grabanysetting function needs to be defined here

$theme = $_POST["theme"];
$browsertitle = $_POST["browsertitle"];
$sitename = $_POST["sitename"];
$slogan = $_POST["slogan"];
$peppercode = $_POST["peppercode"];
$securityquestion = $_POST["securityquestion"];
$securityanswer = $_POST["securityanswer"];
$usealtbbcode = $_POST["usealtbbcode"];
$cost = $_POST["cost"];
$startmoney = $_POST["startmoney"];
$rewardmoney = $_POST["rewardmoney"];
$enabletrades = $_POST["enabletrades"];
$tradecost = $_POST["tradecost"];
$tradeoffercost = $_POST["tradeoffercost"];
$username = $_POST["username"];

function passencr($username, $password, $salt){

    $pepper = $_POST["peppercode"];
    $password = md5($password);
    $newpassword = sha1($username.$password);
    $finalpassword = hash('sha512', $pepper.$newpassword.$salt);
    return $finalpassword;
}   

$stmt = $adopts->query("SELECT * FROM {$prefix}users WHERE `uid` = '1'");
$admin = $stmt->fetchObject();
$encryptpass = passencr($admin->username, $admin->password, $admin->salt);
 
// Update system settings

if($theme == "" or $browsertitle == "" or $sitename == "" or $slogan == "" or $cost == "" or $startmoney == ""){
    die("Something important was left blank.  Please try again!");
}

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('theme', '{$theme}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('browsertitle', '{$browsertitle}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('sitename', '{$sitename}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('slogan', '{$slogan}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('systemuser', '{$admin->username}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('systememail', '{$admin->email}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('admincontact', '{$admin->email}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('peppercode', '{$peppercode}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('securityquestion', '{$securityquestion}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('securityanswer', '{$securityanswer}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('gdimages', 'yes')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('usealtbbcode', '{$usealtbbcode}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('cashenabled', 'yes')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('cost', '{$cost}')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}settings (name, value) VALUES ('startmoney', '{$startmoney}')";
$adopts->query($query);

$query = "UPDATE {$prefix}users SET money='{$startmoney}' WHERE uid=1";
$adopts->query($query);

$query = "UPDATE {$prefix}users SET password='{$encryptpass}' WHERE uid=1";
$adopts->query($query);

//We are DONE with the install!  Yay!!!!!!!!!!

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<title>Mysidia Adoptables v1.3.4 Installation Wizard</title>
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
.style4 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables v1.3.4 Installation Wizard <br>
        <span class='style2'>Step 6: Installation Complete! </span></span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'>&nbsp;</p>
      <p align='left'><span class='style2'>Hey There {$username},</span></p>
      <p align='left'>Mysidia Adoptables v1.3.4 has been installed on your site and is ready for your use! Before you get going, there's a few things you should know: </p>
      <blockquote>
        <p align='left'>1. Your install of Mysidia Adoptables is located at: <strong>http://www.".constant("DOMAIN").constant("SCRIPTPATH")."</strong></p>
        <p align='left'>2. Your Admin CP is located at: <strong>http://www.".constant("DOMAIN").constant("SCRIPTPATH")."/admincp/index</strong></p>
        <p align='left'>You will need to <a href='../login.php'>Log In</a> to your installation of Mysidia Adoptables before you can access the Admin CP.</p>
        <p align='left'>3. You should really CHMOD config.php back to 644 so that it is not writable.</p>
        <p align='left'>4. You MUST delete the install directory for security. You wouldn't want someone installing over your site, now would you?</p>
        <p align='left'>5. For official script support you can visit <strong><a href='http://www.mysidiaadoptables.com/forum' target='_blank'>http://www.mysidiaadoptables.com/forum</a></strong> or just click on the Script Support link in your Admin CP for quick support.</p>
        <p align='left'>6. You should log in to your Admin CP and click on the <strong>Site Settings</strong> option right away to customize your installation of Mysidia Adoptables . Right now your site is running just the default data which doesn't look that flattering to the outside world. Spice it up! </p>
        <p align='center'>Thank you for installing Mysidia Adoptables, a proud product from <a href='http://www.mysidiaadoptables.com' target='_blank'>Mysidia RPG Inc.</a>. </p>
        <p align='center' class='style4'><a href='../index.php'>View Your Website</a></p>
      </blockquote></td>
  </tr>
</table>
</center>
</body>
</html>";


?>