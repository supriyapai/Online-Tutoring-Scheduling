<!-- Gives you a page where student details are displayed and they can be edited to update the database -->

<?php include 'LoginCheck.php'; ?>
<html>
<head>
    <title>Edit Student Information</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/editstudentinfo.css" />
	<script type = "text/javascript">
function validateForm() {
        var sln = document.forms["myForm"]["Sln"].value;
        if (sln == null || sln == "---SELECT---") {
            alert("Please Enter Student Last Name");
            return false;
        }
        var sfn = document.forms["myForm"]["Sfn"].value;
        if (sfn == null || sfn == "---SELECT---") {
            alert("Please Enter Student First Name");
            return false;
        }
        var sphone = document.forms["myForm"]["Sphone"].value;
        if (sphone == null || sphone == "---SELECT---") {
            alert("Please Enter Student Phone Number");
            return false;

        }
        var semail = document.forms["myForm"]["Semail"].value;
        if (semail == null || semail == "---SELECT---") {
            alert("Please Enter Student Email");
            return false;

        }
        var s1 = document.forms["myForm"]["Ssub1"].value;
        var s2 = document.forms["myForm"]["Ssub2"].value;
        var s3 = document.forms["myForm"]["Ssub3"].value;
        var s4 = document.forms["myForm"]["Ssub4"].value;
        var s5 = document.forms["myForm"]["Ssub5"].value;
        var s6 = document.forms["myForm"]["Ssub6"].value;
        if (s1 == null && s2 == null && s3 == null && s4 == null && s5 == null && s6 == null) {
            alert("Please Select Atleast one Subject");
            return false;
        }
</script>
<script type="text/javascript" src="../js/inputyear.js"></script>
</head>
<body onLoad="addOption_list()";>
<center>
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
	<div id="text2"><p>Edit Student Information</p></div>
	<form name = "myForm" action =  "EditStudentInfo.php" onsubmit="return validateForm()"  method = "post">
    <br>
	<p align="right" style="padding-left:150px"><i>You are here: </i>Edit >> Student Information </p>
	<?php
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
	include '../Rules/days.php';
	$polyid = $_POST["poly_id"];
	if(!$polyid){
		$polyid = $_POST["nyuid"];
	}
	$query1 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$polyid' ");
	$query2 = mysql_fetch_array($query1);
	$Sln = $query2[Student_Last_Name];
	$Sfn = $query2[Student_First_Name];
	$Smi = $query2[Student_MI];
	$Sphone = $query2[Student_Phone_No];
	$Semail = $query2[Student_Email];
	$Sclassstatus= $_POST[Class_Status];
	$Sgradyear= $_POST[Graduation_Year];
	$Ssub1 = $query2[Subject_1];
	$Ssub2 = $query2[Subject_2];
	$Ssub3 = $query2[Subject_3];
	$Ssub4 = $query2[Subject_4];
	$Ssub5 = $query2[Subject_5];
	$Ssub6 = $query2[Subject_6];
	$Sactive = $query2[Active];
	$Sstatus = $query2[Student_Status];

	$subject11 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Ssub1' ");
	$subject12 = mysql_fetch_array($subject11);
	$subject1 = $subject12[0];

	$subject21 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Ssub2' ");
	$subject22 = mysql_fetch_array($subject21);
	$subject2 = $subject22[0];

	$subject31 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Ssub3' ");
	$subject32 = mysql_fetch_array($subject31);
	$subject3 = $subject32[0];

	$subject41 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Ssub4' ");
	$subject42 = mysql_fetch_array($subject41);
	$subject4 = $subject42[0];

	$subject51 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Ssub5' ");
	$subject52 = mysql_fetch_array($subject51);
	$subject5 = $subject52[0];

	$subject61 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Ssub6' ");
	$subject62 = mysql_fetch_array($subject61);
	$subject6 = $subject62[0];

	?>
	<div class="ex">
	<div class = "back">
	<br><br>
    <table>
        <tr>
            <td>University ID:</td>
              <td><?php echo $polyid; ?><input type="hidden" name="nyuid" value="<?php echo $polyid;?>"</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Last Name:</td>
            <td><input type="text" name="Sln" value="<?php echo $Sln;?>"</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student First Name:</td>
            <td><input type="text" name="Sfn" value="<?php echo $Sfn;?>"</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Middle Initial:</td>
            <td><input type="text" name="Smi" value="<?php echo $Smi;?>"</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Phone Number:</td>
            <td><input type="text" name="Sphone" value="<?php echo $Sphone;?>"</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Email:</td>
            <td><input type="text" name="Semail" value="<?php echo $Semail;?>"</td>
        </tr>
        <tr>
        <td>Student Class Status:</td>
        <td><select placeholder="Class Status" name = "Sclassstatus" value="<?php print $Sclassstatus; ?>">
			<option value="0">---SELECT---</option>
			<option value="Freshmen">Freshmen</option>
			<option value='Sophmore'>Sophmore</option>
			<option value="Junior">Junior</option>
			<option value="Senior">Senior</option>
			<option value="Graduate">Graduate</option>
			<option value="Alumni">Alumni</option>
			</select></td>
        </tr>
        <tr>
        <td>Student Graduation Year:</td>
        <td><select name="Sgradyear" value="<?php print $Sgradyear; ?>">
	        <Option value="0">---SELECT---</option>
			</select>
		</td>
        </tr>
        <tr>
            <td>Student Subject 1:</td>
            <td>
		<?php
		$student_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");

		while ($student_subjects2 = mysql_fetch_array($student_subjects1)) {
			$student_subjects[]  = $student_subjects2[Subject];
			$student_subjectid[] = $student_subjects2[Subject_Id];
		}
		$subjectcount = count($student_subjectid);

		echo "<select name='Ssub1'> ";
		echo "<option value = $Ssub1>$subject1</option>";
		echo "<option value = 0>None</option>";
		for ($i = 0; $i < $subjectcount; $i++) {
			echo "<option value = $student_subjectid[$i]>$student_subjects[$i]</option>";
		}
		echo "</select>";
		?>
		</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Subject 2:</td>
        <td>
		<?php
		$student_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");

		while ($student_subjects2 = mysql_fetch_array($student_subjects1)) {
			$student_subjects[]  = $student_subjects2[Subject];
			$student_subjectid[] = $student_subjects2[Subject_Id];
		}
		$subjectcount = count($student_subjectid);
		echo "<select name='Ssub2'> ";
		echo "<option value = $Ssub2>$subject2</option>";
		echo "<option value = 0>None</option>";
		for ($i = 0; $i < $subjectcount; $i++) {
			echo "<option value = $student_subjectid[$i]>$student_subjects[$i]</option>";
		}
		echo "</select>";
		?>
		</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Subject 3:</td>
            <td>
		<?php
		$student_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
		while ($student_subjects2 = mysql_fetch_array($student_subjects1)){
			$student_subjects[] = $student_subjects2[Subject];
			$student_subjectid[] = $student_subjects2[Subject_Id];
		}
		$subjectcount = count($student_subjectid);
		echo "<select name='Ssub3'> ";
		echo "<option value = $Ssub3>$subject3</option>";
		echo "<option value = 0>None</option>";
		for ($i=0; $i<$subjectcount; $i++){
			echo "<option value = $student_subjectid[$i]>$student_subjects[$i]</option>";
		}
		echo "</select>";
		?>
		</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Subject 4:</td>
            <td>
		<?php
		$student_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
		while ($student_subjects2 = mysql_fetch_array($student_subjects1)){
			$student_subjects[] = $student_subjects2[Subject];
			$student_subjectid[] = $student_subjects2[Subject_Id];
		}

		$subjectcount = count($student_subjectid);
		echo "<select name='Ssub4'> ";
		echo "<option value = $Ssub4>$subject4</option>";
		echo "<option value = 0>None</option>";
		for ($i=0; $i<$subjectcount; $i++){
			echo "<option value = $student_subjectid[$i]>$student_subjects[$i]</option>";
		}

		echo "</select>";
		?>
		</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Subject 5:</td>
            <td>
		<?php
		$student_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
		while ($student_subjects2 = mysql_fetch_array($student_subjects1)){
			$student_subjects[] = $student_subjects2[Subject];
			$student_subjectid[] = $student_subjects2[Subject_Id];
		}

		$subjectcount = count($student_subjectid);
		echo "<select name='Ssub5'> ";
		echo "<option value = $Ssub5>$subject5</option>";
		echo "<option value = 0>None</option>";
		for ($i=0; $i<$subjectcount; $i++){
			echo "<option value = $student_subjectid[$i]>$student_subjects[$i]</option>";
		}

		echo "</select>";
		?>
	</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Subject 6:</td>
            <td>
		<?php
		$student_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
		while ($student_subjects2 = mysql_fetch_array($student_subjects1)){
			$student_subjects[] = $student_subjects2[Subject];
			$student_subjectid[] = $student_subjects2[Subject_Id];
		}

		$subjectcount = count($student_subjectid);
		echo "<select name='Ssub6'> ";
		echo "<option value = $Ssub6>$subject6</option>";
		echo "<option value = 0>None</option>";
		for ($i=0; $i<$subjectcount; $i++){
			echo "<option value = $student_subjectid[$i]>$student_subjects[$i]</option>";
		}

		echo "</select>";
		?>
	</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Active : Current: <?php echo $Sactive; ?></td>
            <td><input type = "radio" name = "active" value = "YES" selected="selected">Yes
            <input type = "radio" name = "active" value = "NO">No</td>
        </tr>
        <tr></tr><tr></tr>
        <tr>
            <td>Student Status : Current:  <?php echo $Sstatus; ?></td>
            <td><input type = "radio" name = "studentstatus" value = "NEW">New
            <input type = "radio" name = "studentstatus" value = "RETURNING">Returning</td>
        </tr>
    </table>

 
<br>	<button type="submit" name="save"><img src="../images/save.png"  width="102" height="28" border="none"/></a></button>
<?php
	
	if(isset($_POST["save"]))    {
		$newSln = $_POST["Sln"];
		$newSfn = $_POST["Sfn"];
		$newSmi = $_POST["Smi"];
		$newSphone = $_POST["Sphone"];
		$newSemail = $_POST["Semail"];
		$newSclassstatus= $_POST["Sclassstatus"];
		$newSgradyear= $_POST["Sgradyear"];
		$newSsub1 = $_POST["Ssub1"];
		$newSsub2 = $_POST["Ssub2"];
		$newSsub3 = $_POST["Ssub3"];
		$newSsub4 = $_POST["Ssub4"];
		$newSsub5 = $_POST["Ssub5"];
		$newSsub6 = $_POST["Ssub6"];
		$newactive = $_POST["active"];
		
		if($newactive == '')        {
			$newSactive = $Sactive;
		} else        {
			$newSactive = $newactive;
		}

		$newstatus = $_POST["studentstatus"];
		
		if($newstatus == '')        {
			$newSstatus = $Sstatus;
		} else        {
			$newSstatus = $newstatus;
		}

		$subcount = 0;
		
		if($newSsub1 != 0)        {
			$subcount++;
		}

		
		if($newSsub2 != 0)        {
			$subcount++;
		}

		
		if($newSsub3 != 0)        {
			$subcount++;
		}

		
		if($newSsub4 != 0)        {
			$subcount++;
		}

		
		if($newSsub5 != 0)        {
			$subcount++;
		}

		
		if($newSsub6 != 0)        {
			$subcount++;
		}

		
		if(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Sln"]) === 0){
			/* $A = '<br>Last Name must be from letters, dashes, spaces and must not start with dash'; */
			$A = 'Last Name must be from letters, dashes, spaces and must not start with dash';
		}

		elseif(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Sfn"]) === 0){
			/*  $A = '<p class="errText">First Name must be from letters, dashes, spaces and must not start with dash</p>';*/
			$A = 'First Name must be from letters, dashes, spaces and must not start with dash';
		}

		/* elseif(preg_match("/^[a-zA-Z]\w+(\.\w+)*\@\w+(\.[0-9a-zA-Z]+)*\.[a-zA-Z]{2,4}$/", $_POST["Semail"]) === 0){
			$A = 'Email must comply with this mask: chars(.chars)@chars(.chars).chars(2-4)';
		}  */
		elseif(!filter_var($_POST["Semail"], FILTER_VALIDATE_EMAIL)) {
		  $A = "Invalid email format"; 
		}else        {
			//updating the student table
			$updateSln = mysql_query("UPDATE `Student` SET `Student_Last_Name` = '$newSln', `Student_First_Name` = '$newSfn', `Student_MI` = '$newSmi', `Student_Phone_No` = '$newSphone', `Student_Email` = '$newSemail',`Class_Status`='$newSclassstatus',`Graduation_Year`='$newSgradyear',`No_Of_Subjects` = '$subcount', `Subject_1` = '$newSsub1', `Subject_2` = '$newSsub2', `Subject_3` = '$newSsub3', `Subject_4` = '$newSsub4', `Subject_5` = '$newSsub5', `Subject_6` = '$newSsub6', `Active` = '$newSactive', `Student_Status` = '$newSstatus' WHERE Student_Poly_Id = '$polyid' ");
			
			if($updateSln){
			/* Edited By: Parul Joshi Dated: 08/17/2015
			Task - to update the student info in student_tutor_allocation_main table */
			$updateSTA = mysql_query("UPDATE `Student_Tutor_Allocation_Main`  SET `Student_Last_Name` = '$newSln', `Student_First_Name` = '$newSfn' WHERE Student_Poly_Id = '$polyid' ");
			if($updateSTA)        {
				$B= 'Student Info Updated';
			}else{
				$C = 'Student Info NOT updated';
			}
			//updating the subjects info in main and assignment table	
			} else{
				$C = 'Student Info NOT updated';
			}
		}
	}
	elseif(isset($_POST["exit"])){
		$url1 = "Selectfunction.php";
		header("Location:$url1");
	}
	?>
		<div class="mesg"><?php echo $A; ?></div>
		<div class="mesg2"><?php echo $B; ?></div>
		<div class="mesg3"><?php echo $C; ?></div>
</div>
</form>
</center>
</div>
</body>
</html>