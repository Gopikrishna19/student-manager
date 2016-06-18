<h2>Create Moderators</h2>
<section style="overflow: auto">
<div style="float: left; width: 47%">
<br>
Insert the names of the Moderators to be created : <br><br>
<input type="text" id="ucode" name="ucode" class="text"><br><br>
<input type="button" id="btnUserCreate" value="Create" class="btn"><br><br>
<div id="creatUserStatus" style="height: 30px;"></div>
</div>
<div class="alert" style="float: left; width: 47%; margin-top: 20px;">
    <h2>Formats for putting more than one number as input:</h2>
    <ul>
        <li><span r>Spaces will be trimmed: Don't enter spaces inbetween</span></li>
        <li>Use "<span g>[name],[name]</span>": for creating more than one Moderator</li>
        <li>View "<span g>Users &amp; Permissions</span>": to understand about Moderators</li>
    </ul>
</div>
</section>
<script>
    $("#btnUserCreate").click(function (e) {
        $(this).attr("disabled", "disabled");
        var i = $("#ucode").val();
        i = i.replace(/\s/g, "");
        var constraint = /(^([0-9A-Za-z]+[,])+?[0-9A-Za-z]+$)|(^[0-9A-Za-z]+$)/;
        if (!constraint.test(i)) {
            alert("1: Invalid Expression: " + i);
            $(this).removeAttr("disabled");
            return;
        }
        var a = i.split(",");
        if (a !== null) {
            for (n = 0; n < a.length; ++n) {
                constraint = /(^[0-9a-zA-Z]+$)/;
                if (!constraint.test(a[n])) {
                    alert("1: Invalid Expression: " + a[n]);
                    $(this).removeAttr("disabled");
                    return;
                } else _insert(a[n]);
            }
        }
        function _insert(uname) {
            $.ajax({
                url: "user/creatmod.php",
                data: { "uname": uname },
                beforeSend: function (e) {
                    $("#creatUserStatus").html("Creating User, " + uname + " ...");
                },
                success: function (e) {
                    $("#creatUserStatus").html(e);
                },
                complete: function () {
                    $("#btnUserCreate").removeAttr("disabled");
                }
            });
        }
    });
</script>