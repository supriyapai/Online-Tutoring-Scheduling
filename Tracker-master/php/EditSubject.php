﻿<!-- This page allows you to edit the course information like to update the course number -->
<?php
include '../Rules/dbconfig.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';
?>
<html>
<head>
    <title>Edit Email Subject</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/editemail.css" />
<script type="text/javascript">
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "searchSubject.php?q=" + str, true);
    xmlhttp.send();
}

function validateForm() {
    var sub = document.forms["myForm"]["subject"].value;
    if (sub == null || sub == "---SELECT---") {
        alert("Select Email Subject");
        return false;
    }
    var newsub = document.forms["myForm"]["newSubject"].value;
    if (newsub == null || newsub == "") {
        alert("Please Enter new Subject");
        return false;
    }
}
</script>
    
<?php
if(isset($_POST["go"]))
{
    $subject = $_POST["subject"];
    $newsubject = $_POST["newSubject"];
    if($subject == "C")
    {
        $update = mysql_query("UPDATE Email_Content SET Cancel = '$newsubject' WHERE Type='Subject'");
        if($update)
        {
            $A = "Updated";
        }
        else
        {
            $A = "Not Updated";
        }
    }
    elseif($subject == "R")
    {
        $update = mysql_query("UPDATE Email_Content SET Reschedule = '$newsubject' WHERE Type='Subject'");
        if($update)
        {
            $A = "Updated";
        }
        else
        {
            $A = "Not Updated";
        }
    }
    elseif($subject == "C")
    {
        $update = mysql_query("UPDATE Email_Content SET Cancel = '$newsubject' WHERE Type='Subject'");
        if($update)
        {
            $A = "Updated";
        }
        else
        {
            $A = "Not Updated";
        }
    }
    elseif($subject == "BL")
    {
        $update = mysql_query("UPDATE Email_Content SET Block = '$newsubject' WHERE Type='Subject'");
        if($update)
        {
            $A = "Updated";
        }
        else
        {
            $A = "Not Updated";
        }
    }
    elseif($subject == "UB")
    {
        $update = mysql_query("UPDATE Email_Content SET Unblock = '$newsubject' WHERE Type='Subject'");
        if($update)
        {
            $A = "Updated";
        }
        else
        {
            $A = "Not Updated";
        }
    }
	//Added By: Parul Joshi Dated: 09/02/2015 Task : to add drop Session subject info which can be edited by admin
	elseif($subject == "DS")
    {
        $update = mysql_query("UPDATE Email_Content SET DropSession = '$newsubject' WHERE Type='Subject'");
        if($update)
        {
            $A = "Updated";
        }
        else
        {
            $A = "Not Updated";
        }
    }
}
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
$(function() {
	setTimeout(function() { $("#testdiv").fadeOut(1000); }, 1500)
	$('#btnclick').click(function() {
	$('#testdiv').show();
	setTimeout(function() { $("#testdiv").fadeOut(1000); }, 1500)
	})
})
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
	<div id="text2"><p> &nbsp &nbsp Edit Email Subject</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div> 
	<br><br><br>
	<center>
	<div class="ex">
	<div class="back">
	<form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
	<table>
	<br>
	<tr>
	<td>Email Type:</td>
	<td>
		<select name="subject" onChange="showUser(this.value); ">
			<option value="">---SELECT---</option>
			<option value="C">Cancellation</option>
			<option value="R">Rescheduling</option>
			<option value="BL">Block</option>
			<option value="UB">Unblock</option>
			<!--Added By: Parul Joshi Dated: 09/02/2015 Task : to display Drop Session in drop down menu -->
			<option value="DS">Drop Session</option>
		</select>
	</td>
	</tr> 
	<tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td> 
	<tr>
	<td>
		Email Subject:
	</td>            
	<td><div id ="txtHint"></div></td>
	</tr>
	<tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td> 
	<tr>
	<td>
		<table border="0">
			<tr>
				<td>New Email Subject:</td>
			</tr>
		</table>
	</td>
	<td>
		<table border="0">
			<tr>
				<td><textarea rows="1" cols="30" name="newSubject"></textarea></td>
			</tr>
		</table>
	</td>
	</tr>
	</table>
	<br>
	<button type="submit" name="go"><img src="../images/submit.png"  width="102" height="28" border="none"/></a></button>
	<br>
	<!-- message will fade out in 1 minutes -->
	<div class = "mesg2" id="testdiv" class=""> <?php echo "$A"; ?> </div>
	<div class = "mesg2" id="testdiv" class=""> <?php echo "$B"; ?> </div>

	</form>
</div>
</div>
</center>
</div>
</body>