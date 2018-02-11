<!--Created By : Parul Joshi Date:8/25/2015 
 This page allows you to select one session to edit its details -->

<?php
include 'LoginCheck.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';
?>
<?php	include '../Rules/dbconfig.php'; ?>

<html>
<head>
	<title>Edit Single Session</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/editsession.css" />
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
function validateForm(){
	var sdate=document.forms["myForm"]["startdate"].value;
	if (sdate==null || sdate=="---SELECT---" || sdate ==""){
		alert("Select New Session Date");
		return false;
	}
	//****Added by Kishan********
	// Validating the session date. Session date should not be less than current date. 
	if (sdate){
		var today = new Date();
		//alert(date);
		//02/25/2015
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
		var enteredDate = new Date(sdate);
		if(enteredDate < currentDate){
				alert("The session date entered is invalid. Please enter the valid latest date!!");
				return false;
		}
}
//*********End*********
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
	<div id="text2"><p>&nbsp Edit Single Session</p></div>
	<form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
	
<?php
	$Sid = $_GET["var1"];
	$Tid = $_GET["var2"];
	$Sub = $_GET["var3"];
	$date1 = $_GET["var4"];
	$date2 = strtotime($date1);
	$date = date('Y-m-d',$date2);
	$time = $_GET["var5"];
	$startdate = $_GET["var6"];
	$enddate = $_GET["var7"];
?>
		
<?php
if(isset($_POST["back"])){

	echo "<script type='text/javascript'> document.location = 'EditSingleSession.php';</script>";
	//$url1 = "EditSingleSession.php";
	//header("Location:$url1");
}

if(isset($_POST["all"]))
{
	
	$newdate1 = $_POST["startdate"];
	$newdate2 = strtotime($newdate1);
	$newdate = date('Y-m-d',$newdate2);
	$newtime = $_POST["NewSessionTime"];
	$studentnames1 = mysql_query("SELECT `Student_First_Name`, `Student_Last_Name` FROM Student WHERE Student_Poly_Id = '$Sid' ");
    $studentnames2 = mysql_fetch_array($studentnames1);
    $studentnamesfn = $studentnames2[Student_First_Name];
    $studentnamesln = $studentnames2[Student_Last_Name];

    $tutornames1 = mysql_query("SELECT `Tutor_First_Name`, `Tutor_Last_Name`,`Tutor_Hours` FROM Tutor WHERE Tutor_Poly_Id = '$Tid' ");
    $tutornames2 = mysql_fetch_array($tutornames1);
    $tutornamesfn = $tutornames2[Tutor_First_Name];
    $tutornamesln = $tutornames2[Tutor_Last_Name];
    $tutorhours = $tutornames2[Tutor_Hours];

	
	if($newdate == ''){
		$A= "Select New Session Date";
	}
	elseif($newtime == '---SELECT---'){
		$A= "Select New Session Time";
	}
	else{		
		$allocateid1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id`='$Sid' AND `Tutor_Poly_Id` = '$Tid' AND `Date`='$date' AND `Session_Time` = '$time' ");
		$allocateid2 = mysql_fetch_array($allocateid1);
		$allocateid = $allocateid2[Allocate_Id];
		$subjectid = $allocateid2[Subject_Id];
		
		$d = mysql_query("SELECT DAYOFWEEK('$newdate')");
		$d1 = mysql_fetch_array($d);
		$d2 = $d1[0];
		
		
		$diffweek = abs(strtotime($newdate) - strtotime($newdate)) / 604800;
		$number = intval($diffweek);
		
		if($number>30)
			$number=-2;

		$checksessionTutor = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Tid' AND (Time = '$newtime' AND Day = '$d2')");
		$checksessionTutorArr = mysql_fetch_array($checksessionTutor);
		$checksessionTutorFlag = $checksessionTutorArr[Allocate_Id];

		$checksessionStudent = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id`='$Sid' AND (Time = '$newtime' AND Day = '$d2')");
		$checksessionStudentArr = mysql_fetch_array($checksessionStudent);
		$checksessionStudentFlag = $checksessionStudentArr[Allocate_Id];

        $checksessionTutorSt = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Sid' AND (Time = '$newtime' AND Day = '$d2')");
        $checksessionTutorStArr = mysql_fetch_array($checksessionTutorSt);
        $checksessionTutorStFlag = $checksessionTutorStArr[Allocate_Id];

        $checksessionStudentTu = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id`='$Tid' AND (Time = '$newtime' AND Day = '$d2')");
        $checksessionStudentTuArr = mysql_fetch_array($checksessionStudentTu);
        $checksessionStudentTuFlag = $checksessionStudentTuArr[Allocate_Id];

		if($checksessionTutorFlag != 0){
			$B ="Another session exists for selected Tutor on the new session day and time".$checksessionTutorFlag."is the flag";
		}
        elseif($checksessionStudentFlag != 0){
			$B ="Another session exists for selected Student on the new session day and time";
		}
        elseif($checksessionTutorStFlag != 0){
            $B ="Another session exists for selected Student as Tutor on the new session day and time";
        }
        elseif($checksessionStudentTuFlag != 0){
            $B ="Another session exists for selected Tutor as Student on the new session day and time";
        }
		else
		{
    		$query2 = mysql_query("INSERT INTO `Student_Tutor_Allocation_Main`(`Student_Poly_Id`, `Student_First_Name`, `Student_Last_Name`, `Tutor_Poly_Id`, `Tutor_First_Name`, `Tutor_Last_Name`,  `Subject`, `Time`, `Day`, `Session_Start_Date`, `Session_End_Date`) VALUES ('$Sid', '$studentnamesfn', '$studentnamesln', '$Tid', '$tutornamesfn', '$tutornamesln',  '$Sub', '$newtime', '$d2', '$newdate', '$newdate' )");
    		if($query2)
    		{
				$allocateid1 = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id`='$Sid' AND `Tutor_Poly_Id` = '$Tid' AND `Session_Start_Date`='$newdate' AND `Session_End_Date`='$newdate' AND `Time` = '$newtime' ");
				$allocateid2 = mysql_fetch_array($allocateid1);
				$newAllocateid = $allocateid2[Allocate_Id];
    				
				$query = mysql_query("UPDATE Student_Tutor_Assignment SET Session_Type='', Tutor_Type='C',Student_Type='C' WHERE `Allocate_Id` = '$allocateid' AND `Date` = '$date' AND `Session_Time`= '$time'");
				if($query){
					$query3 = mysql_query( "INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`,`Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`) VALUES ('$newAllocateid', '$Sid', '$Tid', '$Sub', '$newtime', '$newdate', '$d2') ");
					//Clearing all the previous entry of the sessions. 
					$querydelete = mysql_query("DELETE from Student_Tutor_Assignment WHERE `Allocate_Id` = '$allocateid' AND `Date` = '$date' AND `Session_Time`= '$time' AND Tutor_Type='C' AND Student_Type='C'");
				}
				$A = "Single Session is Updated";
			}
			else{
				$B = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Not Updated";
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
						<td><label><?php echo $startdate ?></label></td>
												<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				</tr>   
				<tr>
						<td> <label for="name">Session End Date :</label></td>
						<td><label><?php echo $enddate ?></label></td>
												<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				</tr>
				<tr>
						<td><label for="name">Session Date :</label> </td>
						<td>
								<p><label><?php echo $date; ?> </label></p>
						</td>
				</tr>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				<tr>
						<td><label for="name">Session Time :</label> </td>
						<td>
						<!-- Begin of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time -->
							<!--	<p><label><?php //echo $time; ?> </label></p> -->
									<p><label><?php echo date('g:i a', strtotime($time)); ?> </label></p>
						<!-- End of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time -->
						</td>

						<td>
							
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
						</td>
				</tr>
				<tr>
	<td><label for="name">New Session Date :</label></td>
	
	<td>
		<p><input type="text" id="datepicker2" name="startdate"></p>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
	</td>
	</tr>
				<tr>
	</tr>
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
	<button type="submit" name="all"><img src="../images/editsinglesession.png"  width="145" height="28" border="none"/></a></button>
	<button type="submit" name="back"><img src="../images/back.png"  width="145" height="28" border="none"/></a></button>
			<div class = "mesg"> <?php  echo "$A" ;?> </div>
			<div class = "mesg2"> <?php  echo "$B" ;?> </div>
</div>
</div>
</form>
</center>
</div>
</body>
</html>
