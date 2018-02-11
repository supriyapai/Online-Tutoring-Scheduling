﻿<!-- This page allows you to change the email address that you want to send the notification
emails from -->

<?php
include 'LoginCheck.php';
?>
<?php
include '../Rules/dbconfig.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';

?>

<html>
<head>
    <title>Edit Email</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/editemail.css" />
<script type = "text/javascript">
function validateForm(){
	var email1=document.forms["myForm"]["email"].value;
	if (email1==null || email1=="---SELECT---"){
		alert("Select Email address to change");
		return false;
	  }
	var newemail1=document.forms["myForm"]["NewEmail"].value; 
	if (newemail1==null || newemail1==""){
		alert("Please enter new Email address");
		return false;
	}
}
</script>
    </head>
    
    <body>    
        
<?php
$Emailadd1 = mysql_query("SELECT * FROM Email");
$Emailadd2 = mysql_fetch_array($Emailadd1);
$Emailadd = $Emailadd2[Email_Id];

if(isset($_POST["change"])){  
    if(preg_match("/^[a-zA-Z]\w+(\.\w+)*\@\w+(\.[0-9a-zA-Z]+)*\.[a-zA-Z]{2,4}$/", $_POST["NewEmail"]) === 0){
		$A = '<p class="errText">Email must comply with this mask: chars(.chars)@chars(.chars).chars(2-4)</p>';			
    }else{
	$NewEmail = $_POST["NewEmail"];
	$update = mysql_query("UPDATE Email SET Email_Id = '$NewEmail'");
	if($update){
		$A = "Updated";
        }
    }
}
?>
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
	<div id="text2"><p>Change Email Address</p></div>
	<div id="signout"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div> 
	<br> <br> <br>
	<form  name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
		<center>
		<div class="ex">
		<div class="back">
		<table>
		<br><br>
		<tr>
			<td>Email Address:</td>
			<td>
				<select name = "email">
					<option value="">---SELECT---</option>
					<option value=""><?php echo $Emailadd; ?></option>
				</select> 
			</td>
		</tr>
		<tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td> 
		<tr>
			<td>New Email Address:</td>
			<td><input type="text" name="NewEmail" /></td>
		</tr>
		</table>
	<br>
	<!-- <input type="submit" value="Change" name="change"/> -->
	<button type="submit" name="change"><img src="../images/change.png"  width="102" height="28" border="none"/></a></button>
	<br>
	<?php  echo $A; ?>


	</div>
	</div>
	</div>
	</center>
</form>
</body>