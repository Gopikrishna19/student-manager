<div style="margin: auto; width: 400px">        
    <table style="margin: auto">
        <tr><td>User Id</td><td>:</td><td><input id="uname" type="text" class="text" autofocus="true"></td></tr>
        <tr><td>Password</td><td>:</td><td><input id="upass" type="password" class="text"></td></tr>
        <tr><td colspan="2"></td><td><button class="btn" g id="btnSubmit">Log In</button></td></tr>
    </table>     
    <div id="ajax-result" style="text-align: center; color: #600">&nbsp;</div>        
    <div wait><br><br>. . . Verfying . . .</div>
    <script>
        var wait = {
            "width": "150px",
            "text-align": "center",
            "height": "75px",
            "background-image": "url(../images/loader.gif)",
            "background-position": "center top",
            "background-repeat": "no-repeat",
            "margin": "25px auto",
            "opacity": 0
        };
        $(function () {
            $("div[wait]").css(wait);
            $("#btnSubmit").click(function (e) {
                $.ajax({
                    url: "login/login.php",
                    data: { "uname": $("#uname").val(), "upass": $("#upass").val() },
                    beforeSend: function (e) {
                        $("div[wait]").fadeTo(200, 1);
                    },
                    success: function (e) {
                        $("div[wait]").fadeTo(200, 0);
                        $("div#ajax-result").html(e);
                        $("div#ajax-result").fadeTo(200, 1);
                        setTimeout(function () { $("div#ajax-result").fadeTo(200, 0); }, 3000);
                    }
                });
            });
        })
    </script>
</div>