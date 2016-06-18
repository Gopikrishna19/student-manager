<section style="overflow: auto;">
	<div style="float: left; width: 40%">
		Select a Department : <select id="dcode" class="text">
			<option value="0"></option>
			<?php
			include_once ("../../common/config.php");
			$query = "SELECT * FROM st_departments ORDER BY dCode";
			$result = mysqli_query ( $dbc, $query ) or die ( mysqli_error ( $dbc ) );
			while ( $row = mysqli_fetch_row ( $result ) ) {
				echo "<option value=" . $row [0] . ">" . $row [0] . " - " . $row [1] . "</option>";
			}
			?>
		</select>
	</div>
	<div style="width: 59%; float: left;">
		<div class="alert" style="padding: 1px 15px 10px 25px">
			<h2>Steps</h2>
			<ul>
				<li>The subject code is always entered in this format: <span bb>[XX][0000]</span></li>
				<li>Use custom subject codes for subjects that have no code assigned
					<ul>
						<li>Example: <span g>LB1000</span> for Library
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</section>
<hr style="margin: 10px 0px">
<div id="subscontainer" class="table"></div>
<button class="btnplus" id="btnSubsAdd" style="display: none"></button>
<script>
    $(function () {
        var avail = true;
        $("#btnSubsAdd").click(function () {
            if (avail) {
                var toapp = "<div class='row' id='rowSubsAdd'>";
                toapp += "<div d><input type='text' id='cdcode' class='text'></div>";
                toapp += "<div d style='width: 300px'><input type='text' id='cdname' class='text' style='width: 290px'></div>";
                toapp += "<div d><button id='btnSubsCreate' class='btn' g>Create</button>";
                toapp += "<button id='btnSubsCancel' class='btn'>Cancel</button></div></div>";
                $("#subscontainer").append(toapp);
                avail = false;
                $(this).hide();
                $("#btnSubsCancel").bind("click", btnSubsCancel_Click);
                $("#btnSubsCreate").bind("click", btnSubsCreate_Click);
            }
        });
        btnSubsCancel_Click = function () {
            avail = true;
            $("#rowSubsAdd").remove();
            $("#btnSubsAdd").show();
        }
        btnSubsCreate_Click = function () {
            var dcodec = /^[A-Za-z]{2}[0-9]{4}$/;
            var dnamec = /^[\w ]+$/;
            var dcode = $("#cdcode").val();
            var dname = $("#cdname").val();
            if (dcodec.test(dcode)) {
                if (dnamec.test(dname)) {
                    $.ajax({
                        url: "subs/creatsubs.php",
                        data: { "dept": $("#dcode").val(), "dcode": dcode.toUpperCase(), "dname": dname },
                        success: function (e) {
                            switch (e) {
                                case "a": alert("Subject Already Exists"); break;
                                case "s":
                                default: avail = true; $("#btnSubsAdd").show(); loadSubss();
                            }

                        }
                    });
                }
                else {
                    alert("Invalid Subject Name");
                    return;
                }
            }
            else {
                alert("Invalid Subject Code");
                return;
            }
        }
        loadSubss = function (dept) {
            dept = dept || $("#dcode").val();
            $("#btnSubsAdd").fadeOut(250);
            $("#subscontainer").fadeOut(500, function () {
                $.ajax({
                    url: "subs/getsubs.php",
                    data: { "dept": dept },
                    success: function (e) {
                        $("#subscontainer").html("<div class='row'><div h>Code</div><div h style='width: 300px'>Subject</div><div h>Actions</div></div>");
                        $("#subscontainer").append(e);
                        $("#subscontainer").fadeIn(250);
                        $("#btnSubsAdd").fadeIn(250);
                    },
                    error: function (e) {
                        $("#subscontainer").html("Error Aceesing Database<br>");
                    }
                });
            });
        }
        $("#dcode").change(function () {
            $("#btnSubsAdd").fadeOut(250);
            avail = true;
            if ($(this).val() != 0) loadSubss($(this).val());
            else $("#subscontainer").fadeOut(500, function () { $(this).html(""); });
        });
    });
</script>