<!-- This Page displays reports based on Reports displayed by subject -->

<?php include 'LoginCheck.php'; ?>
<?php
//Establishing a connection with the host
                include '../Rules/dbconfig.php';
                include '../Rules/datepicker.php';                
?>


<html>
<head>
    <title>Report - Subject</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/reports.css" />
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
	<div class = "ex">
	<center>

<?php
	$fromedate1 = date("Y-m-d", strtotime($_POST["fromdate"]));
	$todate1 = date("Y-m-d", strtotime($_POST["todate"]));
	$subject = $_POST["subject"];
	$sort = $_POST["sort"];
	if($fromedate1 == '' || $todate1 == ''){
		echo "<br><br>Please Select the Dates";
	}elseif($subject == '---SELECT---'){
		echo "<br><br>Please Select Course";
	}else{
	$session1 = mysql_query("SELECT DISTINCT Allocate_Id FROM Student_Tutor_Assignment WHERE  Subject_Id = '$subject' AND `Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort");
/* Shyam Joshi Begin of code change September 14, 2016
   changed the file name to be report name + from date
*/
		//$filename=strtotime("now").'.csv';

		$file_app_from_date = date("mdY",strtotime($_POST["fromdate"]));
		$filename='SubjectData_'.$file_app_from_date.'.csv'; 

/* Shyam Joshi End of code change September 14,2016 */	
	/* Edited By: Parul Joshi Dated: 08/20/2015
			Task - changed folder from download to csv */
	$fp=fopen("../csv/" .$filename,"w");
	$sql = mysql_query("  SELECT  Tutor_First_Name, Tutor_Last_Name, Student_First_Name, Student_Last_Name,Subject, Session_Time, Date
												 From Student natural join Student_Tutor_Assignment natural join Subject join Tutor 
												 WHERE Tutor.Tutor_Poly_ID=Student_Tutor_Assignment.Tutor_Poly_ID   and
						 Subject_Id = '$subject' AND `Date` BETWEEN '$fromedate1' AND '$todate1' Order By $sort ");
	$row= mysql_fetch_assoc($sql);
	$seperator="";
	$comma="";
	foreach($row as $name => $value){
		$seperator.=$comma.''.str_replace('','""',$name);
		$comma=",";
	}           
	$seperator.="\n";
	fputs($fp,$seperator);
	mysql_data_seek($sql,0);
	while($row= mysql_fetch_assoc($sql)){
		$seperator="";
		$comma="";
		foreach($row as $name => $value){
			//Begin of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
				if($name == 'Session_Time'){
					$value = date('g:i a', strtotime($value));
				}
			//End of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
			$seperator.=$comma.''.str_replace('','""',$value);
			$comma=",";
		}
		$seperator.="\n";
		fputs($fp,$seperator);
		}
           fclose($fp);
}  
         while($sessions2 = mysql_fetch_array($session1))
      {     
          $allocateid[] = $sessions2[Allocate_Id];
      }   
      $count = count($allocateid);
      for($b=0; $b<$count; $b++){
          $details1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid[$b]' ORDER BY $sort");
          while($details2 = mysql_fetch_array($details1))
          {
              $Tid = $details2[Tutor_Poly_Id];
              $Sid = $details2[Student_Poly_Id];
              $time = $details2[Session_Time];
              $date[]= $details2[Date];
          }    
          $tutor1 = mysql_query("SELECT * FROM Tutor WHERE Tutor_Poly_Id = '$Tid'");
          $tutor2 = mysql_fetch_array($tutor1);
          $tutorfn = $tutor2[Tutor_First_Name];
          $tutorln = $tutor2[Tutor_Last_Name];
          $tutorname[] = $tutorfn." ".$tutorln;
          $student1 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$Sid'");
          $student2 = mysql_fetch_array($student1);
          $studentfn = $student2[Student_First_Name];
          $studentln = $student2[Student_Last_Name];
          $studentname[] = $studentfn." ".$studentln; 
          $sessiontime[] = $time;
      }
        $subject1 = mysql_query("SELECT * FROM Subject WHERE Subject_Id = '$subject'");
        $subject2 = mysql_fetch_array($subject1);
        $subjectname = $subject2[Subject];
echo "<br><br><br><br><br><br><table border=\"1\" bordercolor=\"#52981a\" bgcolor=\"white\" style=\"text-align:center\">";
echo "<tr bgcolor=\"e4e4e4\">";
echo "<th>Tutor Name</th>";
echo "<th>Student Name</th>";
echo "<th>Subject </th>";
echo "<th>Session Time</th>";
echo "<th>Date</th>";
echo "</tr>";
for($i=0; $i<$count; $i++){
    echo "<tr>";
    echo "<td>$tutorname[$i]</td>";
    echo "<td>$studentname[$i]</td>";
    echo "<td>$subjectname</td>";   
	//Begin of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time
	//echo "<td>$sessiontime[$i]</td>";
	echo "<td>".date('g:i a', strtotime($sessiontime[$i]))."</td>";
	//End of Code Changes 09/30/2016 Shyam Joshi, Changed the display format for time	
    echo"<td>$date[$i]</td>";
}
echo "</table>";
?>
 </center>
</div>
        <div id="text2">
            <p>Subject Data</p>
                <br>
				<!-- Edited By: Parul Joshi Dated: 08/20/2015
			Task - to download the file from csv folder  
			Dated :12/22/2015
			Task: made links relative
			-->
            <a href="../csv/<?php echo$filename;?>">Download Link</a>
            </div>
   <br>
<br>
</div>
</body>
</html>