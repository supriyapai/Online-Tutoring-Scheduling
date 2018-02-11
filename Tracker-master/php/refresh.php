<!-- This page displays livereport based on the time -->
<!--Author: Kishan -->
<?php
include '../Rules/dbconfig.php';
include '../js/pearMail/pearmail/pearmail/Mail/Mail.php';
include '../js/pearMail/pearmail/pearmimemail/Mail_Mime/Mail/mime.php' ;
?>
<html>
<head>
<!-- The information of the title -->
    <title>New Semester Refresh</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	
<!-- Refresh the page in 60 seconds -->
	<meta http-equiv="refresh" content="60">
	
<!-- CSS stylesheet -->
<link rel="stylesheet" type="text/css" href="../css/reports.css" />
</head>

<!-- The Page will refresh in every 60 seconds -->
<body>
<?php
//Old mail function not in use
function mailAttachments($to, $from, $subject, $message, $attachments = array(), $headers = array(), $additional_parameters = '') {
	$headers['From'] = $from;

	// Define the boundray we're going to use to separate our data with.
	$mime_boundary = '==MIME_BOUNDARY_' . md5(time());

	// Define attachment-specific headers
	$headers['MIME-Version'] = '1.0';
	$headers['Content-Type'] = 'multipart/mixed; boundary="' . $mime_boundary . '"';

	// Convert the array of header data into a single string.
	$headers_string = '';
	foreach($headers as $header_name => $header_value) {
		if(!empty($headers_string)) {
			$headers_string .= "\r\n";
		}
		$headers_string .= $header_name . ': ' . $header_value;
	}

	// Message Body
	$message_string  = '--' . $mime_boundary;
	$message_string .= "\r\n";
	$message_string .= 'Content-Type: text/plain; charset="iso-8859-1"';
	$message_string .= "\r\n";
	$message_string .= 'Content-Transfer-Encoding: 7bit';
	$message_string .= "\r\n";
	$message_string .= "\r\n";
	$message_string .= $message;
	$message_string .= "\r\n";
	$message_string .= "\r\n";

	// Add attachments to message body
	foreach($attachments as $local_filename => $attachment_filename) {
		if(is_file($local_filename)) {
			$message_string .= '--' . $mime_boundary;
			$message_string .= "\r\n";
			$message_string .= 'Content-Type: application/octet-stream; name="' . $attachment_filename . '"';
			$message_string .= "\r\n";
			$message_string .= 'Content-Description: ' . $attachment_filename;
			$message_string .= "\r\n";

			$fp = @fopen($local_filename, 'rb'); // Create pointer to file
			$file_size = filesize($local_filename); // Read size of file
			$data = @fread($fp, $file_size); // Read file contents
			$data = chunk_split(base64_encode($data)); // Encode file contents for plain text sending

			$message_string .= 'Content-Disposition: attachment; filename="' . $attachment_filename . '"; size=' . $file_size.  ';';
			$message_string .= "\r\n";
			$message_string .= 'Content-Transfer-Encoding: base64';
			$message_string .= "\r\n\r\n";
			$message_string .= $data;
			$message_string .= "\r\n\r\n";
		}
	}

	// Signal end of message
	$message_string .= '--' . $mime_boundary . '--';

	// Send the e-mail.
	return mail($to, $subject, $message_string, $headers_string, $additional_parameters);
}

?>
    
