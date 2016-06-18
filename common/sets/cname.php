<?php
    session_start();
    include("../config.php");
    $query = "SELECT userId FROM st_users WHERE userId = '".$_SESSION['st_user_name']."'";
    $res = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
    if(mysqli_fetch_row($res)) {
        $query = "UPDATE st_users SET userDisp = '".$_REQUEST['name']."' WHERE userId = '".$_SESSION['st_user_name']."'";
        $res = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
        if($res == 1) echo "s";
        else echo "f";
    }
    else echo "w"
?>