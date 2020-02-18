<?php /* Smarty version Smarty-3.1.12, created on 2019-02-09 03:10:15
         compiled from "C:\xampp\htdocs\Mysidia-Deluxe\public_html\templates\nightsky\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:138345ba058f7a7b9b1-22452993%%*/if (!defined('SMARTY_DIR')) {
    exit('no direct access allowed');
}
$_valid = $_smarty_tpl->decodeProperties(array(
  'file_dependency' =>
  array(
    'f34d9ff5366d2ce5b7e52db1d7ab10615aa64022' =>
    array(
      0 => 'C:\\xampp\\htdocs\\Mysidia-Deluxe\\public_html\\templates\\nightsky\\header.tpl',
      1 => 1549678213,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138345ba058f7a7b9b1-22452993',
  'function' =>
  array(
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5ba058f7a848d0_59406301',
  'variables' =>
  array(
    'home' => 0,
    'header' => 0,
    'temp' => 0,
    'theme' => 0,
  ),
  'has_nocache_code' => false,
), false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ba058f7a848d0_59406301')) {
    function content_5ba058f7a848d0_59406301($_smarty_tpl) {?><html>
<head>
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadFavicon(((string)$_smarty_tpl->tpl_vars['home']->value)."favicon.ico"); ?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadStyle(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/nightsky_style.css"); ?>

<?php echo $_smarty_tpl->tpl_vars['header']->value->loadAdditionalStyle(); ?>

</head><?php }
} ?>