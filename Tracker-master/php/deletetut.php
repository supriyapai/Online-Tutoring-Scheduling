<?php
include '../Rules/dbconfig.php';


$tutorID=$_REQUEST['tutorID'];
//Takes string of tutorid to create an array an seperate by a comma
$tutorID = explode(",", $tutorID);
foreach ($tutorID as $tID) {
	$tutorDetails1 = mysql_query("DELETE FROM Student_Tutor_Allocation_Main WHERE 
	Tutor_Poly_Id=$tID");

	$tutorDetails2=mysql_query("DELETE FROM Tutor WHERE Tutor_Poly_Id=$tID");
	//echo($tutorID);
}
//pass back array to see contents of array
echo json_encode(array('data' => $tutorID));
?>