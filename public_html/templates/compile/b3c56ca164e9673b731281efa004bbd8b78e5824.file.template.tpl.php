<?php /* Smarty version Smarty-3.1.12, created on 2018-08-15 00:34:31
         compiled from "C:\xampp\htdocs\mys_deluxe\templates\tutorial\template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:215765af5fa1738c1c6-00927357%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3c56ca164e9673b731281efa004bbd8b78e5824' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mys_deluxe\\templates\\tutorial\\template.tpl',
      1 => 1534286070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '215765af5fa1738c1c6-00927357',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5af5fa174c4c58_68868858',
  'variables' => 
  array (
    'root' => 0,
    'temp' => 0,
    'theme' => 0,
    'home' => 0,
    'admin_button' => 0,
    'document_title' => 0,
    'document_content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5af5fa174c4c58_68868858')) {function content_5af5fa174c4c58_68868858($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['root']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<body>
<div class="wrapper">
	<div class="grid-container">
		<div class="item6">
		<img src="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
<?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
<?php echo $_smarty_tpl->tpl_vars['theme']->value;?>
/images/mysdLogo.png" style="width:100%; height:auto;">
		</div>
		<div class="item1">
			<li class="dropdown">
				<a href="javascript:void(0)" class="dropbtn">Dropdown</a>
				<div class="dropdown-content">
					<a href="#">Link 1</a>
					<a href="#">Link 2</a>
					<a href="#">Link 3</a>
				</div>
			</li>
		</div>
		<div class="item2">
			<a href="http://localhost/mys_deluxe/myadopts" class="button">Pets</a></br></br>
			<a href="http://localhost/mys_deluxe/account" class="button">My Account</a></br></br>
			<a href="http://localhost/mys_deluxe/account" class="button">Inventory</a></br></br>
			<a href="http://localhost/mys_deluxe/account" class="button">Inbox</a></br></br>
			<?php echo $_smarty_tpl->tpl_vars['admin_button']->value;?>
</br></br>
			<a href="http://localhost/mys_deluxe/login/logout" class="button" style="background-color:#ef0000">Log Out</a>
		</div>
		<div class="item3">
			<h2><?php echo $_smarty_tpl->tpl_vars['document_title']->value;?>
</h2><hr>
			<p><?php echo $_smarty_tpl->tpl_vars['document_content']->value;?>
</p>
		</div>  
		<div class="item4">Right</div>
		<div class="item5" style="font-size:20px;">Footer information goes here. Should include copyright and links to Terms of Service and privacy policy</div>
	</div>
</div>
</body>

</html><?php }} ?>