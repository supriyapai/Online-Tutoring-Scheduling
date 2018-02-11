<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include '../Rules/dbconfig.php';
    include '../Rules/datepicker.php';
    include '../Rules/jQueryPlugins.php';
?>

<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/sessionreschedule.css" />
	<script type="text/javascript">
	function showUser(str) {
		var sDate = document.forms["myForm"]["date"].value;
		var nyuID = document.forms["myForm"]["polyid"].value;
 		if(nyuID == ''){
			alert('Please enter your university id');
		}else if(sDate == ''){
			alert('Please select a Session Date');
		}else if(str== null || str == '--SELECT--'){
			alert('Please select a Session Time');
		}  
    if (str == "") {
        document.getElementById("studentName").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("studentInfo").innerHTML = xmlhttp.responseText;  
		}
    };
    xmlhttp.open("GET","studentSubject.php?time="+str+"&date="+sDate+"&id="+nyuID, true);
    xmlhttp.send();
}
function test(){
	alert('Please ask your tutor to reschedule your session!!');
}
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	
<body>
<div id="container">	
	<div id="banner">
	<img src="../images/banner2.png"  width="1022" height="150" border="none"/>
	</div>
	
	<div id="line">
	</div>
	
	<div id="login">
		<a href="Adminlogon.php" ><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></a>
	</div>
	
	 <div id="adminlogin">
	 <a href="StudentSelectFunction.php"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></a>
	</div>
	
	<div id="body">
	</div>

	<div id="submit">
	</div>
    
    <div id="back">   
    </div>
	   
	<div id="inputboxbackground">
	</div>
