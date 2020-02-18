<?php /* Smarty version Smarty-3.1.12, created on 2017-11-19 23:35:55
         compiled from "C:\xampp\htdocs\mys_deluxe\templates\acp\template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:207385a11ff63d27d93-25335799%%*/if (!defined('SMARTY_DIR')) {
    exit('no direct access allowed');
}
$_valid = $_smarty_tpl->decodeProperties(array(
  'file_dependency' =>
  array(
    '4ecccbe98b0ec4dc2dda0aa89101f25156a6ffb1' =>
    array(
      0 => 'C:\\xampp\\htdocs\\mys_deluxe\\templates\\acp\\template.tpl',
      1 => 1511130953,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '207385a11ff63d27d93-25335799',
  'function' =>
  array(
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5a11ff63d64df3_43742461',
  'variables' =>
  array(
    'root' => 0,
    'temp' => 0,
    'theme' => 0,
    'sidebar' => 0,
    'document_title' => 0,
    'site_name' => 0,
    'document_content' => 0,
    'home' => 0,
  ),
  'has_nocache_code' => false,
), false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a11ff63d64df3_43742461')) {
    function content_5a11ff63d64df3_43742461($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate(((string)$_smarty_tpl->tpl_vars['root']->value).((string)$_smarty_tpl->tpl_vars['temp']->value).((string)$_smarty_tpl->tpl_vars['theme']->value)."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0); ?>


<body>
<div>

<nav class="navbar navbar-dark bg-dark">
	<h3><strong>MyMysidia</strong> Admin</h3>
	<div style="text-align:center"><a href="../index" class="btn btn-secondary">Return to main site</a></div>
</nav>
<div class="container" style="margin:0;">
		<div class="row">
		<!-- / / / / / / / / / SIDEBAR -->
	<div class="col-sm-3" style="margin-top: 35px;">
		<div class="panel panel-default" style="padding: 10px;">
			<?php echo $_smarty_tpl->tpl_vars['sidebar']->value; ?>

		</div>
	</div>
	<!-- SIDEBAR END / / / / / / / / / -->

	<!-- / / / / / / / / / CONTENTS --> 
	<div class="col-xs-12 col-sm-9" style="margin-top: 20px;">
		<h2><?php echo $_smarty_tpl->tpl_vars['document_title']->value; ?>
</h2>
		<p>
			<div id="stats">
				<center><strong><?php echo $_smarty_tpl->tpl_vars['site_name']->value; ?>
 Statistics</strong></center>
				<p><span><a href="#">00</a> Adoptables</span><span><a href="#">00</a> Users</span></p>
				<p><span><a href="#">00</a> Items</span><span><a href="#">00</a> Shops</span></p>
 				<p><span><a href="#">00</a> Pages</span><span><a href="#">00</a> Advertisers</span></p>
 				<p><span><a href="#">00</a> Admins</span><span><a href="#">00</a> Artists</span></p>
 			</div> 
			<?php echo $_smarty_tpl->tpl_vars['document_content']->value; ?>

		</p>
	</div>
	<!-- CONTENTS END / / / / / / / / / -->
		</div>
</div>
</div>

<center><b>MyMysidia</b> Powered By <a href="http://mysidiaadoptables.com">Mysidia Adoptables</a> &copy;Copyright 2011-2014.</center>
	
<script src="<?php echo $_smarty_tpl->tpl_vars['home']->value; ?>
<?php echo $_smarty_tpl->tpl_vars['temp']->value; ?>
<?php echo $_smarty_tpl->tpl_vars['theme']->value; ?>
/media/js-kyt.js"></script>

</body>
</html><?php }
} ?>