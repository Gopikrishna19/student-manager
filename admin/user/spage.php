<br>
<div id="userSPage">
    <div style="float: left">Select a User Type to <?php echo $_REQUEST["mode"] == "c" ? "Create" : "Delete"; ?>: </div>
    <div class="tab" data-page="user">Users</div>
    <div class="tab" data-page="mod">Moderators</div>
    <?php if($_REQUEST["mode"]=="d") { ?><div class="tab" data-page="apage">Delete All</div> <?php } ?>
    <input type="hidden" value="<?php echo $_REQUEST["mode"]; ?>" id="SPTabMode">
</div>
<br>
<hr style="clear: left; margin-top: 10px;">
<div id="userMethod"></div>
<script>
    var selectedSPTab = "";
    var userL2anime = false;
    $("#userSPage .tab").click(function () {
        var tab = $(this);
        if (!userL2anime)
            if (selectedSPTab != tab.data("page")) {
                userL2anime = true;
                $("#userSPage .tab").removeClass("selected");
                selectedSPTab = tab.data("page");
                tab.addClass("selected");
                $("#userMethod").fadeOut(500, function () {
                    $.ajax({
                        url: "user/" + $("#SPTabMode").val() + tab.data("page") + ".php",
                        success: function (e) {
                            $("#userMethod").html(e);
                        },
                        complete: function () {
                            $("#userMethod").fadeIn(500, function () {
                                userL2anime = false;
                            });
                        }
                    });
                });
            }
    });
</script>