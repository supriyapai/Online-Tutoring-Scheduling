<!--Created By: Parul Joshi 
Dated: 08/24/2015 
Task: to delete Tutor By Status from Database -->

<?php
include '../Rules/dbconfig.php';

$tutorStatus=$_REQUEST['tutorStatus'];

$tutorDetails1 = mysql_query("DELETE FROM Tutor WHERE Class_Status='$tutorStatus'");

echo($tutorStatus);

?>