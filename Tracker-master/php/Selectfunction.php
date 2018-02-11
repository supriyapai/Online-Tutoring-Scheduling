<!-- This page displays livereport based on the time -->

<?php include 'LoginCheck.php'; 


?>

<?php
	include '../Rules/dbconfig.php';;
	$files = glob('../download/*'); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file))
		unlink($file); // delete file
}
?>
<html>
<head>
<!-- The information of the title -->
    <title>Live Report</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	
<!-- Refresh the page in 60 seconds -->
	<meta http-equiv="refresh" content="60">
	
<!-- CSS stylesheet -->
	<link rel="stylesheet" type="text/css" href="../css/reports.css" />

<style>
	div.ex {
		top:250px;
		position: relative;
	}

	#scroll{
		width:917px;
		height:550px;
		overflow:scroll;
	}
</style>
</head>

<!-- The Page will refresh in every 60 seconds -->
<body>

<!-- The outline of the tracker -->
<div id="container" class = "scroll">
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
				<!--Edited By: Parul Joshi Dated: 08/24/2015 Task: To change Single Session & Multiple Session to Session type & Session Schedule
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
	<div id="text2">
		<!-- The report title -->
		<p>&nbsp &nbsp &nbsp Live &nbsp Report</p>
	</div>
	<div id="text3">
		<!-- Sign out button -->
		<a href="Adminlogon.php"><p>Sign Out</p></a>
	</div> 
	<div class = "ex"> 		
	<center>
 
<?php
//Establishing a connection with the host
		include '../Rules/dbconfig.php';	
?>

<?php
// Query to select the livereport form from Student_Tutor_Assignment Table
// Edited By: Parul Joshi Dated: 09/09/2015 Task :Display all the Sessions in the Live Report Which are about to occur after 20 minutes
	$session1 = mysql_query("Select * from Student_Tutor_Assignment where Session_Time< DATE_ADD(NOW(),INTERVAL 20 MINUTE )  and Date=curdate( ) order by Session_Time desc" );

// Use mysql_fetch_array() function to get the elements
    while($sessions2 = mysql_fetch_array($session1)){
		$assignmentid[] = $sessions2[Assignment_Id];
		$date[] = $sessions2[Date];
		$stype[] = $sessions2[Student_Type];
		$slogin[] = $sessions2[Student_Current_Time];
		$tlogin[] =$sessions2[Tutor_Current_Time];
		$ttype[] = $sessions2[Tutor_Type];
		$sessiontype[] = $sessions2[Session_Type];
		$sessiontime[] = $sessions2[Session_Time];
		$Sid[] = $sessions2[Student_Poly_Id];
		$Tid[] = $sessions2[Tutor_Poly_Id];
		$subid[] = $sessions2[Subject_Id];
	}
      
    $count = count($assignmentid);
      
    for($a=0; $a<$count; $a++){ 
// Combine the first and last name together and store in the $studentname[]
        $student1 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$Sid[$a]'");
        $student2 = mysql_fetch_array($student1);
        $studentfn = $student2[Student_First_Name];
        $studentln = $student2[Student_Last_Name];
        $studentname[] = $studentfn." ".$studentln; 
//Combine the first and last name together and store in the $tutorname[]       
        $tutor1 = mysql_query("SELECT * FROM Tutor WHERE Tutor_Poly_Id = '$Tid[$a]'");
        $tutor2 = mysql_fetch_array($tutor1);
        $tutorfn = $tutor2[Tutor_First_Name];
        $tutorln = $tutor2[Tutor_Last_Name];
        $tutorname[] = $tutorfn." ".$tutorln;
 // Get the Subject ID       
        $subject1 = mysql_query("SELECT * FROM Subject WHERE Subject_Id = '$subid[$a]'");
        $subject2 = mysql_fetch_array($subject1);
        $subject[] = $subject2[Subject];
}
	  
