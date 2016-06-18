<h2>Delete All Users and Moderators</h2>
<br>
<input type="button" id="btnUserCreate" value="Delete All" class="btn"><br><br>
<div id="creatUserStatus" style="height: 30px;"></div>
<script>
    $("#btnUserCreate").click(function (e) {
        if (confirm("This option will completely DELETE ALL \nthe USERS and MODERATORS. \n\nAre you sure want to proceed?")) {
            $.ajax({
                url: "user/dall.php",
                success: function (e) {
                    $("#creatUserStatus").html("Deleted ALL Modererators and Users");
                },
                complete: function () {
                    $("#btnUserCreate").removeAttr("disabled");
                }
            });
        }
    });
</script>