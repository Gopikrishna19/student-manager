<?php
if (($_FILES["file"]["type"] == "application/vnd.ms-excel" ))
{
	if ($_FILES["file"]["error"] > 0)
    {
    	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  	else
    {
    	echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    	echo "Type: " . $_FILES["file"]["type"] . "<br />";
   		move_uploaded_file($_FILES["file"]["tmp_name"], "uploaded.csv");
    }
}
else
{
    echo "Invalid file";
}
?>