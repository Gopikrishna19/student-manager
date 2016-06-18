<?php
include("../../common/config.php");
$query = "SELECT * FROM st_departments WHERE dCode = '".$_REQUEST['ndcode']."' AND dName = '".$_REQUEST['ndname']."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc)." 1");
if($row = mysqli_fetch_row($result))  echo "a";
else {
    $query = "UPDATE st_departments SET dCode = '".$_REQUEST['ndcode']."', dName = '".$_REQUEST['ndname']."' ".
             "WHERE dCode = '".$_REQUEST['odcode']."' AND dName = '".$_REQUEST['odname']."'";
    mysqli_query($dbc, $query) or die(mysqli_error($dbc)." 2");
    echo "s";
}
?>