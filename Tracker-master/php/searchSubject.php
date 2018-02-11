<!-- this php script populates the list for the email subjects when you want to edit the email contents or subjects -->


<?php
	include 'LoginCheck.php';
?>
<?php

include '../Rules/dbconfig.php';

?>

<html>
<body>
<?php
$subjecttype = $_GET["q"];
if($subjecttype == "C"){
    $cancle1 = mysql_query("SELECT Cancel FROM Email_Content WHERE Type='Subject'");
    $cancle2 = mysql_fetch_array($cancle1);
    $cancle = $cancle2[Cancel];
    echo "$cancle"; 
}elseif($subjecttype == "R"){
    $reschedule1 = mysql_query("SELECT Reschedule FROM Email_Content WHERE Type='Subject'");
    $reschedule2 = mysql_fetch_array($reschedule1);
    $reschedule = $reschedule2[Reschedule];
    echo "$reschedule";
}elseif($subjecttype == "BL"){
    $blocked1 = mysql_query("SELECT Block FROM Email_Content WHERE Type='Subject'");
    $blocked2 = mysql_fetch_array($blocked1);
    $blocked = $blocked2[Block];
    echo "$blocked";
}elseif($subjecttype == "UB"){
    $unblock1 = mysql_query("SELECT Unblock FROM Email_Content WHERE Type='Subject'");
    $unblock2 = mysql_fetch_array($unblock1);
    $unblock = $unblock2[Unblock];
    echo "$unblock";
}
//Added By: Parul Joshi Dated: 09/02/2015 Task : to fetch Drop Session related info from database
elseif($subjecttype == "DS"){
    $dropsession1 = mysql_query("SELECT DropSession FROM Email_Content WHERE Type='Subject'");
    $dropsession2 = mysql_fetch_array($dropsession1);
    $dropsession = $dropsession2[DropSession];
    echo "$dropsession";
}
?>
