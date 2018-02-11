<?php
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="../css/cancel2.css" />
	<link rel="stylesheet" href="../css/datepicker.css"/>
    <script src="../js/jquery 1.9.1.js"></script>
    <script src="../js/jQuery UI.js"></script>
	<script>
    $(function() {
      
      $("#datepicker, #datepicker2").datepicker({
        onSelect: function(dateText, inst) { 
          $(this).prev()[0].value = dateText;
        }
      });
    
    
  });
  </script>
</head>
<body>
<?php
if(isset($_POST["cancel"])){
	$polyid = $_POST["polyid"];
	$conv1 = $_POST["date"];
	$conv2 = strtotime($conv1);
	$date = date('Y-m-d',$conv2);
	$sessiontime = $_POST["SessionTime"];
	$subjectid = $_POST["Esub"];
	//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number   
	if(preg_match("/^\d{8}$/", $_POST["polyid"]) === 0) {
		//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
		//Actual Code: $A = 'Poly Id must be 7 digits';
		$A = 'University N Number must be 8 digits';
	}elseif($conv1 == ""){
		$A = "Please Select A Date";
	}elseif($sessiontime == "---SELECT---"){
		$A = "Please Select Your Session Time $date";
	}elseif($subjectid == "---SELECT---"){
		$A = "Please Select Your Subject";
	}else{	
	$currentdate=date("Y-m-d");
	$subname1 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subjectid' ");
	$subname2 = mysql_fetch_array($subname1);
	$subname = $subname2[Subject];
	if($date <= $currentdate){
	?><!--<br><br> -->
	<?php
		$B = "This Session can not be cancelled, you can only cancel sessions starting from tomorrow";
	}else{
		$cancelcheck1 = mysql_query("SELECT Student_Poly_Id, `Tutor_Poly_Id`, `Assignment_Id`, `Allocate_Id` FROM Student_Tutor_Assignment WHERE `Date` = '$date' AND `Session_Time` = '$sessiontime' AND `Subject_Id` = '$subjectid' ");
		while($cancelcheck2 = mysql_fetch_array($cancelcheck1)){
			//Added By: Parul Joshi , Dated : 11/6/2015 ,Task : just edited names to temp so they are initialized after we know its a student or a tutor
			$tempstudentpolyid[] = $cancelcheck2[Student_Poly_Id];
			$temptutorpolyid[] = $cancelcheck2[Tutor_Poly_Id];
			$tempassignment[] = $cancelcheck2[Assignment_Id];
			$tempallocateid[] = $cancelcheck2[Allocate_Id];
		}
		//Added By:Parul,Dated: 11/06/2015, Task: when a double session was cancelled by student, all student ids were taken here in consideration, due to which incorrect ,sges were displayed. So considering only valid student ids and then having the count.
		$tempcount = count($tempstudentpolyid);
		$count=0;
		for($i=0; $i<$tempcount; $i++){
			if($tempstudentpolyid[$i] == $polyid){
			$count= $count+1;
			$studentpolyid[] = $tempstudentpolyid[$i];
			$tutorpolyid[]= $temptutorpolyid[$i];
			$assignment[] = $tempassignment[$i];
			$allocateid[]= $tempallocateid[$i];
			}
		}
		if($count == 0){
			$count = count($temptutorpolyid);
			for($i=0;$i<$count;$i++){
				$studentpolyid[] = $tempstudentpolyid[$i];
				$tutorpolyid[]=$temptutorpolyid[$i];
				$assignment[] = $tempassignment[$i];
				$allocateid[]= $tempallocateid[$i];
			}
		}
	
		if($assignment){
			for($i=0; $i<$count; $i++){
				if($studentpolyid[$i] == $polyid){
					$studentsessioncancel1 = mysql_query("SELECT Cancel_Count, `Student_Cancel_Count` FROM Student_Tutor_Allocation_Main WHERE Student_Poly_Id = '$polyid' AND Allocate_Id = '$allocateid[$i]' ");
					$studentsessioncancel2 = mysql_fetch_array($studentsessioncancel1);
					$allocatedsessioncancel = $studentsessioncancel2[Cancel_Count];
					$studentsessioncancel = $studentsessioncancel2[Student_Cancel_Count];	
					$studentcancel1 = mysql_query("SELECT Cancellations, `Block`,  `Student_First_Name`, `Student_Last_Name`, `Student_Email` FROM Student WHERE Student_Poly_Id = '$polyid' ");
					$studentcancel2 = mysql_fetch_array($studentcancel1);
					$studentcancel = $studentcancel2[Cancellations];
					$studentfirstn = $studentcancel2[Student_First_Name];
					$studentlastn = $studentcancel2[Student_Last_Name];
					$studentblock = $studentcancel2[Block];
					$studentname = $studentfirstn." ".$studentlastn;
					$studentemail = $studentcancel2[Student_Email];
				   // print("allocate id");
					//print_r($allocateid[$i]);
					//Modified by kishan: changed the select query to fetch student_type and tutor_type
					
					$tutordetails1 = mysql_query("SELECT `Tutor_Poly_Id`, `Session_Type`,`Student_Type`,`Tutor_Type` FROM Student_Tutor_Assignment WHERE Student_Poly_Id = '$polyid' AND `Date` = '$date' AND `Session_Time` = '$sessiontime' AND `Subject_Id` = '$subjectid' AND `Assignment_Id`= '$assignment[$i]' ");
					$tutordetails2 = mysql_fetch_array($tutordetails1);
					$tutordetails = $tutordetails2[Tutor_Poly_Id];
					//Previous code
					//$sessioncancel = $tutordetails2[Session_Type];
					
					//***************Added extra lines of below code********
					$studenttypecheck=$tutordetails2[Student_Type];
					$tutortypecheck=$tutordetails2[Tutor_Type];
					if($studenttypecheck==C || $tutortypecheck==C){
						$sessioncancel=C;
					}else{
						$sessioncancel="";
					}
					//*****************************


					$tutoremail1 = mysql_query("SELECT Tutor_Email FROM Tutor WHERE Tutor_Poly_Id = '$tutordetails' ");
					$tutoremail2 = mysql_fetch_array($tutoremail1);
					$tutoremail = $tutoremail2[Tutor_Email];
					
					$c_tutorn1 = mysql_query("SELECT Tutor_First_Name , Tutor_Last_Name FROM Tutor WHERE Tutor_Poly_Id = '$tutordetails' ");
					$c_tutorn2 = mysql_fetch_array($c_tutorn1);
					$c_tutorfirstn = $c_tutorn2[Tutor_First_Name];                       
					$c_tutorlastn = $c_tutorn2[Tutor_Last_Name];
					$c_tutorname = $c_tutorfirstn." ".$c_tutorlastn;
					
					if($sessioncancel ==''){
						if($studentblock == 1){
							$B = "<br>You Cannot cancel any further sessions since you have a block on your account. Please meet a staff member ";
						}else{
							$studentupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Student_Type` = 'C',`Tutor_Type` = 'C' WHERE Student_Poly_Id = '$polyid' AND 												      `Date` = '$date' AND `Session_Time` = '$sessiontime' AND `Subject_Id` = '$subjectid'  ");						
							if($studentupdate){
								?><!-- <br><br> --><?php
					
								$addstudentsessioncancel = $studentsessioncancel+1;
								$addstudentcancel = $studentcancel+1;
								$addallocatedsessioncancel = $allocatedsessioncancel+1;
						
								//Code changes start, Shyam March 10th 2017
								// If session cancel count >= 3 or N/s count >=2 in one subject block the student
								//$studentmodulo = $addstudentsessioncancel;
								
								//check for No Show condition
								$No_show_query = "
								select count(*) as 'No Show Count' from Student_Tutor_Assignment where Student_Poly_Id = '$polyid'
								and Subject_Id = $subjectid and Student_Type = 'N/S' and Allocate_Id  = $allocateid[$i]
								";
								$execute_No_Show_query = mysql_query($No_show_query);
								$No_show_count = mysql_fetch_assoc($execute_No_Show_query);
								//print_r($No_show_count);
								//print_r($addstudentsessioncancel);
								
								if($addstudentsessioncancel >= 3 or $No_show_count['No Show Count'] >=2){
								
									$studentblock = mysql_query("UPDATE Student SET Block = '1' WHERE Student_Poly_Id = '$polyid'");
									$to1 = "fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu".","."$studentemail";
				
									$subject1 = "Student Block - Excessive Cancellations";
									//$message1 = "You ($studentname)are receiving this email because you attempted to Sign In/Cancel - Reschedule for a tutoring session with $c_tutorname on $date and were blocked due to problematic attendance. Please speak to a TRIO Staff member as soon as possible to get this problem resolved and return to tutoring.";
									$mailtimestamp = date("F j, Y, g:i a");
									$message1 = "Dear ".$studentname.",\n\nDue to excessive cancellations/No Shows, your TRIO tutoring for ".$subname." course has been terminated.  Please make an appointment to see the Coordinator to discuss reinstating your tutoring.\r\n\n\n\n​Thank you,\r\nTRIO Scholars Program\r\n​[$mailtimestamp]\r\n";
									
									$headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
									mail($to1, $subject1, $message1, implode("\r\n", $headers));
								}
								//code changes end, Shyam March 10th 2017
								$studentcancelupdate = mysql_query("UPDATE Student SET Cancellations = '$addstudentcancel' WHERE Student_Poly_Id = '$polyid' ");
								$sessioncancelupdate = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Cancel_Count = '$addallocatedsessioncancel', `Student_Cancel_Count` = '$addstudentsessioncancel' WHERE Student_Poly_Id = '$polyid' AND Allocate_Id = '$allocateid[$i]' ");
								
								$to = "$tutoremail".","."fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu".","."$studentemail";
								$subject = "TRIO Session Cancel";
								$message = "This Email is to inform you ($c_tutorname)that your Student ($studentname)on $date cancelled a session scheduled on $date for $subname at $sessiontime. Please contact your student if you would like to reschedule this Session.";
								$headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
								mail($to, $subject, $message, implode("\r\n", $headers));
								$C = "Your Session has been cancelled. Please Inform your Tutor";
							}else{
								?><!-- <br><br> --><?php
								$A = "Error updating the database";
							}
						}
					}else{
						$A = "<br>Your Session has already been cancelled";
					}
			}elseif($tutorpolyid[$i] == $polyid){
				$tutorsessioncancel1 = mysql_query("SELECT Cancel_Count, `Tutor_Cancel_Count` FROM Student_Tutor_Allocation_Main WHERE Tutor_Poly_Id = '$polyid' AND Allocate_Id = '$allocateid[$i]' ");
				$tutorsessioncancel2 = mysql_fetch_array($tutorsessioncancel1);
				$allocatedsessioncancel = $tutorsessioncancel2[Cancel_Count];
				$tutorsessioncancel = $tutorsessioncancel2[Tutor_Cancel_Count];				
					$tutorcancel1 = mysql_query("SELECT Cancellations, `Block`, `Tutor_First_Name`, `Tutor_Last_Name`, `Tutor_Email` FROM Tutor WHERE Tutor_Poly_Id = '$polyid' ");
					$tutorcancel2 = mysql_fetch_array($tutorcancel1);
					$tutorcancel = $tutorcancel2[Cancellations];
					$tutorfirstn = $tutorcancel2[Tutor_First_Name];
					$tutorlastn = $tutorcancel2[Tutor_Last_Name];
					$tutorblock = $tutorcancel2[Block];
					$tutorname = $tutorfirstn." ".$tutorlastn;
					$secondtutoremail = $tutorcancel2[Tutor_Email];
					//Modified by Kishan: changed the select query to fetch student_type and tutor_type 
					//Added By :Parul Dated: 11/05/2015 Task: to hide multiple messages when double sessions are cancelled. Just added assignmentID to this query so that specific student tutor type can be fetched and it won't say that your session has already been cancelled as without assignmemnt id it fetched 'C' after cancelling first session 
					$studentdetails1 = mysql_query("SELECT `Student_Poly_Id`, `Session_Type`,`Student_Type`,`Tutor_Type` FROM Student_Tutor_Assignment WHERE Tutor_Poly_Id = '$polyid' AND `Date` = '$date' AND `Session_Time` = '$sessiontime' AND `Subject_Id` = '$subjectid' AND `Assignment_Id`= '$assignment[$i]' ");
					$studentdetails2 = mysql_fetch_array($studentdetails1);
					$studentdetails = $studentdetails2[Student_Poly_Id];
					
					//Previous code
					//$sessioncheck =   $studentdetails2[Session_Type];

					//***************Added extra lines of below code********
					$studenttypecheck=$studentdetails2[Student_Type];
					$tutortypecheck=$studentdetails2[Tutor_Type];
					if($studenttypecheck==C || $tutortypecheck==C){
						$sessioncheck=C;
					}else{
						$sessioncheck="";
					}
					//*****************************
					
					$studentemail1 = mysql_query("SELECT Student_Email FROM Student WHERE Student_Poly_Id = '$studentdetails' ");
					$studentemail2 = mysql_fetch_array($studentemail1);
					$studentemail = $studentemail2[Student_Email];
					
					
					$c_studentn1 = mysql_query("SELECT Student_First_Name , Student_Last_Name FROM Student WHERE Student_Poly_Id = '$studentdetails' ");
					$c_studentn2 = mysql_fetch_array($c_studentn1);
					$c_studentfirstn = $c_studentn2[Student_First_Name];                       
					$c_studentlastn = $c_studentn2[Student_Last_Name];
					$c_studentname = $c_studentfirstn." ".$c_studentlastn;
					
					if($sessioncheck ==''){
						if($tutorblock == 1){
							$B = "<br>You Cannot cancel any sessions since you have a block on your account. Please meet a staff member ";
						}else
						{
							//Modified by Kishan
							//Previous code
							//$tutorupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'C', `Student_Type` = 'C',`Session_Type` = 'C' WHERE Tutor_Poly_Id = '$polyid' AND `Date` = '$date' AND `Session_Time` = '$sessiontime' AND `Subject_Id` = '$subjectid'  ");
							//Modified as
							$tutorupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'C', `Student_Type` = 'C' WHERE Tutor_Poly_Id = '$polyid' AND Student_Poly_Id = '$studentpolyid[$i]' AND `Date` = '$date' AND `Session_Time` = '$sessiontime' AND `Subject_Id` = '$subjectid'  ");
							if($tutorupdate)
							{
								?><!-- <br><br> --><?php
								
								$addtutorsessioncancel = $tutorsessioncancel+1;
								$addallocatedsessioncancel = $allocatedsessioncancel+1;
								$addtutorcancel = $tutorcancel+1;
								//Tutors limit for getting it blocked is cancellation count to 6 
								//Code changes start, Shyam March 10th 2017
								// If session cancel count >= 3 or N/s count >=2 in one subject block the tutor
								$tutormodulo = $addtutorsessioncancel;
								
								
								$No_show_query = "
								select count(*) as 'No Show Count' from Student_Tutor_Assignment where Tutor_Poly_Id = '$polyid'
								and Subject_Id = $subjectid and Tutor_Type = 'N/S' and Allocate_Id  = $allocateid[$i]
								";
								$execute_No_Show_query = mysql_query($No_show_query);
								$No_show_count = mysql_fetch_assoc($execute_No_Show_query);
								//print_r($No_show_count);
								//print_r($addtutorsessioncancel);
								
								
								
								if($addtutorsessioncancel >= 3 or $No_show_count['No Show Count'] >= 2)
								{
						
									$studentblock = mysql_query("UPDATE Tutor SET Block = '1' WHERE Tutor_Poly_Id = '$polyid'");
									$to1 = "fitltech@nyu.edu".","."trionyupoly@gmail.com".","."$secondtutoremail".","."jb3372@nyu.edu".","."pb494@nyu.edu".","."srl446@nyu.edu".","."$studentemail";
									$subject1 = "Tutor Block - Excessive Cancellations";
									//$message1 = "You ($tutorname)are receiving this email because you attempted to Sign In/Cancel - Reschedule for a tutoring session with $c_studentname and were blocked due to problematic attendance. Please speak to a TRIO Staff member as soon as possible to get this problem resolved and return to tutoring.";
									$mailtimestamp = date("F j, Y, g:i a");
									$message1 = "Dear ".$tutorname.",\n\nDue to excessive cancellations/No Shows, your TRIO tutoring for ".$subname." course has been terminated.  Please make an appointment to see the Coordinator to discuss reinstating your tutoring.\r\n\n\n\n​Thank you,\r\nTRIO Scholars Program\r\n​[$mailtimestamp]\r\n";
									$headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
									mail($to1, $subject1, $message1, implode("\r\n", $headers));
								
						
								}
							//Code changes end, Shyam March 10th 2017
								$tutorcancelupdate = mysql_query("UPDATE Tutor SET Cancellations = '$addtutorcancel' WHERE Tutor_Poly_Id = '$polyid' ");
								
								$sessioncancelupdate = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Cancel_Count = '$addallocatedsessioncancel', `Tutor_Cancel_Count` = '$addtutorsessioncancel' WHERE Tutor_Poly_Id = '$polyid' AND Allocate_Id = '$allocateid[$i]' ");
								
								$to = "$studentemail".","."fitltech@nyu.edu".","."trionyupoly@gmail.com".","."jb3372@nyu.edu".","."pb494@nyu.edu".","."srl446@nyu.edu" ;

								$subject = "TRIO Session Cancel";
								$message = "This email is to inform you ($c_studentname) that your tutor ($tutorname) has cancelled a session on $date for  $subname at $sessiontime. Please contact your tutor if you would like to reschedule this session. ";
								$headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
								mail($to, $subject, $message, implode("\r\n", $headers));
								
								$C = "Your Session has been cancelled. Please Inform your Student";
							}else{
								?><!-- <br><br> --><?php
								$A = "error updating the database";
							}
						}
					}else{
						if($sessioncheck== 'C'){
							$A = "<br> Your Session Has Already Been Cancelled";
						}
					}
				}else{
				?><!-- <br><br> --><?php
					//$A = "Error determining the poly id";
					$A = "Please provide correct information";
				}
			}
		}else{
		?><!-- <br><br> --><?php
			$A = "You have not provided correct Information";
		}
		}
	}
}elseif(isset($_POST["done"])){
	$url1 = "SessionModify.php";
	header("Location:$url1");
}
?>
                        
<div id="container">
   <div id="banner">
   <img src="../images/banner2.png"  width="1022" height="150" border="none"/>    
</div>
<div id="line">
</div>
<div id="body">
</div>
<div id="mainbody">
</div>
<div id="submit">
</div>
<div id="back">
</div>
<div id="inputboxbackground">
</div>
    
   <form action="<?php $PHP_SELF; ?>" method="post">
   <table border="0" cellpadding="8" cellspacing="8">
      <tr>
         <td><label for="name">University ID :</label></td>
         <td><input type="text" id="name" placeholder="username"  maxlength="8" name="polyid" value="<?php print $polyid; ?>" />  </td>
      </tr>
      <tr>
         <td>  </td>
      </tr>
      <tr>
         <td><label for="name">Session Date :</label></td>
         <td><input type="text" id="datepicker" placeholder="choose a date" name="date"></td>
      </tr>
      <tr>
         <td>  </td>
      </tr>
      <tr>
         <td><label for="name">Session Time :</label></td>
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
      <tr>
         <td> </td>
      </tr>
      <tr>
         <td><label for="name">Subject :</label></td>
         <td>
            <?php
               $allocate_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
               while ($allocate_subjects2 = mysql_fetch_array($allocate_subjects1))
               {
               	$allocate_subjects[] = $allocate_subjects2[Subject];
               	$allocate_subjectid[] = $allocate_subjects2[Subject_Id];
               }
               
               $subjectcount = count($allocate_subjectid);
               
               echo "<select name='Esub' > ";
               echo "<option>---SELECT---</option>";
               for ($i=0; $i<$subjectcount; $i++)
               {
               	
               	echo "<option value = $allocate_subjectid[$i]>$allocate_subjects[$i]</option>";
               }
               echo "</select>";
               
                    ?>
         </td>
      </tr>
      <tr>
         <td>  </td>
      </tr>
      <tr>
         <td><button type="submit" name="cancel" value="Cancel"><img src="../images/submit.png"  width="102" height="28" border="none"/></button></td>
         <td><button type="submit" name="done" value="Done"><img src="../images/back.png"  width="102" height="28" border="none"/></button></td>
      </tr>
   </table>
</form>    
	<div id="text2">
	<p>Session Cancellation</p><br>
	<!-- <p><?php echo $A; ?></p> -->
	</div>
	<div id = "mesg1">
	<p><?php echo $A; ?></p>
	</div>
	<div id = "mesg2">
	<p><?php echo $B; ?></p>
	</div>
	<div id = "mesg3">
	<p><?php echo $C; ?></p>
	</div>            
</div>
</body>
</html>