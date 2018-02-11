<?php 

//connect to the database
include '../Rules/dbconfig.php';

if ($_FILES[csv][size] > 0) {

    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
    
    //loop through the csv file and insert into database
    do {
        if ($data[0]) {
           mysql_query("INSERT INTO Student (Student_Poly_Id,Student_First_Name,Student_Last_Name,Student_MI,Student_Phone_No,Student_Email,No_Of_Subjects,Subject_1,Subject_2,Subject_3,Subject_4,Subject_5,Subject_6,Active,Student_Status,Lateness,Presence,No_Shows,Cancellations,Reschedules,Block) VALUES
                (
                    '".addslashes($data[0])."',
                    '".addslashes($data[1])."',
                    '".addslashes($data[2])."',
                    '".addslashes($data[3])."',
                    '".addslashes($data[4])."',
                    '".addslashes($data[5])."',
                    '".addslashes($data[6])."',
                    '".addslashes($data[7])."',
                    '".addslashes($data[8])."',
                    '".addslashes($data[9])."',
                    '".addslashes($data[10])."',
                    '".addslashes($data[11])."',
                    '".addslashes($data[12])."',
                    '".addslashes($data[13])."',
                    '".addslashes($data[14])."',
                    '".addslashes($data[15])."',
                    '".addslashes($data[16])."',
                    '".addslashes($data[17])."',
                    '".addslashes($data[18])."',
                    '".addslashes($data[19])."',
                    '".addslashes($data[20])."'
                )
            ");
        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    //

    //redirect
     header('Location: addstu_bulk.php?success=1'); 
     die;
   

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/inputallocation.css" />
<script type="text/javascript" src="../js/addbulk.js">

</script>
<title>Import a CSV File</title>
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
	<div id="inputboxbackground"></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<center>
	<div id="text2"><p>Upload Student Information</p></div>
	<div id="confirm" style="z-index:800; position: relative;"></div>
	<div id="confirm" style="z-index:800; position: relative;">
<?php 
	if (!empty($_GET[success])) { echo "File is Uploaded<br><br>"; } //generic success notice 
?>
</div>
</center>
   
<form action="" method="post" enctype="multipart/form-data" onsubmit="return ExtensionsOkay();" name="form1" id="form1">
	<table>
	<br /><br />
		<tr>
			<td>Choose your file: &nbsp &nbsp <br /></td>
			<td><input name="csv" type="file" id="csv" /></td>
		</tr>	  
	</table>
  <br/>
	<center>
	<div id="upload">
	<button type="submit" name="Submit" value="Submit"><img src="../images/submit.png"  width="102" height="28" border="none"/></button></center>
	</div>
	
</form>
</div>
</body>
</html>
