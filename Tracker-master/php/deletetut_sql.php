<?php
/*Edited By: Parul Joshi 
Dated: 08/25/2015 
Task: to delete all Tutors from Database and check if any session for tutors exist*/

/*Edited by: Parul Joshi Dated:08/26/2015 Task: Removed the studentID variable */
include '../Rules/dbconfig.php';
$sessionDetails = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main");
if(mysql_num_rows($sessionDetails)){
	echo 'true';
}else{
	$tutorDetails1 = mysql_query("SET FOREIGN_KEY_CHECKS = 0"); 
		if($tutorDetails1){
		$check= mysql_query("TRUNCATE Tutor; "); 
		if($check){
			mysql_query("SET FOREIGN_KEY_CHECKS = 1");
		}
	echo 'done';
	}else{
		echo 'error';
	}
}
?>