<?php session_start(); ?>
<fieldset id="passChange">
	<legend
		style="border: 2px groove #484; padding: 2px 5px; font-weight: bold; border-radius: 20px; margin-left: 20px">Change
		Pasword</legend>
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
			<td rowspan="2" id="passNotMatch"
				style="background: url(../../images/brac.png) no-repeat left center; padding-left: 20px; display: none; vertical-align: middle; max-width: 300px">
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
			<td><button id="btnPassSave" class="btn" g>Save</button>
				<button id="btnPassCancel" class="btn">Cancel</button></td>
		</tr>
	</table>
	<div id="ajaxPassResult" style="display: none"></div>
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
                $("#passNotMatch").fadeIn(250);
            }
            else if (conpass != newpass) {
                $("#passNotMatch span").html("Your Passwords do not match");
                $("#passNotMatch").fadeIn(250);
            }
            else {
                $.ajax({
                    url: "../common/sets/cpass.php",
                    data: { "oldpass": oldpass, "newpass": newpass },
                    success: function (e) {
                        $("#oldPassWrong").fadeOut(100);
                        $("#passNotMatch").fadeOut(100);
                        var sr = 0;
                        switch (e) {
                            case "s":
                                $("#ajaxPassResult").html("<span g>Password successfully changed</span>");
                                $("fieldset#passChange input").attr("value", "");
                                sr = 1; break;
                            case "f": $("#ajaxPassResult").html("<span r>Failed to change the password</span>"); sr = 1; break;
                            case "w":
                                $("#oldPassWrong span").html("Your Password is wrong");
                                $("#oldPassWrong").fadeIn(100); break;
                            default: alert(e);
                        }
                        if (sr) {
                            $("#ajaxPassResult").slideDown(500, function () {
                                setTimeout(function () { $("#ajaxPassResult").slideUp(250); sr = 0; }, 5000);
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
<?php if($_SESSION['st_user_prev']!="A") { ?>
<fieldset id="nameChange"
	style="padding: 30px 10px 20px 30px; border-width: 2px 0px 0px; border-color: #484 #000 #600; border-style: groove">
	<legend>Change Display Name</legend>
	<table>
		<tr>
			<td>New Name</td>
			<td>:</td>
			<td><input type="text" id="newname" class="text"></td>
			<td id="oldNameWrong" style="display: none"><span r></span></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td><button id="btnNameSave" class="btn" g>Save</button></td>
		</tr>
	</table>
	<div id="ajaxNameResult"></div>
</fieldset>
<script>
    $(function () {
        $("#btnNameSave").click(function () {
            var newpass = $("#newname").val();            
            var constraint = /(^[0-9A-Za-z-_. ]+$)/;
            if (newpass.trim() == "") {
                $("#oldNameWrong span").html("The fields cannot be empty");
                $("#oldNameWrong").fadeIn(100);
            }
            else {
                $.ajax({
                    url: "../common/sets/cname.php",
                    data: { "name": newpass },
                    success: function (e) {
                        $("#oldNameWrong").fadeOut(100);
                        var sr = 0;
                        switch (e) {
                            case "s":
                                $("#ajaxNameResult").html("<span g>Display name successfully changed.<br>Re-Log-In to apply changes.</span>");
                                $("fieldset#nameChange input").attr("value", "");
                                sr = 1; break;
                            case "f": $("#ajaxNameResult").html("<span r>Failed to change the name</span>"); sr = 1; break;
                            case "w":
                                $("#oldNameWrong span").html("Couldn't locate your credentials.<br>Refresh the browser and retry.");
                                $("#oldNameWrong").fadeIn(100); break;
                            default: alert(e);
                        }
                        if (sr) {
                            $("#ajaxNameResult").slideDown(500, function () {
                                setTimeout(function () { $("#ajaxNameResult").slideUp(250); sr = 0; }, 5000);
                            });
                        }
                    }
                })
            }
        });
    });
</script>
<?php
}
if ($_SESSION ['st_user_prev'] == "A") {
	?>
<fieldset id="emptyDB" style="">
	<legend>Reset Application</legend>
	<span r>!!! Empties all data from Database and Resets the Application as new</span> <br>
	<span r>!!! Caution: CANNOT be UNDONE</span> <br>
	<button id="btnReset" r class="btn">RESET</button>
	</td>
</fieldset>
<script type="text/javascript">
$("#btnReset").click(function(){
	$.ajax({
		url:"../common/sets/reset.php", 
		success: function(e){ 
			if(e=='s')	window.location.href="/";
			alert(e);
		}
	});
});
</script>
<?php }?>