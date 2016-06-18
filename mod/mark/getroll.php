<hr style="margin: 10px 0px; clear: both">
<span f>Enter Roll Number: </span><input type="text" class="text" id="sRoll">
<button class="btn" id="btnMarkGenFields" g>Generate Fields</button>
<div id="divMarkFields" style="display: none;"></div>
<script>
    $("#btnMarkGenFields").click(function () {
        var constraint = /^[0-9]{1,3}$/;
        if (!constraint.test($("#sRoll").val())) { alert("Invalid Input"); return; }
        $("#divMarkFields").slideUp(250, function () {
            $("#divMarkFields").html("");
            $.ajax({
                url: "mark/genfld.php",
                data: {
                    "dp": $("#sDept").val(), "bt": $("#sBatch").val(),
                    "sm": $("#sSem").val(), "sb": $("#sSub").val(),
                    "rn": $("#sRoll").val()
                },
                success: function (e) {
                    $("#divMarkFields").html(e);
                },
                complete: function () {
                    $("#divMarkFields").slideDown(500, function () {
                        $("html, body").animate({ 'scrollTop': $("#divMarkFields").offset().top }, 500);
                    });
                }
            });
        })
    });
</script>