// The first line of the table, please pay attention to the order
echo "<br><br><br> <div id=\"scroll\"> <table border=\"1\" bordercolor=\"#52981a\" bgcolor=\"white\" style=\"text-align:center\">";
echo "<tr bgcolor=\"e4e4e4\">";
echo "<th>Session Time</th>";
echo "<th>Session Type</th>";
echo "<th>Subject</th>";
echo "<th>Tutor Name</th>";
echo "<th>Tutor Type</th>";
echo "<th>Student Name</th>";
echo "<th>Student Type</th>";
echo "</tr>";


for($i=0; $i<$count; $i++){
 //The Variables of the table   
    echo "<tr>";	
	//Begin of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
	//echo "<td>$sessiontime[$i]</td>";
	echo "<td>".date('g:i a', strtotime($sessiontime[$i]))."</td>";
	//End of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
	echo "<td>$sessiontype[$i]</td>";
	echo "<td>$subject[$i]</td>";
    echo "<td>$tutorname[$i]</td>";
	echo "<td>$ttype[$i]</td>";
    echo "<td>$studentname[$i]</td>";
    echo "<td>$stype[$i]</td>";
    echo "</tr>";
}
echo "</table>";
?>
<?php
// Query to select the No show Student form from Student_Tutor_Assignment Table
//Begin of code changes Shyam Rajendra Joshi 1st February 2017
// No Show Policy changed, Update No Show after 15 minutes instead of 20 minutes.
//Old code commented below
/*     $session3 = mysql_query("SELECT * FROM Student_Tutor_Assignment where HOUR(now( )) between 4 and 22 and
                                         DATE_ADD(now( ), INTERVAL -20 minute) > Session_time and
	                                     Date=curdate( ) and Student_Type=' '" );
 */
