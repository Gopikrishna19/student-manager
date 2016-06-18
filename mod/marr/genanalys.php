<?php
include ("../../common/config.php");
include ("../../common/canalysis.php");
echo '<hr style="margin: 10px 0px; clear: both">';
$analys = new Analysis ( $_REQUEST ['dp'], $_REQUEST ['bt'], $_REQUEST ['sem'], $dbc );
if ($_REQUEST ['mode'] == 'stu')
	$analys->perStudent ( $_REQUEST['tt']);
else if ($_REQUEST ['mode'] == 'sub')
	$analys->perSubject ( $_REQUEST['tt'], $_REQUEST['subject'] );
?>