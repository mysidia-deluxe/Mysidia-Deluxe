<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{$header->loadFavicon("{$home}favicon.ico")}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
{$header->loadStyle("{$home}{$temp}{$theme}/nightsky_style.css")}
{$header->loadAdditionalStyle()}
<script>
$(document).ready(function(){
    $('.toast').toast('show');
	
	setInterval(function(){ refresh_notifications(); }, 3000);

function refresh_notifications(){
 
  $.ajax({
   url:'{$home}ajax/notifications.php',
   method:'POST',
   success:function(data){
   
        // retrieved the latest comments. Fade them into holder
        $(data).hide().appendTo( $('#noteholder') ).fadeIn(600);
        
        // could try auto-hiding them later, but I prefer to let user click them away, so nothing can be missed
        // you would have to dynamically create individual divs each time... possible but kinda complicated
   }
  });
 }
	
});
</script>
</head>