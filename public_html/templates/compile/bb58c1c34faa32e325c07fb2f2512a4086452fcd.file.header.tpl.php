<?php /* Smarty version Smarty-3.1.12, created on 2017-11-19 23:26:53
         compiled from "C:\xampp\htdocs\mys_deluxe\templates\acp\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:189635a11ff63dedd17-83677390%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb58c1c34faa32e325c07fb2f2512a4086452fcd' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mys_deluxe\\templates\\acp\\header.tpl',
      1 => 1511130412,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '189635a11ff63dedd17-83677390',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5a11ff63e090e5_06000982',
  'variables' => 
  array (
    'browser_title' => 0,
    'home' => 0,
    'header' => 0,
    'temp' => 0,
    'theme' => 0,
    'js' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a11ff63e090e5_06000982')) {function content_5a11ff63e090e5_06000982($_smarty_tpl) {?><html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['browser_title']->value;?>
</title>
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadFavicon(((string)$_smarty_tpl->tpl_vars['home']->value)."favicon.ico");?>

<?php echo $_smarty_tpl->tpl_vars['header']->value->loadStyle(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/media/acp-style.css");?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadScript(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/media/jquery.min.js");?>

<?php echo $_smarty_tpl->tpl_vars['header']->value->loadScript(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/media/bootstrap.min.js");?>

<?php echo $_smarty_tpl->tpl_vars['header']->value->loadScript(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['js']->value)."/acp.js");?>


</head><?php }} ?>