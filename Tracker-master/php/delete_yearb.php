<<?php
include '../Rules/dbconfig.php';

$tutorID=$_REQUEST['tutorID'];

$tutorDetails= mysql_query("DELETE FROM Tutor WHERE Graduation_Year='$tutorID'");

?>