<!-- This page allows you to make selection to edit details of multiple session. -->

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
	<script>
	$(function() {		
		$("#datepicker, #datepicker1, #datepicker2").datepicker({
			onSelect: function(dateText, inst) { 
				$(this).prev()[0].value = dateText;
			}
		}); 
	});
	</script>
	
<script type = "text/javascript">
function validateForm(){
	var date=document.forms["myForm"]["date"].value;
	if (date==null || date=="---SELECT---" || date==""){
		alert("Select Current Session Date");
		return false;
	}
	var stime=document.forms["myForm"]["SessionTime"].value;
	if (stime==null || stime=="---SELECT---"){
		alert("Select Current Session Time");
		return false;
	}
	var sdate=document.forms["myForm"]["startdate"].value;
	if (sdate==null || sdate=="---SELECT---" || sdate ==""){
		alert("Select New Session Start Date");
		return false;
	}
	var edate=document.forms["myForm"]["enddate"].value;
	if (edate==null || edate=="---SELECT---" || edate ==""){
		alert("Select New Session End Date");
		return false;
	}
	// Validating the session date. Session date should not be less than current date. 
	if (date){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
				dd='0'+dd
		} 

		if(mm<10) {
				mm='0'+mm
		} 

		todayDate = mm+'/'+dd+'/'+yyyy;
		var currentDate = new Date(todayDate);
		var enteredDate = new Date(date);
		if(enteredDate < currentDate){
				alert("The Current Session Date entered is invalid. Please enter the valid latest date!!");
				return false;
		}
		var newStartDate = new Date(sdate);
		if(newStartDate < currentDate){
				alert("The New Session Date entered is invalid. Please enter the valid latest date!!");
				return false;
		}
		var newEndDate = new Date(edate);
		if(newEndDate < currentDate){
				alert("The New End Date entered is invalid. Please enter the valid latest date!!");
				return false;
		}
}
var ntime=document.forms["myForm"]["NewSessionTime"].value;
if (ntime==null || ntime=="---SELECT---"){
	alert("Select New Session Time");
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
	<div id="text2"><p>&nbsp Edit Multiple Sessions</p></div>
	<form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
	
<?php 
	$Sid = $_GET["var1"];
	$Tid = $_GET["var2"];
	$Sub = $_GET["var3"];
	$date1 = $_GET["var4"];
	$date2 = strtotime($date1);
	$startdate = date('Y-m-d',$date2);
	$date3 = $_GET["var5"];
	$date4 = strtotime($date3);
	$enddate = date('Y-m-d',$date4);
	$allocateId = $_GET["var6"];
	$studentdetails1 = mysql_query(" SELECT `Student_First_Name`, `Student_Last_Name` FROM Student WHERE `Student_Poly_Id`='$Sid'");
	$studentdetails2 = mysql_fetch_array($studentdetails1);
		$studentFirstName = $studentdetails2[Student_First_Name];
		$studentLastName= $studentdetails2[Student_Last_Name];
	$tutorDetails1 = mysql_query(" SELECT `Tutor_First_Name`, `Tutor_Last_Name` FROM Tutor WHERE `Tutor_Poly_Id`='$Tid' ");
	$tutorDetails2 = mysql_fetch_array($tutorDetails1); 
		$tutorFirstName = $tutorDetails2[Tutor_First_Name];
		$tutorLastName = $tutorDetails2[Tutor_Last_Name];		
?>
<?php
if(isset($_POST["all"])){
	$newdate1 = $_POST["date"];
	$newdate2 = strtotime($newdate1);
	$currentSessionDate = date('Y-m-d',$newdate2);
	$currentSessionTime = $_POST["SessionTime"];
	$newdate3 = $_POST["startdate"];
	$newdate4 = strtotime($newdate3);
	$newSessionDate = date('Y-m-d',$newdate4);
	$newdate5 = $_POST["enddate"];
	$newdate6 = strtotime($newdate5);
	$newEndDate = date('Y-m-d',$newdate6);
	$newSessionTime = $_POST["NewSessionTime"];

	if($currentSessionDate == ''){
		$A= "Select Current Session Date";
	}elseif($currentSessionTime == '---SELECT---'){
		$A= "Select Current Session Time";
	}elseif($newSessionDate == '---SELECT---'){
		$A= "Select New Session Date";
	}elseif($newEndDate == '---SELECT---'){
		$A= "Select New End Date";
	}elseif($newSessionTime == '---SELECT---'){
		$A= "Select New Session Time";
	}
	else{		
		$d = mysql_query("SELECT DAYOFWEEK('$newSessionDate')");
		$d1 = mysql_fetch_array($d);
		$d2 = $d1[0];
		
		$diffweek = abs(strtotime($newSessionDate) - strtotime($newEndDate)) / 604800;
		$number = intval($diffweek);
		
		if($number>30)
			$number=-2;

		$checksessionTutor = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Tid' AND (Time = '$newSessionTime' AND Day = '$d2')");
		$checksessionTutorArr = mysql_fetch_array($checksessionTutor);
		$checksessionTutorFlag = $checksessionTutorArr[Allocate_Id];

		$checksessionStudent = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id`='$Sid' AND (Time = '$newSessionTime' AND Day = '$d2')");
		$checksessionStudentArr = mysql_fetch_array($checksessionStudent);
		$checksessionStudentFlag = $checksessionStudentArr[Allocate_Id];

        $checksessionTutorSt = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Sid' AND (Time = '$newSessionTime' AND Day = '$d2')");
        $checksessionTutorStArr = mysql_fetch_array($checksessionTutorSt);
        $checksessionTutorStFlag = $checksessionTutorStArr[Allocate_Id];

        $checksessionStudentTu = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id`='$Tid' AND (Time = '$newSessionTime' AND Day = '$d2')");
        $checksessionStudentTuArr = mysql_fetch_array($checksessionStudentTu);
        $checksessionStudentTuFlag = $checksessionStudentTuArr[Allocate_Id];

		if($checksessionTutorFlag != 0){
			$B ="Another session exists for selected Tutor on the new start day and time";
		}
        elseif($checksessionStudentFlag != 0){
			$B ="Another session exists for selected Student on the new start day and time";
		}
        elseif($checksessionTutorStFlag != 0){
            $B ="Another session exists for selected Student as Tutor on the new start day and time";
        }
        elseif($checksessionStudentTuFlag != 0){
            $B ="Another session exists for selected Tutor as Student on the new start day and time";
        }
		else
		{
			//Added By : Parul Joshi Dated: 08/28/2015 Task : To split one existing multiple session into two(first-the existing one & second- the new one entered) 
			//only if there are sessions before new session start date or after new session end date which have not yet occurred.
			$todayDate=date('Y-m-d');
			$sessionsExist = mysql_query("SELECT * FROM `Student_Tutor_Assignment` WHERE `Tutor_Poly_Id`='$Tid' AND `Student_Poly_Id`='$Sid' AND `Subject_Id`='$Sub' AND `Allocate_Id`='$allocateId' AND UNIX_TIMESTAMP(`Date`)!=0 AND (`Date` <'$newSessionDate' OR `Date` >'$newEndDate')");
			$sessionsExistNum = mysql_fetch_array($sessionsExist);
			$sessionsExistFlag = $sessionsExistNum[Allocate_Id];
			if($sessionsExistFlag!=0){
    		$query2 = mysql_query("INSERT INTO `Student_Tutor_Allocation_Main`(`Student_Poly_Id`, `Student_First_Name`, `Student_Last_Name`, `Tutor_Poly_Id`, `Tutor_First_Name`, `Tutor_Last_Name`, `Subject`, `Time`, `Day`, `Session_Start_Date`, `Session_End_Date`) VALUES ('$Sid', '$studentFirstName','$studentLastName','$Tid','$tutorFirstName','$tutorLastName', '$Sub','$newSessionTime','$d2','$newSessionDate','$newEndDate' )");
    		if($query2){
				$query = mysql_query("SELECT * FROM `Student_Tutor_Allocation_Main` WHERE `Tutor_Poly_Id`='$Tid' AND `Student_Poly_Id`='$Sid' AND `Subject`='$Sub' AND `Session_Start_Date`='$newSessionDate' AND `Session_End_Date`='$newEndDate' ");
				if($query){
					$queryDetails=mysql_fetch_array($query);
					$newAllocationID = $queryDetails[Allocate_Id];
					$query1 = mysql_query("UPDATE `Student_Tutor_Assignment` SET Session_Type='', Tutor_Type='C',Student_Type='C' WHERE `Date` BETWEEN '$currentSessionDate' AND '$newEndDate' AND `Allocate_Id` = '$allocateId' ");
					if($query1){
					$r = get_days ($newSessionDate, $newEndDate);
					for ($i=0; $i<=$number+1; $i++){
						$newday1 = mysql_query("SELECT DAYOFWEEK('$r[$i]')");
						$newday2 = mysql_fetch_array($newday1);
						$newday = $newday2[0];
						$query3 = mysql_query( "INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`,`Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`) VALUES ('$newAllocationID', '$Sid', '$Tid', '$Sub', '$newSessionTime', '$r[$i]', '$newday') ");
					}
				}
					//Clearing all the previous entry of the sessions. 
					$querydelete = mysql_query("DELETE FROM `Student_Tutor_Assignment` WHERE  `Allocate_Id` = '$allocateId' AND `Tutor_Type`='C' AND `Student_Type`='C'");
				}$A = "Updated";
			}else{
				$B = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Not Updated";
			}
			}else{
			//code if newenddate>current end date
    		$query2 = mysql_query("UPDATE `Student_Tutor_Allocation_Main` SET `Day`='$d2', `Time`='$newSessionTime',`Session_End_Date`='$newEndDate' WHERE `Allocate_Id` = '$allocateId'");
    		if($query2){
				$query = mysql_query("UPDATE `Student_Tutor_Assignment` SET Session_Type='', Tutor_Type='C',Student_Type='C' WHERE `Allocate_Id` = '$allocateId' AND `Date` >= '$currentSessionDate' ");
				if($query){
					$r = get_days ($newSessionDate, $newEndDate);
					for ($i=0; $i<=$number+1; $i++){
						$newday1 = mysql_query("SELECT DAYOFWEEK('$r[$i]')");
						$newday2 = mysql_fetch_array($newday1);
						$newday = $newday2[0];
						$query3 = mysql_query( "INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`,`Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`) VALUES ('$allocateId', '$Sid', '$Tid', '$Sub', '$newSessionTime', '$r[$i]', '$newday') ");
					}
					//Clearing all the previous entry of the sessions. 
					$querydelete = mysql_query("DELETE from `Student_Tutor_Assignment` WHERE `Allocate_Id` = '$allocateId' AND `Date` >= '$currentSessionDate' AND Tutor_Type='C' AND Student_Type='C'");
				}$A = "Updated";
			}else{
				$B = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Not Updated";
			}
		}	
	}
}
}



?>
<center>
<div class="ex">
<div class = "back">
<br><br>
		<table>
				<tr>
						<td> <label for="name">Session Start Date :</label></td>
						<td><label><?php echo $startdate?></label></td>
												<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				</tr>   
				<tr>
						<td> <label for="name">Session End Date :</label></td>
						<td><label><?php echo $enddate?></label></td>
												<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				</tr>
				<tr>
					<td><label for="name">Current Session Date :</label> </td>
					<td>
					<p><input type="text" placeholder="Current Session date" id="datepicker1" name="date"></p> 
					<!--<input type="text" id="" name="date"></input> -->
					</td>
				</tr>
					<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				<tr>
						<td><label for="name">Current Session Time :</label> </td>
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
				<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
								</td>
				</tr>
				<tr>
						<td><label for="name">New Session Date :</label> </td>
						<td>
						<p><input type="text" placeholder="New Session Start date" id="datepicker" name="startdate"></p> 
						</td>
				</tr>
					<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				<tr>
					<td><label for="name">New End Date :</label> </td>
						<td>
							<p><input type="text" placeholder="New Session End Date" id="datepicker2" name="enddate"></p>
					</td>
				</tr>
					<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				<tr>
				<td><label for="name">New Session Time :</label> </td>
				<td>
					<select name="NewSessionTime">
						
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
					<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				</td>	
			</tr>
		<p>        
		</table>
		<br>
	<button type="submit" name="all"><img src="../images/editallsession.png"  width="145" height="28" border="none"/></a></button>
	
			<div class = "mesg"> <?php  echo "$A" ;?> </div>
			<div class = "mesg2"> <?php  echo "$B" ;?> </div>
</div>
</div>
</form>
</center>
</div>
</body>
</html>
