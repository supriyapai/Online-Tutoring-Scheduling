<?php
include '../Rules/dbconfig.php';

$studentID=$_REQUEST['studentID'];

$studentDetails1 = mysql_query("DELETE FROM Student WHERE Class_Status='$studentID'");

echo($studentID);

?>