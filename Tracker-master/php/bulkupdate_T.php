<?php
//Establishing a connection with the host
                include '../Rules/dbconfig.php';
?>


                
<html>
<head>
    <title>Bulk Update</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
        <link rel="stylesheet" type="text/css" href="../css/studentblock.css" />
<script type="text/javascript" src="../js/addbulk.js">
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
	<div id="signout"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></div>
	<div id="text2"><p>Bulk Update Information</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<br><br><br> 

<?php
if (isset($_POST['submit']))
{ 

   $session1=mysql_query("CREATE TABLE TempTutor
                         (Tutor_Poly_Id varchar(10),
                          Tutor_First_Name varchar(100),
                          Tutor_Last_Name varchar(100),
                          Tutor_MI varchar(100),
                          Tutor_Email varchar(100),
                          Tutor_Phone_No bigint(20),
                                                  Tutor_Hours int(11),
                                                  Hire_Date varchar(100),
                                                  No_Of_Subjects int(11),
                                                  Subject_Taught_1 int(11),
                                                  Subject_Taught_2 int(11),
                                                  Subject_Taught_3 int(11),
                                                  Subject_Taught_4 int(11),
                                                  Subject_Taught_5 int(11),
                                                  Subject_Taught_6 int(11),
												  Class_Status      varchar(100),
												  Graduation_Year   varchar(100),
                                                  Active varchar(100),
                                                  Pay_Rate float,
                                                  Tutor_Status varchar(100),    
                                                  Lateness  int(11),
                                                  Presence  int(11),
                                                  No_Shows  int(11),
                                                  Cancellations  int(11),
                                                  Reschedules   int(11),
                                                  Block         int(11)
                          )");
                                                  
   $file=$_FILES['csv']['tmp_name'];
   
   $handel= fopen($file, "r");
   while(($fileop=fgetcsv($handel,1000,",")) !==false)
   {
     $Tutor_Poly_Id=$fileop[0];
         $Tutor_First_Name=$fileop[1];
         $Tutor_Last_Name=$fileop[2];
         $Tutor_MI=$fileop[3];
         $Tutor_Email=$fileop[4];
         $Tutor_Phone_No=$fileop[5];
         $Tutor_Hours=$fileop[6];
         $Hire_Date=$fileop[7];
         $No_Of_Subjects=$fileop[8];
         $Subject_Taught_1=$fileop[9];
         $Subject_Taught_2=$fileop[10];
         $Subject_Taught_3=$fileop[11];
         $Subject_Taught_4=$fileop[12];
         $Subject_Taught_5=$fileop[13];
         $Subject_Taught_6=$fileop[14];
		 $Class_Status=$fileop[15];
		 $Graduation_Year=$fileop[16];
         $Active=$fileop[17];
         $Pay_Rate=$fileop[18];
         $Tutor_Status=$fileop[19];
         $Lateness=$fileop[20];
         $Presence=$fileop[21];
         $No_Shows=$fileop[22];
         $Cancellations=$fileop[23];
         $Reschedules=$fileop[24];
         $Block=$fileop[25];
         
         $session2=mysql_query("INSERT INTO TempTutor (Tutor_Poly_Id,
         Tutor_First_Name,Tutor_Last_Name,Tutor_MI,Tutor_Email,
         Tutor_Phone_No,Tutor_Hours,Hire_Date,No_Of_Subjects,Subject_Taught_1,
         Subject_Taught_2,Subject_Taught_3,Subject_Taught_4,Subject_Taught_5,Subject_Taught_6,Class_Status,
         Graduation_Year,Active,Pay_Rate,Tutor_Status,Lateness,Presence,No_Shows,Cancellations,Reschedules,Block) Values ('$Tutor_Poly_Id','$Tutor_First_Name',
         '$Tutor_Last_Name','$Tutor_MI','$Tutor_Email','$Tutor_Phone_No','$Tutor_Hours','$Hire_Date',
         '$No_Of_Subjects','$Subject_Taught_1','$Subject_Taught_2','$Subject_Taught_3',
         '$Subject_Taught_4','$Subject_Taught_5','$Subject_Taught_6','$Class_Status','$Graduation_Year','$Active','$Pay_Rate','$Tutor_Status',
         '$Lateness','$Presence','$No_Shows','$Cancellations','$Reschedules','$Block')");
}
         
          
     $session3=mysql_query("update Tutor,TempTutor
                          set Tutor.Tutor_First_Name = TempTutor.Tutor_First_Name,
                                              Tutor.Tutor_Last_Name = TempTutor.Tutor_Last_Name,
                                                  Tutor.Tutor_MI = TempTutor.Tutor_MI,
                                                  Tutor.Tutor_Email = TempTutor.Tutor_Email,
                              Tutor.Tutor_Phone_No = TempTutor.Tutor_Phone_No,
                                                  Tutor.Tutor_Hours = TempTutor.Tutor_Hours,
                                                  Tutor.Hire_Date = TempTutor.Hire_Date,
                                                  Tutor.No_Of_Subjects = TempTutor.No_Of_Subjects,
                                                  Tutor.Subject_Taught_1= TempTutor.Subject_Taught_1,
                                                  Tutor.Subject_Taught_2 = TempTutor.Subject_Taught_2,
                                                  Tutor.Subject_Taught_3 = TempTutor.Subject_Taught_3,
                                                  Tutor.Subject_Taught_4 = TempTutor.Subject_Taught_4,
                                                  Tutor.Subject_Taught_5 = TempTutor.Subject_Taught_5,
                                                  Tutor.Subject_Taught_6 = TempTutor.Subject_Taught_6,
												  Tutor.Class_Status = TempTutor.Class_Status,
                                                  Tutor.Graduation_Year= TempTutor.Graduation_Year,
												  Tutor.Active= TempTutor.Active,
                              Tutor.Pay_Rate = TempTutor.Pay_Rate,
                                                  Tutor.Tutor_Status = TempTutor.Tutor_Status,
                                                  Tutor.Lateness = TempTutor.Lateness,
                                                  Tutor.Presence = TempTutor.Presence,
                                                  Tutor.No_Shows = TempTutor.No_Shows,
                                                  Tutor.Cancellations = TempTutor.Cancellations,
                                                  Tutor.Reschedules = TempTutor.Reschedules,
                                                  Tutor.Block = TempTutor.Block
           where Tutor.Tutor_Poly_Id = TempTutor.Tutor_Poly_Id");
              
     $session4 = mysql_query("DROP TABLE TempTutor");
         
         if($session1&$session2&$session3&$session4)
                {
                    $A = "Content Updated";
                     
                }   
                    
                  
                
                
                else
                {
                    $B = "Unable To Update";
                }
        
        }
?>
   <center>
   <div class="ex">
   <div class = "back">
	<form  action = "bulkupdate_T.php" name="form1" id="form1" method = "post" enctype="multipart/form-data" onsubmit="return ExtensionsOkay();">
		<table>
		<br><br>
			<tr>
				<td>Select the file to upload: &nbsp &nbsp</td>
				<td>
				  <input type="file" name="csv"  />
				</td>
				</tr>
				<tr>
				</tr>
			
		</table>
		<br>
		<button type="submit" name="submit"><img src="../images/generate.png"  width="102" height="28" border="none"/></a></button>      
	</form>
	<div class = "mesg1"> <?php  echo "$A" ;?> </div>
	<div class = "mesg2"> <?php  echo "$B" ;?> </div>

</body>
</html>