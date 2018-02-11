<!-- This page displays Reports based on the selections made on Reports by time period -->
<?php
//Establishing a connection with the host
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';              
?>
<html>
<head>
    <title>Report - Time Period</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/reports.css" />
</head>
<body>
    <div id="container">
<div class="menu">
		<ul>
			<li><a class="hide" href="">INPUT</a>
			<ul>
				<li><a href="CreateT.php">Tutor Information</a></li>
				<li><a href="CreateS.php">Student Information</a></li>
				<li><a href="Allocate.php">Student-Tutor Allocation</a></li>
				<li><a href="Course.php">Course Information</a></li>
			</ul>
			</li>
			<li><a class="hide" href="">EDIT</a>
			<ul>
				<li><a href="EditTutor.php">Tutor Information</a></li>
				<li><a href="EditStudent.php">Student Information</a></li>
				<li><a class="EditSession.php">Student-Tutor Allocation ></a>
				<!--Edited By: Parul Joshi Dated: 09/03/2015 Task: To change Single Session & Multiple Session to Session type & Session Schedule
				(Session Schedule to Edit Single Session & Edit Multiple Session) -->
				<ul>
					<li><a href="EditOneSession.php">Session Type</a></li>
					<li><a class="EditSession.php">Session Schedule ></a>
					<ul>
						<li><a href="EditSingleSession.php">Edit Single Session</a></li>
						<li><a href="EditMultipleSession.php">Edit Multiple Sessions</a></li>
					</ul>
					</li>
				</ul>
				<!-- End -->
				</li>
				<li><a href="EditCourse.php">Course Information</a></li>
			</ul>
			</li>
			<li><a class="hide" href="">REPORT</a>
			<ul>
			<!--Shyam Joshi Begin of Code Changes May 2016 Added Reports by number-->
				<li><a href="number_of_sessions.php">Available Spaces</a></li>
				<li><a href="number_of_session_type.php">Session Type</a></li>
				<li><a href="SessionByDays.php">Attendance Report</a></li>
				<li><a href="SessionByType.php">By Session Type</a></li>
				<li><a href="SessionByGroup.php">By Group</a></li>				
				<li><a class="EditSession.php">Subject ></a>
					<ul>
						<li><a href="number_of_subject.php">Data Overview</a></li>						
						<li><a href="SessionBySubject.php">Subject Data</a></li>						
					</ul>
				</li>
				<li><a href="semesterEndReport.php">Semester End Report</a></li>
			<!--Shyam Joshi End of Code Changes May 2016 Added Reports by number-->
			</ul>
			</li>
			<li><a class="hide" href="">APPROVALS/CHANGES</a>
			<ul>
				<li><a href="StudentBlock.php">Student Block/Unblock</a></li>
				<li><a href="TutorBlock.php">Tutor Block/Unblock</a></li>
				<li><a href="SessionDrop.php">Drop Session</a></li>
			</ul>
			</li>
			<li><a class="hide" href="">DATA MANAGEMENT</a>
			<ul>
				<li><a href="#">Save ></a>
				<ul>
					<li><a href="SaveStudent.php">Student</a></li>
					<li><a href="SaveTutor.php">Tutor</a></li>
				</ul>
				</li>
				<li><a href="#">Bulk Changes > </a>
				<ul>
					<li><a href="bulkstudent.php">Student</a></li>
					<li><a href="bulktutor.php">Tutor</a></li>
				</ul>
				</li>
				<li><a href="refresh.php">New Semester Refresh</a></li>
				<li><a href="#">Delete ></a>
				<ul>
					<li><a href="DeleteS_Nav.php">Student</a></li>
					<li><a href="DeleteT_Nav.php">Tutor</a></li>
				</ul>
				</li>
			</ul>
			</li>
			<li><a class="hide" href=" ">ACCOUNT MANAGEMENT</a>
			<ul>
				<li><a class="hide">Email ></a>
				<ul>
					<li><a href="EditEmail.php">Change Email Address</a></li>
					<li><a href="EditSubject.php">Change Email Subject</a></li>
					<li><a href="EditContext.php">Change Email Content</a></li>
				</ul>
				</li>
				<li><a href="AccountManagement.php">Password</a></li>
			</ul>
			</li>
			<li><a class="hide" href="livereport.php">LIVE REPORT</a></li>
		</ul>
	</div>
	<div id="banner"><img src="../images/banner2.png"  width="1022" height="150" border="none"/></div>
	<div id="signout"><img src="../images/adminlogin.png" width="17" height="15" border="none" /></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
    <div class = "ex">
    <center>	
 <?php
	$Sname = $_POST["Sname"];
	$Tname = $_POST["Tname"];
	$fromedate1 = date("Y-m-d", strtotime($_POST["fromdate"]));
	$todate1 = date("Y-m-d", strtotime($_POST["todate"]));
	$sort = $_POST["sort"];
