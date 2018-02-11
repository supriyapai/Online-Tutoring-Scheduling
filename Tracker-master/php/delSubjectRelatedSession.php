<?php
include '../Rules/dbconfig.php';

// Edited By: Parul Joshi Dated: 08/17/2015
$tutorID=$_REQUEST['tutorID'];
$subID=$_REQUEST['subID'];


$tutor = mysql_query("DELETE FROM `Student_Tutor_Allocation_Main` WHERE `Tutor_Poly_Id` ='$tutorID' AND `Subject`= '$subID' ")or die(mysql_error());
$result = mysql_query($tutor);
?>