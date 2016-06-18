<div style="line-height: 30px">
<?php
$button = "Generate Report";
if ($_REQUEST ['mode'] == 'exp') {
	$button = "Export Report";
	?>
    <span bb>Generate and Export Report</span><br> <span b>The exported
		file will be in CSV(EXCEL) format</span><br>
<?php
}
if (isset ( $_REQUEST ['page'] )) {
	
	echo "<span f style='width: 210px'>Select the Test:</span>";
	?>
	<select id="examMode" class="text">
		<option value="unit1">Unit test 1</option>
		<option value="unit2">Unit test 2</option>
		<option value="unit3">Unit test 3</option>
		<option value="unit4">Unit test 4</option>
		<option value="unit5">Unit test 5</option>
		<option value="model1">Model Exam 1</option>
		<option value="model2">Model Exam 2</option>
		<option value="model3">Model Exam 3</option>
		<option value="univ">University Exam</option>
	</select>
	<?php
}
if ($_REQUEST ['mode'] == 'exp' || $_REQUEST ['mode'] == 'sub') {
	echo "<span f style='width: 210px'>Select the Subject:</span>";
	include ("../../common/config.php");
	$dp = $_REQUEST ['dp'];
	
	$query = "SELECT subcode, subname FROM st_subjects WHERE deptcode = '" . $dp . "' ORDER BY subcode";
	$result = mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
	echo "<select id='marrSubject' class='text'><option value='0'></option>";
	while ( $row = mysqli_fetch_row ( $result ) ) {
		echo "<option value='" . $row [0] . "'>" . $row [0] . " - " . $row [1] . "</option>";
	}
	echo "</select><br>";
}
?>
	<input type="hidden"
		value="<?php echo isset($_REQUEST['page'])?$_REQUEST['page']:"genrep"; ?>"
		id="ajaxPage">
	<?php
	if (! isset ( $_REQUEST ['page'] )) {
		?>
		<span f style="width: 210px">Enter the Roll Number(s):</span> <input
		type="text" id="marrRollNumbers" class="text"><br>
		<?php
	}
	?>
	<span f style="width: 210px">&nbsp;</span>
	<button class="btn" g id="btnGenReport"><?php echo $button ?></button>
</div>
<script>
    $(function () {
        $("#btnGenReport").click(function () {
            var subject = null;
            var mode = $("#marrMode .tab.selected").data("type");
            if(mode == "anl")
                mode = $("#analysMode .tab.selected").data("type");            
            if ($("#marrSubject").length > 0) { subject = $("#marrSubject").val(); }
            if (subject != null) if (subject == '0') {
                alert("You must select a subject"); return;
            }
            if($("#marrRollNumbers").length>0){
                var constraint = /(^([0-9]{1,3}[,-])+?[0-9]{1,3}$)|(^[0-9]{1,3}$)/;
                if (!constraint.test($("#marrRollNumbers").val())) {
                    alert("Invalid Inputs Given"); return;
                }
            }
            $("#marrGenReport").slideUp(500, function () {
                $("#marrGenReport").html("");
                $.ajax({
                    url: "marr/"+$("#ajaxPage").val()+".php",
                    data: {
                        "mode": mode,
                        "tt": ($("#examMode").length>0)?$("#examMode").val():"",
                        "dp": $("#sDept").val(), "bt": $("#sBatch").val(),
                        "range": ($("#marrRollNumbers").length>0)?$("#marrRollNumbers").val():"", 
                        "subject": subject,
                        "sem": $("#sSem").val()
                    },
                    success: function (e) {
                        $("#marrGenReport").html(e);
                    },
                    complete: function () {
                        $("#marrGenReport").slideDown(500, function () {
                            $("html, body").animate({ 'scrollTop': $("#marrGenReport").offset().top }, 500);
                        });
                    }
                });
            });
        });
    });
</script>