<?php
include("../common/config.php");
$query = "SELECT content FROM st_notifications";
$result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
$i = 1;
echo "<div class='note'>";
if(!($row = mysqli_fetch_row($result))) {
    echo "<span r>Currently there is no Notifications for you !</span>";
}
else
{
    do
    {
        echo "<div style='word-wrap: break-word; position: absolute; width: 250px; display: none' data-count='".$i."'>".$row[0]."</div>";
        $i+=1;
    } while($row = mysqli_fetch_row($result));
}
echo "</div>";
?>
<script>
    $(function () {
        var i = 1;
        $(".note div[data-count='1']").fadeIn(500);
        loopNotes = function () {
            $(".note div[data-count='" + i + "']").fadeOut(500);
            i += 1;
            if (i > $(".note div").length) i = 1;
            $(".note div[data-count='" + i + "']").fadeIn(500);
        }
        setInterval(function () { loopNotes(); }, 2500);
    })
</script>