<?php
	if(isset($_POST["submit"]) )
	{
            $user = $_POST["userid"];
            $pass = md5($_POST["password"]);//computing MD5 of the password provided by the user
     
			$username1 = mysql_query("SELECT Username, `Password`, SemRefreshAccess FROM Admin_LogIn where Username='$user'");
            $username2 = mysql_fetch_array($username1);
            $username = $username2[Username];
            $password = $username2[Password];
			$semRefreshAccess = $username2[SemRefreshAccess];
            $E=$username;
            

            if($username == $user AND $semRefreshAccess==1)
            {
            	$assignment_table='Student_Tutor_Assignment';
				$allocation_table='Student_Tutor_Allocation_Main';

                if($password == $pass)
                {
					//Allocation report generation
					$filename_Allocation=strtotime("now").'Allocation.csv';
					/* Edited By: Parul Joshi Dated: 08/20/2015
					Task - changed folder from download to csv */
					$fp=fopen("../csv/" .$filename_Allocation,"w");
					
					$sql=mysql_query("SELECT Student_First_Name,Student_Last_Name,Tutor_First_Name,Tutor_Last_Name,Time,Day,Session_Start_Date,Session_End_Date,Cancel_Count,Student_Cancel_Count,Tutor_Cancel_Count,Student_Late_Count,Tutor_Late_Count,Student_Noshow_Count,Tutor_Noshow_Count FROM $allocation_table Order By Allocate_Id");
					$row= mysql_fetch_assoc($sql);
					$seperator="";
					$comma="";
					foreach($row as $name => $value)
					{
						$seperator.=$comma.''.str_replace('','""',$name);
						$comma=",";
					}
					$seperator.="\n";
					fputs($fp,$seperator);
					mysql_data_seek($sql,0);
					while($row= mysql_fetch_assoc($sql))
					{
						$seperator="";
						$comma="";
						foreach($row as $name => $value)
						{
							if($name=="Subject"){
								$sql2=mysql_query("select Subject from subject where Subject_Id=$value");
								$row2= mysql_fetch_array($sql2);
								$sub = $row2[Subject];
								$value=$sub;
							}
							//replacing day-number to the day word
							if($name=="Day"){
								$array_day = array("Saturday","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday");
								$value=$array_day[$value];
							}
							$seperator.=$comma.''.str_replace('','""',$value);
							$comma=",";
						}
						$seperator.="\n";
						fputs($fp,$seperator);
					}
					fclose($fp);
					
					//Assignment report generation
					$filename_Assignment=strtotime("now").'Assignment.csv';
					/* Edited By: Parul Joshi Dated: 08/20/2015
					Task - changed folder from download to csv */
					$fp=fopen("../csv/" .$filename_Assignment,"w");
					
					//$sql=mysql_query("SELECT Student_Poly_Id,Tutor_Poly_Id,Subject_Id,Session_Time,Date,Student_Current_Time,Tutor_Current_Time,Day,Student_Type,Tutor_Type,Session_Type FROM student_tutor_assignment Order By Assignment_Id");
					//$sql=mysql_query("select c.*, d.Student_First_Name, d.Student_Last_Name from student as d, (select a.*, b.Tutor_First_Name, b.Tutor_Last_Name from student_tutor_assignment as a, tutor as b where a.Tutor_Poly_Id = b.Tutor_Poly_Id) as c where c.Student_Poly_Id = d.Student_Poly_Id");
					$sql=mysql_query("select c.Date as Session_Date,d.Student_First_Name, d.Student_Last_Name,c.Tutor_First_Name, c.Tutor_Last_Name,c.Subject_Id as Subject,c.Day,c.Session_Time,c.Session_Type,c.Student_Current_Time as Student_SignIn_Time,c.Tutor_Current_Time as Tutor_SignIn_Time,c.Student_Type,c.Tutor_Type from Student as d, (select a.*, b.Tutor_First_Name, b.Tutor_Last_Name from $assignment_table as a, Tutor as b where a.Tutor_Poly_Id = b.Tutor_Poly_Id) as c where c.Student_Poly_Id = d.Student_Poly_Id");
					
					$row= mysql_fetch_assoc($sql);
					$seperator="";
					$comma="";
					foreach($row as $name => $value)
					{
						
							$seperator.=$comma.''.str_replace('','""',$name);
							$comma=",";

						
					}
					$seperator.="\n";
					fputs($fp,$seperator);
					mysql_data_seek($sql,0);
					while($row= mysql_fetch_assoc($sql))
					{
						$seperator="";
						$comma="";

						foreach($row as $name => $value)
						{
							//Replqcing the Subject ID with Subject name
							if($name=="Subject"){
								$sql2=mysql_query("select Subject from subject where Subject_Id=$value");
								$row2= mysql_fetch_array($sql2);
								$sub = $row2[Subject];
								$value=$sub;
							}
							//replacing day-number to the day word
							if($name=="Day"){
								$array_day = array("Saturday","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday");
								$value=$array_day[$value];
							}
							$seperator.=$comma.''.str_replace('','""',$value);
							$comma=",";
						}
						$seperator.="\n";
						fputs($fp,$seperator);
					}
					fclose($fp);
					
					
					$to = "fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu";

					$from = 'trionyupoly@gmail.com';
					$subject = 'See Attachments:New Semester Refresh';
					$message = 'New Semester refresh is done. Please check out the attachments in this mail';
					$Assignment_path='../csv/'.$filename_Assignment;
					$Allocation_path='../csv/'.$filename_Allocation;

					//Old mail code commented
					/* // Define a list of FILES to send along with the e-mail. Key = File to be sent. Value = Name of file as seen in the e-mail.
					$attachments = array(
						$Assignment_path => 'Assignment_backup.csv', $Allocation_path => 'Allocation_backup.csv'
					);

					// Define any additional headers you may want to include
					$headers = array(
						'Reply-to' => 'trionyupoly@gmail.com',
					);

					$status = mailAttachments($to, $from, $subject, $message, $attachments, $headers);
					if($status === True) {
						print 'Successfully mailed!';
					} else {
						print 'Unable to send e-mail.';
					} */
					#old mail code commented
					
					#new mail code Starts
									
					$crlf = "\n";
					
					$hdrs = array(
								  'From'    => 'trionyupoly@gmail.com',
								  'Subject' => 'See Attachments:New Semester Refresh',
								  'Reply-to' => 'trionyupoly@gmail.com',
								  );

					$mime = new Mail_mime(array('eol' => $crlf));

					$mime->setTXTBody($message);
					//$mime->setHTMLBody($html);
					//$mime->addAttachment($file, 'text/csv');
					$mime->addAttachment($Assignment_path, 'text/csv');
					$mime->addAttachment($Allocation_path, 'text/csv');

					$body = $mime->get();
					$hdrs = $mime->headers($hdrs);

					$mail =& Mail::factory('mail');
					$mail->send($to, $hdrs, $body);

					
					#new mail code Ends
					
					
					//Back-up table names
					$assignment_backup_table=$assignment_table.'_backup_'.date("F").'_'.date("Y");
					$allocation_backup_table=$allocation_table.'_backup_'.date("F").'_'.date("Y");

					//Creating a new backup table for assignment and inserting all assignment rows to backup table
					$sql=mysql_query("CREATE TABLE $assignment_backup_table LIKE $assignment_table");
					$sql=mysql_query("INSERT INTO $assignment_backup_table SELECT * FROM $assignment_table");
					
					//Creating a new backup table for allocation and inserting all allocation rows to backup table
					$sql=mysql_query("CREATE TABLE $allocation_backup_table LIKE $allocation_table");
					$sql=mysql_query("INSERT INTO $allocation_backup_table SELECT * FROM $allocation_table");
					
					//Clearing all the student&tutor tracking details and the subject details. We are not clearing tutor subject details
					$sql=mysql_query("UPDATE student SET No_Of_Subjects=0,Subject_1=0,Subject_2=0,Subject_3=0,Subject_4=0,Subject_5=0,Subject_6=0,Lateness=0,Presence=0,No_Shows=0,Cancellations=0,Reschedules=0,Block=0");
					$sql=mysql_query("UPDATE tutor SET Lateness=0,Presence=0,No_Shows=0,Cancellations=0,Reschedules=0,Block=0");

					//Clearing all the rows of assignment and the allocation table using truncate method
                    $sql=mysql_query("TRUNCATE $assignment_table");
                    $sql=mysql_query("TRUNCATE $allocation_table");
                    
                    //Resetting the auto-increment to 1
                    $sql=mysql_query("ALTER TABLE $assignment_table AUTO_INCREMENT = 1");
                    $sql=mysql_query("ALTER TABLE $allocation_table AUTO_INCREMENT = 1");

                    //Revert Back: Dummy code to revert all the back-up table to the original assignment and allocation table
                    /*
                    $sql=mysql_query("INSERT INTO $assignment_table SELECT * FROM $assignment_backup_table");
                    $sql=mysql_query("INSERT INTO $allocation_table SELECT * FROM $allocation_backup_table");
                    //$sql=mysql_query("DROP TABLE $assignment_backup_table");
                    //$sql=mysql_query("DROP TABLE $allocation_backup_table");
					*/
                    $url = "RefreshComplete.php";
                    header("Location:$url?var1=$filename_Allocation&var2=$filename_Assignment");
                }
                else
                {
                    $A = "Incorrect Username/Password";
                }
            }
            else
            {
                $A = "Incorrect Username/Password";
            }
            
		
	}
