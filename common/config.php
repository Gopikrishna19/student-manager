<?php

$config = parse_ini_file("config.ini",true);
$mode = "st_config_imp";
$db_host = $config[$mode]['host'];
$db_name = $config[$mode]['username'];
$db_pass = $config[$mode]['password'];
$db_data = $config[$mode]['database'];

$dbc = mysqli_connect($db_host,$db_name,$db_pass,$db_data) or die(mysqli_error());

?>