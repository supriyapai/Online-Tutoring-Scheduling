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
		$("#datepicker, #datepicker2").datepicker({
			onSelect: function(dateText, inst) { 
				$(this).prev()[0].value = dateText;
			}
		}); 
	});
	function showStartEndDate(sub){
		var sname=document.forms["myForm"]["Sname"].value;
		var tname=document.forms["myForm"]["Tname"].value;
		var sub=document.forms["myForm"]["Esub"].value;
		if (sub=="" || tname=='' || sname==''){
			return;
		}
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){    
				var text=xmlhttp.responseText;
				text=text.trim();
				var textstr=text.split(",");
				
				document.getElementById("txtStart").innerHTML=textstr[0]; 
				document.getElementById("txtEnd").innerHTML=textstr[1]; 
				}
			}		
		if(sname!=null && tname!=null && sub!=null){
			xmlhttp.open("GET","searchEndStartDate.php?sname="+sname+"&tname="+tname+"&sub="+sub,true);
		}		
		xmlhttp.send();
	}
	</script>
<script type = "text/javascript">
function validateForm(){
	var sname=document.forms["myForm"]["Sname"].value;
	if (sname==null || sname=="---SELECT---"){
		alert("Select Student");
		return false;
	}
	var tname=document.forms["myForm"]["Tname"].value;
	if (tname==null || tname=="---SELECT---"){
		alert("Select Tutor");
		return false;
	}	
	var sub=document.forms["myForm"]["Esub"].value;
	if (sub==null || sub=="---SELECT---"){
		alert("Select Course");
		return false;
	}	
	var date=document.forms["myForm"]["date"].value;
	if (date==null || date=="---SELECT---" || date==""){
		alert("Select Session Date");
		return false;
	}
	var stime=document.forms["myForm"]["SessionTime"].value;
	if (stime==null || stime=="---SELECT---"){
		alert("Select Session Time");
		return false;
	}
	var sdate=document.forms["myForm"]["startdate"].value;
	if (sdate==null || sdate=="---SELECT---" || sdate ==""){
		alert("Select New Session Date");
		return false;
	}
	//****Added by Kishan********
	// Validating the session date. Session date should not be less than current date. 
	if (date){
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
		var enteredDate = new Date(date);
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
				<ul>
					<li><a href="EditOneSession.php">Single Session</a></li>
					<li><a href="EditSession.php">All Sessions</a></li>
				</ul>
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

if(isset($_POST["all"]))
{
	$Sid = $_POST["Sname"];
	$Tid = $_POST["Tname"];
	$Sub = $_POST["Esub"];
	$date1 = $_POST["date"];
	$date2 = strtotime($date1);
	$date = date('Y-m-d',$date2);
	$time = $_POST["SessionTime"];
	$newdate1 = $_POST["startdate"];
	$newdate2 = strtotime($newdate1);
	$newdate = date('Y-m-d',$newdate2);
	$newtime = $_POST["NewSessionTime"];

	if($Sid == '---SELECT---'){
		$A= "Select Student Name";
	}
	elseif($Tid == '---SELECT---'){
		$A= "Select Tutor Name";
	}
	elseif($Sub == '---SELECT---'){
		$A= "Select Subject";
	}
	elseif($date == ''){
		$A= "Select Session Date";
	}
	elseif($time == '---SELECT---'){
		$A= "Select Session Time";
	}
	elseif($newdate == ''){
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
		
		$assignment1 = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Allocate_Id` = '$allocateid'");
		$assignment2 = mysql_fetch_array($assignment1);
		$enddate = $assignment2[Session_End_Date];
		
		$d = mysql_query("SELECT DAYOFWEEK('$newdate')");
		$d1 = mysql_fetch_array($d);
		$d2 = $d1[0];
		
		$diffweek = abs(strtotime($newdate) - strtotime($enddate)) / 604800;
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
    		$query2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET `Day`='$d2', `Time`='$newtime' WHERE `Allocate_Id` = '$allocateid'");
    		if($query2)
    		{
    				//Previous Code
    				//$query = mysql_query("UPDATE Student_Tutor_Assignment SET Session_Type='Changed' WHERE `Allocate_Id` = '$allocateid' AND `Date` >= '$date' ");
    				/*
    				When the session is changed to another time or another day, 
    				the current assignment entry in the database is updated as session-type changed. 
    				We are now following a convention that the changed session which fall as cancelled session type. 
    				So changed multiple sessions will be a regular session with student-type and tutor-type marked as "C" 
    				*/
    				//Modified By Kishan
    				$query = mysql_query("UPDATE Student_Tutor_Assignment SET Session_Type='', Tutor_Type='C',Student_Type='C' WHERE `Allocate_Id` = '$allocateid' AND `Date` >= '$date' ");
    				if($query)
    				{
    					$r = get_days ($newdate, $enddate);
    					//$A= $A."<script>alert('newdate: '+$newdate+' number: '+'$number'); </script>";
    					for ($i=0; $i<=$number+1; $i++)
    					{
    						$newday1 = mysql_query("SELECT DAYOFWEEK('$r[$i]')");
    						$newday2 = mysql_fetch_array($newday1);
    						$newday = $newday2[0];

    						$query3 = mysql_query( "INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`,`Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`) VALUES ('$allocateid', '$Sid', '$Tid', '$Sub', '$newtime', '$r[$i]', '$newday') ");
    					}
    					//Added by Kishan
    					//Clearing all the previous entry of the sessions. 
    					$querydelete = mysql_query("DELETE from Student_Tutor_Assignment WHERE `Allocate_Id` = '$allocateid' AND `Date` >= '$date' AND Tutor_Type='C' AND Student_Type='C'");
    					

    				}
    				$A = "Updated";
    			}
    			else
    			{
    				$B = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNot Updated";

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
						<td><label for="name">Student Name :</label></td>
						<td>
		<select name = "Sname" onChange="showStartEndDate()">
			<option>---SELECT---</option>
		<?php
			for($j=0;$j<$no; $j++)
			{
				
				echo "<option value=$studentPolyId[$j]>$studentName[$j]</option>";
			}
		?>
		</select>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
						</td>
				</tr>
				<tr>
						<td><label for="name">Tutor Name :</label></td>
						<td>
		<select name = "Tname" onChange="showStartEndDate()">
			<option>---SELECT---</option>
		<?php
			for($b=0;$b<$no1;$b++)
			{
				echo "<option value=$tutorPolyId[$b]>$tutorName[$b]</option>";
			}
		?>
		</select>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
						</td>
				</tr>
				<tr>
						<td><label for="name">Course/Subject :</label></td>
						<td>
								<select name = "Esub" onChange="showStartEndDate()">
			<option>---SELECT---</option>
		<?php
			for($i=0;$i<$subjectcount;$i++)
			{
				echo "<option value=$allocate_subjectid[$i]>$allocate_subjects[$i]</option>";
			}
		?>
		</select>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
						</td>
				</tr>
				<tr>
						<td> <label for="name">Session Start Date :</label></td>
						<td><div id ="txtStart"></div></td>
												<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				</tr>   
				<tr>
						<td> <label for="name">Session End Date :</label></td>
						<td><div id ="txtEnd"></div></td>
												<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				</tr>
				<tr>
						<td><label for="name">Session Date :</label> </td>
						<td>
								<p><input type="text" id="datepicker" name="date"></p>
						</td>
				</tr>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
				<tr>
						<td><label for="name">Session Time :</label> </td>
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
	<td><label for="name">New Start Date :</label></td>
	
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
