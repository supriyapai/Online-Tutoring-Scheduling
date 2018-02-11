<?php
	include 'LoginCheck.php';
	include '../Rules/dbconfig.php';

?>

<html>
<body>
        

<?php

$contenttype = $_GET["q"];
if($contenttype == "C")
{
    $cancle1 = mysql_query("SELECT Cancel FROM Email_Content");
    $cancle2 = mysql_fetch_array($cancle1);
    $cancle = $cancle2[Cancel];
    echo "$cancle"; 
}
elseif($contenttype == "R")
{
    $reschedule1 = mysql_query("SELECT Reschedule FROM Email_Content");
    $reschedule2 = mysql_fetch_array($reschedule1);
    $reschedule = $reschedule2[Reschedule];
    echo "$reschedule";
}
elseif($contenttype == "BL")
{
    $blocked1 = mysql_query("SELECT Block FROM Email_Content");
    $blocked2 = mysql_fetch_array($blocked1);
    $blocked = $blocked2[Block];
    echo "$blocked";
}
elseif($contenttype == "UB")
{
    $unblock1 = mysql_query("SELECT Unblock FROM Email_Content");
    $unblock2 = mysql_fetch_array($unblock1);
    $unblock = $unblock2[Unblock];
    echo "$unblock";
}
//Added By: Parul Joshi Dated: 09/02/2015 Task : to fetch Drop Session related info from database
elseif($contenttype == "DS"){
    $dropsession1 = mysql_query("SELECT DropSession FROM Email_Content ");
    $dropsession2 = mysql_fetch_array($dropsession1);
    $dropsession = $dropsession2[DropSession];
    echo "$dropsession";
}
?>
