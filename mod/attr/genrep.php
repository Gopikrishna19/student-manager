<hr style="margin: 10px 0px;">
<?php
include("../../common/config.php");
include("../../common/cattendance.php");
$att = new Attendance($_REQUEST['dp'],$_REQUEST['bt'],$_REQUEST['fdate'], $_REQUEST['tdate'],$dbc);
if($_REQUEST['mode']=='stu') {
    $att->perStudent($_REQUEST['range']);
?>
<script>
    var selectedAttrSubRow = -1;
    $("div.expan").click(function () {
        var expan = $(this);
        if (selectedAttrSubRow != expan.data("row")) {
            $("div.expan").removeClass("s");
            $("div.toExpand").slideUp();
            $("div.toExpand[data-row='" + expan.data("row") + "']").slideDown();
            expan.addClass("s");
            selectedAttrSubRow = expan.data("row");
        }
    });
</script>
<?php
}
else if($_REQUEST['mode']=='sub') $att->perSubject($_REQUEST['range'], $_REQUEST['subject']);
else if($_REQUEST['mode']=='exp') {    
    $out = $att->genCSText($_REQUEST['range']);
    if($out != NULL) echo "<script>window.location.href = 'attr/export.php?&content=".$out."'</script>";
    else echo "<div class='alert'>Sorry! No Records Found!</div>";
}
else echo "<div class='alert'>Sorry! Unable to process your request</div>";
?>