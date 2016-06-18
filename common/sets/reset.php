<?php
include ("../config.php");
$query = "DELETE FROM st_users WHERE privilege IN ('M', 'U'); ";
mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
$query = "DELETE FROM st_marks; ";
mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
$query = "DELETE FROM st_departments; ";
mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
$query = "DELETE FROM st_subjects; ";
mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
$query = "DELETE FROM st_notifications";
mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
$query = "DELETE FROM st_attendance";
mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
echo "s";
?>