<?php
//Establishing a connection with the host
                include '../Rules/dbconfig.php';
?>

<?php
if (isset($_POST['submit'])){ 
	$session1=mysql_query("CREATE TABLE TempStudent
						 (Student_Poly_Id bigint(10),
						  Student_First_Name varchar(100),
						  Student_Last_Name varchar(100),
						  Student_MI varchar(100),
						  Student_Phone_No bigint(20),
						  Student_Email varchar(100),
						  No_Of_Subjects int(11),
						  Subject_1  int(11),
						  Subject_2     int(11),
						  Subject_3   int(11),
						  Subject_4     int(11),
						  Subject_5     int(11),
						  Subject_6     int(11),
						   Active varchar(100),
						 Student_Status varchar(100),
						 Lateness int(11),
						 Presence int(11),
						 No_Shows       int(11),
						 Cancellations          int(11),
						 Reschedules    int(11),
						  Block         int(11)
						  )");
												  
	$file=$_FILES['csv']['tmp_name'];
	echo $file;
	$handel= fopen($file, "r");
	while(($fileop=fgetcsv($handel,1000,",")) !==false){
		$Student_Poly_Id=$fileop[0];
		$Student_First_Name=$fileop[1];
		$Student_Last_Name=$fileop[2];
		$Student_MI=$fileop[3];
		$Student_Phone_No=$fileop[4];
		$Student_Email=$fileop[5];
		$No_Of_Subjects=$fileop[6];
		$Subject_1=$fileop[7];
		$Subject_2=$fileop[8];
		$Subject_3=$fileop[9];
		$Subject_4=$fileop[10];
		$Subject_5=$fileop[11];
		$Subject_6=$fileop[12];
		$Active=$fileop[13];
		$Student_Status=$fileop[14];
		$Lateness=$fileop[15];
		$Presence=$fileop[16];
		$No_Shows=$fileop[17];
		$Cancellations=$fileop[18];
		$Reschedules=$fileop[19];
		$Block=$fileop[20];
			 
	 $session2=mysql_query("INSERT INTO TempStudent (Student_Poly_Id,
		 Student_First_Name,Student_Last_Name,Student_MI,Student_Phone_No,
		 Student_Email,No_Of_Subjects,Subject_1,Subject_2,Subject_3,
		 Subject_4,Subject_5,Subject_6,Active,Student_Status,Lateness,
		 Presence,No_Shows,Cancellations,Reschedules,Block) Values ('$Student_Poly_Id','$Student_First_Name',
		 '$Student_Last_Name','$Student_MI','$Student_Phone_No','$Student_Email','$No_Of_Subjects','$Subject_1',
		 '$Subject_2','$Subject_3','$Subject_4','$Subject_5',
		 '$Subject_6','$Active','$Student_Status','$Lateness','$Presence','$No_Shows',
		 '$Cancellations','$Reschedules','$Block')");
		}
	if ($sql){
		echo 'data upload successfully';
	 }
	$session3=mysql_query("update Student,TempStudent
                          set Student.Student_First_Name = TempStudent.Student_First_Name,
                              Student.Student_Last_Name= TempStudent.Student_Last_Name,
                                                  Student.Student_MI = TempStudent.Student_MI,
                                                  Student.Student_Phone_No = TempStudent.Student_Phone_No,
                                                  Student. Student_Email = TempStudent. Student_Email,
                                                  Student.No_Of_Subjects = TempStudent.No_Of_Subjects,
                                                  Student.Subject_1 = TempStudent.Subject_1,
                                                  Student.Subject_2 = TempStudent.Subject_2,
                                                  Student.Subject_3 = TempStudent.Subject_3,
                                                  Student.Subject_4 = TempStudent.Subject_4,
                                                  Student.Subject_5 = TempStudent.Subject_5,
                                                  Student.Subject_6 = TempStudent.Subject_6,
                                                  Student.Active= TempStudent.Active,
                                                  Student.Student_Status = TempStudent.Student_Status,
                                                  Student.Lateness = TempStudent.Lateness,
                                                  Student.Presence = TempStudent.Presence,
                                                  Student.No_Shows = TempStudent.No_Shows,
                                                  Student.Cancellations = TempStudent.Cancellations,
                                                  Student.Reschedules = TempStudent.Reschedules,
                                                  Student.Block= TempStudent.Block
           where Student.Student_Poly_Id = TempStudent.Student_Poly_Id");
              
	$session4 = mysql_query("DROP TABLE TempStudent");    
	if($session1&$session2&$session3&$session4){
		$A = "Content Updated";
	}else{
		$B = "Unable To Update";
	}
	echo $session1; echo $session2; echo $session3; echo $session4;
}
?>
                
<html>
<head>
    <title>Bulk Update</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
        <link rel="stylesheet" type="text/css" href="../css/studentblock.css" />
<script type="text/javascript" src="../js/addbulk.js">
</script>

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
	<div id="text2"><p>Bulk Update Information</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<br><br><br> 
	<center>
	<div class="ex">
	<div class = "back">
	<form  action = "bulkupdate.php" name="form1" id="form1" method = "post" enctype="multipart/form-data" onsubmit="return ExtensionsOkay();">
	<table>
	<br><br>
		<tr>
			<td>Select the file to upload: &nbsp &nbsp</td>
			<td>
			  <input type="file" name="csv"  />
			</td>
			</tr>
			<tr>
			</tr>
		
	</table>
    <br>
        <button type="submit" name="submit"><img src="../images/generate.png"  width="102" height="28" border="none"/></a></button>      
</form>
	<div class = "mesg1"> <?php  echo "$A" ;?> </div>
	<div class = "mesg2"> <?php  echo "$B" ;?> </div>
</body>
</html>