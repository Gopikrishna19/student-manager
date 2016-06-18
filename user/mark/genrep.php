<hr style="margin: 10px 0px;">
<?php
include("../../common/config.php");
include("../../common/cmark.php");
$att = new Mark($_REQUEST['dp'],$_REQUEST['bt'],$_REQUEST['sem'], $dbc);
$att->perSubject($_REQUEST['range'], $_REQUEST['subject']); ?>