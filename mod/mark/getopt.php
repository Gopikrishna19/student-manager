<hr style="margin: 10px 0px">
<br style="margin: 10px 0px; clear: both">
<div id="enterMode">
<span f>Input Method:</span>
<div class="tab" data-type="ent">Enter</div>
<div class="tab" data-type="imp">Import</div>
</div>
<div id="divMarkRoll"></div></div>
<script>
    var selectedMode = "";
    var modani = false;
    var tabClick = function () {
        var tab = $(this);
        if (!modani)
            if (selectedMode != tab.data("type")) {
                modani = true;
                $("#enterMode .tab").removeClass("selected");
                tab.addClass("selected");
                selectedMode = tab.data("type");
                $("#divMarkRoll").fadeOut(100, function () {
                    $("#divMarkRoll").html("");
                    var urloc = "mark/get" + (tab.data("type") == "ent" ? "roll" : "imp") + ".php";
                    $.ajax({
                        url: urloc,
                        data: { "dp": $("#sDept").val(), "bt": $("#sBatch").val() },
                        success: function (e) { $("#divMarkRoll").html(e); },
                        complete: function () { 
                            $("#divMarkRoll").fadeIn(500, function () { modani = false; });
                            $("html, body").animate({ 'scrollTop': $("#divMarkRoll").offset().top }, 500);
                        }
                    });

                });
            }
    }
    $("#enterMode .tab").bind("click", tabClick);    
</script>