<?php
include '../Rules/dbconfig.php';

$studentID=$_REQUEST['studentID'];

$studentDetails1 = mysql_query("DELETE FROM Student WHERE Graduation_Year='$studentID'");

?>