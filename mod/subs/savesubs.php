<?php
include("../../common/config.php");
$query = "SELECT * FROM st_subjects WHERE subcode = '".$_REQUEST['ndcode']."' ".
         "AND deptcode = '".$_REQUEST['dept']."' AND subname = '".$_REQUEST['ndname']."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc)." 1");
if($row = mysqli_fetch_row($result))  echo "a";
else {
    $query = "UPDATE st_subjects SET subcode = '".$_REQUEST['ndcode']."', subname = '".$_REQUEST['ndname']."' ".
             "WHERE subcode = '".$_REQUEST['odcode']."' AND subname = '".$_REQUEST['odname']."' AND deptcode = '".$_REQUEST['dept']."'";
    mysqli_query($dbc, $query) or die(mysqli_error($dbc)." 2");
    echo "s";
}
?>