<section style="overflow: auto">
    <div style="width: 72%; float: left">
        <div id="notecontainer" class="table"></div>
        <button class="btnplus" id="btnNoteAdd"></button>
    </div>
<div class="alert" style="float: right; width: 22%">
    <h2>Instructions</h2>
    <ul>
        <li>Use <span b>{h}...{-h}</span> for Headings
            <ul><li b>Usage: <span b>{h}<span g> Heading </span>{-h}</span></li></ul>
        </li>
        <li>Use <span b>{p}...{-p}</span> for Paragraphs
            <ul><li b>Usage: <span b>{p}<span g> Paragraph </span>{-p}</span></li></ul>
        </li>
        <li>Use <span b>{b}</span> for linebreaks
            <ul><li b>Usage: <br><span g>First Line<span b> {b} </span>Second Line</span></li></ul>
        </li>
        <li>Any other Markups will be displayed as is</li>
    </ul>
</div>
</section>
<script>
    $(function () {
        var avail = true;
        $("#btnNoteAdd").click(function () {
            if (avail) {
                var toapp = "<div class='row' id='rowNoteAdd'>";
                toapp += "<div d style='width: 450px'><textarea id='cncontent' class='text' style='width: 440px' rows='5'>";
                toapp += "</textarea></div><div d style='width:175px'><button id='btnNoteCreate' class='btn' g>Create</button>";
                toapp += "<button id='btnNoteCancel' class='btn'>Cancel</button></div></div>";
                $("#notecontainer").append(toapp);
                avail = false;
                $(this).hide();
                $("#btnNoteCancel").bind("click", btnNoteCancel_Click);
                $("#btnNoteCreate").bind("click", btnNoteCreate_Click);
            }
        });
        btnNoteCancel_Click = function () {
            avail = true;
            $("#rowNoteAdd").remove();
            $("#btnNoteAdd").show();
        }
        btnNoteCreate_Click = function () {
            var ncontent = $("#cncontent").val();
            ncontent = ncontent.replace(/</g, "&lt;");
            ncontent = ncontent.replace(/>/g, "&gt;");
            ncontent = ncontent.replace(/\{[bB]\}/g, "<br>");
            ncontent = ncontent.replace(/\{[pP]\}((.*))\{-[pP]\}/g, "<p>$1</p>");
            ncontent = ncontent.replace(/\{[hH]\}((.*))\{-[hH]\}/g, "<h6>$1</h6>");
            $.ajax({
                url: "note/creatnote.php",
                data: { "ncontent": ncontent },
                success: function (e) {
                    avail = true;
                    $("#btnNoteAdd").show();
                    loadNotes();
                }
            });

        }
        loadNotes = function () {
            $("#btnNoteAdd").toggle();
            $("#notecontainer").fadeOut(500, function () {
                $.ajax({
                    url: "note/getnote.php",
                    success: function (e) {
                        var head = "<div class='row'><div h style='width: 450px'>Notifications</div>";
                        head += "<div h style='width: 175px;'>Actions</div></div>";
                        $("#notecontainer").html(head);
                        $("#notecontainer").append();
                        $("#notecontainer").append(e);
                        $("#notecontainer").fadeIn(500);
                        $("#btnNoteAdd").fadeIn(500);
                    },
                    error: function (e) {
                        $("#notecontainer").html("Error Accessing Database<br>");
                    }
                });
            });
        }
        loadNotes();
    });
</script>