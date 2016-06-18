<?php
session_start();
if(!isset($_SESSION['st_user_name'])) header("Location: ../home");
switch($_SESSION['st_user_prev']) {
    case "U": header("Location: ../user"); break;
}
$pp = "../";
$pt = $_SESSION['st_user_disp'];
$pm = "m";
include("../common/header.php");
?>
<div id="box" data-default="1"></div>
<?php 
include("../common/footer.php"); ?>