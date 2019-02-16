{include file="{$root}{$temp}{$theme}/header.tpl"}

<body>
<div id='noteholder'></div>

<nav class="navbar navbar-expand-lg" style="background-color: #1c2b49; font-size: 20px;">
	<a class="navbar-brand" href="{$home}">
		<img src="{$home}{$temp}{$theme}/images/mysdLogo.png" width="400px" height="auto" alt="">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		<div class="navbar-nav">
			<a class="nav-item nav-link btn btn-night" href="#"><i class="fas fa-globe-americas"></i> Explore</a>&nbsp;
			<a class="nav-item nav-link btn btn-night" href="#"><i class="fas fa-heart"></i> Adopt</a>&nbsp;
			<a class="nav-item nav-link btn btn-night" href="#"><i class="fas fa-paw"></i> My Pets</a>&nbsp;
			<div class="dropdown">
				<a class="nav-item nav-link btn btn-night dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-store-alt"></i> Shopping
				</a>

				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="{$home}bank"><i class="fas fa-caret-right"></i> Bank</a>
					<a class="dropdown-item" href="#"><i class="fas fa-caret-right"></i> Marketplace</a>
					<a class="dropdown-item" href="#"><i class="fas fa-caret-right"></i> Auction House</a>
				</div>
			</div>
			<a class="nav-item nav-link btn btn-night" href="#"><i class="fas fa-comments"></i> Forum</a>
		</div>
	</div>

    {$smarty.now|date_format:"%l:%M %p"} :|: {$smarty.now|date_format:"%b %eth, %Y"}

</nav>
<div class="container mt-3">
  <div class="row">
    <div class="col-sm-8 col-12 inner">
		<h2>{$document_title}</h2>
		<hr class="style-seven">
		<p>{$document_content}</p></div>
		<div class="col-sm-3 offset-sm-2 col-12 inner">
			{$avatar}</br>
			{$username}<hr>
			<i class="fas fa-coins"></i> {$cash}<hr>
			<a href="{$home}messages" class="btn btn-night btn-lg btn-block">
				<i class="fas fa-envelope"></i> Messages {$mailcount}
			</a></br>
			<a href="{$home}account" class="btn btn-night btn-lg btn-block">
				<i class="fas fa-cog"></i> User CP
			</a></br>
			{$admin_button}
			<a href="{$home}login/logout" class="btn btn-night btn-lg btn-block"><i class="fas fa-sign-out-alt"></i></a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col inner"><img src="{$home}picuploads/cats/tricolor.png" style="height:150px; width:auto;"></br>
			<footer>Footer information goes here. Should include copyright and links to Terms of Service and privacy policy</footer>
		</div>
	</div>
</div>
</body>

</html>