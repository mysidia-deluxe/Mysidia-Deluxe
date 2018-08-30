{include file="{$root}{$temp}{$theme}/header.tpl"}

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
			{$sidebar}
		</div>
	</div>
	<!-- SIDEBAR END / / / / / / / / / -->

	<!-- / / / / / / / / / CONTENTS --> 
	<div class="col-xs-12 col-sm-9" style="margin-top: 20px;">
		<h2>{$document_title}</h2>
		<p>
			<div id="stats">
				<center><strong>{$site_name} Statistics</strong></center>
				<p><span><a href="#">00</a> Adoptables</span><span><a href="#">00</a> Users</span></p>
				<p><span><a href="#">00</a> Items</span><span><a href="#">00</a> Shops</span></p>
 				<p><span><a href="#">00</a> Pages</span><span><a href="#">00</a> Advertisers</span></p>
 				<p><span><a href="#">00</a> Admins</span><span><a href="#">00</a> Artists</span></p>
 			</div> 
			{$document_content}
		</p>
	</div>
	<!-- CONTENTS END / / / / / / / / / -->
		</div>
</div>
</div>

<center><b>MyMysidia</b> Powered By <a href="http://mysidiaadoptables.com">Mysidia Adoptables</a> &copy;Copyright 2011-2014.</center>
	
<script src="{$home}{$temp}{$theme}/media/js-kyt.js"></script>

</body>
</html>