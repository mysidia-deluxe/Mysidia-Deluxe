{include file="{$root}{$temp}{$theme}/header.tpl"}

<body>
<div id="wrapper">

<!-- Menu Start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index">{$site_name}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			{if $logged_in}
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
			{else}
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
			{/if}
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
		<h4 class="card-title">{$document_title}</h4>
	</div>
	<p></p>
	<div class="container" style="margin:0;">
		<div class="row">
			<div class="col-12 col-md-4">
				{if $logged_in}
				<div class="card">
					<center>{$avatar}</br>
					<b>{$username}</b>
					</br>You have {$cash} CURRENCY
					</center>
					<div class="btn-group-vertical">
						<a class="btn btn-dark" href="donate"><i class="fa fa-money"></i> Donate to friends<a>
						<a class="btn btn-dark" href="myadopts"><i class="fa fa-paw"></i> Manage Adoptables<a>
						<a class="btn btn-dark" href="account"><i class="fa fa-envelope"></i> Messages <span class="badge badge-secondary">{$messages}</span><a>
						<a class="btn btn-dark" href="account"><i class="fa fa-archive"></i> Inventory<a>
						<a class="btn btn-dark" href="account"><i class="fa fa-cog"></i> User CP<a>
						{$admin_button}
						
						<a class="btn btn-danger" href="login/logout"><i class="fa fa-sign-out"></i> Logout<a>
					</div>
					</br>
					<a href="online">There are {$users} user(s) and {$guests} guest(s) online</a>
				</div>
				{else}
				<div class="card">
					<div class="card-header" style="text-align:center;"><h3>Welcome!</h3></div>
					<p>You're a guest! Why not <a href="login">login</a> or <a href="register">register</a>?</p>
					<p></p>
					<a href="online">There are {$users} user(s) and {$guests} guest(s) online</a>
				</div>
				{/if}
			</div>
			<p></p>
			<div class="col-12 col-md-8" style="float:right;">
				<p>{$document_content}</p>
			</div>
		</div>
	</div>
  </div>
  <div class="card-footer" style="text-align:center;">{$footer} <a href="tos">Terms of Service</a></div>
</div>
</div>

</body>

</html>