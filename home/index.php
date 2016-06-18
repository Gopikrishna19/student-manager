<?php
session_start();
session_unset();
session_destroy();
$pp = "../";
$pt = "Home";
$pm = "h";
include("../common/header.php");
?>
<div id="box" data-default="1"></div>
<?php include("../common/footer.php"); ?>