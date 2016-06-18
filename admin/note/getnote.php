<?php
include("../../common/config.php");
$query = "SELECT * FROM st_notifications";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
$i = 1;
while($row = mysqli_fetch_row($result))
{
    echo "<div class='row'>".
         "<span class='sdcode' data-count='".$i."' style='display: none'>".$row[0]."</span>".
         "<div d style='width: 450px'><span class='sdname' data-count='".$i."' style='word-wrap: break-word'>".$row[1]."</span>".
            "<textarea class='tdname text' style='width: 440px; display: none;' rows='5' data-count='".$i."'>".$row[1]."</textarea></div>".
         "<div d style='width: 175px'>".
            "<button class='btn btnNoteDel' b data-count='".$i."'>Delete</button>".
            "<button class='btn btnNoteSav' g data-count='".$i."' style='display: none;'>Save</button>".
            "<button class='btn btnNoteRen' data-count='".$i."'  >Edit</button>".
         "</div></div><hr style='margin: 10px 0px;'>";
    $i += 1;
}
?>
<script>
    var ren = true;
    $(".btnNoteDel").click(function () {
        var i = $(this).data("count");
        var dcode = $(".sdcode[data-count='" + i + "']").html();
        var dname = $(".sdname[data-count='" + i + "']").html();
        $.ajax({ url: "note/delnote.php", data: { "dcode": dcode }, success: function (e) { loadNotes(); } });
    });
    $(".btnNoteRen").click(function () {
        if (ren) {
            var i = $(this).data("count");
            var ncontent = $(".tdname[data-count='" + i + "']").val();
            ncontent = ncontent.replace(/<br>/g, "{b}");
            ncontent = ncontent.replace(/<p>/g, "{p}");
            ncontent = ncontent.replace(/<\/p>/g, "{-p}");
            ncontent = ncontent.replace(/<h6>/, "{h}");
            ncontent = ncontent.replace(/<\/h6>/, "{-h}");
            $(".tdname[data-count='" + i + "']").html(ncontent);
            $(".tdname[data-count='" + i + "']").show();
            $(".sdname[data-count='" + i + "']").hide();
            $(".btnNoteSav[data-count='" + i + "']").show();
            $(".btnNoteDel[data-count='" + i + "']").hide();
            $(this).html("Cancel");
            ren = false;
        }
        else {
            var i = $(this).data("count");
            $(".tdname[data-count='" + i + "']").hide();
            $(".sdname[data-count='" + i + "']").show();
            $(this).html("Edit")
            $(".btnNoteSav[data-count='" + i + "']").hide();
            $(".btnNoteDel[data-count='" + i + "']").show();
            ren = true;
        }
    });
    $(".btnNoteSav").click(function () {
        var i = $(this).data("count");
        var ncontent = $(".tdname[data-count='" + i + "']").val();
        ncontent = ncontent.replace(/</g, "&lt;");
        ncontent = ncontent.replace(/>/g, "&gt;");
        ncontent = ncontent.replace(/\{[bB]\}/g, "<br>");
        ncontent = ncontent.replace(/\{[pP]\}((.*))\{-[pP]\}/g, "<p>$1</p>");
        ncontent = ncontent.replace(/\{[hH]\}((.*))\{-[hH]\}/g, "<h6>$1</h6>");
        $.ajax({
            url: "note/savenote.php",
            data: {
                "odcode": $(".sdcode[data-count='" + i + "']").html(),
                "ndname": ncontent
            },
            success: function (e) {
                loadNotes();
            }
        });
    });
</script>