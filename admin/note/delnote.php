<?php
    include("../../common/config.php");
    $query = "DELETE FROM st_notifications WHERE id = '".$_REQUEST['dcode']."'";
    mysqli_query($dbc, $query) or die(mysqli_error($dbc));
?>