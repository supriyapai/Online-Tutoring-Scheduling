<?php
	include '../Rules/dbconfig.php';
	$id = $_GET["id"];
	$sessionTime = $_GET["time"];
	$conv1 = $_GET["date"];
	$conv2 = strtotime($conv1);
	$sessionDate = date('Y-m-d',$conv2);
	
	$tutorcheck1 = mysql_query("SELECT `Tutor_Poly_Id` FROM `Student_Tutor_Assignment` WHERE `Date` = '$sessionDate' AND `Session_Time` = '$sessionTime' AND `Student_Poly_Id` = '$id' ");
			while ($tutorcheck2 = mysql_fetch_array($tutorcheck1)){
			$tutorcheck[] = $tutorcheck2[Tutor_Poly_Id];
		}
	$tutorcount =count($tutorcheck);
	if($tutorcount>0){
		echo "<style onload='test();'></style>";
	}else{
	$studentcheck1 = mysql_query("SELECT `Student_Poly_Id`,`Subject_Id`, `Assignment_Id` FROM `Student_Tutor_Assignment` WHERE `Date` = '$sessionDate' AND `Session_Time` = '$sessionTime' AND `Tutor_Poly_Id` = '$id' ");
		while ($studentcheck2 = mysql_fetch_array($studentcheck1)){
			$studentcheck[] = $studentcheck2[Student_Poly_Id];
			$subject[] = $studentcheck2[Subject_Id];
			$assignmentId[] = $studentcheck2[Assignment_Id];
		}	 
		$checkcount = count($studentcheck);
		if($studentcheck==0){
			echo "Sorry!! No Such Session Found";
		}else{	
			echo "<select name='studentInfo'>";
			echo "<option value=''>---SELECT---</option>";
			for($i=0;$i<$checkcount;$i++){
				$studentnames1 = mysql_query("SELECT `Student_First_Name`, `Student_Last_Name` FROM Student WHERE Student_Poly_Id = '$studentcheck[$i]' ");
				$studentnames2 = mysql_fetch_array($studentnames1);
				$studentnamesfn = $studentnames2[Student_First_Name];
				$studentnamesln = $studentnames2[Student_Last_Name];
				$studentname = $studentnamesfn." ".$studentnamesln;
				
				$subname1 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subject[$i]' ");
				$subname2 = mysql_fetch_array($subname1);
				$subname = $subname2[Subject];

				echo "<option value='$studentcheck[$i],$subject[$i],$assignmentId[$i]'>${studentname}_${subname}</option>";
			}
		}	
	}
?>
        
</body>
</html>


