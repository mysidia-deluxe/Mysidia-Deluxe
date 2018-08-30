<?php

//Max Volume Installation Wizard
define("SUBDIR", "Install");
include("../inc/config.php");

$step = $_GET["step"];
$step = preg_replace("/[^a-zA-Z0-9s]/", "", $step);

if($step == 3 or $step == "3"){

try{
    $dsn = "mysql:host=".constant("DBHOST").";dbname=".constant("DBNAME");
    $prefix = constant("PREFIX");
    $adopts = new PDO($dsn, DBUSER, DBPASS); 
}
catch(PDOException $pe){
    die("Could not connect to database, the following error has occurred: <br><b>{$pe->getmessage()}</b>");  
} 

// Now begins the tedious database execution process

// Create Table levels_settings and its corresponding rows
$query = "CREATE TABLE {$prefix}levels_settings (lsid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(20), value varchar(200))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (1, 'system', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (2, 'method', 'multiple')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (3, 'clicks', '5,2')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (4, 'maximum', 3)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (5, 'number', 10)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (6, 'reward', '10,20')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}levels_settings (lsid, name, value) VALUES (7, 'owner', 'enabled')";
$adopts->query($query);


// Add table and entries for new trade system
$query = "CREATE TABLE {$prefix}trade (tid int NOT NULL AUTO_INCREMENT PRIMARY KEY, type varchar(15), sender varchar(40), recipient varchar(40), adoptoffered varchar(40), adoptwanted varchar(40), itemoffered varchar(40), itemwanted varchar(40), cashoffered int DEFAULT 0, message varchar(100), status varchar(20), date varchar(20))";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}trade_associations (taid int NOT NULL AUTO_INCREMENT PRIMARY KEY, publicid int DEFAULT 0, privateid int DEFAULT 0)";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}trade_settings (tsid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(20), value varchar(40))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (1, 'system', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (2, 'multiple', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (3, 'partial', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (4, 'public', 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (5, 'species', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (6, 'interval', 1)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (7, 'number', 3)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (8, 'duration', 5)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (9, 'tax', 300)";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (10, 'usergroup', 'all')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (11, 'item', '')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}trade_settings (tsid, name, value) VALUES (12, 'moderate', 'disabled')";
$adopts->query($query);


// Update for module system.
$query = "INSERT INTO {$prefix}modules VALUES (NULL, 'footer', 'Ads', '', 'user', '', '', 0, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}modules VALUES (NULL, 'footer', 'Credits', '', 'user', '', '', 10, 'enabled')";
$adopts->query($query);


// Finally, the Widget system update and some clean-up works.
$query = "DROP TABLE {$prefix}trades";
$adopts->query($query);

$query = "DROP TABLE {$prefix}widgets";
$adopts->query($query);

$query = "CREATE TABLE {$prefix}widgets (wid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(40), controller varchar(20), `order` int DEFAULT 0, status varchar(20))";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (1, 'header', 'all', 0, 'enabled')"; 
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (2, 'menu', 'main', 10, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (3, 'document', 'all', 20, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (4, 'sidebar', 'all', 30, 'enabled')";
$adopts->query($query);

$query = "INSERT INTO {$prefix}widgets VALUES (5, 'footer', 'all', 40, 'enabled')";
$adopts->query($query);

// All done, cheers!

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<title>Mysidia Adoptables Installation Wizard</title>
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
.style4 {font-size: 12px; }
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables Installation Wizard <br>
        <span class='style2'>Successfully upgrade Mysidia Adoptables to version v1.3.4 </span></span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
      <span class='style2'>Congratulations, you have successfully upgraded to Mysidia Adoptables version v1.3.4! We strongly advise you to remove this upgrader before working on your site again.</span></p>
        </p></td>
  </tr>
</table>
</center>
</body>
</html>";

}


else if($step == 2 or $step == "2"){

//Check file permissions...
$flag = 0;
echo"<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<title>Mysidia Adoptables Installation Wizard</title>
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
        <span class='style2'>Step 2: Add new tables </span></span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
      <span class='style2'>This page will check information provided in your config.php file, which should not be a problem unless you have manually edited it by yourself.  
	Please make sure your file config.php is writable and your database information is provided correctly. Then click on the continue button below to proceed.</span></p>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Check the file permissions here and echo the results...

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if (is_writable("../inc/config.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your config.php file is writable and is connected to database.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/no.gif'> FAIL:</b> Your config.php file is not writable.  Please CHMOD config.php so that it is executable.<br></p>";
    $flag = 1;
}

if (file_exists("../classes/class_view.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your class_view.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your class_view.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../classes/class_widget.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your class_widget.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your class_widget.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../classes/class_trade.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your class_trade.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your class_trade.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../classes/class_tradehelper.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your class_tradehelper.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your class_tradehelper.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../classes/class_tradeoffer.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your class_tradeoffer.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your class_tradeoffer.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../classes/class_tradevalidator.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your class_tradevalidator.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your class_tradevalidator file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../trade.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your trade.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your trade.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../view/tradeview.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your view/tradeview.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your view/tradeview.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../admincp/trade.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your admincp/trade.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your admincp/trade.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

if (file_exists("../admincp/view/tradeview.php")) {
    echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your admincp/view/tradeview.php file exists and is executable.<br></p>";
} else {
    echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Something is very very wrong with your admincp/view/tradeview.php file. Please make sure it exists and CHMOD the directory to 644.<br></p>";
    $flag = 1;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//END THE FILE PERMISSIONS CHECKS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if($flag == 0){

echo "<br><p align='right'><br>
        <a href='upgrade.php?step=3'><span class='style2'><img src='../templates/icons/yes.gif' border=0> Yes, I wish to Continue</span></a> </p></td>";

}


echo"</tr>
</table>
</center>
</body>
</html>";

}

else{
echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<title>Mysidia Adoptables Installation Wizard</title>
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
.style3 {font-size: 16px}
.style4 {font-size: 12px}
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables Installation Wizard <br>
        <span class='style2'>Step 1: Welcome and License Agreement</span>
      </span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
        <span class='style2'>This upgrader will update your Mysidia Adoptables to version v1.3.4. Before you upgrade, however, please make sure that your Mysidia Adoptables version is currently at v1.3.3. Also, you must agree to the Mysidia Adoptables License Agreement as it is outlined below:</span></p>
       <p align='left' class='style3'><u>Mysidia Adoptables License Agreement: </u></p>
      <p align='left' class='style4'>Mysidia Adoptables is licensed under a Free for Non-Commercial Use license, terms of this license are interpreted as the following: </p>
      <p align='left' class='style4'>---Commercial use of the product on your server is OK, while the script may not be redistributed in whole or as part of another script. </p>
      <p align='left' class='style4'>---You must post credit to Mysidia Adoptables (http://www.mysidiaadoptables.com) and keep it visible on all pages unless you have created a credits page.  </p>
      <p align='left' class='style4'>---You can create modifications of this script (or hire freelancers to create modifications of this script) at any time. </p>
      <p align='left' class='style4'>For permissions beyond the scope of this license please Contact (Hall of Famer) at halloffamer@mysidiaadoptables.com.</p>
    <p align='right' class='style2'><a href='upgrade.php?step=2'><img src='../templates/icons/yes.gif' border=0> I Agree - Continue Installation</a>  </p></td>
  </tr>
</table>
</center>
</body>
</html>";
}

?>