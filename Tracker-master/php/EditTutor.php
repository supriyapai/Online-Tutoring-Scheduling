<!-- This page allows you to select the tutor who is present in the database to be edited.-->

<?php 
	include 'LoginCheck.php';
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
	include '../Rules/days.php';
?>
<html>
<head>
    <title>Edit Tutor Information</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/edittutor.css" />
<script type = "text/javascript">
function validateForm(){
	var x=document.forms["myForm"]["poly_id"].value;
	if (x==null || x=="---SELECT---"){
	alert("Select Tutor");
	return false;
	}
}
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
		<div id="text2"><p>Edit Tutor Information</p></div>
        <div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<form name = "myForm" action = "EditTutorInfo.php" onsubmit="return validateForm()" method = "post">
	<?php
	$tutorDetails1 = mysql_query(" SELECT `Tutor_First_Name`, `Tutor_Last_Name`, `Tutor_Poly_Id` FROM Tutor ORDER BY Tutor_Last_Name ");
	while($tutorDetails2 = mysql_fetch_array($tutorDetails1) ){
		$tutorFirstName[] = $tutorDetails2[Tutor_First_Name];
		$tutorLastName[] = $tutorDetails2[Tutor_Last_Name];
		$tutorPolyId[]       = $tutorDetails2[Tutor_Poly_Id];
	}
	$no1 = count($tutorPolyId);
	for($a=0; $a<$no1; $a++){
		$tutorName[] = $tutorLastName[$a]." ".$tutorFirstName[$a];
	}
?>
<center>
    <div class="ex">
	<div class="back">
<br><br>
<table>
    <tr>
		<td><label for="name">Tutor Name :</label></td>
		<br>
	<td>
	<select name = "poly_id">
		<option>---SELECT---</option>
		<?php
			for($b=0;$b<$no1;$b++){
				echo "<option value=$tutorPolyId[$b]>$tutorName[$b]</option>";
			}
		?>
	</select>
	</td>
    </tr>    
        <tr></tr>
		
        <tr>
        </tr>
        <tr></tr>
</table>
<br><br>
<button type="submit" name="edit"><img src="../images/edit.png"  width="102" height="28" border="none"/></a></button>
<div class="mesg"><?php echo $error; ?></div>
</div>
</div>
</form>
</center>
</div>
</body>
</html>
