<?php
include("../../common/config.php");
$query = "SELECT * FROM st_departments";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
$i = 1;
while($row = mysqli_fetch_row($result))
{
    echo "<div class='row'>".
         "<div d ><span class='sdcode' data-count='".$i."'>".$row[0]."</span>".
            "<input type='text' class='text tdcode' style='display: none;' value='".$row[0]."' data-count='".$i."'></div>".
         "<div d ><span class='sdname' data-count='".$i."'>".$row[1]."</span>".
            "<input type='text' class='text tdname' style='display: none;' value='".$row[1]."' data-count='".$i."'></div>".
         "<div d>".
            "<button class='btn btnDeptDel' b data-count='".$i."'>Delete</button>".
            "<button class='btn btnDeptSav' g data-count='".$i."' style='display: none;'>Save</button>".
            "<button class='btn btnDeptRen' data-count='".$i."'  >Rename</button>".
         "</div></div>";
    $i += 1;
}
?>
<script>
    var ren = true;
    $(".btnDeptDel").click(function () {
        var i = $(this).data("count");
        var dcode = $(".sdcode[data-count='" + i + "']").html();
        var dname = $(".sdname[data-count='" + i + "']").html();
        $.ajax({ url: "dept/deldept.php", data: { "dcode": dcode, "dname": dname }, success: function (e) { loadDepts(); } });
    });
    $(".btnDeptRen").click(function () {
        if (ren) {
            var i = $(this).data("count");
            $(".tdcode[data-count='" + i + "']").show();
            $(".tdname[data-count='" + i + "']").show();
            $(".sdcode[data-count='" + i + "']").hide();
            $(".sdname[data-count='" + i + "']").hide();
            $(".btnDeptSav[data-count='" + i + "']").show();
            $(".btnDeptDel[data-count='" + i + "']").hide();
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
            $(".btnDeptSav[data-count='" + i + "']").hide();
            $(".btnDeptDel[data-count='" + i + "']").show();
            ren = true;
        }
    });
    $(".btnDeptSav").click(function () {
        var i = $(this).data("count");
        var dcodec = /^[0-9]+$/;
        var dnamec = /^[\w- ]+$/;
        var dcode = $(".tdcode[data-count='" + i + "']").val();
        var dname = $(".tdname[data-count='" + i + "']").val();
        if (dcodec.test(dcode)) {
            if (dnamec.test(dname)) {
                $.ajax({
                    url: "dept/savedept.php",
                    data: {
                        "odcode": $(".sdcode[data-count='" + i + "']").html(),
                        "odname": $(".sdname[data-count='" + i + "']").html(),
                        "ndcode": $(".tdcode[data-count='" + i + "']").val(),
                        "ndname": $(".tdname[data-count='" + i + "']").val()
                    },
                    success: function (e) {
                        switch (e) {
                            case "a": alert("The Department already exists"); $(".btnDeptRen[data-count='" + i + "']").click(); break;
                            case "s": loadDepts(); break;
                            default: loadDepts();
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

    })
</script>