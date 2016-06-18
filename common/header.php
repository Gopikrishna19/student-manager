<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $pt; ?> | Student Portal</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $pp; ?>styles/domstyle.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $pp; ?>styles/cusstyle.css">
        <script src="<?php echo $pp; ?>scripts/jquery.js" type="text/javascript"></script>
        <script src="<?php echo $pp; ?>scripts/prescript.js" type="text/javascript"></script>
    </head>
    <body>
        <noscript>
            <meta content="0;../no_js" http-equiv="refresh">
        </noscript>
        <div id="wrapper">
            <div id="header">
                <div class="center-it">
                    <div id="nav">
                        <ul>
<?php 
include_once("menu.php"); 
switch($pm)
{
    case "a": adminMenu(); break;
    case "h": homeMenu(); break;
    case "u": userMenu(); break;
    case "m": modMenu(); break;
}
?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="strip"></div>
            <section id="content">
            <div id="main-content" class="center-it">
