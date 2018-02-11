<!-- This page gives you page to make selection to drop a scheduled session -->
<!--Edited By: Parul Joshi Dated: 08/27/2015 Task : to add the HTML code in this page and correctly place the confirmation msg -->
<?php
include 'LoginCheck.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';
include '../Rules/dbconfig.php';
?>
<html>
    <head>
        <title>Session Drop Confirmation</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/studentblock.css" />
	<link rel="stylesheet" href="../css/datepicker.css"/>
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
	<div id="text2"><p>&nbsp &nbsp &nbsp Session Drop Confirmation</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div> 
		<br><br><br>
<center>

<div class="ex">
<div class="back">
<?php

$fromdate = $_GET["var1"];
$allocateid = $_GET["var2"];
$tutorsessions = $_GET["var3"];
$studentsessions = $_GET["var4"];
$studentid = $_GET["var5"];
$tutorid = $_GET["var6"];
$SessionTime= $_GET["var7"];
$Esub = $_GET["var8"];

?>

<?php

if($tutorsessions == 1 && $studentsessions==1)
{
    $Confirm="This is the last session for the tutor and the student. Are you sure you want to drop?<br><br>";
   
}
elseif($studentsessions == 1)
{
    $Confirm= "This is the last session for student. Are you sure you want to drop?<br><br>";
    
}
elseif($tutorsessions == 1)
{
    $Confirm="This is the last session for Tutor. Are you sure you want to drop?<br><br>";
    
}

?>


<?php
   
    if(isset($_POST["yes"]))
    {
			//Added By: Parul Joshi Dated: 09/15/2015 Task: When a session was dropped, those sessions were not deleted from Student_Tutor_Allocation_Main 
			//table due to which allocating new sessions created problem.So, I deleted the sessions which did not occur and updated the session end date
			 $editDate1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$studentid' AND `Tutor_Poly_Id` = '$tutorid' AND `Session_Time` = '$SessionTime' AND `Date`> CURDATE() AND `Date` < '$fromdate' ORDER BY `Date` Desc ");
			while($editDate2 = mysql_fetch_array($editDate1)){
            $edit[] = $editDate2[Assignment_Id];
            $PreviousSession[] = $editDate2[Date];
			}
			$countNew= count($edit);
			if($countNew==0){
				$drop1 = mysql_query("DELETE FROM Student_Tutor_Allocation_Main WHERE `Allocate_Id`='$allocateid'");
				$drop2 = mysql_query("DELETE FROM Student_Tutor_Assignment WHERE `Allocate_Id`='$allocateid' AND `Date` >= '$fromdate'");
			}else{
				$drop1 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET `Session_End_Date`='$PreviousSession[0]' WHERE `Allocate_Id`='$allocateid'");
				$drop2 = mysql_query("DELETE FROM Student_Tutor_Assignment WHERE `Allocate_Id`='$allocateid' AND `Date` >= '$fromdate'");
			}
		
        if($tutorsessions == 1 && $studentsessions==1)
        {
            $studentinactive = mysql_query("UPDATE Student SET Active = 'NO' WHERE Student_Poly_Id = '$studentid' ");
            $tutorinactive = mysql_query("UPDATE Tutor SET Active = 'NO' WHERE Tutor_Poly_Id = '$tutorid' ");
        }
        elseif($studentsessions == 1)
        {
            $studentinactive = mysql_query("UPDATE Student SET Active = 'NO' WHERE Student_Poly_Id = '$studentid' ");
        }
        elseif($tutorsessions == 1)
        {
            $tutorinactive = mysql_query("UPDATE Tutor SET Active = 'NO' WHERE Tutor_Poly_Id = '$tutorid' ");
        }
        
        if($drop1)
        {
            
			//Added By: Parul Joshi Dated: 09/03/2015 Task: To send email when a session is dropped
				$studentemail1 = mysql_query("SELECT Student_Email FROM Student WHERE Student_Poly_Id = '$studentid'");
				$studentemail2 = mysql_fetch_array($studentemail1);
				$studentemail = $studentemail2[0];
				$c_studentn1 = mysql_query("SELECT Student_First_Name , Student_Last_Name FROM Student WHERE Student_Poly_Id = '$studentid' ");
				$c_studentn2 = mysql_fetch_array($c_studentn1);
				$c_studentfirstn = $c_studentn2[Student_First_Name];
				$c_studentlastn = $c_studentn2[Student_Last_Name];
				$c_studentname = $c_studentfirstn." ".$c_studentlastn;
				 $c_tutorn1 = mysql_query("SELECT Tutor_First_Name , Tutor_Last_Name FROM Tutor WHERE Tutor_Poly_Id = '$tutorid' ");
				 $c_tutorn2 = mysql_fetch_array($c_tutorn1);
				 $c_tutorfirstn = $c_tutorn2[Tutor_First_Name];                       
				 $c_tutorlastn = $c_tutorn2[Tutor_Last_Name];
				 $c_tutorname = $c_tutorfirstn." ".$c_tutorlastn;
				  $subjectName= mysql_query("SELECT `Subject` FROM Subject WHERE `Subject_Id`= $Esub");
				$subjectName1 = mysql_fetch_array($subjectName);
				$subjectName2 =$subjectName1[Subject];
				$getMailSubject = mysql_query("SELECT `DropSession` FROM `Email_Content` WHERE `Type`='Subject'");
				$mailSubject1 = mysql_fetch_array($getMailSubject);
				$mailSubject=$mailSubject1[DropSession];
				$getMailContent = mysql_query("SELECT `DropSession` FROM `Email_Content` WHERE `Type`='Content'");
				$mailContent1 = mysql_fetch_array($getMailContent);
				$mailContent=$mailContent1[DropSession];
				$time =date("Y-m-d H:i:s");
				$to1 = $studentemail.","."fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu".","."pj649@nyu.edu";				
				$headers[] = "From: TRIO Program <trionyupoly@gmail.com>\r\n";
				$subject1 = $mailSubject;
				//Edited By:Parul Joshi Dated:09/23/2015 Task: to add new drop session message with details
//PLEASE DO NOT EDIT THE EMAIL CONTENT --speacially quotes as these are formatted for user readability
				
				$message1="	
				Tutor Name: $c_tutorname
				Student Name: $c_studentname
				Course: $subjectName2
				Day and Time of Session: $fromdate at $SessionTime
";				
				$message1.= $mailContent;
				$message1.="
Sent on : ";			
				$message1.=$time;
				mail($to1, $subject1, $message1, implode("\r\n", $headers)); 
				$A= "Session Dropped";
				//Added by : Parul, Task: Header was not redirecting here, so changed to 'document.location' Dated: 12/03/2015
				echo "<script type='text/javascript'> document.location = 'SessionDrop.php';</script>";
				//$url='SessionDrop.php';
				//header("Location:$url");
        }
        else
        {
			$A= "Session not dropped.Please try again";
            //$A= $PreviousSession[0];
        }
    }
    elseif(isset($_POST["no"]))
    {
        $url='SessionDrop.php';
        header("Location:$url");
    }

?>
<br><br><br>
<form action = "<?php $PHP_SELF; ?>" method = "post" >

<center><?php echo "$Confirm"; ?>
		<br>
		<input type="submit" value=" Yes  " name="yes">
		<input type="submit" value=" No   " name="no"><br><br>
</center>
<div class = "mesg"><?php echo "$err"; ?></div>
<div class = "mesg2"><?php echo "$A"; ?></div>

</div>
</div>
 </center>   
</form>
</div>
</body>
</html>