<hr style="margin: 10px 0px;">
<?php
include("../../common/config.php");
include("../../common/cattendance.php");
$att = new Attendance($_REQUEST['dp'],$_REQUEST['bt'],$_REQUEST['fdate'], $_REQUEST['tdate'],$dbc);
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