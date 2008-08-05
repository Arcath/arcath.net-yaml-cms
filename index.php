<?php
//*********************************************
//Arcath.net CMS
//
//Coded By:
//	-Arcath (arcath@spacis.co.uk)
//
//Version 0.1
//*********************************************
//Include config file
$starttime=microtime();
include('config/system.php');
$template->head();
echo(content($_GET['var']));
$template->foot();
$endtime=microtime();
$timetaken=$endtime-$startime;
echo('Page loaded in '.$timetaken.'ms');
?>