?>
<!-- The outline of the tracker -->
    <div id="container" class =" scroll">
    <div class="menu">
         <ul>
             <li><a class="hide" href="">INPUT</a>
                 <ul>
                     <li><a href="CreateT.php" >Tutor Information</a></li>
                     <li><a href="CreateS.php" >Student Information</a></li>
                     <li><a href="Allocate.php" >Student-Tutor Allocation</a></li>
                     <li><a href="Course.php" >Course Information</a></li>
                 </ul>
             </li>

             <li><a class="hide" href="">EDIT</a>
                 <ul>
                     <li><a href="EditTutor.php" >Tutor Information</a></li>
                     <li><a href="EditStudent.php" >Student Information</a></li>
                     <li><a class="EditSession.php" >Student-Tutor Allocation ></a>
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
                     <li><a href="EditCourse.php" >Course Information</a></li>
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
                     <li><a href="StudentBlock.php" >Student Block/Unblock</a></li>
                     <li><a href="TutorBlock.php" >Tutor Block/Unblock</a></li>
                     <li><a href="SessionDrop.php" >Drop Session</a></li>
                 </ul>
             </li>

              <li><a class="hide" href="">DATA MANAGEMENT</a>
			     <ul>
                        <li><a href="#" >Save ></a>
                        <ul>
						      <li><a href="SaveStudent.php" >Student</a></li>
                              <li><a href="SaveTutor.php">Tutor</a></li>
						</ul>
						</li>
                        
                        <li><a href="#" >Bulk Changes > </a>
					    <ul>
                     	      <li><a href="bulkstudent.php" >Student</a></li>
                              <li><a href="bulktutor.php">Tutor</a></li>
                         </ul>
					    </li>
                      
					    <li><a href="refresh.php" >New Semester Refresh</a></li>
                     <li><a href="#" >Delete ></a>
					 <ul>
					        <li><a href="DeleteS_Nav.php" >Student</a></li>
                            <li><a href="DeleteT_Nav.php">Tutor</a></li>
					 </ul>
					 </li>
                 </ul>
             </li>

             <li><a class="hide" href=" ">ACCOUNT MANAGEMENT</a>
                 <ul>
                     <li><a class="hide">Email ></a>
                         <ul>
                             <li><a href="EditEmail.php" >Change Email Address</a></li>
                             <li><a href="EditSubject.php">Change Email Subject</a></li>
                             <li><a href="EditContext.php">Change Email Content</a></li>
                         </ul>
                     </li>
                     <li><a href="AccountManagement.php" >Password</a></li>
                 </ul>
             </li>

            <li><a class="hide" href="livereport.php">LIVE REPORT</a></li>

           </ul>
        </div>

		<div id="banner">
        <img src="../images/banner2.png"  width="1022" height="150" border="none"/>
	    </div>
	    
        <div id="signout">
        <img src="../images/adminlogin.png"  width="17" height="15" border="none"/>
		</div>
		<div id="text2">
		
		<!-- The report title -->
		<center>
	    <!--<p>Login for New Semester Refresh</p>-->
	    </div>
        <div id="text3">
		</center>
		<!-- Sign out button -->
		<a href="Adminlogon.php"><p>Sign Out</p></a>
		</div> 

    <center>
		<div id="mainbody">
	    </div>
		<div id="inputboxbackground">
			</br></br>
			<h2><b>Login for New Semester Refresh</b></h2>
			</br>
			<form action="<?php $PHP_SELF; ?>" method="post">      
				
				<label for="name">Username : </label>
				<input type="text" id="name" name="userid" placeholder="username" />
				</br>
		
				<label for="name">Password : </label>
				<input type="password" id="name" name="password" placeholder="password" />
				<br><br>
                <center><button type="submit" name="submit" value="Log In"><img src="../images/submit.png"  width="102" height="28" style="border:0" /></button></center><br> 
				<font size="2"><a href="RefreshChangePassword.php">Change Password</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="RefreshForgotPassword.php">Forgot Password?</a></font>
                <center><?php echo $A; ?></center>
			</form>
	    </div>
	</center>
	</div>
	</div>
</body>
</html>