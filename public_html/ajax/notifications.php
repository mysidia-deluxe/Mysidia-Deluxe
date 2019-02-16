<?php
// place in ajax folder
include("../inc/config.php");
$db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
$query = "SELECT * FROM adopts_comments WHERE comment_status = 0 ORDER BY comment_id DESC";
$result = mysqli_query($db, $query);
$output = '';
while($row = mysqli_fetch_array($result)){
$noteid = $row['comment_id'];
$text = $row['comment_text'];
$title = $row['comment_subject'];
$output .= "
<div class='card card{$noteid}'>
	<script>
		$('.hidenote').click(function() { thisnote = $(this).data('noteid'); $('.card'+thisnote).hide('slow'); });
	</script>
	<div class='toast-header'>
		<b>{$title}</b> <div class='hidenote' data-noteid='{$noteid}'>&times;</div>
	</div><br>
	<div class='toast-body'>{$text}</div>
</div></br>";
}
// for some reason the button clicking wouldn't work if this script was on the main page...
// so sneak it in here 

$update_query = "UPDATE adopts_comments SET comment_status = 1 WHERE comment_status = 0";
mysqli_query($db, $update_query);
echo $output;
?>