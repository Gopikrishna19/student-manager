<div id="analysMode" style="overflow: auto">
	<span f style="width: 150px;">Do Analysis with respect to: </span>
	<div class="tab" data-type="sub">Subject</div>
	<div class="tab" data-type="stu">Student</div>
</div>
<hr style="margin: 10px 0px; clear: both">
<div id="analysInputSpace"></div>
<script>
var subselmode = "";
var submodani = false;
var subTabClick = function () {
    var tab = $(this);
    if (!submodani)
        if (subselmode != tab.data("type")) {
            submodani = true;
            $("#analysMode .tab").removeClass("selected");
            tab.addClass("selected");
            subselmode = tab.data("type");
            $("#marrGenReport").slideUp(500, function () {
                $("#analysInputSpace").fadeOut(100, function () {
                    $("#analysInputSpace").html("");
                    $.ajax({
                        url: "marr/getspace.php",
                        data: { "mode": subselmode, "dp": $("#sDept").val(), "page": "genanalys" },
                        success: function (e) {
                            $("#analysInputSpace").html(e);
                        },
                        complete: function () {
                            $("#analysInputSpace").fadeIn(500, function () { submodani = false; });
                            $("html, body").animate({ 'scrollTop': $("#analysInputSpace").offset().top }, 500);
                        },
                        error: function () {
                            alert("Error");
                        }
                    });
                });

            });
        }
}
$("#analysMode .tab").bind("click", subTabClick);
</script>