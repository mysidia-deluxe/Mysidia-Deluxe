<?php /* Smarty version Smarty-3.1.12, created on 2018-08-14 23:29:47
         compiled from "C:\xampp\htdocs\mys_deluxe\templates\tutorial\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7375af5fa175caf46-60473624%%*/if (!defined('SMARTY_DIR')) {
    exit('no direct access allowed');
}
$_valid = $_smarty_tpl->decodeProperties(array(
  'file_dependency' =>
  array(
    '24a8974ae27c7f956d4e00bd71a2865a8ca55d7f' =>
    array(
      0 => 'C:\\xampp\\htdocs\\mys_deluxe\\templates\\tutorial\\header.tpl',
      1 => 1534282146,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7375af5fa175caf46-60473624',
  'function' =>
  array(
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5af5fa17620430_80202738',
  'variables' =>
  array(
    'home' => 0,
    'header' => 0,
    'temp' => 0,
    'theme' => 0,
  ),
  'has_nocache_code' => false,
), false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5af5fa17620430_80202738')) {
    function content_5af5fa17620430_80202738($_smarty_tpl) {?><html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadFavicon(((string)$_smarty_tpl->tpl_vars['home']->value)."favicon.ico"); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadStyle(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/tutorial_style.css"); ?>

<?php echo $_smarty_tpl->tpl_vars['header']->value->loadAdditionalStyle(); ?>

</head><?php }
} ?>