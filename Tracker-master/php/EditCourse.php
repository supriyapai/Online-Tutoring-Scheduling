<!-- This Page allows you to edit the course details which already exists -->

<?php include 'LoginCheck.php'; ?>
<?php
include '../Rules/dbconfig.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';

?>

<html>
<head>
    <title>Edit Course</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/editsession.css" />
	<script type = "text/javascript">
	function validateForm(){
	var x=document.forms["myForm"]["course"].value;
	if (x==null || x=="---SELECT---"){
		alert("Please select a valid course");
		return false;
	}  
	var y=document.forms["myForm"]["newcourse"].value;
	if (y==null || y=="---SELECT---" || y==""){
		alert("Enter New Course");
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
	<div id="text2"><p>Edit Course Information</p></div>
 
	<form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
    <br><br><br>


<?php
    $courseinfo1 = mysql_query("SELECT * FROM Subject ORDER BY Subject");
    while($courseinfo2 = mysql_fetch_array($courseinfo1)){
        $courseinfo[] = $courseinfo2[Subject];
        $courseid[] = $courseinfo2[Subject_Id];
    }
?>
    
<?php
if(isset($_POST["edit"])){
    $subid = $_POST["course"];
    $newname = $_POST["newcourse"];
    
    if($subid == '---SELECT---'){
        $A = "Please select a valid course";
    }elseif(preg_match("/^[0-9a-zA-Z]+$/", $_POST["newcourse"]) === 0){
        $A = "Please enter only leters and numbers";    
    }else{
		  $check1 = mysql_query("SELECT Subject_Id FROM Subject WHERE Subject = '$newname' ");
        $check2 = mysql_fetch_array($check1);
        $check = $check2[0];
      
        if ($check != 0) {
            $B = "This course Already Exists";
        }
       else{		
			$update = mysql_query("UPDATE Subject SET Subject = '$newname' WHERE Subject_Id = '$subid'");
			if($update){
				$A = "Updated";
			}else{
				$B = "Not Updated";
			}
	   }
    }
}
?>
<br><br>
<center>
    <div class="ex">
	<div class = "back">
	<br><br>
    <table> 
        <tr>
            <td><label for="name">Current Course/Subject :</label> </td>
            <td>
                <select name="course">
                    <option>---SELECT---</option>
                    <?php
						for($i=0; $i<count($courseid); $i++){
							echo "<option value=$courseid[$i]>$courseinfo[$i]</option>";
						}
                    ?>
                </select>
            </td>
        </tr>
		<tr><td></tr></td>
        <tr>
            <td>
               <label for="name">New Course/Subject :</label> 
            </td>
            <td>
                <input type="text" name="newcourse">
            </td>
        </tr>
    </table>
    <br>
	<button type="submit" name="edit"><img src="../images/edit.png"  width="102" height="28" border="none"/></a></button>
    <br>
   <div class = "mesg"> <?php echo "$A"; ?> </div>
   <div class = "mesg2"> <?php echo "$B"; ?> </div>
</div>
</div>
</center>
</body>
</div>
</head>
</html>