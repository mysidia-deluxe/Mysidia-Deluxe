<?php

//Max Volume Installation Wizard
require_once './_header.php';

define("SUBDIR", "Install");
$step = isset($_GET["step"]) ? $_GET['step'] : 0;
$step = preg_replace("/[^a-zA-Z0-9s]/", "", $step);

if ($step == 3 or $step == "3") {
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
.style4 {font-size: 12px; }
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables v1.3.4 Installation Wizard <br>
        <span class='style2'>Step 3: Database and Site Configuration </span></span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
      <span class='style2'>This page will set up your config.php file which is responsible for handling database and configuration information for your installation of Mysidia Adoptables.</span></p>
      <form name='form1' method='post' action='configwrite.php'>
        <p class='style2'><u>Database Information:</u></p>
        <p>Database Host: 
            <input name='dbhost' type='text' id='dbhost' value='localhost'>
        </p>
        <p>Database User: 
          <input name='dbuser' type='text' id='dbuser'>
</p>
        <p>Database Password: 
          <input name='dbpass' type='text' id='dbpass'>
</p>
        <p>Database Name: 
          <input name='dbname' type='text' id='dbname'>
</p>
        <p class='style2'><u>Domain Information:</u></p>
        <p class='style4'>Domain Name: 
          <input name='domain' type='text' id='domain'>
</p>
        <p class='style4'>You must enter your domain name in the form of <strong>yoursite.com</strong> ONLY! &nbsp;DO NOT include the http:// or www. portions of the domain.</p>
        <p class='style4'>Script Path: 
          <input name='scriptpath' type='text' id='scriptpath'>
</p>
        <p class='style4'>Your script path tells Mysidia Adoptables where it is installed on the server relative to your domain. If you have uploaded this script to the <strong>ROOT</strong> of your domain name then leave the Script Path box blank. If you installed this script in a subfolder, such as <strong>adoptables</strong>, then put the folder name with a slash before it, such as <strong>/adoptables</strong> in the Script Path box. </p>
        <p class='style4'>Database Table Prefix: 
          <input name='prefix' type='text' id='prefix' value='adopts_'>
</p>
        <p class='style4'>The table prefix determines how the tables in your database are named.  In most cases, the adopts_ prefix will do, however if you are running multiple copies of Mysidia Adoptables on the same database, change the table prefix.</p>
        <p class='style4'>
          <input type='submit' name='Submit' value='Continue Installation'> 
          </p>
        <p>&nbsp;         </p>
      </form>      <p align='left'>&nbsp;</p>
      <p align='right'><br>
        </p></td>
  </tr>
</table>
</center>
</body>
</html>";
} elseif ($step == 2 or $step == "2") {

//Check file permissions...
    $flag = 0;
    echo"<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
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
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables v1.3.4 Installation Wizard <br>
        <span class='style2'>Step 2: File Permissions </span></span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
      <span class='style2'>This page will check that all of your file permissions and CHMOD settings are correct. It will also check the status of the GD image library on this server.  If any of the below read FAIL then please CHMOD the object so that it is writable, usually CHMOD 777 on most hosts.  
	If an object is marked as WARNING then it is optional that you CHMOD it to 777, however failure to do this will cause the file upload functions of the Admin CP to not work correctly.</span></p>";

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Check the file permissions here and echo the results...

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (is_writable(CONFIG_FOLDER)) {
        echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your configuration folder is writable.<br></p>";
    } else {
        echo "<b><p align='left'><img src='../templates/icons/no.gif'> FAIL:</b> Your configuration folder, ", CONFIG_FOLDER, ", is not writeable.<br></p>";
        $flag = 1;
    }

    if (is_writable("../picuploads/gif")) {
        echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your picuploads/gif directory is writable.<br></p>";
    } else {
        echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Your picuploads/gif directory is not writable.  Please CHMOD the directory so that it is writable if you wish to be able to upload GIF images from your ACP.<br></p>";
    }

    if (is_writable("../picuploads/jpg")) {
        echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your picuploads/jpg directory is writable.<br></p>";
    } else {
        echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Your picuploads/jpg directory is not writable.  Please CHMOD the directory so that it is writable if you wish to be able to upload JPG images from your ACP.<br></p>";
    }

    if (is_writable("../picuploads/png")) {
        echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your picuploads/png directory is writable.<br></p>";
    } else {
        echo "<b><p align='left'><img src='../templates/icons/warning.gif'> WARNING:</b> Your picuploads/png directory is not writable.  Please CHMOD the directory so that it is writable if you wish to be able to upload PNG images from your ACP.<br></p>";
    }

    // Check for PDO...

    if (class_exists('PDO')) {
        echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your server supports the PDO extension and can handle database requests..<br></p>";
    } else {
        echo "<b><p align='left'><img src='../templates/icons/warning.gif'> FAIL:</b> Your server does not appear to support the PDO extension for some reason.  Your site will not function well under this condition, please contact your host to enable PDO on your server.<br></p>";
        $flag = 1;
    }

    // Check for GD...

    if (function_exists('imagegif')) {
        echo "<p align='left'><img src='../templates/icons/yes.gif'> <b>PASS:</b>  Your server supports the GD image libraries and can handle fancy signature images..<br></p>";
    } else {
        echo "<b><p align='left'><img src='../templates/icons/warning.gif'> FAIL:</b> Your server does not appear to support the GD image libraries.  You will not be able to use fancy signature images for your adoptables on this server.  You can still use the traditional images, however.<br></p>";
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //END THE FILE PERMISSIONS CHECKS
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if ($flag == 0) {
        echo "<br><p align='right'><br>
        <a href='index.php?step=3'><span class='style2'><img src='../templates/icons/yes.gif' border=0> Continue Installation</span></a> </p></td>";
    }


    echo"</tr>
</table>
</center>
</body>
</html>";
} else {
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
.style3 {font-size: 16px}
.style4 {font-size: 12px}
-->
</style></head>

<body>
<center><table width='750' border='0' cellpadding='0' cellspacing='0'>
  <!--DWLayoutTable-->
  <tr>
    <td width='750' height='57' valign='top' bgcolor='#FF3300'><div align='left'>
      <p><span class='style1'>Mysidia Adoptables v1.3.4 Installation Wizard <br>
        <span class='style2'>Step 1: Welcome and License Agreement</span>
      </span></p>
    </div></td>
  </tr>
  <tr>
    <td height='643' valign='top' bgcolor='#FFFFFF'><p align='left'><br>
        <span class='style2'>This installer will help you install the Mysidia Adoptables Script on your server. Before you can install Mysidia Adoptables, however, you must agree to the Mysidia Adoptables License Agreement as it is outlined below:</span></p>
      <p align='left' class='style3'><u>Mysidia Adoptables License Agreement: </u></p>
      <p align='left' class='style4'>Mysidia Adoptables is licensed under a Free for Non-Commercial Use license, terms of this license are interpreted as the following: </p>
      <p align='left' class='style4'>---Commercial use of the product on your server is OK, while the script may not be redistributed in whole or as part of another script. </p>
      <p align='left' class='style4'>---You must post credit to Mysidia Adoptables (http://www.mysidiaadoptables.com) and keep it visible on all pages unless you have created a credits page.  </p>
      <p align='left' class='style4'>---You can create modifications of this script (or hire freelancers to create modifications of this script) at any time. </p>
      <p align='left' class='style4'>For permissions beyond the scope of this license please Contact (Hall of Famer) at halloffamer@mysidiaadoptables.com.</p>
      <p align='right' class='style2'><a href='index.php?step=2'><img src='../templates/icons/yes.gif' border=0> I Agree - Continue Installation</a>  </p></td>
  </tr>
</table>
</center>
</body>
</html>";
}
