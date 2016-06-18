<hr style="margin: 10px 0px;">
<?php
include("../../common/config.php");

$dp=$_REQUEST['dp'];
$bt=$_REQUEST['bt'];
$rn=$_REQUEST['rn'];
$sb=$_REQUEST['sb'];
$sm=$_REQUEST['sm'];

$query = "SELECT unit1, unit2, unit3, unit4, unit5, model1, model2, model3, univ FROM st_marks ".
         "WHERE dept= '".$dp."' AND batch= '".$bt."' AND roll= '".$rn."' AND sem= '".$sm."' AND subject = '".$sb."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
if(!($row = mysqli_fetch_row($result))) { $row=array("0","0","0","0","0","0","0","0","0"); }
?>
<div id="markInputs" style="line-height: 30px;">
    <span b f>Test 1: </span><input type="text" id="mU1" class="text" value="<?php echo $row[0]; ?>"><br>
    <span b f>Test 2: </span><input type="text" id="mU2" class="text" value="<?php echo $row[1]; ?>"><br>
    <span b f>Test 3: </span><input type="text" id="mU3" class="text" value="<?php echo $row[2]; ?>"><br>
    <span b f>Test 4: </span><input type="text" id="mU4" class="text" value="<?php echo $row[3]; ?>"><br>
    <span b f>Test 5: </span><input type="text" id="mU5" class="text" value="<?php echo $row[4]; ?>"><br>
    <span g f>Model 1: </span><input type="text" id="mM1" class="text" value="<?php echo $row[5]; ?>"><br>
    <span g f>Model 2: </span><input type="text" id="mM2" class="text" value="<?php echo $row[6]; ?>"><br>
    <span g f>Model 3: </span><input type="text" id="mM3" class="text" value="<?php echo $row[7]; ?>"><br>
    <span r f>University: </span><input type="text" id="mUn" class="text" value="<?php echo $row[8]; ?>"> *<br>
    <span f>&nbsp;</span><i>Use <span g>AB or ab</span> for absent<br>
    <span f>&nbsp;</span><i></i>* You can enter Grades too: S, A, B, C, D, E, U.<br>
    <span b f>&nbsp;</span><button id="btnSaveAttendance" class="btn" g>Save</button>
</div>
<script>
    $(function () {
    	$("#markInputs .text").each(function () {
        	var m = $(this);
        	switch(m.val())
        	{
        	case "-1": m.val("AB"); break;
        	case "-2": m.val("S"); break;
        	case "-3": m.val("A"); break;
        	case "-4": m.val("B"); break;
        	case "-5": m.val("C"); break;
        	case "-6": m.val("D"); break;
        	case "-7": m.val("E"); break;
        	case "-8": m.val("U"); break;
        	}            
        });
        $("#btnSaveAttendance").click(function () {
            var constraint = /^(100|AB|ab|Ab|[0-9]{1,2}(\.[0-9]{1,2})?)$|^(S|A|B|C|D|E|U|s|a|b|c|d|e|u|)$/;
            var err = false;
            $("#markInputs .text").each(function () {
                if (!constraint.test($(this).val())) err = true;
            });

            if (err)
                alert("Invalid Inputs Given");
            else {
                var row = {}
                $("#markInputs .text").each(function () {
                    row[$(this).attr("id")] = $(this).val();
                });
                row["dp"] = $("#sDept").val();
                row["bt"] = $("#sBatch").val();
                row["sm"] = $("#sSem").val();
                row["sb"] = $("#sSub").val();
                row["rn"] = $("#sRoll").val();
                $.ajax({
                    url: "mark/savemark.php",
                    data: row,
                    complete: function () {
                        $("#btnMarkGenFields").click();
                    }
                });
            }
        });
    })
</script>

