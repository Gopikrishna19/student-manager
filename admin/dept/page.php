<div id="deptcontainer" class="table"></div>
<button class="btnplus" id="btnDeptAdd" style="display: none"></button>
<script>
    $(function () {
        var avail = true;
        $("#btnDeptAdd").click(function () {
            if (avail) {
                var toapp = "<div class='row' id='rowDeptAdd'>";
                toapp += "<div d><input type='text' id='cdcode' class='text'></div>";
                toapp += "<div d><input type='text' id='cdname' class='text'></div>";
                toapp += "<div d><button id='btnDeptCreate' class='btn' g>Create</button>";
                toapp += "<button id='btnDeptCancel' class='btn'>Cancel</button></div></div>";
                $("#deptcontainer").append(toapp);
                avail = false;
                $(this).hide();
                $("#btnDeptCancel").bind("click", btnDeptCancel_Click);
                $("#btnDeptCreate").bind("click", btnDeptCreate_Click);
            }
        });
        btnDeptCancel_Click = function () {
            avail = true;
            $("#rowDeptAdd").remove();
            $("#btnDeptAdd").show();
        }
        btnDeptCreate_Click = function () {
            var dcodec = /^[0-9]+$/;
            var dnamec = /^[\w ]+$/;
            var dcode = $("#cdcode").val();
            var dname = $("#cdname").val();
            if (dcodec.test(dcode)) {
                if (dnamec.test(dname)) {
                    $.ajax({
                        url: "dept/creatdept.php",
                        data: { "dcode": dcode, "dname": dname },
                        success: function (e) {
                            switch (e) {
                                case "a": alert("Department Already Exists"); break;
                                case "s":
                                default: avail = true; $("#btnDeptAdd").show(); loadDepts();
                            }

                        }
                    });
                }
                else {
                    alert("Invalid Department Name");
                    return;
                }
            }
            else {
                alert("Invalid Department Code");
                return;
            }
        }
        loadDepts = function () {
            $("#btnDeptAdd").fadeOut(250);
            $("#deptcontainer").fadeOut(500, function () {
                $.ajax({
                    url: "dept/getdept.php",
                    success: function (e) {
                        $("#deptcontainer").html("<div class='row'><div h>Code</div><div h>Department</div><div h>Actions</div></div>");
                        $("#deptcontainer").append(e)
                    },
                    complete: function () {
                        $("#deptcontainer").fadeIn(500);
                        $("#btnDeptAdd").fadeIn(250);
                    }
                });
            });
        }
        loadDepts();
    });
</script>