<hr style="margin: 10px 0px; clear: both">
<div class="alert">
	<h2>Instructions</h2>
	<ul>
		<li>Select the Examination for which the marks are to be entered</li>
		<li>Enter the Roll Numbers in the first column and Marks in the second
			column of the Excel Sheet; Use 'AB' or 'ab' for absentees</li>
		<li>Use grades (S, A, B, C, D, E, U) in case of grades</li>
		<li>Enter <span rr>only the last digit</span> of the Roll Numbers (as
			shown below)
		</li>
		<li>Save the Excel Sheet as CSV (Comma Separated Values) file (as
			shown below)</li>
		<li>Upload the file and click GO</li>
	</ul>
	<br>
	<div
		style="background-image: url(../images/ultut.gif); background-position: -12px 0px; background-repeat: no-repeat; height: 150px; background-size: auto 100%;"></div>
</div>
<br>
<span f>Examination:</span>
<select id="examMode" class="text">
	<option value="unit1">Unit test 1</option>
	<option value="unit2">Unit test 2</option>
	<option value="unit3">Unit test 3</option>
	<option value="unit4">Unit test 4</option>
	<option value="unit5">Unit test 5</option>
	<option value="model1">Model Exam 1</option>
	<option value="model2">Model Exam 1</option>
	<option value="model3">Model Exam 1</option>
	<option value="univ">University Exam</option>
</select>
<br>
<br>
<span f>&nbsp;</span>
<input type="file" id="importMarkFile" class="btn" accept="text/csv" r>
<input type="button" value="Go" class="btn" g id="btnSubmit">
<div id="fileImportOutput"></div>
<script>
    $("#importMarkFile").change(function (e) {
        var fd = new FormData();
        fd.append("file", $("#importMarkFile")[0].files[0]);
        $.ajax({
            url: "mark/import.php",
            type: 'POST',
            cache: false,
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#fileImportOutput").html("Uploading, please wait....");
            },
            success: function (e) {
                $("#fileImportOutput").html(e);
            }
        });
    });
    $("#btnSubmit").click(function (e) {
        var row = {};
        row["dp"] = $("#sDept").val();
        row["bt"] = $("#sBatch").val();
        row["sm"] = $("#sSem").val();
        row["sb"] = $("#sSub").val();
        row["tt"] = $("#examMode").val();    	      
        $.ajax({
            url: "mark/popmark.php",
            data: row,
            beforeSend: function () {
                $("#fileImportOutput").html("Saving Marks, please wait....");
            },
            success: function (e) {
                $("#fileImportOutput").html(e);
                var control = $("#importMarkFile");
                control.replaceWith( control = control.val('').clone( true ) );
            }
        });
    });
</script>