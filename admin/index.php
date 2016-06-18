<?php 
session_start();
if(!isset($_SESSION['st_user_name'])) header("Location: ../home");
switch($_SESSION['st_user_prev']) {
    case "M": header("Location: ../mod"); break;
    case "U": header("Location: ../user"); break;
}
$pp = "../";
$pt = $_SESSION['st_user_disp'];
$pm = "a";
include("../common/header.php");
?>
<div id="box" data-default="4"></div>
<?php include("../common/footer.php"); ?>