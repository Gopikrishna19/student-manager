<?php 
session_start();
$number = strrev($_SESSION['st_user_name']);
?>
<div style="line-height: 25px;">
        <input type="hidden" id="roll" value="<?php echo intval(strrev(substr($number, 0,3))); ?>">
    	<input type="hidden" id="dept" value="<?php echo intval(strrev(substr($number, 3,3))); ?>">
    	<input type="hidden" id="batch" value="<?php echo intval("20".strrev(substr($number, 6,2))); ?>">
        <span f>Select the Date: </span><br><span g f>FROM - </span><span b>Year:</span>
        <select id="sfDYear" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 2009; $i < 2025; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select> <span b>Month:</span>
        <select id="sfDMonth" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 01; $i < 13; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select> <span b>Day:</span>
        <select id="sfDDay" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 01; $i < 32; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select><br><span g f>TO - </span><span b>Year:</span>
        <select id="stDYear" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 2009; $i < 2025; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select> <span b>Month:</span>
        <select id="stDMonth" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 01; $i < 13; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select> <span b>Day:</span>
        <select id="stDDay" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 01; $i < 32; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select><br>
        <span f>&nbsp;</span><button id="btnGenRep" class="btn" g>Generate Report</button>
        <div id="attendancePeriod" style="display: none"></div>
</div>
<script>
    hidePage = function () { $("#attendancePeriod").fadeOut(250); }
    var yfs = false; var mfs = false; var dfs = false;
    var yts = false; var mts = false; var dts = false;
    $("#btnGenRep").click(function () {
        if (yfs && mfs && dfs && yts && mts && dts)
            $("#attendancePeriod").fadeOut(250, function () {
                $.ajax({
                    url: "attd/genrep.php",
                    data: {
                        "fdate": $("#sfDYear").val() + "-" + $("#sfDMonth").val() + "-" + $("#sfDDay").val(),
                        "tdate": $("#stDYear").val() + "-" + $("#stDMonth").val() + "-" + $("#stDDay").val(),
                        "dp": $("#dept").val(), "bt": $("#batch").val(),
                        "range": $("#roll").val()
                    },
                    success: function (e) {
                        $("#attendancePeriod").html(e);
                    },
                    complete: function () {
                        $("#attendancePeriod").fadeIn(250);
                    }
                });
            });
        else alert("Invalid Dates");
    });
    $("#sfDYear").change(function () {
        hidePage();
        if ($(this).val() != 0) yfs = true;
        else yfs = false;
    });
    $("#sfDMonth").change(function () {
        hidePage();
        if ($(this).val() != 0) mfs = true;
        else mfs = false;
    });
    $("#sfDDay").change(function () {
        hidePage();
        if ($(this).val() != 0) dfs = true;
        else dfs = false;
    });
    $("#stDYear").change(function () {
        hidePage();
        if ($(this).val() != 0) yts = true;
        else yts = false;
    });
    $("#stDMonth").change(function () {
        hidePage();
        if ($(this).val() != 0) mts = true;
        else mts = false;
    });
    $("#stDDay").change(function () {
        hidePage();
        if ($(this).val() != 0) dts = true;
        else dts = false;
    });
</script>