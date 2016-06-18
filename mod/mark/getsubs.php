<span f>Select a Semester: </span>
<select id="sSem" class="text"><option value="0"></option>
<?php for($i = 1; $i < 9; ++$i) echo "<option value='".$i."'>".$i."</option>"; ?>
</select><br>
<span f>Select the Subject:</span>
<select id='sSub' class='text'><option value='0'></option>
  <?php 
    include("../../common/config.php");
    $dp=$_REQUEST['dp'];

    $query = "SELECT subcode, subname FROM st_subjects WHERE deptcode = '".$dp."' ORDER BY subcode";
    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
    echo "";
    while($row = mysqli_fetch_row($result)) {
        echo "<option value='".$row[0]."'>".$row[0]." - ".$row[1]."</option>";
    }    
  ?>
</select><br>
<script>
    getOpt = function () {
        $.ajax({
            url: "mark/getopt.php",
            success: function (e) { $("#divMarkOpt").html(e); },
            complete: function (e) { $("#divMarkOpt").fadeIn(500); }
        });
    }
    $("#sSem").change(function () {
        $("#divMarkOpt").fadeOut(250, function () { $("#divMarkOpt").html(""); 
        if ($("#sSem").val() != "0" && $("#sSub").val() != "0") getOpt(); });
    });
    $("#sSub").change(function () {
        $("#divMarkOpt").fadeOut(250, function () { $("#divMarkOpt").html(""); 
        if ($("#sSem").val() != "0" && $("#sSub").val() != "0") getOpt(); });
    });
</script>