<?php
if(isset($_POST["reschedule"])){
	$conv1 = $_POST["date"];
	$conv2 = strtotime($conv1);
	$date = date('Y-m-d',$conv2);
	$sessiontime = $_POST["SessionTime"];
	$newdateconvo1 = $_POST["newdate"];
	$newdateconvo2 = strtotime($newdateconvo1);
	$newdate = date('Y-m-d',$newdateconvo2);
	$newsessiontime = $_POST["NewSessionTime"];
	$polyid = $_POST["polyid"];
	$currentdate=date("Y-m-d");
	$studentInfo1 = $_POST["studentInfo"];
	$studentInfo = explode(",", $studentInfo1);
	$studentid = $studentInfo[0];
	$subjectid = $studentInfo[1];	
	$assignmentId = $studentInfo[2];	
	//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
	if(preg_match("/^\d{8}$/", $_POST["polyid"]) === 0) {
		//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
		$error = '<p class="errText">University N Number must be 8 digits</p>';
		echo "$error";
	}elseif($conv1 == ""){
		$error= '<p class="errText2">Please Enter The date of the session you wished to reschedule</p>';
		echo "$error";
	}elseif($sessiontime == '---SELECT---'){
		$error= '<p class="errText2">Please select the session time of your old session';
		echo "$error";
	}elseif($newdateconvo1 == ''){
		$error= '<p class="errText">Please select the new date';
		echo "$error ";
	}elseif($newsessiontime == '---SELECT---'){
		$error= '<p class="errText">Please select the new session time';
		echo "$error";
	}elseif($date<=$currentdate){
		$error= '<p class="errText2">You can not reschedule this session because of the date</p>';
		echo "$error";
		}else{
		$d = mysql_query("SELECT DAYOFWEEK('$newdate')");
		$d1 = mysql_fetch_array($d);
		$d2 = $d1[0];

					//Dated: 11/5/2015 Edited By: Parul Task: to remove multiple messages
					
						
					$studentemail1 = mysql_query("SELECT Student_Email, `Reschedules` FROM Student WHERE Student_Poly_Id = '$studentid' ");
					$studentemail2 = mysql_fetch_array($studentemail1);
					$studentemail = $studentemail2[Student_Email];
					$studentreschedule = $studentemail2[Reschedules];
					
					$tutorreschedule1 = mysql_query("SELECT Reschedules FROM Tutor WHERE Tutor_Poly_Id = '$polyid' ");
					$tutorreschedule2 = mysql_fetch_array($tutorreschedule1);
					$tutorreschedule = $tutorreschedule[0];
				
					$values1 = mysql_query("SELECT `Allocate_Id`, `Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id` FROM Student_Tutor_Assignment WHERE Assignment_Id = '$assignmentId'");
					$values2 = mysql_fetch_array($values1);
			
					$allocateid = $values2[Allocate_Id];
					$studentid =  $values2[Student_Poly_Id];
					$tutorid =    $values2[Tutor_Poly_Id];
					$subjectid =  $values2[Subject_Id]; 
				//Modified by Kishan
				//Prev Code: 
				/*
				$sessioncheck1 = mysql_query(" SELECT Session_Type FROM Student_Tutor_Assignment WHERE Assignment_Id = '$assignmentcheck[$i]' ");
				$sessioncheck2 = mysql_fetch_array($sessioncheck1);
				$sessioncheck = $sessioncheck2[Session_Type];
				*/
				
					$sessioncheck1 = mysql_query(" SELECT Session_Type,Student_Type,Tutor_Type FROM Student_Tutor_Assignment WHERE Assignment_Id = '$assignmentId' ");
					$sessioncheck2 = mysql_fetch_array($sessioncheck1);
					//$sessioncheck = $sessioncheck2[Session_Type];
					//***************Added extra lines of below code********
					$studenttypecheck=$sessioncheck2[Student_Type];
					$tutortypecheck=$sessioncheck2[Tutor_Type];
					//echo "here :$studenttypecheck:$tutortypecheck";
					if($studenttypecheck==C || $tutortypecheck==C){
					//echo "here";
						$sessioncheck=C;
					}else{
						$sessioncheck="";
					}
				//*****************************
					if($sessioncheck == C){	
					//Modified by Kishan	
					//$update = mysql_query("UPDATE Student_Tutor_Assignment SET Session_Type = 'C' WHERE Assignment_Id = $assignmentcheck[$i] ");
					
					//$insert2= mysql_query("INSERT INTO `Student_Tutor_Allocation_Main`(`Student_Poly_Id`, `Student_First_Name`, `Student_Last_Name`, `Tutor_Poly_Id`, `Tutor_First_Name`, `Tutor_Last_Name`,  `Subject`, `Time`, `Day`, `Session_Start_Date`, `Session_End_Date`) VALUES ('$Sname', '$studentnamesfn', '$studentnamesln', '$Tname', '$tutornamesfn', '$tutornamesln',  '$subject', '$SessionTime', '$d2', '$SessionStart', '$SessionEnd';
					$studentnames1 = mysql_query("SELECT `Student_First_Name`, `Student_Last_Name` FROM Student WHERE Student_Poly_Id = '$studentid' ");
					$studentnames2 = mysql_fetch_array($studentnames1);
					$studentnamesfn = $studentnames2[Student_First_Name];
					$studentnamesln = $studentnames2[Student_Last_Name];
					$studentname = $studentnamesfn." ".$studentnamesln;
					//Shyam Joshi Code Change Begin. Fetch Tutor Email Id to send email to tutors also. Added Tutor_Email
					$tutornames1 = mysql_query("SELECT `Tutor_First_Name`, `Tutor_Last_Name`,`Tutor_Hours` , Tutor_Email FROM Tutor WHERE Tutor_Poly_Id = '$tutorid' ");
					//Shyam Joshi Code Change End. Fetch Tutor Email Id to send email to tutors also. Added Tutor_Email
					$tutornames2 = mysql_fetch_array($tutornames1);
					$tutornamesfn = $tutornames2[Tutor_First_Name];
					$tutornamesln = $tutornames2[Tutor_Last_Name];
					//Shyam Joshi Code Change Begin. Fetch Tutor Email Id to send email to tutors also. Added Tutor_Email
					$tutoremail = $tutornames2[Tutor_Email];
					//Shyam Joshi Code Change End. Fetch Tutor Email Id to send email to tutors also. Added Tutor_Email
					$tutorname = $tutornamesfn." ".$tutornamesln;

					$subname1 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subjectid' ");
					$subname2 = mysql_fetch_array($subname1);
					$subname = $subname2[Subject];
					
					$getMailSubject = mysql_query("SELECT `Reschedule` FROM `Email_Content` WHERE `Type`='Subject'");
					$mailSubject1 = mysql_fetch_array($getMailSubject);
					$mailSubject=$mailSubject1[Reschedule];
					$getMailContent = mysql_query("SELECT `Reschedule` FROM `Email_Content` WHERE `Type`='Content'");
					$mailContent1 = mysql_fetch_array($getMailContent);
					$mailContent=$mailContent1[Reschedule];
					
					//Dated: 11/5/2015 Task : to check redundant sessions Added By:Parul
					
					//$checksession1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$Sname' AND `Tutor_Poly_Id`='$Tname' AND `Subject_Id`= '$subject' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND `Session_Time` = '$SessionTime' AND `Day` = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C' ");
					$checksession1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$studentid' AND `Tutor_Poly_Id`='$tutorid' AND `Subject_Id`= '$subjectid' AND `Date` = '$newdate' AND `Session_Time` = '$newsessiontime'  AND `Student_Type` !='C' AND `Tutor_Type`!='C' ");
					$checksession2 = mysql_fetch_array($checksession1);
					$checksession = $checksession2[Allocate_Id];

					//$checksessionTutor = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Tname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
					$checksessionTutor = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$tutorid' AND `Date` = '$newdate' AND `Session_Time` = '$newsessiontime' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
					$checksessionTutorArr = mysql_fetch_array($checksessionTutor);
					$checksessionTutorFlag = $checksessionTutorArr[Allocate_Id];
					
					//$checksessionStudent = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id` = '$Sname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
					$checksessionStudent = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$studentid' AND `Date` = '$newdate' AND `Session_Time` = '$newsessiontime' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
					$checksessionStudentArr = mysql_fetch_array($checksessionStudent);
					$checksessionStudentFlag = $checksessionStudentArr[Allocate_Id];

					//$checksessionTutorSt = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Sname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
					$checksessionTutorSt = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$studentid' AND `Date` = '$newdate' AND Session_Time = '$newsessiontime' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
					$checksessionTutorStArr = mysql_fetch_array($checksessionTutorSt);
					$checksessionTutorStFlag = $checksessionTutorStArr[Allocate_Id];

					//$checksessionStudentTu = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id` = '$Tname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
					$checksessionStudentTu = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$tutorid' AND `Date` = '$newdate' AND Session_Time = '$newsessiontime' AND `Student_Type` !='C' AND `Tutor_Type`!='C' ");
					$checksessionStudentTuArr = mysql_fetch_array($checksessionStudentTu);
					$checksessionStudentTuFlag = $checksessionStudentTuArr[Allocate_Id];
					
					$flag = true;
					
					if($checksession != 0){
						$error=  '<p class="errText">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspThis Session Already Exists</p>';
						$flag =false;
						
					}elseif($checksessionTutorFlag != 0){
						//$A = "Another session exists for selected Tutor on the same day and time";
						$doubleSession = mysql_query("SELECT COUNT(DISTINCT Student_Poly_Id) AS studentCount FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$tutorid' AND `Date` = '$newdate' AND `Session_Time` = '$newsessiontime'  AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
						$doubleSessionArr = mysql_fetch_array($doubleSession);
						$doubleSessionFlag = $doubleSessionArr[studentCount];
						//to check the count of students in this session
						if ($doubleSessionFlag>1){
								   $error = '<p class="errText">Sorry, this session already has two students</p>';
								   $flag =false;
								   
								   
						}else{
							$confirmSubject = mysql_query("SELECT Subject_Id FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$tutorid' AND `Date` = '$newdate' AND `Session_Time` = '$newsessiontime' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
							$confirmSubjectArr = mysql_fetch_array($confirmSubject);
							$confirmSubjectFlag = $confirmSubjectArr[Subject_Id];
							if($subject != $confirmSubjectFlag){
								$error = '<p class="errText">Tutor teaches another subject on the same day and time</p>';						
								$flag =false;
							}else{
								echo "<script type='text/javascript'>
										var answer = confirm('Session entered by you will be a Double Session.Please confirm if you want this session');
										if (answer == false){	
											window.location('Allocate.php');
										}
										</script>";
								$flag = true;
							}
						}	
					}elseif($checksessionStudentFlag != 0) {
						$error = '<p class="errText">Another session exists for selected Student on the same day and time</p>';
						
						$flag =false;
					}elseif($checksessionTutorStFlag != 0) {
						$error = '<p class="errText">Another session exists for selected Student as Tutor on the same day and time</p>';
						echo "$error";
						$flag =false;
					}elseif($checksessionStudentTuFlag != 0) {
						$error = '<p class="errText">Another session exists for selected Tutor as Student on the same day and time</p>';
						echo "$error";
						$flag =false;
					} 
					if ($flag == true){ //added till here on 11/5/2015 by parul
					$insertAllocation = mysql_query("INSERT INTO  Student_Tutor_Allocation_Main (`Student_Poly_Id`, `Student_First_Name`, `Student_Last_Name`, `Tutor_Poly_Id`, `Tutor_First_Name`, `Tutor_Last_Name`,  `Subject`, `Time`, `Day`, `Session_Start_Date`, `Session_End_Date`) VALUES ('$studentid','$studentnamesfn','$studentnamesln','$tutorid','$tutornamesfn','$tutornamesln','$subjectid','$newsessiontime','$d2','$newdate','$newdate')");
					//Edited By Parul Dated: 10/8/2015 Task: Subject variable was incorrect
					$insertAlID1      = mysql_query("SELECT *  from Student_Tutor_Allocation_Main  
																			where `Student_Poly_Id`= '$studentid'          and
																				   `Tutor_Poly_Id`=  '$tutorid'            and 
																				   `Subject`      =  '$subjectid'          and
																				   `Time`         =  '$newsessiontime'     and
																				   `Session_Start_Date`  =  '$newdate'   ");
					$insertAlID2= mysql_fetch_array($insertAlID1);	

					$insertAlID = $insertAlID2[Allocate_Id]	;					
					$insert = mysql_query("INSERT INTO Student_Tutor_Assignment(`Allocate_Id`, `Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`, `Session_Type`) VALUES ('$insertAlID', '$studentid', '$tutorid', '$subjectid', '$newsessiontime', '$newdate', '$d2', 'R') ");
					
					if($insert)
					{
						$addstudentreschedule = $studentreschedule+1;
						$addtutorreschedule = $tutorreschedule+1;
						
						$studentreschedule = mysql_query("UPDATE Student SET Reschedules = '$addstudentreschedule' WHERE Student_Poly_Id = '$studentdetails'");
						$tutorreschedule =   mysql_query("UPDATE Tutor SET Reschedules = '$addtutorreschedule' WHERE Tutor_Poly_Id = '$polyid'"); 
					
						$time =date("Y-m-d H:i:s");
						$to = "$tutoremail".","."fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu".","."$studentemail";
						//Edited By:Parul Joshi Dated:09/23/2015 Task: to add new reschedule message with details
						$subject = $mailSubject;
						$message = "
				Tutor Name: $tutorname
				Student Name: $studentname
				Course: $subname
				Day and Time of Session: $date at $sessiontime
				Rescheduled Day and Time of Session:$newdate at $newsessiontime
";
						$message.=$mailContent;
						$message.="
Sent on : ";			
						$message.=$time;
						$headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
						mail($to, $subject, $message, implode("\r\n", $headers));
						
						//$url1 = "StudentSelectFunction.php";
						//header("Location:$url1");
						$error= '<p class="errText3">Your Session is Rescheduled';
						echo "$error";
					}
					else
					{
						$error= '<p class="errText">Error';
						echo "$error";
					}
					}else{
						echo "$error";
					}
				}elseif(!$sessioncheck)
				{	//try removing this
					if($date<=$currentdate)
					{
						$error= '<p class="errText2">You can not reschedule this session because of the date</p>';
						echo "$error";
					}
					elseif($date>$currentdate)
					{
						$error= '<p class="errText">Please Cancel The Session Before Rescheduling';
						echo "$error";
						
						/* Keep this part commented
						$update = mysql_query("UPDATE Student_Tutor_Assignment SET Session_Type = 'R for $newdate' WHERE Assignment_Id = $assignmentcheck[$i] ");
					
						$insert = mysql_query("INSERT INTO Student_Tutor_Assignment(`Allocate_Id`, `Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`, 							`Session_Type`) VALUES ('$allocateid', '$studentid', '$tutorid', '$subjectid', '$newsessiontime', '$newdate', '$d2', 'R') ");
						if($insert)
						{
							
							$to = "$studentemail".","."fitltech@nyu.edu" ;
							$subject = "Test";
							$message = "Your TRIO Session On $date for the subject $subname at $sessiontime am/pm EST has been Rescheduled to $newdate my student is $studentemail";
							mail($to, $subject, $message);

							$url1 = "StudentSelectFunction.php";
							header("Location:$url1");
				
						}
						else
						{
							echo "Error";
						}	
						Keep this part commented ends here*/  
				}
				}			
				else{
					echo "$sessioncheck";
				}	
			
	}
}
if(isset($_POST["done"])){
	$url1 = "SessionModify.php";
	header("Location:$url1");
}	
?>

 <div id="text2">
    <p>Session Reschedule</p>
    </div>

<table border="0">
<tr>
<td>
<center>

<form action="<?php $PHP_SELF; ?>" method="post" name ="myForm">
<table>
<tr>
<td ><font size="3">University Id :</td>
<td><input type="text" placeholder="University ID" maxlength="8" name="polyid" value="<?php print $polyid; ?>"></td>
</tr>
<tr>
<td><font size="3">Session Date :</td>
<td><input type="text" placeholder="Choose a date" class="datepicker" name="date"></td>
</tr>
<tr>
<td><font size="3">Session Time :</td>
<td>
	<select name="SessionTime" onChange="showUser(this.value);">	
		<option value ="--SELECT--">---SELECT---</option>
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
<!-- Added By Parul, Dated: 11/11/2015 Task: Add Student Name, subject name so that tutor can select a student to reschedule for double session -->
<tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<td><font size="3">Student Info:</td>
<td><div id ="studentInfo"></div>
</td>
</tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr>
<td><font size="3">New date: </td>
<td><input type="text" placeholder="Choose a date" class="datepicker" name="newdate"></td>
</tr>
<tr>
<td><font size="3">New Time :</td>
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
</td>
</tr>
<br>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
</table>
<button type="submit" name="reschedule" value="Reschedule" ><img src="../images/submit.png"  width="102" height="28" border="none"/></button>
<button type="submit" name="done" value="Done"><img src="../images/back.png"  width="102" height="28" border="none"/></button>
</form>
</center>
</td>
</tr>

</table>

</center>
</body>
</html>