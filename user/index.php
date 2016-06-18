<?php
session_start();
if(!isset($_SESSION['st_user_name'])) header("Location: ../home");
switch($_SESSION['st_user_prev']) {
    case "A": header("Location: ../admin"); break;
    case "M": header("Location: ../mod"); break;
}
$pp = "../";
$pt = $_SESSION['st_user_disp'];
$pm = "u";
include("../common/header.php");
?>
<div id="box" data-default="3"></div>
<?php 
include("../common/footer.php"); ?>