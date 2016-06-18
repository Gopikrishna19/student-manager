<?php
    session_start();
    include("../config.php");
    $pass = md5($_REQUEST['oldpass']);
    $query = "SELECT userId FROM st_users WHERE userId = '".$_SESSION['st_user_name']."' AND password = '".$pass."'";
    $res = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
    if(mysqli_fetch_row($res)) {
        $pass = md5($_REQUEST['newpass']);
        $query = "UPDATE st_users SET password = '".$pass."' WHERE userId = '".$_SESSION['st_user_name']."'";
        $res = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
        if($res == 1) echo "s";
        else echo "f";
    }
    else echo "w"
?>