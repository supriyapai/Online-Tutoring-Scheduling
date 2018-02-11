<?php
include '../Rules/dbconfig.php';

$studentID=$_REQUEST['studentID'];
//Takes string of studentid to create an array an seperate by a comma
$studentID = explode(",", $studentID);
foreach ($studentID as $sID) {
	$studentDetails1 = mysql_query("DELETE FROM Student_Tutor_Allocation_Main WHERE 
	Student_Poly_Id=$sID");

	$studentDetails2=mysql_query("DELETE FROM Student WHERE Student_Poly_Id=$sID");
	//echo($studentID);
}
//pass back array to see contents of array
echo json_encode(array('data' => $studentID));
?>