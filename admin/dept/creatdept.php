<?php
include("../../common/config.php");
$query = "SELECT * FROM st_departments WHERE dCode = '".$_REQUEST['dcode']."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc)." 1");
if($row = mysqli_fetch_row($result))  echo "a";
else {
    $query = "INSERT INTO st_departments VALUES('".$_REQUEST['dcode']."','".$_REQUEST['dname']."')" or die("Error Parsing the input");
    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
    echo "s";
}
?>