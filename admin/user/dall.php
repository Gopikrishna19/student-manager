<?php 
include("../../common/config.php");
$query = "DELETE FROM st_users WHERE privilege IN ('M', 'U')";
mysqli_query($dbc, $query) or die("<span style='color: #600'>".mysqli_error($dbc)."</span>");
?>