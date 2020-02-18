<?php /* Smarty version Smarty-3.1.12, created on 2020-02-18 17:43:05
         compiled from "/Users/judda/Documents/code/Mysidia-Deluxe/public_html/templates/main/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2657140695e4c6879b1fa46-58863259%%*/if (!defined('SMARTY_DIR')) {
    exit('no direct access allowed');
}
$_valid = $_smarty_tpl->decodeProperties(array(
  'file_dependency' =>
  array(
    '0fe8ed8f3532ac940e958ce81ed28ff4034b43f3' =>
    array(
      0 => '/Users/judda/Documents/code/Mysidia-Deluxe/public_html/templates/main/header.tpl',
      1 => 1582064727,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2657140695e4c6879b1fa46-58863259',
  'function' =>
  array(
  ),
  'variables' =>
  array(
    'home' => 0,
    'header' => 0,
    'temp' => 0,
    'theme' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5e4c6879b3fd27_94057279',
), false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4c6879b3fd27_94057279')) {
    function content_5e4c6879b3fd27_94057279($_smarty_tpl) {?><html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadFavicon(((string)$_smarty_tpl->tpl_vars['home']->value)."favicon.ico"); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php echo $_smarty_tpl->tpl_vars['header']->value->loadStyle(((string)$_smarty_tpl->tpl_vars['home']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/media/style.css"); ?>

<?php echo $_smarty_tpl->tpl_vars['header']->value->loadAdditionalStyle(); ?>

</head><?php }
} ?>