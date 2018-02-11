﻿<?php

include 'LoginCheck.php';
include '../Rules/datepicker.php';
include '../Rules/dbconfig.php';
?>

<!-- This page allows you to change your password. The UI for this is done but the 
backend changes needs to be done to change the password. Hence it is under consturction.--> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
    
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <link rel="stylesheet" type="text/css" href="../css/accountmgmt.css" />
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script>
function validateForm()
{
var pass=document.forms["ChangePassword"]["password"].value;
var cpass = document.forms["ChangePassword"]["confirmPassword"].value;
	if (pass.length <= 6 && cpass.length <= 6)
	{
	alert("Password should have atleast 6 characters");
	return false;
   }
   if(pass != cpass)
   {
	alert("Passwords do not match");
	return false;
   }
}
</script>
</head>
<body>
<!--Added By : Parul Joshi Dated: 09/01/2015 Task: to add the functionality of changing the password -->
<?php 
if(isset($_POST["submit"])){
	 $pass = $_POST["password"];
	 $confirmPassword =$_POST["confirmPassword"];
	 if($pass==$confirmPassword){
		$username1 = mysql_query("UPDATE `Admin_LogIn` SET Password = MD5('$pass') WHERE Username='trionyupoly'");
		if($username1){
			$A= "<center><h3>Password has been changed successfully!</h3></center>";
		}
		else{
			$A="<h3>Password has <b>not</b> been changed successfully!</h3>";
		}         
	 }else{
		 $A= "New Password and Confirm Password does not match";
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
	<div id="signout"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></div>
	<div id="text2"><p>Change Password</p></div>    
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<div id="mainbody"></div>
	<div id="save"></div>
	<div id="inputboxbackground"></div>
	<br>
	<p align ="right" style="padding-left:150px"><i>You are here: </i>Account Management >> Change Password</p>
	<br/><br/><br/>
	<center>
	<div class="ex">
	<form id="ChangePassword" name="ChangePassword" method="post" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()"> 
		<table>
			<tr>
				<p>
				<td><label for="password">New Password: </label></td> <td><input type="password" id="password" name="password" /></td>
				<p>
			</tr>
			<tr>
				<td><label for="confirmPassword">Confirm Password: </label></td><td><input type="password" id="confirmPassword" name="confirmPassword" /></td>
			</tr>
		</table>
		</p>
		<p>
		<br>
		<center>
		<button type="submit" value="Submit" class="submit" name="submit"/><img src="../images/save.png"  width="102" height="28" border="none"/></button>
		</center>
		<br><br> <center><?php echo $A; ?></center>
		</p>
		</fieldset>
	</form>
</div>
</center>
</body>
</html>
