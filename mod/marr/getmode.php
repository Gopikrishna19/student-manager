<div id="marrMode" style="overflow: auto">
	<span f>Show Report As: </span>
	<div style="display: block; overflow: auto; clear: left; float: left">
		<div class="tab" data-type="sub">Per Subject</div>
		<div class="tab" data-type="stu">Per Student</div>
		<div class="tab" data-type="anl">Analysis</div>
		<div class="tab exp" data-type="exp" style="">Export Report</div>
	</div>
</div>
<hr style="margin: 10px 0px; clear: both">
<div id="marrInputSpace"></div>
<script>
    var selectedMode = "";
    var modani = false;
    var tabClick = function () {
        var tab = $(this);
        if (!modani)
            if (selectedMode != tab.data("type")) {
                modani = true;
                $("#marrMode .tab").removeClass("selected");
                tab.addClass("selected");
                selectedMode = tab.data("type");
                $("#marrGenReport").slideUp(500, function () {
                    $("#marrInputSpace").fadeOut(100, function () {
                        $("#marrInputSpace").html("");
                        if(selectedMode == "anl")
                        	$.ajax({
                                url: "marr/getanalys.php",                                
                                success: function (e) {
                                    $("#marrInputSpace").html(e);
                                },
                                complete: function () {
                                    $("#marrInputSpace").fadeIn(500, function () { modani = false; });
                                    $("html, body").animate({ 'scrollTop': $("#marrInputSpace").offset().top }, 500);
                                },
                                error: function () {
                                    alert("Error");
                                }
                            }); 
                        else
                        $.ajax({
                            url: "marr/getspace.php",
                            data: { "mode": selectedMode, "dp": $("#sDept").val() },
                            success: function (e) {
                                $("#marrInputSpace").html(e);
                            },
                            complete: function () {
                                $("#marrInputSpace").fadeIn(500, function () { modani = false; });
                                $("html, body").animate({ 'scrollTop': $("#marrInputSpace").offset().top }, 500);
                            },
                            error: function () {
                                alert("Error");
                            }
                        });
                    });

                });
            }
    }
    $("#marrMode .tab").bind("click", tabClick);    
</script>