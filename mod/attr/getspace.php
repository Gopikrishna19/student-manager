<div style="line-height: 30px">
<?php
$button = "Generate Report";
if($_REQUEST['mode']!='exp') {
  if($_REQUEST['mode']=='sub') {
    echo "<span f style='width: 210px'>Select the Subject:</span>";
    include("../../common/config.php");
    $dp=$_REQUEST['dp'];

    $query = "SELECT subcode, subname FROM st_subjects WHERE deptcode = '".$dp."' ORDER BY subcode";
    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
    echo "<select id='attrSubject' class='text'><option value='0'></option>";
    while($row = mysqli_fetch_row($result)) {
        echo "<option value='".$row[0]."'>".$row[0]." - ".$row[1]."</option>";
    }
    echo "</select><br>";
  }
}
else {
    $button = "Export Report";
?>
    <span bb>Generate and Export Report for the given set of date</span><br>
    <span b>The exported file will be in CSV(EXCEL) format</span><br>
<?php } ?>
    <span f style="width: 210px">Enter the Roll Number(s):</span><input type="text" id="attrRollNumbers" class="text"><br>
    <span f style="width: 210px">&nbsp;</span><button class="btn" g id="btnGenReport"><?php echo $button ?></button>
</div>
<script>
    $(function () {
        $("#btnGenReport").click(function () {
            var subject = null;
            var mode = $("#attrMode .tab.selected").data("type");
            if ($("#attrSubject").length > 0) { subject = $("#attrSubject").val(); }
            if (subject != null) if (subject == '0') {
                alert("You must select a subject"); return;
            }
            var constraint = /(^([0-9]{1,3}[,-])+?[0-9]{1,3}$)|(^[0-9]{1,3}$)/;
            if (!constraint.test($("#attrRollNumbers").val())) {
                alert("Invalid Inputs Given"); return;
            }
            $("#attrGenReport").slideUp(500, function () {
                $("#attrGenReport").html("");
                $.ajax({
                    url: "attr/genrep.php",
                    data: {
                        "mode": mode,
                        "fdate": $("#sfDYear").val() + "-" + $("#sfDMonth").val() + "-" + $("#sfDDay").val(),
                        "tdate": $("#stDYear").val() + "-" + $("#stDMonth").val() + "-" + $("#stDDay").val(),
                        "dp": $("#sDept").val(), "bt": $("#sBatch").val(),
                        "range": $("#attrRollNumbers").val(), "subject": subject
                    },
                    success: function (e) {
                        $("#attrGenReport").html(e);
                    },
                    complete: function () {
                        $("#attrGenReport").slideDown(500, function(){
                            $("html, body").animate({ 'scrollTop': $("#attrGenReport").offset().top }, 500);
                        });
                    }
                });
            });
        });
    });
</script>