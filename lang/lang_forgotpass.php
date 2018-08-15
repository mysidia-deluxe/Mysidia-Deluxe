<?php

//Language variables used for Forgotpass Page

$lang['title'] = "Request Password Reset";
$lang['default'] = "So, you've forgotten your password?  Don't worry, it happens to the best of us.  Simply 
                    fill out the form below with your username and email address and we'll email you a link to reset your password.<br><br>";
$lang['invalidcode_error'] = "Incorrect activation code";
$lang['invalidcode'] = "The activation code you entered is incorrect. It is possible that the code is invalid.";
$lang['reset_title'] = "Reset Password";
$lang['reset'] = "Enter your username, email and password reset code to proceed, the code can be found in the last email you have received from this site.<br>";
$lang['success_title'] = "Password Reset Successfully";
$lang['success'] = "Dear {$mysidia->input->post("username")},<br>Your password has been reset successfully.<br>";
$lang['instruction'] = "You may now <a href='../login'>Log In</a> with this new password.  You can also change the password to something that is easier to remember
                        once you are logged in.";
$lang['password_error'] = "Error with password Reset";
$lang['match'] = "There's been an error.  The details you entered do not match any user in our system!  We cannot
                  reset your password at this time. Please make sure you enter both username and email correctly.";
$lang['email_title'] = "Password Reset Email Sent";
$lang['email'] = "We have sent you an email with detailed instruction on how to reset your password, please read it and enter the password reset code to proceed.";
$lang['logged_title'] = "You are already logged in";
$lang['logged'] = "You are already logged in, only guests can access this page.";

?>