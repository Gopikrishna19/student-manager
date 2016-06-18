<?php
include("../../common/config.php");
$query = "SELECT subcode, subname FROM st_subjects WHERE deptcode = '".$_REQUEST['dept']."' ORDER BY subcode";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
$i = 1;
while($row = mysqli_fetch_row($result))
{
    echo "<div class='row'>".
         "<div d ><span class='sdcode' data-count='".$i."'>".$row[0]."</span>".
            "<input type='text' class='text tdcode' style='display: none;' value='".$row[0]."' data-count='".$i."'></div>".
         "<div d style='width: 300px'><span class='sdname' data-count='".$i."'>".$row[1]."</span>".
            "<input type='text' class='text tdname' style='display: none; width: 290px' value='".$row[1]."' data-count='".$i."'></div>".
         "<div d>".
            "<button class='btn btnSubsDel' b data-count='".$i."'>Delete</button>".
            "<button class='btn btnSubsSav' g data-count='".$i."' style='display: none;'>Save</button>".
            "<button class='btn btnSubsRen' data-count='".$i."'  >Rename</button>".
         "</div></div>";
    $i += 1;
}
?>
<script>
    var ren = true;
    $(".btnSubsDel").click(function () {
        var i = $(this).data("count");
        var dcode = $(".sdcode[data-count='" + i + "']").html();
        var dname = $(".sdname[data-count='" + i + "']").html();
        $.ajax({ url: "subs/delsubs.php", data: { "dept": $("#dcode").val(), "dcode": dcode, "dname": dname }, success: function (e) { loadSubss(); } });
    });
    $(".btnSubsRen").click(function () {
        if (ren) {
            var i = $(this).data("count");
            $(".tdcode[data-count='" + i + "']").show();
            $(".tdname[data-count='" + i + "']").show();
            $(".sdcode[data-count='" + i + "']").hide();
            $(".sdname[data-count='" + i + "']").hide();
            $(".btnSubsSav[data-count='" + i + "']").show();
            $(".btnSubsDel[data-count='" + i + "']").hide();
            $(this).html("Cancel");
            ren = false;
        }
        else {
            var i = $(this).data("count");
            $(".tdcode[data-count='" + i + "']").hide();
            $(".tdname[data-count='" + i + "']").hide();
            $(".sdcode[data-count='" + i + "']").show();
            $(".sdname[data-count='" + i + "']").show();
            $(this).html("Rename")
            $(".btnSubsSav[data-count='" + i + "']").hide();
            $(".btnSubsDel[data-count='" + i + "']").show();
            ren = true;
        }
    });
    $(".btnSubsSav").click(function () {
        var i = $(this).data("count");
        var dcodec = /^[A-Za-z]{2}[0-9]{4}$/;
        var dnamec = /^[\w- ]+$/;
        var dcode = $(".tdcode[data-count='" + i + "']").val();
        var dname = $(".tdname[data-count='" + i + "']").val();
        if (dcodec.test(dcode)) {
            if (dnamec.test(dname)) {
                $.ajax({
                    url: "subs/savesubs.php",
                    data: {
                        "dept": $("#dcode").val(),
                        "odcode": $(".sdcode[data-count='" + i + "']").html(),
                        "odname": $(".sdname[data-count='" + i + "']").html(),
                        "ndcode": $(".tdcode[data-count='" + i + "']").val(),
                        "ndname": $(".tdname[data-count='" + i + "']").val()
                    },
                    success: function (e) {
                        switch (e) {
                            case "a": alert("The Department already exists"); $(".btnSubsRen[data-count='" + i + "']").click(); loadSubss(); break;
                            case "s": loadSubss(); break;
                            default: loadSubss();
                        }
                    }
                });
            }
            else {
                alert("Invalid Department Name");
                return;
            }
        }
        else {
            alert("Invalid Department Code");
            return;
        }

    });
</script>