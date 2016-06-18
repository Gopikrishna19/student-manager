<?php
    include("../../common/config.php");
    $query = "DELETE FROM st_subjects WHERE subcode = '".$_REQUEST['dcode']."' AND subname = '".$_REQUEST['dname']."' AND deptcode = '".$_REQUEST['dept']."'";
    mysqli_query($dbc, $query) or die(mysqli_error($dbc));
?>