<fieldset id="passChange" style="padding: 30px 10px 20px 30px; border-width: 2px 0px 0px; border-color: #484 #000 #600; border-style: groove">
    <legend style="border: 2px groove #484; padding: 2px 5px; font-weight: bold; border-radius: 20px; margin-left: 20px">Change Pasword</legend>
    <table>
        <tr>
            <td>Old Password</td>
            <td>:</td>
            <td><input type="password" id="oldpass" class="text"></td>
            <td id="oldPassWrong" style="display: none"><span r></span></td>
        </tr>
        <tr>
            <td>New Password</td>
            <td>:</td>
            <td><input type="password" id="newpass" class="text"></td>
            <td rowspan="2" id="passNotMatch" style="background: url(../../images/brac.png) no-repeat left center;
                 padding-left: 20px; display: none; vertical-align: middle; max-width: 300px">
                <span r></span>
            </td>
        </tr>
        <tr>
            <td>Confirm</td>
            <td>:</td>
            <td><input type="password" id="conpass" class="text"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td><button id="btnPassSave" class="btn" g>Save</button> <button id="btnPassCancel" class="btn">Cancel</button></td>
        </tr>
    </table>
    <div id="ajaxResult"></div>
</fieldset>
<script>
    $(function () {
        $("#btnPassSave").click(function () {
            $("#oldPassWrong").fadeOut(100);
            $("#passNotMatch").fadeOut(100);
            var oldpass = $("#oldpass").val();
            var newpass = $("#newpass").val();
            var conpass = $("#conpass").val();
            var constraint = /(^[0-9A-Za-z-_. #$]{6,}$)/;
            if (oldpass.trim() == "" || newpass.trim() == "" || newpass.trim() == "") {
                $("#oldPassWrong span").html("The fields cannot be empty");
                $("#oldPassWrong").fadeIn(100);
            }
            else if (!constraint.test(newpass) || !constraint.test(conpass)) {
                $("#passNotMatch span").html("Your Passwords can only contain ");
                $("#passNotMatch span").append("A-Z, a-z, 0-9 , -, _, ., space, #, $ ");
                $("#passNotMatch span").append("and must be at least 6 characters long");
                $("#passNotMatch").fadeIn(500);
            }
            else if (conpass != newpass) {
                $("#passNotMatch span").html("Your Passwords do not match");
                $("#passNotMatch").fadeIn(500);
            }
            else {
                $.ajax({
                    url: "sets/change.php",
                    data: { "oldpass": oldpass, "newpass": newpass },
                    success: function (e) {
                        $("#oldPassWrong").fadeOut(100);
                        $("#passNotMatch").fadeOut(100);
                        var sr = 0;
                        switch (e) {
                            case "s":
                                $("#ajaxResult").html("<span g>Password successfully changed</span>");
                                $("fieldset#passChange input").attr("value", "");
                                sr = 1; break;
                            case "f": $("#ajaxResult").html("<span r>Failed to change the password</span>"); sr = 1; break;
                            case "w":
                                $("#oldPassWrong span").html("Your Password is wrong");
                                $("#oldPassWrong").fadeIn(100); break;
                            default: alert(e);
                        }
                        if (sr) {
                            $("#ajaxResult").fadeIn(500, function () {
                                setTimeout(function () { $("#ajaxResult").fadeOut(500); sr = 0; }, 5000);
                            });
                        }
                    }
                })
            }
        });
        $("#btnPassCancel").click(function () {
            $("fieldset#passChange input").attr("value", "");
        })
    });
</script>