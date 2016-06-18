<?php
$filename = $_REQUEST['content'];

header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=".$filename);

readfile($filename);
exit;
?>