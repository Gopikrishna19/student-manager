<?php
$uname = $_REQUEST['uname'];
$upass = $_REQUEST['upass'];
include("../../common/config.php");
$query = "SELECT * FROM st_users WHERE userId = '".$uname."' AND password = '".md5($upass)."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
if($row = mysqli_fetch_row($result))
{
    session_start();
    $_SESSION["st_user_name"] = $row[0];
    $_SESSION["st_user_prev"] = $row[2];
    $_SESSION["st_user_disp"] = $row[4];
    $red = "";
    switch($row[2])
    {
        case "A": $red = "../admin/"; break;
        case "M": $red = "../mod/"; break;
        case "U": $red = "../user/"; break;
    }
    echo "<script>window.location.href = '".$red."';</script>";
}
else 
{
    echo "Invalid User Id or Password";
}
?>