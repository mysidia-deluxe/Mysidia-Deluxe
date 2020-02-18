<?php /* Smarty version Smarty-3.1.12, created on 2020-02-18 17:43:05
         compiled from "/Users/judda/Documents/code/Mysidia-Deluxe/public_html/templates/main/template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3635950345e4c68799ebc83-30047728%%*/if (!defined('SMARTY_DIR')) {
    exit('no direct access allowed');
}
$_valid = $_smarty_tpl->decodeProperties(array(
  'file_dependency' =>
  array(
    'bc9f253bb116c94e92021e6f125e5f197dd6dba7' =>
    array(
      0 => '/Users/judda/Documents/code/Mysidia-Deluxe/public_html/templates/main/template.tpl',
      1 => 1582064727,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3635950345e4c68799ebc83-30047728',
  'function' =>
  array(
  ),
  'variables' =>
  array(
    'root' => 0,
    'temp' => 0,
    'theme' => 0,
    'site_name' => 0,
    'logged_in' => 0,
    'document_title' => 0,
    'avatar' => 0,
    'username' => 0,
    'cash' => 0,
    'messages' => 0,
    'admin_button' => 0,
    'users' => 0,
    'guests' => 0,
    'document_content' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5e4c6879ad7ea6_34882452',
), false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4c6879ad7ea6_34882452')) {
    function content_5e4c6879ad7ea6_34882452($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate(((string)$_smarty_tpl->tpl_vars['root']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0); ?>


<body>
<div id="wrapper">

<!-- Menu Start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index"><?php echo $_smarty_tpl->tpl_vars['site_name']->value; ?>
</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<?php if ($_smarty_tpl->tpl_vars['logged_in']->value) {?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Adoptables
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Adoption Center</a>
					<a class="dropdown-item" href="#">Pound</a>
					<a class="dropdown-item" href="#">Redeem</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Explore
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Trading Center</a>
					<a class="dropdown-item" href="#">Breeding Center</a>
					<a class="dropdown-item" href="#">Daycare</a>
					<a class="dropdown-item" href="#">Market</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Community
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Shoutbox</a>
					<a class="dropdown-item" href="#">Forum</a>
					<a class="dropdown-item" href="#">Members List</a>
					<a class="dropdown-item" href="#">Leaderboards</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Search
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Search for Adoptables</a>
					<a class="dropdown-item" href="#">Search for Users</a>
					<a class="dropdown-item" href="#">Search for Items</a>
				</div>
			</li>
			<?php } else { ?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Community
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Shoutbox</a>
					<a class="dropdown-item" href="#">Forum</a>
					<a class="dropdown-item" href="#">Members List</a>
					<a class="dropdown-item" href="#">Leaderboards</a>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
</nav>
<!-- Menu End -->

<!-- Banner -->
<img src="https://placeimg.com/640/480/nature" class="img-fluid" style="width:100%; height:30%;" alt="Site Banner">

<!-- Content Start -->
<div class="card" style="border-radius:0px;">
  <div class="card-body">
	<div class="card-header" style="text-align:center;">
		<h4 class="card-title"><?php echo $_smarty_tpl->tpl_vars['document_title']->value; ?>
</h4>
	</div>
	<p></p>
	<div class="container" style="margin:0;">
		<div class="row">
			<div class="col-12 col-md-4">
				<?php if ($_smarty_tpl->tpl_vars['logged_in']->value) {?>
				<div class="card">
					<center><?php echo $_smarty_tpl->tpl_vars['avatar']->value;?>
</br>
					<b><?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</b>
					</br>You have <?php echo $_smarty_tpl->tpl_vars['cash']->value;?>
 CURRENCY
					</center>
					<div class="btn-group-vertical">
						<a class="btn btn-dark" href="donate"><i class="fa fa-money"></i> Donate to friends<a>
						<a class="btn btn-dark" href="myadopts"><i class="fa fa-paw"></i> Manage Adoptables<a>
						<a class="btn btn-dark" href="account"><i class="fa fa-envelope"></i> Messages <span class="badge badge-secondary"><?php echo $_smarty_tpl->tpl_vars['messages']->value;?>
</span><a>
						<a class="btn btn-dark" href="account"><i class="fa fa-archive"></i> Inventory<a>
						<a class="btn btn-dark" href="account"><i class="fa fa-cog"></i> User CP<a>
						<?php echo $_smarty_tpl->tpl_vars['admin_button']->value;?>

						
						<a class="btn btn-danger" href="login/logout"><i class="fa fa-sign-out"></i> Logout<a>
					</div>
					</br>
					<a href="online">There are <?php echo $_smarty_tpl->tpl_vars['users']->value;?>
 user(s) and <?php echo $_smarty_tpl->tpl_vars['guests']->value;?>
 guest(s) online</a>
				</div>
				<?php } else { ?>
				<div class="card">
					<div class="card-header" style="text-align:center;"><h3>Welcome!</h3></div>
					<p>You're a guest! Why not <a href="login">login</a> or <a href="register">register</a>?</p>
					<p></p>
					<a href="online">There are <?php echo $_smarty_tpl->tpl_vars['users']->value;?>
 user(s) and <?php echo $_smarty_tpl->tpl_vars['guests']->value;?>
 guest(s) online</a>
				</div>
				<?php } ?>
			</div>
			<p></p>
			<div class="col-12 col-md-8" style="float:right;">
				<p><?php echo $_smarty_tpl->tpl_vars['document_content']->value; ?>
</p>
			</div>
		</div>
	</div>
  </div>
  <div class="card-footer" style="text-align:center;"><?php echo $_smarty_tpl->tpl_vars['footer']->value; ?>
 <a href="tos">Terms of Service</a></div>
</div>
</div>

</body>

</html><?php }
} ?>