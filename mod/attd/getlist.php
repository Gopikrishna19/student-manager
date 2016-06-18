<?php
include("../../common/config.php");

$dt=$_REQUEST['dt'];
$dp=$_REQUEST['dp'];
$bt=$_REQUEST['bt'];
$pd=$_REQUEST['pd'];

$query = "SELECT subcode, subname FROM st_subjects WHERE deptcode = '".$dp."' ORDER BY subcode";
$subs[] = "";
$subc[] = "";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
while($row = mysqli_fetch_row($result)) {
    $subs[] = $row[0]." - ".$row[1];
    $subc[] = $row[0];
}
$query = "SELECT subject, abs FROM st_attendance WHERE dept= '".$dp."' AND batch= '".$bt."' AND date= '".$dt."' AND period= '".$pd."'";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
if(!($row = mysqli_fetch_row($result))) { $row=array("","0"); }
?>
<span b f>Subject: </span><select id="attdSubject" class="text">
    <?php for($s = 0; $s < count($subc); ++$s) 
            echo "<option value='".$subc[$s]."' ".($row[0]===$subc[$s]?"selected":"").">".$subs[$s]."</option>"; 
    ?>
</select><br>
<span b f>Absentees: </span><input type="text" id="attdAbs" class="text" value="<?php echo $row[1]; ?>"><br>
<span b f>&nbsp;</span><button id="btnSaveAttendance" class="btn" g>Save</button>
<script>
    $(function () {
        $("#btnSaveAttendance").click(function () {

            var constraint = /(^([0-9]{1,3}[,-])+?[0-9]{1,3}$)|(^[0-9]{1,3}$)/;
            if (!(constraint.test($("#attdAbs").val()) && $("#attdSubject").val().trim() !== ""))
                alert("Invalid Inputs Given");
            else {
                $.ajax({
                    url: "attd/saveattd.php",
                    data: {
                        "dept": $("#sDept").val(), "batch": $("#sBatch").val(),
                        "date": $("#attdDate").val(), "period": $(".selectPeriod.s").data("period"),
                        "subject": $("#attdSubject").val(), "abs": $("#attdAbs").val()
                    },
                    complete: function () {
                        selper = 0;
                        $(".selectPeriod.s").click();
                    }
                });
            }
        });
    })
</script>

