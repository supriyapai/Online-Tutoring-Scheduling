<?php

/*
Author: Jordan Brutus
        Date: 7/20/2013
        
        Filename: Delete.php 
        Supporting Files: deletetut.php, delete_people.js, mainmenu.css
*/

session_start();
session_cache_expire(30);


include '../Rules/dbconfig.php';
include '../Rules/datepicker.php';

$studentDetails1 = mysql_query(" SELECT `Student_First_Name`, `Student_Last_Name`, `Student_Poly_Id` 

FROM Student ORDER BY Student_Last_Name ");
while($studentDetails2 = mysql_fetch_array($studentDetails1) ){
    $studentFirstName[] = $studentDetails2[Student_First_Name];
    $studentLastName[] = $studentDetails2[Student_Last_Name];
    $studentPolyId[]       = $studentDetails2[Student_Poly_Id];
}
$no1 = count($studentPolyId);
for($a=0; $a<$no1; $a++){
    $studentName[] = $studentLastName[$a]." ".$studentFirstName[$a];
}
?>

<!DOCTYPE HTML>
<html>
<head>

<meta charset="utf-8" />
<title>Delete</title>
<link type="text/css" rel="stylesheet" href="../css/mainmenu.css" />
<script type="text/javascript" src="../js/delete_people.js">
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
	<div id="signout"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></div>
	<div id="inputboxbackground_del"></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<div id="text2"><center><p>Delete Student Information</p></center></div>
	<br><center>
	<div id="confirm" style="z-index:800; position: relative;">
	</div></center>
	<center>
		<div id="text5" style="z-index:800; position: relative;"> 
		<p>&nbsp; &nbsp;Deleting student or tutor will permanently delete the session allocations for the students or tutors.</p>
		<p>Always <b>SAVE</b> before you <b>DELETE</b>.</p>
		</div>
	</center>
<div id="dropdown" style="z-index:800; position: relative;">
        <table border="0">
        <tr>
		<center><td><p>Student Name:&nbsp; &nbsp;</p></td>
        <form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
        <td>
			<select name = "poly_id" id="poly_id" multiple >            
                <?php
                        for($b=0;$b<$no1;$b++)
                        {
                                echo "<option value=$studentPolyId[$b]>$studentName[$b]</option>";
                        }
                ?>
			</select>
		</td>
        </tr>
        </form>
        </table>
<br><br>
</center>
</div>
<div id="deletebut" style="z-index:800; position: relative;">
<center>
<button type="submit" name="delete" onclick="validateForm();" value="Delete"><img src="../images/delete.png"  width="102" height="28" border="none"/></button></center>
</div>
</div>
</body>
</html>