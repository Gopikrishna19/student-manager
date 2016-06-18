<?php
include("../../common/config.php");

$dp=$_REQUEST['dp'];
$bt=$_REQUEST['bt'];
$sm=$_REQUEST['sm'];
$sb=$_REQUEST['sb'];
$rn=$_REQUEST['rn'];

function refineInput($m)
{
	$m = (preg_match ( '/^(AB|ab|Ab)$/', $m ) ? "-1" : $m);
	$m = (preg_match ( '/^(S|s)$/', $m ) ? "-2" : $m);
	$m = (preg_match ( '/^(A|a)$/', $m ) ? "-3" : $m);
	$m = (preg_match ( '/^(B|b)$/', $m ) ? "-4" : $m);
	$m = (preg_match ( '/^(C|c)$/', $m ) ? "-5" : $m);
	$m = (preg_match ( '/^(D|d)$/', $m ) ? "-6" : $m);
	$m = (preg_match ( '/^(E|e)$/', $m ) ? "-7" : $m);
	$m = (preg_match ( '/^(U|u)$/', $m ) ? "-8" : $m);
	return $m;
}

$mU1=refineInput($_REQUEST['mU1']);
$mU2=refineInput($_REQUEST['mU2']);
$mU3=refineInput($_REQUEST['mU3']);
$mU4=refineInput($_REQUEST['mU4']);
$mU5=refineInput($_REQUEST['mU5']);
$mM1=refineInput($_REQUEST['mM1']);
$mM2=refineInput($_REQUEST['mM2']);
$mM3=refineInput($_REQUEST['mM3']);
$mUn=refineInput($_REQUEST['mUn']);



$query = "SELECT 1 FROM st_marks ".
         "WHERE dept= '".$dp."' AND batch= '".$bt."' AND subject = '".$sb."' AND roll = '".$rn."' AND sem = '".$sm."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc)+" 1");

if(mysqli_fetch_row($result)) 
    $query = "UPDATE st_marks SET unit1 = '".$mU1."', unit2 = '".$mU2."', unit3 = '".$mU3."', unit4 = '".$mU4."', ".
             "unit5 = '".$mU5."', model1 = '".$mM1."', model2 = '".$mM2."', model3 = '".$mM3."', univ = '".$mUn."' ".
             "WHERE dept= '".$dp."' AND batch= '".$bt."' AND subject = '".$sb."' AND roll = '".$rn."' AND sem = '".$sm."'";
else 
    $query = "INSERT INTO st_marks VALUES('".$dp."','".$bt."','".$rn."','".$sm."','".$sb."',".
              "'".$mU1."','".$mU2."','".$mU3."','".$mU4."','".$mU5."','".$mM1."','".$mM2."','".$mM3."','".$mUn."')";

$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
if($result) echo "Success";
?>