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
    <div id="selectDate" style="margin-top: 10px; display: none; line-height: 25px;">
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
        </select>
        <hr style="margin: 10px 0px;">
        <div id="attendancePeriod" style="display: none"></div>
    </div>
</div>
</div>
<div class="alert" style="float: left; width: 37%">
    <h2>Steps</h2>
    <ul>
        <li>Select the Department, Batch and the Date Range for which the Attendance Report is to be generated</li>
        <li>Input the numbers of the Students for who the Report is to be Generated
            <ul>
                <li b>Use "<span g>1</span>": for a single student</li>
                <li b>Use "<span g>1-45</span>": for a range from 1 to 45 </li>
                <li b>Use "<span g>1,2,5,10...</span>": for specific numbers</li>
                <li b>Use "<span g>1-5,10-23</span>": for sets of sequential numbers</li>
                <li b>Use "<span g>1-5,7</span>": for the combination of 1, 2 ... 5, 7</li>
                <li b><span r>All Spaces will be removed <br>i.e '1 2' will be treated as '12'</span></li>                
            </ul>
        </li>
    </ul>
</div>
</section>
<div id="attrGenReport" style="display: block; clear: left;"></div>
<script>
    $(function () {
        var yfs = false; var mfs = false; var dfs = false;
        var yts = false; var mts = false; var dts = false;
        hidePage = function () {
            $("#attrGenReport").fadeOut(100, function () { $("#attrGenReport").html(""); });
            $("#attrInputSpace").fadeOut(100, function () { $("#attrInputSpace").html(""); });
            $("#attendancePeriod").fadeOut(100, function () { $("#attendancePeriod").html(""); });
        }
        resetDate = function () {
            $("#sfDYear option:first").attr("selected", "selected");
            $("#sfDMonth option:first").attr("selected", "selected");
            $("#sfDDay option:first").attr("selected", "selected");
            $("#stDYear option:first").attr("selected", "selected");
            $("#stDMonth option:first").attr("selected", "selected");
            $("#stDDay option:first").attr("selected", "selected");
            yfs = false; mfs = false; dfs = false;
            yts = false; mts = false; dts = false;
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
                    url: "attr/getmode.php",
                    success: function (e) {
                        $("#attendancePeriod").html(e);
                    },
                    complete: function () {
                        $("#attendancePeriod").fadeIn(250);
                    }
                });
            });
        }
        $("#sfDYear").change(function () {
            hidePage();
            if ($(this).val() != 0) yfs = true;
            else yfs = false;
            if (yfs && mfs && dfs && yts && mts && dts) performAction();
        });
        $("#sfDMonth").change(function () {
            hidePage();
            if ($(this).val() != 0) mfs = true;
            else mfs = false;
            if (yfs && mfs && dfs && yts && mts && dts) performAction();
        });
        $("#sfDDay").change(function () {
            hidePage();
            if ($(this).val() != 0) dfs = true;
            else dfs = false;
            if (yfs && mfs && dfs && yts && mts && dts) performAction();
        });
        $("#stDYear").change(function () {
            hidePage();
            if ($(this).val() != 0) yts = true;
            else yts = false;
            if (yfs && mfs && dfs && yts && mts && dts) performAction();
        });
        $("#stDMonth").change(function () {
            hidePage();
            if ($(this).val() != 0) mts = true;
            else mts = false;
            if (yfs && mfs && dfs && yts && mts && dts) performAction();
        });
        $("#stDDay").change(function () {
            hidePage();
            if ($(this).val() != 0) dts = true;
            else dts = false;
            if (yfs && mfs && dfs && yts && mts && dts) performAction();
        });
    });
</script>