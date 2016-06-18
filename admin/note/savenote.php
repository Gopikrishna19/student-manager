<?php
include("../../common/config.php");
$query = "DELETE FROM st_notifications WHERE id = '".$_REQUEST['odcode']."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc)." 1");

$text = mysqli_real_escape_string($dbc, $_REQUEST['ndname']);
$query = "INSERT INTO st_notifications VALUES('".md5(sha1($text))."','".$text."')" or die("Error Parsing the input");
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc)." 2");
?>