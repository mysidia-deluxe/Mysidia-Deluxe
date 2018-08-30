<?php

//Language variables used for AdminCP/Content Page

$lang['default_title'] = "Custom Page Editor";
$lang['default'] = "Here you can edit the content that appears on your site.  
					Here you can edit your home page, terms of service page, and more.  
					You can also create new pages as needed below.<br /><br />
					<b><a href='add'><img src='../../templates/icons/add.gif' border=0> Add a new page</a></b>
					<p><b><u>Your Existing Pages:</u></b></p>";
$lang['default_none'] = "Currently there is no custom pages created.";					
$lang['add_title'] = "Create a new page";
$lang['add'] = "Here you can create a new page for your site.  You can use the buttons above the textarea below to insert BBCODE into the form.<br />";
$lang['explain'] =  "<br /><u>Pages will appear at:</u><br /> {$mysidia->path->getAbsolute()}<b>pages/view/pageurl</b> 
					 <br />The page url may contain letters and numbers only and may not include spaces.";
$lang['accessibility'] = "<b>Note: Leave the fields below blank if they do not apply!</b>";
$lang['added_title'] = "Page Created Successfully";
$lang['added'] = "Your page has been created successfully. <a href='edit'>Return to the pages listing.</a>";
$lang['edit_title'] = "Here you can edit an existing page:<br />";
$lang['edit'] = "Here you can edit an existing page.  Use the text editor below to change the page title or content.
				 You may use some limited BBCodes in the box below.<br />";
$lang['editing'] = "<b><u>Currently Editing Page:</u> {$mysidia->input->get("pageurl")}</b>";
$lang['edited_title'] = "Page Updated Successfully";
$lang['edited'] = "<a href='../edit'>Click Here</a> to return to the content manager.";		
$lang['delete_title'] = "Page Deleted Successfully";
$lang['delete'] = "The page with the name <b>{$mysidia->input->get("pageurl")}</b> has been deleted.<br /><br /><a href='../../index'>ACP Home</a>";
$lang['url'] = "You have yet to enter a url for the page, please go back and fill in the blank.";
$lang['title'] = "The page title is left blank, please return to the previous page and specify it";
$lang['content'] = "You have yet to specify the page content, please go back and enter the field.";
$lang['special'] = "Special pages for index/TOS cannot be deleted?";
$lang['nonexist'] = "The Page does not exist.";
?>