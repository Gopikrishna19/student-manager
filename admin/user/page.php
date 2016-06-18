<div id="userOPage">
    <div style="float: left">Select an Operation </div>
    <div class="tab" data-type="c">Create</div>
    <div class="tab" data-type="d">Delete</div>
</div>
<br>
<hr style="clear: left; margin-top: 10px;">
<div id="userOperMethod"></div>
<script>
    var selectedTab = "";
    var userL1anime = false;
    $("#userOPage .tab").click(function () {
        var tab = $(this);
        if (!userL1anime)
            if (selectedTab !== tab.data("type")) {
                userL1anime = true;
                $("#userOPage .tab").removeClass("selected");
                tab.addClass("selected");
                selectedTab = tab.data("type");
                $("#userOperMethod").fadeOut(500, function () {
                    $.ajax({
                        url: "user/spage.php",
                        data: { "mode": tab.data("type") },
                        success: function (e) {
                            $("#userOperMethod").html(e);
                        },
                        complete: function () {
                            $("#userOperMethod").fadeIn(500, function () {
                                userL1anime = false;
                            });
                        }
                    });
                });
            }
    });
</script>