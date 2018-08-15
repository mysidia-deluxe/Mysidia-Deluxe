{include file="{$root}{$temp}{$theme}/header.tpl"}

<body>
<div class="wrapper">
	<div class="grid-container">
		<div class="item6">
		<img src="{$home}{$temp}{$theme}/images/mysdLogo.png" style="width:100%; height:auto;">
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
			{$admin_button}</br></br>
			<a href="http://localhost/mys_deluxe/login/logout" class="button" style="background-color:#ef0000">Log Out</a>
		</div>
		<div class="item3">
			<h2>{$document_title}</h2><hr>
			<p>{$document_content}</p>
		</div>  
		<div class="item4">Right</div>
		<div class="item5" style="font-size:20px;">Footer information goes here. Should include copyright and links to Terms of Service and privacy policy</div>
	</div>
</div>
</body>

</html>