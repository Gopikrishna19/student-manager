<?php
include ("../../common/config.php");
if (! file_exists ( "uploaded.csv" ))
	die ( "<b>Please, select a file first!</b>" );

$file = fopen ( "uploaded.csv", "r" );
$error = FALSE;

while ( ! feof ( $file ) ) {
	$line = fgets ( $file );
	$line = preg_replace ( '/\s+/', '', $line );
	if ($line != null)
		if (! preg_match ( '/^[0-9]{0,3},(100|AB|ab|Ab|S|A|B|C|D|E|U|s|a|b|c|d|e|u|[0-9]{1,2}(\.[0-9]{1,2})?)$/', $line )) {
			$error = TRUE;
			break;
		}
}
if ($error)
	echo "<span r><b>Invalid File Format</b></span>";
else {
	
	rewind ( $file );
	
	$dp = $_REQUEST ['dp'];
	$bt = $_REQUEST ['bt'];
	$sm = $_REQUEST ['sm'];
	$sb = $_REQUEST ['sb'];
	$tt = $_REQUEST ['tt'];
	
	while ( ! feof ( $file ) ) {
		$line = fgets ( $file );
		$line = preg_replace ( '/\s+/', '', $line );
		if ($line != null) {
			
			$params = explode ( ',', $line );
			
			$params [1] = (preg_match ( '/^(AB|ab|Ab)$/', $params [1] ) ? "-1" : $params [1]);
			$params [1] = (preg_match ( '/^(S|s)$/', $params [1] ) ? "-2" : $params [1]);
			$params [1] = (preg_match ( '/^(A|a)$/', $params [1] ) ? "-3" : $params [1]);
			$params [1] = (preg_match ( '/^(B|b)$/', $params [1] ) ? "-4" : $params [1]);
			$params [1] = (preg_match ( '/^(C|c)$/', $params [1] ) ? "-5" : $params [1]);
			$params [1] = (preg_match ( '/^(D|d)$/', $params [1] ) ? "-6" : $params [1]);
			$params [1] = (preg_match ( '/^(E|e)$/', $params [1] ) ? "-7" : $params [1]);			
			$params [1] = (preg_match ( '/^(U|u)$/', $params [1] ) ? "-8" : $params [1]);
			
			// echo $params[0]." ".$params[1];
			
			$query = "SELECT 1 FROM st_marks ";
			$query .= "WHERE dept= '" . $dp . "' AND batch= '" . $bt . "' AND subject = '" . $sb . "' ";
			$query .= "AND roll = '" . $params [0] . "' AND sem = '" . $sm . "'";
			
			$result = mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) + " 1" );
			
			if (mysqli_fetch_row ( $result )) {
				$query = GenerateQuery ( $dp, $bt, $sb, $sm, $tt, $params [0], $params [1] );
			} else {
				$query = "INSERT INTO st_marks VALUES(";
				$query .= "'" . $dp . "','" . $bt . "','" . $params [0] . "','" . $sm . "','" . $sb . "',";
				$query .= "'0','0','0','0','0','0','0','0','0')";
				mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
				
				$query = GenerateQuery ( $dp, $bt, $sb, $sm, $tt, $params [0], $params [1] );
			}
			
			$result = mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
			if ($result)
				$error = FALSE;
		}
	}
}

if ($error)
	echo "<span r><b>An error occured: " . (mysqli_error ( $dbc )) . "</b></span>";
else
	echo "<span g><b>Success</b></span>";

fclose ( $file );
unlink ( "uploaded.csv" );
function GenerateQuery($dp, $bt, $sb, $sm, $tt, $rn, $mk) {
	$query = "UPDATE st_marks SET " . $tt . " = '" . $mk . "' ";
	$query .= "WHERE dept= '" . $dp . "' AND batch= '" . $bt . "' AND subject = '" . $sb . "' ";
	$query .= "AND roll = '" . $rn . "' AND sem = '" . $sm . "'";
	return $query;
}
?>