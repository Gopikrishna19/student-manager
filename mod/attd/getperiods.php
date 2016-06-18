<?php

include("../../common/config.php");

$y=$_REQUEST['y'];
$m=$_REQUEST['m'];
$d=$_REQUEST['d'];

echo "Select a Period:<br><div style='overflow: auto'>";
$i = 1;
while($i < 10) {    
?>
<div data-period="<?php echo $i; ?>" class="selectPeriod"><?php echo $i; ?></div>
<?php
    ++$i;
}
echo "</div>";
echo "<input type='hidden' id='attdDate' value='".$y."-".$m."-".$d."'>";
?>
<hr style="margin: 10px 0px;">
<div style="line-height: 30px; clear: left; margin-top: 20px; display: none" id="divAttendance"></div>
<script>
    var selper = 0;
    var perani = false;
    $(function () {
        $(".selectPeriod").click(function () {
            if (!perani)
                if (selper != $(this).data("period")) {
                    perani = true;
                    $(".selectPeriod").removeClass("s");
                    $(this).addClass("s");
                    selper = $(this).data("period");
                    $("#divAttendance").fadeOut(500, function () {
                        $.ajax({
                            url: "attd/getlist.php",
                            data: {
                                "dt": $("#attdDate").val(), "dp": $("#sDept").val(),
                                "bt": $("#sBatch").val(), "pd": $(".selectPeriod.s").data("period")
                            },
                            success: function (e) {
                                $("#divAttendance").html(e);
                                $("#divAttendance").fadeIn(250, function () { perani = false; });
                            }
                        });
                    });
                }
        });
    });
</script>