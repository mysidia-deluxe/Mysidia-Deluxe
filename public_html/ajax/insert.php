<?php
//insert.php
if (isset($_POST["subject"])) {
    include("../inc/config.php");
    $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    $subject = mysqli_real_escape_string($db, $_POST["subject"]);
    $comment = mysqli_real_escape_string($db, $_POST["comment"]);
    $query = "INSERT INTO adopts_comments(comment_subject, comment_text) VALUES ('$subject', '$comment')";
    mysqli_query($db, $query);
}