/* Shyam Joshi Begin of code change September 14, 2016
   changed the file name to be report name + from date
*/
	//$filename=strtotime("now").'.csv';

	$file_app_from_date = date("mdY",strtotime($_POST["fromdate"]));
	$filename='AttendanceReport_'.$file_app_from_date.'.csv'; 

/* Shyam Joshi End of code change September 14,2016 */
	/* Edited By: Parul Joshi Dated: 08/20/2015
			Task - changed folder from download to csv */
	$fp=fopen("../csv/" .$filename,"w");
	if($Sname == '---SELECT---'){
		echo "<br><br>Please Select Student Name";
	}elseif($Tname == '---SELECT---'){
		echo "<br><br>Please Select Tutor Name";
	}elseif($fromedate1 =='' || $todate1 ==''){
		echo "<br><br>Please Select Dates";
		break;
	}elseif($Sname == '' && $Tname == ''){
	$session1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort");
	}elseif($Sname == ''){
	  $session1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE Tutor_Poly_Id='$Tname' AND`Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort");
	}elseif($Tname == ''){
	$session1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE Student_Poly_Id='$Sname' AND `Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort");
	}else{
		echo "<br><br>Please Select Only one from Student and Tutor";
		break;
	}	  
	if($Sname == '' && $Tname == ''){
		$sql= mysql_query("SELECT  Tutor_First_Name, Tutor_Last_Name, Student_First_Name, Student_Last_Name,Subject, Session_Time,Session_Type,Date,
								Tutor_Current_Time as Tutor_Sign_In,  Student_Current_Time as Student_Sign_In, Tutor_Type , Student_Type
													 From Student natural join Student_Tutor_Assignment join Subject join Tutor 
													 WHERE Tutor.Tutor_Poly_ID=Student_Tutor_Assignment.Tutor_Poly_ID  and
						Subject.Subject_ID=Student_Tutor_Assignment.Subject_ID and 
											   `Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort");
	}elseif($Sname == ''){
		$sql= mysql_query("SELECT  Tutor_First_Name, Tutor_Last_Name, Student_First_Name, Student_Last_Name,Subject, Session_Time,Session_Type, Date,
								Tutor_Current_Time as Tutor_Sign_In,  Student_Current_Time as Student_Sign_In, Tutor_Type , Student_Type
													 From Student natural join Student_Tutor_Assignment join Subject join Tutor 
													 WHERE Tutor.Tutor_Poly_ID=Student_Tutor_Assignment.Tutor_Poly_ID  and
						 Subject.Subject_ID=Student_Tutor_Assignment.Subject_ID and Tutor.Tutor_Poly_Id='$Tname' AND
													`Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort");
	}elseif($Tname == ''){
		$sql = mysql_query("SELECT  Tutor_First_Name, Tutor_Last_Name, Student_First_Name, Student_Last_Name,Subject, Session_Time,Session_Type, Date,
								Tutor_Current_Time as Tutor_Sign_In,  Student_Current_Time as Student_Sign_In, Tutor_Type , Student_Type
													 From Student natural join Student_Tutor_Assignment join Subject join Tutor 
													 WHERE Tutor.Tutor_Poly_ID=Student_Tutor_Assignment.Tutor_Poly_ID  and
						Subject.Subject_ID=Student_Tutor_Assignment.Subject_ID and 
													Student_Poly_Id='$Sname' AND `Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort");
	}else{
		echo "<br><br>Please Select Only one from Student and Tutor";
		break;
	}
	$row= mysql_fetch_assoc($sql);
	$seperator="";
	$comma="";
	foreach($row as $name => $value){
		$seperator.=$comma.''.str_replace('','""',$name);
		$comma=",";
	}
	$seperator.="\n";
	fputs($fp,$seperator);
	mysql_data_seek($sql,0);
	while($row= mysql_fetch_assoc($sql)){
		$seperator="";
		$comma="";
		foreach($row as $name => $value){
			//Begin of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
			if($name == 'Session_Time'){
				$value = date('g:i a', strtotime($value));
			}
			//End of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
			$seperator.=$comma.''.str_replace('','""',$value);
			$comma=",";
		}
		$seperator.="\n";
		fputs($fp,$seperator);
	}
	fclose($fp);
	while($sessions2 = mysql_fetch_array($session1)){
		$assignmentid[] = $sessions2[Assignment_Id];
		$date[] = $sessions2[Date];
		$stype[] = $sessions2[Student_Type];
		$slogin[] = $sessions2[Student_Current_Time];
		$tlogin[] = $sessions2[Tutor_Current_Time];
		$ttype[] = $sessions2[Tutor_Type];
		$sessiontype[] = $sessions2[Session_Type];
		$sessiontime[] = $sessions2[Session_Time];
		$Sid[] = $sessions2[Student_Poly_Id];
		$Tid[] = $sessions2[Tutor_Poly_Id];
		$subid[] = $sessions2[Subject_Id];
	}
	$count = count($assignmentid);

	for($a=0; $a<$count; $a++){
		$student1 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$Sid[$a]'");
		$student2 = mysql_fetch_array($student1);
		$studentfn = $student2[Student_First_Name];
		$studentln = $student2[Student_Last_Name];
		$studentname[] = $studentfn." ".$studentln; 


		$tutor1 = mysql_query("SELECT * FROM Tutor WHERE Tutor_Poly_Id = '$Tid[$a]'");
		$tutor2 = mysql_fetch_array($tutor1);
		$tutorfn = $tutor2[Tutor_First_Name];
		$tutorln = $tutor2[Tutor_Last_Name];
		$tutorname[] = $tutorfn." ".$tutorln;

		$subject1 = mysql_query("SELECT * FROM Subject WHERE Subject_Id = '$subid[$a]'");
		$subject2 = mysql_fetch_array($subject1);
		$subject[] = $subject2[Subject];
	}
	echo "<br><br><br><br><br><br><div id=\"scroll\"><table border=\"1\" bordercolor=\"#52981a\" bgcolor=\"white\" style=\"text-align:center\">";
	echo "<tr bgcolor=\"e4e4e4\">";
	echo "<th>Tutor Name</th>";
	echo "<th>Student Name</th>";
	echo "<th>Subject</th>";
	echo "<th>Session Time</th>";
	//***Added by Kishan*********
	echo "<th>Session Type</th>";
	//***************************
	echo "<th>Date</th>";
	echo "<th>Tutor Sign In Time</th>";
	echo "<th>Student Sign In Time</th>";
	echo "<th>Tutor Type</th>";
	echo "<th>Student Type</th>";
	echo "</tr>";
	for($i=0; $i<$count; $i++){    
		echo "<tr>";
		echo "<td>$tutorname[$i]</td>";
		echo "<td>$studentname[$i]</td>";
		echo "<td>$subject[$i]</td>";		
//Begin of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
		//echo "<td>$sessiontime[$i]</td>";		
		echo "<td>".date('g:i a', strtotime($sessiontime[$i]))."</td>";
//End of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time	
		//***Added by Kishan*********
		echo "<td>$sessiontype[$i]</td>";
		//***************************
		echo "<td>$date[$i]</td>";
		echo "<td>$tlogin[$i]</td>";
		echo "<td>$slogin[$i]</td>";
		echo "<td>$ttype[$i]</td>";
		echo "<td>$stype[$i]</td>";
		echo "</tr>";
	}
echo "</table>";
?>
</center>
</div>
	<div id="text2">
		<p>Attendance Report</p>
			<br>
			<!-- Edited By: Parul Joshi Dated: 08/20/2015
			Task - to download the file from csv folder  
			Dated :12/22/2015
			Task: made links relative
			-->
			&nbsp <a href="../csv/<?php echo$filename;?>">Download Link</a>
		</div>
	</div>
</body>
</html>
