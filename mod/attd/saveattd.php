<?php
include("../../common/config.php");

$dt=$_REQUEST['date'];
$dp=$_REQUEST['dept'];
$bt=$_REQUEST['batch'];
$pd=$_REQUEST['period'];
$sb=$_REQUEST['subject'];
$ab=$_REQUEST['abs'];

$query = "SELECT 1 FROM st_attendance WHERE dept= '".$dp."' AND batch= '".$bt."' AND date = '".$dt."' AND period = '".$pd."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

if(mysqli_fetch_row($result)) 
    $query = "UPDATE st_attendance SET subject = '".$sb."', abs = '".$ab."'".
             " WHERE dept= '".$dp."' AND batch= '".$bt."' AND date = '".$dt."' AND period = '".$pd."'";
else 
    $query = "INSERT INTO st_attendance VALUES('".$dp."','".$bt."','".$dt."','".$pd."','".$sb."','".$ab."')";

$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
if($result) echo "Success";
?>