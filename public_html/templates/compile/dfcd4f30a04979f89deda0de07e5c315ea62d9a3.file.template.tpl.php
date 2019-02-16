<?php /* Smarty version Smarty-3.1.12, created on 2019-02-09 03:24:27
         compiled from "C:\xampp\htdocs\Mysidia-Deluxe\public_html\templates\nightsky\template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:98455ba058f7a20736-22998485%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dfcd4f30a04979f89deda0de07e5c315ea62d9a3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Mysidia-Deluxe\\public_html\\templates\\nightsky\\template.tpl',
      1 => 1549679066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98455ba058f7a20736-22998485',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5ba058f7a6b298_26183788',
  'variables' => 
  array (
    'root' => 0,
    'temp' => 0,
    'theme' => 0,
    'home' => 0,
    'document_title' => 0,
    'document_content' => 0,
    'avatar' => 0,
    'username' => 0,
    'mailcount' => 0,
    'admin_button' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ba058f7a6b298_26183788')) {function content_5ba058f7a6b298_26183788($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\xampp\\htdocs\\Mysidia-Deluxe\\public_html\\inc\\smarty\\plugins\\modifier.date_format.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['root']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<body>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #99a8c6; font-size: 20px;">
  <a class="navbar-brand" href="#">
    <img src="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
<?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
<?php echo $_smarty_tpl->tpl_vars['theme']->value;?>
/images/mysdLogo.png" width="auto" height="8%" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Features</a>
      <a class="nav-item nav-link" href="#">Pricing</a>
      <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </div>
  </div>
</nav>

<div class="wrapper">
	<div class="grid-container">
		<div class="item1">
			<ul id="dropdown1" class="dropdown-content">
				<li><a href="#!">one</a></li>
				<li><a href="#!">two</a></li>
				<li class="divider"></li>
				<li><a href="#!">three</a></li>
			</ul>
			<nav class="indigo darken-3" style="padding:0px 5px;">
				<div class="nav-wrapper">
					<ul id="nav-mobile" class="right">
						<li><a href="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
adopt">Adoption Center</a></li>
						<li><a href="badges.html">Components</a></li>
						<li><a href="collapsible.html">JavaScript</a></li>
					</ul>
					<ul id="nav-mobile" class="left">
						<li><i class="fas fa-clock fa-sm"></i> <?php echo smarty_modifier_date_format(time(),"%l:%M %p");?>
 :|</li>
						<li>: <?php echo smarty_modifier_date_format(time(),"%b %eth, %Y");?>
</li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="item2">
			<a href="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
myadopts" class="btn-large deep-purple" style="width: 200px;">
				<i class="fas fa-paw"></i> My Pets
			</a></br></br>
			<a href="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
account" class="btn-large deep-purple" style="width: 200px;"><i class="fas fa-box-open"></i> Inventory</a></br></br>
			
		</div>
		<div class="item3">
			<h2><?php echo $_smarty_tpl->tpl_vars['document_title']->value;?>
</h2><hr class="style-seven">
			<p><?php echo $_smarty_tpl->tpl_vars['document_content']->value;?>
</p>
		</div>  
		<div class="item4">
			<?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</br>
			<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
<hr>
			<a href="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
messages" class="btn-large deep-purple" style="width: 200px;">
				<i class="fas fa-envelope"></i> Messages <?php echo $_smarty_tpl->tpl_vars['mailcount']->value;?>

			</a></br></br>
			<a href="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
account" class="btn-large deep-purple" style="width: 200px;">
				<i class="fas fa-cog"></i> User CP
			</a></br></br>
			<?php echo $_smarty_tpl->tpl_vars['admin_button']->value;?>
</br></br>
			<a href="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
login/logout" class="btn-floating btn-large red"><i class="fas fa-sign-out-alt"></i></a>
		</div>
		<div class="item5" style="font-size:20px;">
			<img src="<?php echo $_smarty_tpl->tpl_vars['home']->value;?>
picuploads/cats/tricolor.png" style="height:150px; width:auto;"></br>
			<div>Footer information goes here. Should include copyright and links to Terms of Service and privacy policy</div>
		</div>
	</div>
</div>
</body>

</html><?php }} ?>