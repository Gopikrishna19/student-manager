<?php
include("../../common/config.php");
$text = mysqli_real_escape_string($dbc, $_REQUEST['ncontent']);
$query = "INSERT INTO st_notifications VALUES('".md5(sha1($text))."','".$text."')" or die("Error Parsing the input");
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
echo $result;
?>