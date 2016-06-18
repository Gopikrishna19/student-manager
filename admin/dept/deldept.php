<?php
    include("../../common/config.php");
    $query = "DELETE FROM st_departments WHERE dCode = '".$_REQUEST['dcode']."' AND dName = '".$_REQUEST['dname']."'";
    mysqli_query($dbc, $query) or die(mysqli_error($dbc));
?>