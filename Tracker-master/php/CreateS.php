<!-- This Page helps you create a student profile and inserts it into the database -->

<?php include 'LoginCheck.php'; ?>
<?php 
    include '../Rules/dbconfig.php'; 
    include '../Rules/datepicker.php';
?>

<?php
if(isset($_POST["Submit"]) ){
//Assigining various inputs obtained from the form to the variables	
	$Sln = $_POST["Sln"];
	$Sfn = $_POST["Sfn"];
	$Smi = $_POST["Smi"];
	$Sphone = $_POST["Sphone"];
	$active = $_POST["active"];
	$studentstatus = $_POST["studentstatus"];
	$Sclassstatus= $_POST["Sclassstatus"];
	$Sgradyear= $_POST["Sgradyear"];
	$Semail = $_POST["Semail"];
	$Spid = $_POST["SPid"];
	//Error check for poly id
	//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
	if(preg_match("/^\d{8}$/", $_POST["SPid"]) === 0) {
		//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
		$A = 'University N Number must be 8 digits';
	}
	elseif(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Sln"]) === 0){
		$C = 'Last Name must be from letters, dashes, spaces and must not start with dash';
	}
	elseif(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Sfn"]) === 0){
		$C = '<p class="errText">First Name must be from letters, dashes, spaces and must not start with dash</p>';
	}
	elseif(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$/", $_POST["Semail"]) === 0){
		$C = 'Email must comply with this mask: chars(.chars)@chars(.chars).chars(2-4)';
	}
	else{			
//Inserting into the database                    
		$checkstudent1 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$Spid'");
		$checkstudent2 = mysql_fetch_array($checkstudent1);
		$checkstudent = $checkstudent2[Active];		
		$count = count($checkstudent);
		if($count != 0){
			if($checkstudent == 'YES'){
				$A = "The student is already Present and Active";   
			}else{
				$A = "The student is Present and NOT active. You can activate the student from the edit tab.";	
			}	
		}else{
			$insert = mysql_query("INSERT INTO `Student`(Student_Poly_Id, `Student_First_Name`, `Student_Last_Name`, `Student_MI`, `Student_Phone_No`, `Student_Email`, `Active`, `Student_Status`,`Class_Status`,`Graduation_Year`) VALUES ('$Spid', '$Sfn', '$Sln', '$Smi', '$Sphone', '$Semail','$active', '$studentstatus','$Sclassstatus','$Sgradyear')" );
			if($insert){
				$B = $Sfn." ".$Sln." has been inserted. Please enter another or exit";
			}else{
				$A = $Tfn." ".$Tln." has NOT been inserted";
			}
		}
	}
}
if(isset($_POST["back"])){
	$url = "Selectfunction.php";
	header("Location:$url");
}		
?>
<html>
    <head>
        <title>Input Student</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/inputstudent.css" />
		<script type = "text/javascript">
function validateForm(){
	var spid=document.forms["myForm"]["SPid"].value;
	if (spid==null || spid == ""){
		//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
		alert("Please Enter University N Number without N");
		return false;
    }
	var lname = document.forms["myForm"]["Sln"].value;
	if (lname==null || lname == ""){
		alert("Please Enter Last Name");
		return false;
   }
   var fname = document.forms["myForm"]["Sfn"].value;
	if (fname==null || fname == ""){
		alert("Please Enter First Name");
		return false;
   } 
	var mname = document.forms["myForm"]["Smi"].value;
	if (mname==null || mname == ""){
		alert("Please Enter Middle Name");
		return false;
   }
   var email = document.forms["myForm"]["Semail"].value;
	if (email==null || email ==""){
		alert("Please Enter Email Address");
		return false;
   }
   var phone = document.forms["myForm"]["Sphone"].value;
	if (phone==null || phone ==""){
		alert("Please Enter Phone number");
		return false;
   }
   var class_sta = document.forms["myForm"]["Sclassstatus"].value;
	if (class_sta=="0" || class_sta ==""){
		alert("Please Select your Class Status");
		return false;
   }
   var grad_year = document.forms["myForm"]["Sgradyear"].value;
	if (grad_year=="0" || grad_year ==""){
		alert("Please Select your Expected Graduation Date");
		return false;
   }   
}
</script>
<script type="text/javascript" src="../js/inputyear.js"></script>
</head>
<body onLoad="addOption_list()";>

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
	<div id="line"></div>
	<div id="signout"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></div>
	<div id="text2"><p> &nbsp &nbsp Input Student Information</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<div id="mainbody"></div>
	<div id="save"></div>
    <div id="inputboxbackground"></div>
	    
	<form name="myForm" action="<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method="post">

		</br>
		<label for="name">University ID :</label>
		<input type="text" maxlength="8" placeholder="University ID" name="SPid" value="<?php print $Spid; ?>" required>
		</br>

		<label for="name">Student Last Name :</label>
		<input type="text" name="Sln" placeholder="Last Name" value="<?php print $Sln; ?>" required>
		</br>

		<label for="name">Student First Name :</label>
		<input type="text" name="Sfn" placeholder="First Name" value="<?php print $Sfn; ?>" required>
		</br>

		<label for="name">Student Middle Name :</label>
		<input type="text" name="Smi" placeholder="MI" value="<?php print $Smi; ?>" >
		</br>

		<label for="name">Student Email :</label>
		<input type="text" name="Semail" placeholder="Email" value="<?php print $Semail; ?>" required>
		</br>

		<label for="name">Student Phone Number :</label>
		<input type="text" maxlength="10" placeholder="Phone Number" name="Sphone" value="<?php print $Sphone; ?>" required>
		</br>


		<label for="name">Student Class Status :</label>
		<select placeholder="Class Status" name="Sclassstatus" value="<?php print $Sclassstatus; ?>" required>
			<option value="">---SELECT---</option>
			<option value="Freshmen">Freshmen</option>
			<option value='Sophmore'>Sophmore</option>
			<option value="Junior">Junior</option>
			<option value="Senior">Senior</option>
			<option value="Graduate">Graduate</option>
			<option value="Alumni">Alumni</option>

		</select>

		</br>

		<label for="name">Student Graduation Year :</label>
		<select name="Sgradyear" value="<?php print $Sgradyear; ?>" required>
			<Option value="">---SELECT---</option>
		</select>

		</br>

		<label for="name">Is the Student currently active:</label>
		<input type="radio" name="active" value="YES" selected="selected">Yes
		<input type="radio" name="active" value="NO">No
		</br>

		<label for="name">Student Status :</label>
		<input type="radio" name="studentstatus" value="NEW">New
		<input type="radio" name="studentstatus" value="RETURNING">Returning
		</br>
		</br>

		<center>
			<button type="submit" name="Submit"><img src="../images/save.png" width="102" height="28" border="none" />
			</button>
			<div class="mesg1">
				<?php echo "$A"; ?>
			</div>
			<div class="mesg2">
				<?php echo "$B" ;?> </div>
			<div class="mesg3">
				<?php echo "$C" ;?> </div>
		</center>

	</form>
</div>
</body>
</html>
