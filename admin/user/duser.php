<h2>Delete Users</h2>
<section style="overflow: auto">
<div style="float: left; width: 47%">
<br>Insert the Roll Numbers of Users to be deleted : <br><br>
<input type="text" value="8142" name="ccode" class="text" id="ccode" style="width: 75px; text-align: center" max="4">
<input type="text" value="13" name="syear" class="text" id="syear" style="width: 50px; text-align: center" max="2">
<select name="dcode" id="dcode" class="text">
<?php 
include_once("../../common/config.php");
$query = "SELECT * FROM st_departments ORDER BY dCode";
$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
while($row = mysqli_fetch_row($result))
{
    echo "<option value=".$row[0].">".$row[0]." - ".$row[1]."</option>";
}
?>
</select>
<br><br>
<input type="text" id="ucode" name="ucode" class="text"><br><br>
<input type="button" id="btnUserCreate" value="Delete" class="btn"><br><br>
<div id="creatUserStatus" style="height: 30px;"></div>
</div>
<div class="alert" style="float: left; width: 47%; margin-top: 20px;">
    <h2>Formats for putting more than one number as input:</h2>
    <ul>
        <li>Set College Code and Department Code: They will be prepended for every Roll Number</li>
        <li><span r>Spaces will be trimmed: Don't enter spaces between numbers; "1 2" will be taken as "12"</span></li>
        <li>Use "<span g>1-45</span>": for deleting sequential Roll Numbers from 001 to 045 </li>
        <li>Use "<span g>1,2,5,10...</span>": for deleting specific Roll Numbers i.e. 001, 002, 005, 010, ...</li>
        <li>Use "<span g>1-5,10-23</span>": for deleting sets of sequential Roll Numbers</li>
        <li>Use "<span g>1-5,7</span>": for the combination of 001, 002 ... 005, 007</li>
        <li>Use "<span g>1</span>": for deleting only the Roll Number 001</li>
    </ul>
</div>
</section>
<script>
    $("#btnUserCreate").click(function (e) {        
        $(this).attr("disabled", "disabled");
        var fail = 0;
        var succ = 0;
        var i = $("#ucode").val();
        var coll = $("#ccode").val();
        var year = $("#syear").val();
        var dept = $("#dcode").val();
        i = i.replace(/\s/g, "");
        var constraint = /(^([0-9]+[,-])+?[0-9]+$)|(^[0-9]+$)/;
        if (!constraint.test(i)) {
            alert("1: Invalid Expression: " + i);
            $(this).removeAttr("disabled");
            return;
        }
        var a = i.split(",");
        if (a != "") {
            for (n = 0; n < a.length; ++n) {
                var conh = /^[0-9]{1,3}-[0-9]{1,3}$/;
                var conc = /^[0-9]{1,3}$/;
                if (conh.test(a[n])) {
                    var range = a[n].split("-");
                    var ll = parseInt(range[0]);
                    var ul = parseInt(range[1]);
                    if (ul < ll) {
                        alert("2: Invalid Expression: " + a[n]);
                        $(this).removeAttr("disabled");
                        return;
                    }
                    for (m = ll; m <= ul; ++m) {
                        var app = "";
                        if (m < 10) app = "00";
                        else if (m < 100) app = "0";
                        _insert(coll + year + dept + app + Number(m));
                    }
                    $("#btnUserCreate").removeAttr("disabled");
                }
                else if (conc.test(a[n])) {
                    var app = "";
                    if (a[n] < 10) app = "00";
                    else if (a[n] < 100) app = "0";
                    _insert(coll + year + dept + app + Number(a[n]));
                }
                else {
                    alert("3: Invalid Expression: " + a[n]);
                    $(this).removeAttr("disabled");
                    return;
                }
            }
        }
        function _insert(uname) {
            $.ajax({
                url: "user/delete.php",
                data: { "uname": uname, "perm": "U" },
                beforeSend: function (e) {
                    $("#creatUserStatus").html("Deleting User, " + uname + " ...");
                },
                success: function (e) {
                    $("#creatUserStatus").html(e);
                },
                complete: function(){
                    $("#btnUserCreate").removeAttr("disabled");
                }
            });
        }
    });
</script>