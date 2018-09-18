<?php /* Smarty version Smarty-3.1.12, created on 2018-09-18 03:46:31
         compiled from "C:\xampp\htdocs\Mysidia-Deluxe\public_html\templates\nightsky\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:138345ba058f7a7b9b1-22452993%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f34d9ff5366d2ce5b7e52db1d7ab10615aa64022' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Mysidia-Deluxe\\public_html\\templates\\nightsky\\header.tpl',
      1 => 1537233275,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138345ba058f7a7b9b1-22452993',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'home' => 0,
    'header' => 0,
    'temp' => 0,
    'theme' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5ba058f7a848d0_59406301',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ba058f7a848d0_59406301')) {function content_5ba058f7a848d0_59406301($_smarty_tpl) {?><html>
<head>
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadFavicon(((string)$_smarty_tpl->tpl_vars['home']->value)."favicon.ico");?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadStyle(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/nightsky_style.css");?>

<?php echo $_smarty_tpl->tpl_vars['header']->value->loadAdditionalStyle();?>

</head><?php }} ?>