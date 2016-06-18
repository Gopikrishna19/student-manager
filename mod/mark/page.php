<?php include("../../common/config.php"); ?>
<section style="overflow: auto;">
    <div style="line-height: 30px;float: left; width: 56%; margin-right: 5px;">
        <span f>Select a Department: </span>
        <select id="sDept" class="text"><option value="0" selected></option>
        <?php
          $query = "SELECT * FROM st_departments ORDER BY dCode";
          $result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
          while($row = mysqli_fetch_row($result)) echo "<option value=".$row[0].">".$row[0]." - ".$row[1]."</option>";
        ?>
        </select><br>
        <span f>Select a Batch: </span>
        <select id="sBatch" class="text"><option value="0"></option>
        <?php for($i = 2009; $i < 2020; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select><br>
        <div id="divMarkSub" style="margin-bottom: 10px; display: none; line-height: 30px"></div>
    </div>
    <div class="alert" style="float: left; width: 37%">
        <h2>Steps</h2>
        <ul>
            <li>Select the Department, Batch, Subject and the Semester Range for which the Mark is to be entered</li>
            <li>Select a Method of Input</li>
        </ul>
    </div>
</section>
<div id="divMarkOpt" style="margin-bottom: 10px; display: none; line-height: 30px"></div>
<script>
    $(function () {
        getSubs = function () {
            $.ajax({
                url: "mark/getsubs.php",
                data: { "dp": $("#sDept").val(), "bt": $("#sBatch").val() },
                success: function (e) { $("#divMarkSub").html(e); },
                complete: function (e) { $("#divMarkSub").fadeIn(500); }
            });
        }
        $("#sDept").change(function () {
            $("#divMarkSub").fadeOut(250, function () { $("#divMarkSub").html(""); });
            if ($("#sDept").val() != "0" && $("#sBatch").val() != "0") getSubs();            
        });
        $("#sBatch").change(function () {
            $("#divMarkSub").fadeOut(250, function () { $("#divMarkSub").html(""); });
            if ($("#sBatch").val() != "0" && $("#sDept").val() != "0") getSubs();
        });
    });
</script>