<!-- this page allows you to edit the details of the selected session on the EditOneSession.php page -->
<?php
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
	include '../Rules/days.php';
?>
<?php include 'LoginCheck.php'; ?>
<html>
<head>
    <title>Edit Session Type</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/editonesession.css" />
</head>
<center>
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
	<div id="text2"><p>&nbsp &nbsp &nbsp Edit Session Type</p></div>
    <br>
	<p align="right" style="padding-left:150px"><i>You are here: </i>Edit >> Single Session </p>
	

<form action = "<?php $PHP_SELF; ?>"  method = "post">

<?php
/* Edited By:Parul Joshi Dated: 08/24/2015
Task: to add a 'back' button */

if(isset($_POST["back"])){
	//$url1 = "EditOneSession.php";
	//header("Location:$url1");
	echo "<script type='text/javascript'> document.location = 'EditOneSession.php';</script>";
}


$Sid = $_GET["var1"];
$Tid = $_GET["var2"];
$Sub = $_GET["var3"];
$date = $_GET["var4"];
$time = $_GET["var5"];


$allocateid1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id`='$Sid' AND `Tutor_Poly_Id` = '$Tid' AND `Date`='$date' AND `Session_Time` = '$time' ");
$allocateid2 = mysql_fetch_array($allocateid1);
$allocateid = $allocateid2[Allocate_Id];
$assignmentid = $allocateid2[Assignment_Id];
$Ttype = $allocateid2[Tutor_Type];
$Stype = $allocateid2[Student_Type];
    
$Sdetails1 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$Sid'");
$Sdetails2 = mysql_fetch_array($Sdetails1);
$Slate = $Sdetails2[Lateness];
$Spresence = $Sdetails2[Presence];
$Sns = $Sdetails2[No_Shows];
$Scancel = $Sdetails2[Cancellations];
    
$Tdetails1 = mysql_query("SELECT * FROM Tutor WHERE Tutor_Poly_Id = '$Tid'");
$Tdetails2 = mysql_fetch_array($Tdetails1);
$Tlate = $Tdetails2[Lateness];
$Tpresence = $Tdetails2[Presence];
$Tns = $Tdetails2[No_Shows];
$Tcancel = $Tdetails2[Cancellations];
    
$allocationdetails1 = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE Allocate_Id='$allocateid'");
$allocationdetails2 = mysql_fetch_array($allocationdetails1);
$Scancelcount = $allocationdetails2[Student_Cancel_Count];
$Slatecount = $allocationdetails2[Student_Late_Count];
$Snoshowcount = $allocationdetails2[Student_Noshow_Count];
$Tcancelcount = $allocationdetails2[Tutor_Cancel_Count];
$Tlatecount = $allocationdetails2[Tutor_Late_Count];
$Tnoshowcount = $allocationdetails2[Tutor_Noshow_count];
    
if($assignmentid == ''){
	echo "Incorrect Information";
}else{
 function Tutorupdate($typew, $assign, $allocate, $id, $presence, $late, $ns, $cancel, $latecount, $nscount, $cancelcount ){
    $typex = $typew;
    $assignx = $assign;
    $allocatex = $allocate;
    $Tutorid = $id;
    $presencex = $presence;
    $latex = $late;
    $nsx = $ns;
    $cancelx = $cancel;
    $latecountx = $latecount;
    $nscountx = $nscount;
    $cancelcountx = $cancelcount;
        
    if($typex == "P"){
       $presencex = $presencex + 1;
       $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Tutor_Type='P' WHERE Assignment_Id= '$assignx' ");
       $tutupdate = mysql_query("UPDATE Tutor SET Presence = '$presencex' WHERE Tutor_Poly_Id = '$Tutorid'");
    }elseif($typex == "L"){
       $latex = $latex+1;
       $latecountx = $latecountx + 1;
       $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Tutor_Type='L' WHERE Assignment_Id= '$assignx' ");
       $tutupdate = mysql_query("UPDATE Tutor SET Lateness = '$latex' WHERE Tutor_Poly_Id = '$Tutorid'");
       $tutupdate2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Late_Count = '$latecountx' WHERE Allocate_Id = '$allocatex'");
    }elseif($typex == "N/S"){
      $nsx = $nsx+1;
      $nscountx = $nscountx+1;
      $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Tutor_Type='N/S' WHERE Assignment_Id= '$assignx' ");
      $tutupdate = mysql_query("UPDATE Tutor SET No_Shows = '$nsx' WHERE Tutor_Poly_Id = '$Tutorid'");
      $tutupdate2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Noshow_Count = '$nscountx' WHERE Allocate_Id = '$allocatex'");
    }elseif($typex == "C"){
      $cancelx = $cancelx+1;
      $cancelcountx = $cancelcountx+1;
      $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Tutor_Type='C' WHERE Assignment_Id= '$assignx' ");
	  //Code change start, Shyam March 8th 2017
	//Commented below code, to not increment cancel count when admin cancels the session.
     // $tutupdate = mysql_query("UPDATE Tutor SET Cancellations= '$cancelx' WHERE Tutor_Poly_Id = '$Tutorid'");
      //$tutupdate2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Cancel_Count = '$cancelcountx' WHERE Allocate_Id = '$allocatex'");
	  //Code change end, Shyam March 8th 2017
    }   
        
}
function Studentupdate($typew, $assign, $allocate, $id, $presence, $late, $ns, $cancel, $latecount, $nscount, $cancelcount ){
        $typex = $typew;
        $assignx = $assign;
        $allocatex = $allocate;
        $Tutorid = $id;
        $presencex = $presence;
        $latex = $late;
        $nsx = $ns;
        $cancelx = $cancel;
        $latecountx = $latecount;
        $nscountx = $nscount;
        $cancelcountx = $cancelcount;
       
        if($typex == "P"){
            $presencex = $presencex + 1;
            $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Student_Type='P' WHERE Assignment_Id= '$assignx' ");
            $tutupdate = mysql_query("UPDATE Student SET Presence = '$presencex' WHERE Student_Poly_Id = '$Tutorid'");
        }
        elseif($typex == "L"){
            $latex = $latex+1;
            $latecountx = $latecountx + 1;
            $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Student_Type='L' WHERE Assignment_Id= '$assignx' ");
            $tutupdate = mysql_query("UPDATE Student SET Lateness = '$latex' WHERE Tutor_Poly_Id = '$Tutorid'");
            $tutupdate2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Late_Count = '$latecountx' WHERE Allocate_Id = '$allocatex'");
        }
        elseif($typex == "N/S"){
            $nsx = $nsx+1;
            $nscountx = $nscountx+1;
            $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Student_Type='N/S' WHERE Assignment_Id= '$assignx' ");
            $tutupdate = mysql_query("UPDATE Student SET No_Shows = '$nsx' WHERE Student_Poly_Id = '$Tutorid'");
            $tutupdate2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Noshow_Count = '$nscountx' WHERE Allocate_Id = '$allocatex'");
        }
        elseif($typex == "C"){
            $cancelx = $cancelx+1;
            $cancelcountx = $cancelcountx+1;
            $assignmentupdate = mysql_query("UPDATE Student_Tutor_Assignment SET Student_Type='C' WHERE Assignment_Id= '$assignx' ");
			//Code change start, Shyam March 8th 2017
			//Commented below code, to not increment cancel count when admin cancels the session.
            //$tutupdate = mysql_query("UPDATE Student SET Cancellations= '$cancelx' WHERE Student_Poly_Id = '$Tutorid'");
            //$tutupdate2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Cancel_Count = '$cancelcountx' WHERE Allocate_Id = '$allocatex'");
			//Code change end, Shyam March 8th 2017
        }    
    }
?>
<?php
	if(isset($_POST["go"])){
		$tutortype = $_POST["tutor_type"];
		$studenttype = $_POST["student_type"];
		//Dated: 10/28/2015, Updated by : Parul, Task : added a prompt if student/tutor type is not selected 
		if($tutortype == '---SELECT---'){
		$A = "Select New Tutor type";
		}
		elseif($studenttype == '---SELECT---'){
			$A = "Select New Student Type";
		}else{
		if($tutortype != $Ttype){
			
			if($Ttype == 'L'){
				
				if($Tlate != 0){
					$Tlate = $Tlate -1;
				}

				
				if($Tlatecount != 0){
					$Tlatecount = $Tlatecount - 1;
				}

				$update1 = mysql_query("UPDATE Tutor SET Lateness = '$Tlate' WHERE Tutor_Poly_Id = '$Tid'");
				$update2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Late_Count = '$Tlatecount' WHERE Allocate_Id = '$allocateid'");
				
				if($update1 && $update2){
					Tutorupdate($tutortype, $assignmentid, $allocateid, $Tid, $Tpresence, $Tlate, $Tns, $Tcancel, $Tlatecount, $Tnoshowcount,  $Tcancelcount);
					$B = 'Updated';
				} else             {
					$A = 'Not Updated';
				}

			}

			elseif($Ttype == ''){
				
				if($Tns != 0){
					$Tns = $Tns-1;
				}

				
				if($Tnoshowcount != 0)            {
					$Tnoshowcount = $Tnoshowcount - 1;
				}

				$update1 = mysql_query("UPDATE Tutor SET No_Shows = '$Tns' WHERE Tutor_Poly_Id = '$Tid'");
				$update2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Noshow_count = '$Tnoshowcount' WHERE Allocate_Id = '$allocateid'");
				
				if($update1 && $update2)            {
					Tutorupdate($tutortype, $assignmentid, $allocateid, $Tid, $Tpresence, $Tlate, $Tns, $Tcancel, $Tlatecount, $Tnoshowcount,  $Tcancelcount);
					//echo '<div id = "mesg">' . 'Updated' . '</div>';
					$B='Updated';
				} else             {
					//echo '<div id = "mesg">' . 'Not Updated' . '</div>';
					$A = 'Not Updated';
				}

			}

			elseif($Ttype == 'P'){
				if($Tpresence != 0){
					$Tpresence = $Tpresence-1;
				}
				$update1 = mysql_query("UPDATE Tutor SET Presence = '$Tpresence' WHERE Tutor_Poly_Id = '$Tid'");		
				if($update1){
					Tutorupdate($tutortype, $assignmentid, $allocateid, $Tid, $Tpresence, $Tlate, $Tns, $Tcancel, $Tlatecount, $Tnoshowcount,  $Tcancelcount);
					$B = 'Updated';
				} else{
					$A = 'Not Updated</div>';
				}
			}
			elseif($Ttype == 'C'){

				Tutorupdate($tutortype, $assignmentid, $allocateid, $Tid, $Tpresence, $Tlate, $Tns, $Tcancel, $Tlatecount, $Tnoshowcount,  $Tcancelcount);
				$B = 'Updated';
				
				//Code change start. Shyam March 8th 2017.
				//Decrement cancel count when cancellation change is done through admin
				
				if($Tcancel != 0){
					$Tcancel = $Tcancel-1;
				}

				
				if($Tcancelcount != 0)            {
					$Tcancelcount = $Tcancelcount - 1;
				}

				$update1 = mysql_query("UPDATE Tutor SET Cancellations = '$Tcancel' WHERE Tutor_Poly_Id = '$Tid'");
				$update2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Cancel_Count = '$Tcancelcount' WHERE Allocate_Id = '$allocateid'");
				
				//Code change end. Shyam March 8th 2017.
				
				
/* 				$query_ns_count_tutor = "				
				SELECT Tutor_Poly_Id,count(*) as 'No Show Count' 
				FROM Student_Tutor_Assignment
				where Tutor_Type = 'N/S' and Tutor_Poly_Id = $Tid and subject_id = $Sub				
				";
				$ns_count_tutor_result = mysql_query($query_ns_count_tutor);
				$ns_count_tutor = mysql_fetch_array($ns_count_tutor_result);
				if($ns_count_tutor['No Show Count'] < 2 and $Tcancelcount < 3){
					//unblock tutor
					$query_unblock_tutor = "
					 Update Tutor set Block = 0 where Tutor_Poly_Id = $Tid
					";
					$query_unblock_tutor_result = mysql_query($query_unblock_tutor);
					// mail tutor regarding unlock
					
					$to = $Tdetails2['Tutor_Email'].","."fitltech@nyu.edu".","."trionyupoly@gmail.com".","."jb3372@nyu.edu".","."pb494@nyu.edu".","."srl446@nyu.edu" ;
					//$mailtimestamp = date("F j, Y, g:i a");
					$subject = "TRIO - Tutor UnBlocked";
					$message = "You ($Tdetails2['Tutor_First_Name'] $Tdetails2['Tutor_Last_Name']) have been UnBlocked.";
					$headers[] = "From: shyamrjoshi@gmail.com";
					mail($to, $subject, $message, implode("\r\n", $headers));
				} */
				
			}

			elseif($Ttype == 'N/S'){
				
				Tutorupdate($tutortype, $assignmentid, $allocateid, $Tid, $Tpresence, $Tlate, $Tns, $Tcancel, $Tlatecount, $Tnoshowcount,  $Tcancelcount);
				$B = 'Updated';
				//shyam code changes start
				//calculate the N/s Count.
				//if n/s count<2 and cancelcount<3 unblock the student
/* 				$query_ns_count_tutor = "				
				SELECT Tutor_Poly_Id,count(*) as 'No Show Count' 
				FROM Student_Tutor_Assignment
				where Tutor_Type = 'N/S' and Tutor_Poly_Id = $Tid and subject_id = $Sub				
				";
				$ns_count_tutor_result = mysql_query($query_ns_count_tutor);
				$ns_count_tutor = mysql_fetch_array($ns_count_tutor_result);
				if($ns_count_tutor['No Show Count'] < 2 and $Tcancelcount < 3){
					//unblock tutor
					$query_unblock_tutor = "
					 Update Tutor set Block = 0 where Tutor_Poly_Id = $Tid
					";
					$query_unblock_tutor_result = mysql_query($query_unblock_tutor);
					
					$to = $Sdetails2['Tutor_Email'].","."fitltech@nyu.edu".","."trionyupoly@gmail.com".","."jb3372@nyu.edu".","."pb494@nyu.edu".","."srl446@nyu.edu" ;
					//$mailtimestamp = date("F j, Y, g:i a");
					$subject = "TRIO - Student UnBlocked";
					$message = "You ($Sdetails2['Student_First_Name'] $Sdetails2['Student_Last_Name']) have been UnBlocked.";
					$headers[] = "From: shyamrjoshi@gmail.com";
					mail($to, $subject, $message, implode("\r\n", $headers));
				} */
				
				//shyam code changes end 
			}
		}
		if($studenttype != $Stype)   {
			
			if($Stype == 'L')    {
				
				if($Slate != 0)        {
					$Slate = $Slate -1;
				}

				
				if($Slatecount != 0)        {
					$Slatecount = $Slatecount - 1;
				}

				$update1 = mysql_query("UPDATE Student SET Lateness = '$Slate' WHERE Student_Poly_Id = '$Sid'");
				$update2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Late_Count = '$Slatecount' WHERE Allocate_Id = '$allocateid'");
				
				if($update1 && $update2)        {
					Studentupdate($studenttype, $assignmentid, $allocateid, $Sid, $Spresence, $Slate, $Sns, $Scancel, $Slatecount, $Snoshowcount,  $Scancelcount);
					//echo '<div id = "mesg">' . 'Updated' . '</div>';
					$B = 'Updated';
				} else         {
					//echo '<div id = "mesg">' . 'Not Updated' . '</div>';
					$A = 'Not Updated';
				}
			}
			elseif($Stype == '')    {
				
				if($Sns != 0)        {
					$Sns = $Sns-1;
				}
				if($Snoshowcount != 0)        {
					$Snoshowcount = $Snoshowcount - 1;
				}

				$update1 = mysql_query("UPDATE Student SET No_Shows = '$Sns' WHERE Student_Poly_Id = '$Sid'");
				$update2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Noshow_count = '$Snoshowcount' WHERE Allocate_Id = '$allocateid'");
				
				if($update1 && $update2)        {
					Studentupdate($studenttype, $assignmentid, $allocateid, $Sid, $Spresence, $Slate, $Sns, $Scancel, $Slatecount, $Snoshowcount,  $Scancelcount);
					//echo '<div id = "mesg">' . 'Updated' . '</div>';
					$B = 'Updated';
				} else         {
					//echo '<div id = "mesg">' . 'Not Updated' . '</div>';
					$A = 'Not Updated';
				}

			}
			elseif($Stype == 'P')    {
				
				if($Spresence != 0)        {
					$Spresence = $Spresence-1;
				}

				$update1 = mysql_query("UPDATE Student SET Presence = '$Spresence' WHERE Student_Poly_Id = '$Sid'");
				
				if($update1)        {
					Studentupdate($studenttype, $assignmentid, $allocateid, $Sid, $Spresence, $Slate, $Sns, $Scancel, $Slatecount, $Snoshowcount,  $Scancelcount);
					//echo '<div id = "mesg">' . 'Updated' . '</div>';
					$B= 'Updated';
				} else         {
					//echo '<div id = "mesg">' . 'Not Updated' . '</div>';
					$A = 'Not Updated';
				}

			}

			elseif($Stype == 'C')    {

								
				Studentupdate($studenttype, $assignmentid, $allocateid, $Sid, $Spresence, $Slate, $Sns, $Scancel, $Slatecount, $Snoshowcount,  $Scancelcount);
				$B = 'Updated';
				
				//Code change start. Shyam March 8th 2017.
				//Decrement cancel count when cancellation change is done by admin
				
				if($Scancel != 0){
					$Scancel = $Scancel-1;
				}

				
				if($Scancelcount != 0)            {
					$Scancelcount = $Scancelcount - 1;
				}

				$update1 = mysql_query("UPDATE Student SET Cancellations = '$Scancel' WHERE Student_Poly_Id = '$Sid'");
				$update2 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Cancel_Count = '$Scancelcount' WHERE Allocate_Id = '$allocateid'");
				
				//Code change End. Shyam March 8th 2017.
				
				/* 						
	
				$query_ns_count_student = "				
				SELECT Student_Poly_Id,count(*) as 'No Show Count' 
				FROM Student_Tutor_Assignment
				where Student_Type = 'N/S' and Student_Poly_Id = $Sid and subject_id = $Sub
				";
				$ns_count_student_result = mysql_query($query_ns_count_student);
				$ns_count_student = mysql_fetch_array($ns_count_student_result);
				if($ns_count_student['No Show Count'] < 2 and $Scancelcount < 3){
					//unblock Student
					$query_unblock_student = "
					 Update Student set Block = 0 where Student_Poly_Id = $Sid
					";
					$query_unblock_student_result = mysql_query($query_unblock_student);
				} */
			}

			elseif($Stype == 'N/S')    {
				Studentupdate($studenttype, $assignmentid, $allocateid, $Sid, $Spresence, $Slate, $Sns, $Scancel, $Slatecount, $Snoshowcount,  $Scancelcount);
				$B = 'Updated';
				//shyam code changes start
				//calculate the N/s Count.
				//if n/s count<2 and cancelcount<3 unblock the student
/* 				$query_ns_count_student = "				
				SELECT Student_Poly_Id,count(*) as 'No Show Count' 
				FROM Student_Tutor_Assignment
				where Student_Type = 'N/S' and Student_Poly_Id = $Sid and subject_id = $Sub
				";
				$ns_count_student_result = mysql_query($query_ns_count_student);
				$ns_count_student = mysql_fetch_array($ns_count_student_result);
				if($ns_count_student['No Show Count'] < 2 and $Scancelcount < 3){
					//unblock Student
					$query_unblock_student = "
					 Update Student set Block = 0 where Student_Poly_Id = $Sid
					";
					$query_unblock_student_result = mysql_query($query_unblock_student);
				} */
				
				//shyam code changes end 
			}

		}
	}
}
}

?>

<br><br><br> 
<div class="ex">
<div class = "back">
	<br><br>
    <table>
		<tr>
            <td>Session Date: </td>
            <td><?php echo $date; ?></td>
        </tr>
		<tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
        <tr>
            <td>Session Time: </td>
            <td><?php echo $time; ?></td>
        </tr>
		<tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
		<tr>
            <td>Current Tutor Type: </td>
            <td><?php echo $Ttype; ?></td>
        </tr>
         <tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>         
        <tr>
            <td>New Tutor Type: </td>
            <td>
                <select name="tutor_type">
				<!--Task - to add a blank option Dated: 10/27/2015 -->
					<option>---SELECT---</option>
                    <option value="P">P</option>
                    <option value="L">L</option>
                    <option value="N/S">N/S</option>
                    <option value="C">C</option>
                </select>
            </td>
            
        </tr>
		<tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
        <tr>
            <td>Current Student Type: </td>
            <td><?php echo $Stype; ?></td>
        </tr>
		<tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
        <tr>
            <td>New Student Type: </td>
            <td>
                <select name="student_type">
				<!--Task - to add a blank option Dated: 10/27/2015 -->
					<option>---SELECT---</option>
                    <option value="P">P</option>
                    <option value="L">L</option>
                    <option value="N/S">N/S</option>
                    <option value="C">C</option>
                </select>
            </td>
        </tr>
    </table>
	<br>
	<button type="submit" name="go"><img src="../images/edit.png"  width="102" height="28" border="none"/></a></button>
	<button type="submit" name="back"><img src="../images/back.png"  width="102" height="28" border="none"/></a></button>
   <div class = "mesg" > <?php echo "$A"; ?> </div>
   <div class = "mesg2" > <?php echo "$B"; ?> </div>
</div>
</div>
</form>
</body>
</center>
</html>
