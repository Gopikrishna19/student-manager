<?php include("../../common/config.php"); ?>
<section style="overflow: auto">
	<div style="float: left; width: 56%; margin-right: 5px; line-height: 30px;">
		<span f>Select a Department: </span> <select id="sDept" class="text"><option
				value="0" selected></option>
        <?php
								$query = "SELECT * FROM st_departments ORDER BY dCode";
								$result = mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
								while ( $row = mysqli_fetch_row ( $result ) )
									echo "<option value=" . $row [0] . ">" . $row [0] . " - " . $row [1] . "</option>";
								?>
        </select><br> <span f>Select a Batch: </span> <select
			id="sBatch" class="text"><option value="0"></option>
        <?php for($i = 2009; $i < 2020; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select><br> <span f>Select a Semester: </span> <select
			id="sSem" class="text"><option value="0"></option>
        <?php for($i = 1; $i < 9; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
        </select><br>
		<hr style="margin: 10px 0px; clear: both">
		<div id="divMarkMode"
			style="margin-bottom: 10px; display: none; line-height: 30px"></div>
	</div>
	<div class="alert" style="float: left; width: 37%">
	<h2>Steps</h2>
		<ul>
			<li>Select the Department, the Batch, the Semester and the Test for which the
				Attendance Report is to be generated</li>
			<li>Input the numbers of the Students for who the Report is to be
				Generated
				<ul>
					<li b>Use "<span g>1</span>": for a single student</li>
					<li b>Use "<span g>1-45</span>": for a range from 1 to 45</li>
					<li b>Use "<span g>1,2,5,10...</span>": for specific numbers</li>
					<li b>Use "<span g>1-5,10-23</span>": for sets of sequential numbers</li>
					<li b>Use "<span g>1-5,7</span>": for the combination of 1, 2 ... 5, 7</li>
					<li b><span r>All Spaces will be removed <br>i.e '1 2' will be treated as '12'
					</span></li>
				</ul>
			</li>
		</ul></div>
</section>
<div id="marrGenReport" style="display: block; clear: left;"></div>
<script>
    $(function () {
        getMode = function () {
            $.ajax({
                url: "marr/getmode.php",
                success: function (e) { $("#divMarkMode").html(e); },
                complete: function (e) { $("#divMarkMode").fadeIn(250); }
            });
        }
        HideReport = function(){
        	$("#marrGenReport").fadeOut(250, function (){
            	$("#marrGenReport").html("");
            });
        }
        $("#sDept").change(function () {
            HideReport();
            $("#divMarkMode").fadeOut(250, function () {
                $("#divMarkMode").html("");
                if ($("#sDept").val() != "0" && $("#sBatch").val() != "0" && $("#sSem").val() != "0") getMode();
            });
        });
        $("#sBatch").change(function () {
        	HideReport();
            $("#divMarkMode").fadeOut(250, function () {
                $("#divMarkMode").html("");
                if ($("#sBatch").val() != "0" && $("#sDept").val() != "0" && $("#sSem").val() != "0") getMode();
            });
        });
        $("#sSem").change(function () {
        	HideReport();
            $("#divMarkMode").fadeOut(250, function () {
                $("#divMarkMode").html("");
                if ($("#sBatch").val() != "0" && $("#sDept").val() != "0" && $("#sSem").val() != "0") getMode();
            });
        });
    });
</script>