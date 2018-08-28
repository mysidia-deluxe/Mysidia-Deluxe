{include file="{$root}{$temp}{$theme}/header.tpl"}

<body>
<div class="wrapper">
	<div class="grid-container">
		<div class="item6">
		<img src="{$home}{$temp}{$theme}/images/mysdLogo.png" style="width:100%; height:auto;">
		</div>
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
						<li><a href="{$home}adopt">Adoption Center</a></li>
						<li><a href="badges.html">Components</a></li>
						<li><a href="collapsible.html">JavaScript</a></li>
					</ul>
					<ul id="nav-mobile" class="left">
						<li><i class="fas fa-clock fa-sm"></i> {$smarty.now|date_format:"%l:%M %p"} :|</li>
						<li>: {$smarty.now|date_format:"%b %eth, %Y"}</li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="item2">
			<a href="http://localhost/mys_deluxe/myadopts" class="btn-large deep-purple" style="width: 200px;">
				<i class="fas fa-paw"></i> My Pets
			</a></br></br>
			<a href="http://localhost/mys_deluxe/account" class="btn-large deep-purple" style="width: 200px;"><i class="fas fa-box-open"></i> Inventory</a></br></br>
			
		</div>
		<div class="item3">
			<h2>{$document_title}</h2><hr class="style-seven">
			<p>{$document_content}</p>
		</div>  
		<div class="item4">
			{$avatar}</br>
			{$username}<hr>
			<a href="http://localhost/mys_deluxe/messages" class="btn-large deep-purple" style="width: 200px;">
				<i class="fas fa-envelope"></i> Messages {$mailcount}
			</a></br></br>
			<a href="http://localhost/mys_deluxe/account" class="btn-large deep-purple" style="width: 200px;">
				<i class="fas fa-cog"></i> User CP
			</a></br></br>
			{$admin_button}</br></br>
			<a href="http://localhost/mys_deluxe/login/logout" class="btn-floating btn-large red"><i class="fas fa-sign-out-alt"></i></a>
		</div>
		<div class="item5" style="font-size:20px;">
			<img src="{$home}picuploads/cats/tricolor.png" style="height:150px; width:auto;"></br>
			<div>Footer information goes here. Should include copyright and links to Terms of Service and privacy policy</div>
		</div>
	</div>
</div>
</body>

</html>