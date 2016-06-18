<section style="overflow: auto">
<div style="float: left; width: 56%; margin-right: 5px;">
<span f>Select a Department: </span><select id="sDept" class="text">
<option value="0" selected></option>
<?php 
include_once("../../common/config.php");
$query = "SELECT * FROM st_departments ORDER BY dCode";
$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
while($row = mysqli_fetch_row($result)) echo "<option value=".$row[0].">".$row[0]." - ".$row[1]."</option>";
?>
</select>
<div id="selectBatch" style="margin-top: 10px; display: none">
    <span f>Select a Batch: </span>
    <select id="sBatch" class="text"><option value="0"></option>
        <?php for($i = 2009; $i < 2020; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
    </select>
    <div id="selectDate" style="margin-top: 10px; display: none">
        <span f>Select a Date: </span><span b>Year:</span>
        <select id="sDYear" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 2009; $i < 2025; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select> <span b>Month:</span>
        <select id="sDMonth" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 01; $i < 13; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select> <span b>Day:</span>
        <select id="sDDay" class="text" style="width: auto"><option value="0"></option>
            <?php for($i = 01; $i < 32; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select>
        <hr style="margin: 10px 0px;">
        <div id="attendancePeriod" style="display: none"></div>
    </div>
</div>
</div>
<div class="alert" style="float: left; width: 37%">
    <h2>Steps</h2>
    <ul>
        <li>Select the Department & Batch</li>
        <li>Select the Date for which the attendance is to be edited</li>
        <li>Select a Period</li>
        <li>Select a Subject</li>
        <li>Input Absentees field with following styles
            <ul>
                <li b>Use "<span g>1-45</span>": for a range from 1 to 45 </li>
                <li b>Use "<span g>1,2,5,10...</span>": for specific numbers</li>
                <li b>Use "<span g>1-5,10-23</span>": for sets of sequential numbers</li>
                <li b>Use "<span g>1-5,7</span>": for the combination of 1, 2 ... 5, 7</li>
                <li b><span r>All Spaces will be removed <br>i.e '1 2' will be treated as '12'</span></li>
                <li b>Leave a zero if no input is specified</li>
            </ul>
        </li>
    </ul>
</div>
</section>
<script>
    $(function () {
        var ys = false;
        var ms = false;
        var ds = false;
        hidePage = function () {
            $("#attendancePeriod").fadeOut(100, function () { $("#attendancePeriod").html(""); });
        }
        resetDate = function () {
            $("#sDYear option:first").attr("selected", "selected");
            $("#sDMonth option:first").attr("selected", "selected");
            $("#sDDay option:first").attr("selected", "selected");
            ys = false; ms = false; ds = false;
            $("#selectDate").fadeOut(250);
            hidePage();
        }
        $("#sDept").change(function () {
            $("#sBatch option:first").attr("selected", "selected");
            resetDate();
            if ($(this).val() != 0) $("#selectBatch").fadeIn(250);
            else { $("#selectBatch").fadeOut(250); }
        });
        $("#sBatch").change(function () {
            resetDate();
            if ($(this).val() != 0) $("#selectDate").fadeIn(250);
        });
        performAction = function () {
            $("#attendancePeriod").fadeOut(500, function () {
                $.ajax({
                    url: "attd/getperiods.php",
                    data: {
                        "y": $("#sDYear").val(), "m": $("#sDMonth").val(), "d": $("#sDDay").val(),
                        "dp": $("#sDept").val(), "bt": $("#sBatch").val()
                    },
                    success: function (e) {
                        $("#attendancePeriod").html(e);
                    },
                    complete: function () {
                        $("#attendancePeriod").fadeIn(250);
                    }
                });
            });
        }
        $("#sDYear").change(function () {
            if ($(this).val() != 0) ys = true;
            else { ys = false; hidePage(); }
            if (ys && ms && ds) performAction();
        });
        $("#sDMonth").change(function () {
            if ($(this).val() != 0) ms = true;
            else { ms = false; hidePage(); }
            if (ys && ms && ds) performAction();
        });
        $("#sDDay").change(function () {
            if ($(this).val() != 0) ds = true;
            else { ds = false; hidePage(); }
            if (ys && ms && ds) performAction();
        });
    });
</script>