//Old code comment ends
//New code starts
    $session3 = mysql_query("SELECT * FROM Student_Tutor_Assignment where HOUR(now( )) between 4 and 22 and
                                         DATE_ADD(now( ), INTERVAL -15 minute) > Session_time and
	                                     Date=curdate( ) and Student_Type=' '" );
//New code Ends				
//End Of Code Changes Shyam Rajendra Joshi 1st February 2017 									 										 
// Use mysql_fetch_array() function to get the elements
if (mysql_num_rows($session3)!=0) {  
           while($sessions4 = mysql_fetch_array($session3))
          {
		   $allocateid1[] = $sessions4['Allocate_Id'];
           $assignmentid1[] = $sessions4['Assignment_Id'];
           $student_ns_id[] = $sessions4['Student_Poly_Id'];
        
          }
      
            $count = count($assignmentid1);
			//print_r($assignmentid1);
	       for($a=0; $a<$count; $a++)
          { 
		    $No_Show_Student = mysql_query("UPDATE Student_Tutor_Assignment SET Student_Type='N/S' 
																		WHERE Assignment_Id = '$assignmentid1[$a]'");
		  }
		   
		   	//Code changes Start, Shyam March 10th 2017
		   //If No show count >= 2 in one subject, block the student
		   
		   
		   
		   if(!empty($student_ns_id)){
		   
		   
		   
		   $student_ns_id_s = join(",",$student_ns_id);  
		   $allocate_student_ns_id_s = join(",",$allocateid1);  
		  
		  $query_student_ns_list = "
			select Student_Poly_Id,Allocate_Id,Tutor_Poly_Id,Subject_Id,count(*)
				from Student_Tutor_Assignment
				where Student_Type = 'N/S'
				and Student_Poly_Id in ($student_ns_id_s)				
				group by Student_Poly_Id,Allocate_Id,Tutor_Poly_Id,Subject_Id
				having count(*) >= 2
		  ";
		  
		  //block students having N/s count >= 2
		  
		  $result_student_ns_list = mysql_query($query_student_ns_list);
		  while($result_student_list_ns = mysql_fetch_assoc($result_student_ns_list))
			  {
			   $allocateid_ns[] = $result_student_list_ns['Allocate_Id'];
			   $student_ns_list[] = $result_student_list_ns['Student_Poly_Id'];
			
			  }
		  
		   if(!empty($student_ns_list)){
			  $student_ns_list_s = join(",",$student_ns_list); 
			  //print_r($student_ns_list_s);
			   $query_block_ns_student = "		   
			   Update Student set Block = 1 where Student_Poly_Id in ($student_ns_list_s)							   
			   ";
			   
			   $block_ns_student = mysql_query($query_block_ns_student); 
		   }
		  
		  //Block Student, if cancellation count >=3 and there is a N/s
		  $query_cancel_count_student = "
			
				SELECT Student_Poly_Id,Allocate_Id,Tutor_Poly_Id,Subject, Student_Cancel_Count FROM Student_Tutor_Allocation_Main
					where Student_Poly_Id in ($student_ns_id_s)
					group by Student_Poly_Id,Allocate_Id,Tutor_Poly_Id,Subject,Student_Cancel_Count
					having Student_Cancel_Count >= 3
					;
			 ";	
			 
			$result_student_cancel_list = mysql_query($query_cancel_count_student); 
		    while($result_student_list_cancel = mysql_fetch_assoc($result_student_cancel_list))
			  {
			   $allocateid_cancel[] = $result_student_list_cancel['Allocate_Id'];
			   $student_cancel_list[] = $result_student_list_cancel['Student_Poly_Id'];
			
			  }
			if(!empty($student_cancel_list)){
			  $student_cancel_list_s = join(",",$student_cancel_list); 
			  //print_r($student_cancel_list_s);
			   $query_block_cancel_student = "		   
			   Update Student set Block = 1 where Student_Poly_Id in ($student_cancel_list_s)
					)		   
			   ";
			   
			   $block_cancel_student = mysql_query($query_block_cancel_student); 
		   }
		   
		   //send email to all students that have been blocked.
		   if(!empty($allocateid_ns) and !empty($allocateid_cancel) ){
		   $email_allocate_id = array_unique(array_merge($allocateid_ns,$allocateid_cancel), SORT_REGULAR);
		   }
		   else{
			   if(!empty($allocateid_ns) and empty($allocateid_cancel)){
				   $email_allocate_id = array_unique($allocateid_ns);
			   }
			   else{
				   if(!empty($allocateid_cancel) and empty($allocateid_ns)){
					    $email_allocate_id = array_unique($allocateid_cancel);
				   }
				   else{
					    $email_allocate_id = [];
				   }
				  
			   }
		   }
		 
		    if(!empty($email_allocate_id)){
				$allocateid_cancel_ns_s = join(",",$email_allocate_id);  
				
				
				$student_detail_query = "
				select  distinct sta.Student_Poly_Id,sta.Student_First_Name,sta.Student_Last_Name, s.Student_Email, sb.Subject 
				from Student_Tutor_Allocation_Main sta
				inner join Student s on sta.Student_Poly_Id = s.Student_Poly_Id 
				inner join Subject sb on sta.Subject = sb.Subject_Id
				where Allocate_Id in ($allocateid_cancel_ns_s) 
				";
				$student_detail_query_result = mysql_query($student_detail_query);
				
				if($student_detail_query_result){
						$student_detail_email = mysql_fetch_assoc($student_detail_query_result);
						   
                        		
                        		$to = $student_detail_email['Student_Email'].","."fitltech@nyu.edu".","."trionyupoly@gmail.com".","."jb3372@nyu.edu".","."pb494@nyu.edu".","."srl446@nyu.edu" ;
								$mailtimestamp = date("F j, Y, g:i a");
								$subject = "TRIO Student Block - Excessive No Shows";
								$message = "Dear ".$student_detail_email['Student_First_Name']." ".$student_detail_email['Student_Last_Name'].",\n\nDue to excessive cancellations/No Shows, your TRIO tutoring for ".$student_detail_email['Subject']." course has been terminated.  Please make an appointment to see the Coordinator to discuss reinstating your tutoring.\r\n\n\n\n​Thank you,\r\nTRIO Scholars Program\r\n​[$mailtimestamp]\r\n";
								$headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
								//$headers[] = "From: shyamrjoshi@gmail.com";
								mail($to, $subject, $message, implode("\r\n", $headers));

				}
				
				
			}

		   }
		   }
		   
	
	
	
	
	
	
	
//Begin of code changes Shyam Rajendra Joshi 1st February 2017
// No Show Policy changed, Update No Show after 15 minutes instead of 20 minutes.
//Old code commented below
/* 	$session5 = mysql_query("SELECT * FROM Student_Tutor_Assignment where HOUR(now( )) between 4 and 22 and
                                          DATE_ADD(now( ), INTERVAL -20 minute) > Session_time	 and Date=curdate( ) and Tutor_Type=' '" );
	 */									  
//Old code comment ends
//New code starts
		$session5 = mysql_query("SELECT * FROM Student_Tutor_Assignment where HOUR(now( )) between 4 and 22 and
                                          DATE_ADD(now( ), INTERVAL -15 minute) > Session_time	 and Date=curdate( ) and Tutor_Type=' '" );
//New code Ends				
//End Of Code Changes Shyam Rajendra Joshi 1st February 2017 
// Use mysql_fetch_array() function to get the elements
if (mysql_num_rows($session5)!=0) { 
           while($sessions6 = mysql_fetch_array($session5))
          {
			//print_r($sessions6);
		   $allocateid2[] = $sessions6['Allocate_Id'];
           $assignmentid2[] = $sessions6['Assignment_Id'];
		   $tutor_ns_id[] = $sessions6['Tutor_Poly_Id'];
          }
      
           $count = count($assignmentid2);
	       for($a=0; $a<$count; $a++)
          {
		    $No_Show_Tutor = mysql_query("
			UPDATE Student_Tutor_Assignment SET Tutor_Type='N/S' 			
			WHERE Assignment_Id = '$assignmentid2[$a]'");
			// Dated: 12/23/2015 Task: A random number appears below the report which can be seen till a N/S is updated in the report 
			//echo "<td>&nbsp &nbsp $assignmentid2[$a]</td>";
		 }
		   	//Code changes Start, Shyam March 10th 2017
		   //If No show count >= 2 in one subject, block the Tutor
		   
		   
		   
		   if(!empty($tutor_ns_id)){
		   
		   
		   
		   $tutor_ns_id_s = join(",",$tutor_ns_id);  
		   $alocate_tutor_ns_id_s = join(",",$allocateid2);  
		  
		  $query_tutor_ns_list = "
			select Tutor_Poly_Id,Allocate_Id,Student_Poly_Id,Subject_Id,count(*)
				from Student_Tutor_Assignment
				where Tutor_Type = 'N/S' and Tutor_Poly_Id in ($tutor_ns_id_s)				
				group by Tutor_Poly_Id,Allocate_Id,Student_Poly_Id,Subject_Id
				having count(*) >= 2
		  ";
		  
		  //block Tutors having N/s count >= 2
		  
		  $result_tutor_ns_list = mysql_query($query_tutor_ns_list);
		  while($result_tutor_list_ns = mysql_fetch_assoc($result_tutor_ns_list))
			  {
			   $tutor_allocateid_ns[] = $result_tutor_list_ns['Allocate_Id'];
			   $tutor_ns_list[] = $result_tutor_list_ns['Tutor_Poly_Id'];
			
			  }
		  
		   if(!empty($tutor_ns_list)){
			  $tutor_ns_list_s = join(",",$tutor_ns_list); 
			  //print_r($student_ns_list_s);
			   $query_block_ns_tutor = "		   
			   Update Tutor set Block = 1 where Tutor_Poly_Id in ($tutor_ns_list_s)
							   
			   ";
			   
			   $block_ns_tutor = mysql_query($query_block_ns_tutor); 
		   }
		  
		  //Block tutor, if cancellation count >=3 and there is a N/s
		  $query_cancel_count_tutor = "				
						SELECT Tutor_Poly_Id,Allocate_Id,Tutor_Cancel_Count,Student_Poly_Id,Subject
							FROM Student_Tutor_Allocation_Main
							where Tutor_Poly_Id in ($tutor_ns_id_s)
							group by Tutor_Poly_Id,Allocate_Id,Tutor_Cancel_Count,Student_Poly_Id,Subject
							having Tutor_Cancel_Count >= 3
						;
			 ";	
			 
			$result_tutor_cancel_list = mysql_query($query_cancel_count_tutor); 
		    while($result_tutor_list_cancel = mysql_fetch_assoc($result_tutor_cancel_list))
			  {
			   $tutor_allocateid_cancel[] = $result_tutor_list_cancel['Allocate_Id'];
			   $tutor_cancel_list[] = $result_tutor_list_cancel['Tutor_Poly_Id'];
			
			  }
			if(!empty($tutor_cancel_list)){
			  $tutor_cancel_list_s = join(",",$tutor_cancel_list); 
			  //print_r($student_cancel_list_s);
			   $query_block_cancel_tutor = "		   
			   Update Tutor set Block = 1 where Tutor_Poly_Id in ($tutor_cancel_list_s)
					)		   
			   ";
			   
			   $block_cancel_tutor = mysql_query($query_block_cancel_tutor); 
		   }
		   
		   //send email to all tutors that have been blocked.
		   if(isset($tutor_allocateid_ns) or isset($tutor_allocateid_cancel)){
			   
			   if(!empty($tutor_allocateid_ns) and !empty($tutor_allocateid_cancel) ){
			   $tutor_email_allocate_id = array_unique(array_merge($tutor_allocateid_ns,$tutor_allocateid_cancel), SORT_REGULAR);
			   }
			   else{
				   if(!empty($tutor_allocateid_ns) and empty($tutor_allocateid_cancel)){
					   $tutor_email_allocate_id = array_unique($tutor_allocateid_ns);
				   }
				   else{
					   if(!empty($tutor_allocateid_cancel) and empty($tutor_allocateid_ns)){
						   $tutor_email_allocate_id = array_unique($tutor_allocateid_cancel);
					   }
					   else{
						   $tutor_email_allocate_id = [];
					   }
						
				   }
			   }
			 
				if(!empty($tutor_email_allocate_id)){
					$tutor_allocateid_cancel_ns_s = join(",",$tutor_email_allocate_id);  
					
					
					$tutor_detail_query = "
					select  distinct sta.Tutor_Poly_Id,sta.Tutor_First_Name,sta.Tutor_Last_Name, t.Tutor_Email, s.Subject 
						from Student_Tutor_Allocation_Main sta
						inner join Tutor t on sta.Tutor_Poly_Id = t.Tutor_Poly_Id 
						inner join Subject s on sta.Subject = s.Subject_Id
						where Allocate_Id in ($tutor_allocateid_cancel_ns_s) 
					";
					$tutor_detail_query_result = mysql_query($tutor_detail_query);
					
					if($tutor_detail_query_result){
							$tutor_detail_email = mysql_fetch_assoc($tutor_detail_query_result);
							   
									
									$to = $tutor_detail_email['Tutor_Email'].","."fitltech@nyu.edu".","."trionyupoly@gmail.com".","."jb3372@nyu.edu".","."pb494@nyu.edu".","."srl446@nyu.edu" ;
									$mailtimestamp = date("F j, Y, g:i a");
									$subject = "TRIO Tutor Block - Excessive No Shows";
									$message = "Dear ".$tutor_detail_email['Tutor_First_Name']." ".$tutor_detail_email['Tutor_Last_Name'].",\n\nDue to excessive cancellations/No Shows, your TRIO tutoring for ".$tutor_detail_email['Subject']." course has been terminated.  Please make an appointment to see the Coordinator to discuss reinstating your tutoring.\r\n\n\n\n​Thank you,\r\nTRIO Scholars Program\r\n​[$mailtimestamp]\r\n";
									$headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
									//$headers[] = "From: shyamrjoshi@gmail.com";
									mail($to, $subject, $message, implode("\r\n", $headers));

					}
					
					
				}
		   }

		   }
}
?>
	</center>
	</div>
</div>
</body>
</html>
