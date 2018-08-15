<?php

/*** CKEditor ***/

if (defined("SUBDIR") and SUBDIR == "AdminCP") include_once("../inc/ckeditor/ckeditor.php"); 
else include_once ("ckeditor/ckeditor.php"); 
$CKEditor = new CKEditor(); 

if (defined("SUBDIR") and SUBDIR == "AdminCP")  $CKEditor->basePath = '../inc/ckeditor/'; // Path to the CKEditor directory.
else $CKEditor->basePath = 'inc/ckeditor/';

/*** HTML Purifier ***/
if($admin == "true") require_once ("../inc/htmlpurifier/HTMLPurifier.auto.php");
else require_once ("htmlpurifier/HTMLPurifier.auto.php");

$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.Doctype', 'HTML 4.01 Strict'); // replace with your doctype
$config->set('HTML.TidyLevel', 'heavy');
$config->set('AutoFormat.AutoParagraph', true);
$config->set('AutoFormat.Linkify', true);
$config->set('Output.TidyFormat', true);
$purifier = new HTMLPurifier($config);

function formattext($text){    
    $text = html_entity_decode($text);
    $text = stripslashes($text);
    return $text;
}


?>