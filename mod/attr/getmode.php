<div id="attrMode" style="overflow: auto">
    <span f>Show Report As: </span>
    <div class="tab" data-type="sub">Per Subject</div>
    <div class="tab" data-type="stu">Per Student</div>
    <div class="tab exp" data-type="exp" style="">Export Report</div>
</div>
<hr style="margin: 10px 0px; clear: both">
<div id="attrInputSpace"></div>
<script>
    var selectedMode = "";
    var modani = false;
    var tabClick = function () {
        var tab = $(this);
        if (!modani)
            if (selectedMode != tab.data("type")) {
                modani = true;
                $("#attrMode .tab").removeClass("selected");
                tab.addClass("selected");
                selectedMode = tab.data("type");
                $("#attrGenReport").slideUp(500, function () {
                    $("#attrInputSpace").fadeOut(100, function () {
                        $("#attrInputSpace").html("");
                        $.ajax({
                            url: "attr/getspace.php",
                            data: { "mode": tab.data("type"), "dp": $("#sDept").val() },
                            success: function (e) {
                                $("#attrInputSpace").html(e);
                            },
                            complete: function () {
                                $("#attrInputSpace").fadeIn(500, function () { modani = false; });
                                $("html, body").animate({ 'scrollTop': $("#attrInputSpace").offset().top }, 500);
                            }
                        });
                    });

                });
            }
    }
    $("#attrMode .tab").bind("click", tabClick);    
</script>