<!-- This page allows you to select one session to edit its details -->
<?php
include 'LoginCheck.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';
?>
<?php	include '../Rules/dbconfig.php'; ?> 
<html>
<head>
    <title>Edit Session Type</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="../css/editonesession.css" />
	<link rel="stylesheet" href="../css/datepicker.css"/>
	<script src="jquery 1.9.1.js"></script>
	<script src="jQuery UI.js"></script>
	<script>
    $(function() {  
      $("#datepicker, #datepicker2").datepicker({
        onSelect: function(dateText, inst) { 
          $(this).prev()[0].value = dateText;
        }
      });
	});
	</script>
	<script type = "text/javascript">
	function validateForm()
	{
	var sname=document.forms["myForm"]["Sname"].value;
	if (sname==null || sname=="---SELECT---")
	  {
	  alert("Select Student");
	  return false;
	  }
	var tname=document.forms["myForm"]["Tname"].value;
	if (tname==null || tname=="---SELECT---")
	  {
	  alert("Select Tutor");
	  return false;
	  }
	 var sub=document.forms["myForm"]["Esub"].value;
	if (sub==null || sub=="---SELECT---")
	  {
	  alert("Select Course");
	  return false;
	  }
	  var date=document.forms["myForm"]["date"].value;
	if (date==null || date=="")
	  {
	  alert("Select Session Date");
	  return false;
	  }
	  var time =document.forms["myForm"]["SessionTime"].value;
	if (time ==null || time =="---SELECT---")
	  {
	  alert("Select Session Date");
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
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
	
<?php
	$studentdetails1 = mysql_query(" SELECT `Student_First_Name`, `Student_Last_Name`, `Student_Poly_Id` FROM Student ORDER BY Student_Last_Name");
	while($studentdetails2 = mysql_fetch_array($studentdetails1) ){
		$studentFirstName[] = $studentdetails2[Student_First_Name];
		$studentLastName[] = $studentdetails2[Student_Last_Name];
		$studentPolyId[]       = $studentdetails2[Student_Poly_Id];
	}

	$no = count($studentPolyId);
	for($i=0; $i<$no;$i++){
		$studentName[] = $studentLastName[$i]." ".$studentFirstName[$i];
	}

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

	$allocate_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
	while ($allocate_subjects2 = mysql_fetch_array($allocate_subjects1)){
		$allocate_subjects[] = $allocate_subjects2[Subject];
		$allocate_subjectid[] = $allocate_subjects2[Subject_Id];
	}

	$subjectcount = count($allocate_subjectid);
?>
    
<?php
if(isset($_POST["one"]))
{
    $Sid = $_POST["Sname"];
    $Tid = $_POST["Tname"];
    $Sub = $_POST["Esub"];
    $date1 = $_POST["date"];
    $date2 = strtotime($date1);
    $date = date('Y-m-d',$date2);
    $time = $_POST["SessionTime"];
	$currentDate= date("Y-m-d");
	
	if($Sid == '---SELECT---'){
		$A = "Select Student Name";
	}
	elseif($Tid == '---SELECT---'){
		$A = "Select Tutor Name";
	}
	elseif($Sub == '---SELECT---'){
		$A = "Select Course Name";
	}
	elseif($date == ''){
		$A = "Select Date";
	}
	elseif($time == '---SELECT---'){
		$A = "Select Time";
	}
	else{
		/*Edited By: Parul Joshi Dated: 08/21/2015
		Task: To check if the session has not occurred yet.	*/
		$allocateid1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id`='$Sid' AND `Tutor_Poly_Id` = '$Tid' AND `Date`='$date' AND `Session_Time` = '$time' AND `Subject_Id`='$Sub' ");
		$allocateid2 = mysql_fetch_array($allocateid1);
		$allocateid = $allocateid2[Allocate_Id];
		if($allocateid!=0){
			$assignmentid = $allocateid2[Assignment_Id];
			$Ttype = $allocateid2[Tutor_Type];
			$Stype = $allocateid2[Student_Type];
			$sCurrentTime =$allocateid2[Student_Current_Time];
			$tCurrentTime = $allocateid2[Tutor_Current_Time];
			
			//added link to edit session type of all existing sessions.
			//Added by : Parul, Task: Header was not redirecting here, so changed to 'document.location' Dated: 12/04/2015
			echo "<script type='text/javascript'> document.location = 'EditOneSessionInfo.php?var1=$Sid&var2=$Tid&var3=$Sub&var4=$date&var5=$time';</script>";
			//$url1 = "EditOneSessionInfo.php";
			//header("Location:$url1?var1=$Sid&var2=$Tid&var3=$Sub&var4=$date&var5=$time");
				
			/* Edited By : Parul 
			Task: REMOVED the condition where admin is not allowed to edit the session which has not occurred yet, as per TRIO's requirement. 
			Dated: 10/22/2015
			//Edited by:Parul Joshi Dated :09/16/2015 Task: change condition so that admin can edit the session type which are null and occurred in past 
			if(($date >= $currentDate) AND ($Ttype== NULL) AND ($Stype==NULL) ){
					echo "<script type='text/javascript'>alert('Sorry, you cannot edit the session type as there is time for this session to occur.');</script>";
			}else{
				$url1 = "EditOneSessionInfo.php";
				header("Location:$url1?var1=$Sid&var2=$Tid&var3=$Sub&var4=$date&var5=$time");
			}	
			*/
	}else{
		echo $A="Sorry !!No Session exist for this info.";
	}
	}
}
    
?>
	<div id="text2">
	<p>&nbsp &nbsp &nbsp Edit Session Type</p>
	</div>
<center> 
<div class="ex">
<div class ="back">
	<br><br>
    <table>
        <tr>
            <td><label for="name">Student Name :</label></td> 
            <td>
			<select name = "Sname">
				<option>---SELECT---</option>
			<?php
			for($j=0;$j<$no; $j++){	
				echo "<option value=$studentPolyId[$j]>$studentName[$j]</option>";
			}
			?>
			</select>
            </td>
        </tr>
        <tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
        <tr>
            <td><label for="name">Tutor Name :</label></td>
            <td>
			<select name = "Tname">
				<option>---SELECT---</option>
				<?php
					for($b=0;$b<$no1;$b++)
					{
						echo "<option value=$tutorPolyId[$b]>$tutorName[$b]</option>";
					}
				?>
			</select>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
            </td>
        </tr>
        
        <tr>
            <td><label for="name">Course/Subject :</label> </td>
            <td>
                <select name = "Esub">
					<option>---SELECT---</option>
					<?php
						for($i=0;$i<$subjectcount;$i++)
						{
							echo "<option value=$allocate_subjectid[$i]>$allocate_subjects[$i]</option>";
						}
					?>
				</select>
		 <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
            </td>
        </tr>
        <tr>
            <td><label for="name">Session Date :</label></td>
            <td>
                <p><input type="text" id="datepicker" name="date"></p>
            </td>
			<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
        </tr>
        <tr>
            <td><label for="name">Session Time: </label></td>
            <td>
                <select name="SessionTime">
					<option>---SELECT---</option>
					<option value = "09:00:00">09:00 AM</option>
								<option value = "09:30:00">09:30 AM</option>
					<option value = "10:00:00">10:00 AM</option>
								<option value = "10:30:00">10:30 AM</option>
					<option value = "11:00:00">11:00 AM</option>
								<option value = "11:30:00">11:30 AM</option>
					<option value = "12:00:00">12:00 PM</option>
								<option value = "12:30:00">12:30 PM</option>
					<option value = "13:00:00">1:00 PM</option>
								<option value = "13:30:00">1:30 PM</option>
					<option value = "14:00:00">2:00 PM</option>
								<option value = "14:30:00">2:30 PM</option>
					<option value = "15:00:00">3:00 PM</option>
								<option value = "15:30:00">3:30 PM</option>
					<option value = "16:00:00">4:00 PM</option>
								<option value = "16:30:00">4:30 PM</option>
					<option value = "17:00:00">5:00 PM</option>
								<option value = "17:30:00">5:30 PM</option>
					<option value = "18:00:00">6:00 PM</option>
								<option value = "18:30:00">6:30 PM</option>
								<option value = "19:00:00">7:00 PM</option>
				</select>
            </td>
        </tr>
		 <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
	</table>
    <br>
	<button type="submit" name="one"><img src="../images/edit.png"  width="145" height="28" border="none"/></a></button>
	 <center> <div class = "mesg"><?php  echo "$A" ;?> </div></center>
</div>
</div>
</form>
</center>
</div>
</body>
</html>
