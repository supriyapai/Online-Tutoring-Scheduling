<!--Created By : Parul Joshi
Dated: 09/01/2015
Task: to display more than one multiple sessions which can be edited by user
-->

<?php
include 'LoginCheck.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';
?>
<?php	include '../Rules/dbconfig.php'; ?>

<html>
<head>
	<title>Edit Multiple Sessions</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/editsession.css" />
	<link rel="stylesheet" href="../css/datepicker.css"/>
	<script src="jquery 1.9.1.js"></script>
	<script src="jQuery UI.js"></script>
</head>
<body>
<?php
	$Sid = $_GET["var1"];
	$Tid = $_GET["var2"];
	$Sub = $_GET["var3"];
	
	$studentdetails1 = mysql_query(" SELECT * FROM Student WHERE `Student_Poly_Id`='$Sid'");
	$studentdetails2 = mysql_fetch_array($studentdetails1);
	$studentFirstName = $studentdetails2[Student_First_Name];
	$studentLastName = $studentdetails2[Student_Last_Name];
	$studentName = $studentLastName." ".$studentFirstName;
	
	$tutorDetails1 = mysql_query(" SELECT * FROM Tutor WHERE `Tutor_Poly_Id`='$Tid'");
	$tutorDetails2 = mysql_fetch_array($tutorDetails1);
	$tutorFirstName = $tutorDetails2[Tutor_First_Name];
	$tutorLastName = $tutorDetails2[Tutor_Last_Name];
	$tutorName = $tutorLastName." ".$tutorFirstName;
	
	$allocate_subjects1 = mysql_query("SELECT * FROM Subject WHERE `Subject_Id`='$Sub'");
	$allocate_subjects2 = mysql_fetch_array($allocate_subjects1);
	$Subject = $allocate_subjects2[Subject];
?>

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
	<div id="text2">Edit Multiple Sessions </div>
	<form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
	


<center>
<div class="ex">
<div class = "back">
<br>
	<center>
	Student: <?php echo $studentName?> <br>
	Tutor: <?php echo $tutorName?> <br>
	Subject: <?php echo $Subject?> 	<br>
	<br>
	<table>
		<?php 
	$allocateid1 = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id`='$Sid' AND `Tutor_Poly_Id` = '$Tid' AND `Subject` = '$Sub' ");
	while($allocateid2 = mysql_fetch_array($allocateid1)){
		$flag=0;
		$allocateid = $allocateid2[Allocate_Id];
		$date1 = $allocateid2[Session_Start_Date];
		$date2 = strtotime($date1);
		$startdate = date('Y-m-d',$date2);
		$date3 = $allocateid2[Session_End_Date];
		$date4 = strtotime($date3);
		$enddate = date('Y-m-d',$date4);
		$currentdate=date("Y-m-d");
		if($startdate != $enddate){
			if($enddate>$currentdate){
				$flag=1;
				echo "<tr>";
				echo "<td>Session: </td>";
				echo "<td><label> $startdate to $enddate</label></td>";
				echo "<td>";
				echo "<a href='EditMultipleSessionInfo.php?var1=$Sid&var2=$Tid&var3=$Sub&var4=$date1&var5=$date3&var6=$allocateid'>";
				echo "<img src='../images/edit.png'  width='100' height='28' border='none'/>";
				echo "</a>";
				echo "<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> ";
				echo "</td>";
				echo "</tr>";
			}else{
				$A="Multiple sessions for this input has already ended";
			}
		}
	}
	if($flag==0){
			$A="Sorry! No Multiple Sessions exist for this input !!";
	}
	if(isset($_POST["back"])){
		$url="EditMultipleSession.php";
		header("Location:$url");
	}
	?>
	</table>
	</center>
	
		<br>
		<button type="submit" name="back"><img src="../images/back.png"  width="100" height="28" border="none"/></a></button>
			<div class = "mesg"> <?php  echo "$A" ;?> </div>
			<div class = "mesg2"> <?php  echo "$B" ;?> </div>
</div>
</div>
</form>
</center>
</div>
</body>
</html>
