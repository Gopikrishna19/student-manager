<?php 
include("../../common/config.php");
$query = "SELECT userId FROM st_users WHERE userId = '".$_REQUEST['uname']."' AND privilege = '".$_REQUEST['perm']."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
$type = $_REQUEST['perm'] == "M" ? "Moderator" : "User";
if(mysqli_fetch_row($result)) {
    $query = "DELETE FROM st_users WHERE userId = '".$_REQUEST['uname']."' AND privilege = '".$_REQUEST['perm']."'";
    mysqli_query($dbc, $query) or die("<span style='color: #600'>".mysqli_error($dbc)."</span>");
    echo "<span style='color: #484'>User ".$_REQUEST['uname']." Deleted Successfully</span>";   
}
else die("<span style='color: #600'>".$type." ".$_REQUEST['uname']." is not Found</span>");
?>