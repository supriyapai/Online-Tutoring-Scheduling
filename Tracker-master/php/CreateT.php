<!-- This page helps to create Tutor profile and inserts it into the database -->
<?php	include 'LoginCheck.php';   ?>
<?php
//Establishing a connection with the host                
		include '../Rules/dbconfig.php';
		include '../Rules/datepicker.php';
?>
<html>
    <head>
        <title>Input Tutor</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/inputtutor2.css" />
        <link rel="stylesheet" href="../css/datepicker.css" />
        <script src="jquery 1.9.1.js"></script>
<script>
    $(function() {
      
      $("#datepicker").datepicker({
        onSelect: function(dateText, inst) { 
          $(this).prev()[0].value = dateText;
        }
      });
  });
  </script>
		<script type = "text/javascript">

function validateForm() {
    var tpid = document.forms["myForm"]["TPid"].value;
    if (tpid == null || tpid == "") {
        //Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
        alert("Please Enter University N Number without N");
        return false;
    }
    var lname = document.forms["myForm"]["Tln"].value;
    if (lname == null || lname == "") {
        alert("Please Enter Last Name");
        return false;
    }
    var fname = document.forms["myForm"]["Tfn"].value;
    if (fname == null || fname == "") {
        alert("Please Enter First Name");
        return false;
    }

    var mname = document.forms["myForm"]["Tmi"].value;
    if (mname == null || mname == "") {
        alert("Please Enter Middle Name");
        return false;
    }
    var temail = document.forms["myForm"]["Temail"].value;
    if (temail == null || temail == "") {
        alert("Please Enter Email Address");
        return false;
    }
    var tphone = document.forms["myForm"]["Tphone"].value;
    if (tphone == null || tphone == "") {
        alert("Please Enter Phone number");
        return false;
    }
    var thours = document.forms["myForm"]["Tutor_hours"].value;
    if (thours == null || thours == "") {
        alert("Please Enter Tutor Hours");
        return false;
    }
    var hired = document.forms["myForm"]["hiredate"].value;
    if (hired == null || hired == "") {
        alert("Please Enter Date of Hire");
        return false;
    }
    var pay = document.forms["myForm"]["payrate"].value;
    if (pay == null || pay == "") {
        alert("Please Enter Pay Rate");
        return false;
    }

    var tsub = document.forms["myForm"]["Tsub"].value;
    if (tsub == null || tsub == "---SELECT---") {
        alert("Please Select Subject");
        return false;
    }
    var class_sta = document.forms["myForm"]["Sclassstatus"].value;
    if (class_sta == "0" || class_sta == "") {
        alert("Please Select your Class Status");
        return false;
    }
    var grad_year = document.forms["myForm"]["Sgradyear"].value;
    if (grad_year == "0" || grad_year == "") {
        alert("Please Select your Expected Graduation Date");
        return false;
    }

}
</script>

<script type="text/javascript" src="../js/inputyear.js"></script>
<?php
if(isset($_POST["enter"]) ){
//assigning the user inputs obtained from the form to variables
                    
	$Tphone = $_POST["Tphone"];
	$Tutor_hours = $_POST["Tutor_hours"];
	$Tpid = $_POST["TPid"];
	$Tfn = $_POST["Tfn"];
	$Tln = $_POST["Tln"];
	$Tmi = $_POST["Tmi"];
	$Temail = $_POST["Temail"];
	$Tsub = $_POST["Tsub"];
	$active = $_POST["active"];
	$Sclassstatus= $_POST["Sclassstatus"];
	$Sgradyear= $_POST["Sgradyear"];
	$hiredateconvo1 = $_POST["hiredate"];
	$hiredateconvo2 = strtotime($hiredateconvo1);
	$hiredate = date('Y-m-d',$hiredateconvo2);
	$payrate = $_POST["payrate"];
	$tutorstatus = $_POST["tutorstatus"];
	//Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number        
	if(preg_match("/^\d{8}$/", $_POST["TPid"]) === 0) {
		$A = 'University N Number must be 8 digits';
	}
	elseif(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Tln"]) === 0){
		$C = 'Last Name must be from letters,dashes,spaces and must not start with dash';		
	}
	elseif(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Tfn"]) === 0){
		$C = 'First Name must be from letters,dashes,spaces and must not start with dash';
	}
	elseif(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$/", $_POST["Temail"]) === 0){
		$C = 'Email must comply with this mask: chars(.chars)@chars(.chars).chars(2-4)';
	}
	elseif(count($Tsub)==0){
		$A = 'Please Select At least One(1) Subject';
		}
	else{
//Assigning tutor subjects obtained from the tsub array
		$Tsub1 = $Tsub[0];
		$Tsub2 = $Tsub[1];
		$Tsub3 = $Tsub[2];
		$Tsub4 = $Tsub[3];
		$Tsub5 = $Tsub[4];
		$Tsub6 = $Tsub[5];
//Inserting the data into the Tutor table of the database
		$checktutor1 = mysql_query("SELECT * FROM Tutor WHERE Tutor_Poly_Id = '$Tpid'");
		$checktutor2 = mysql_fetch_array($checktutor1);
		$checktutor = $checktutor2[Active];
		$count = count($checktutor);
		if($count != 0){
			if($checktutor == 'YES'){
				$A = "The tutor is already Present and Active";   
			}
			else{
				$A = "The tutor is Present and NotActive. You can activate the tutor from the edit tab.";	
			}
		}
		else{
			//echo $Tpid;
			$insert = mysql_query("INSERT INTO `Tutor`(Tutor_Poly_Id, `Tutor_First_Name`, `Tutor_Last_Name`, `Tutor_MI`, `Tutor_Email`, `Tutor_Phone_No`,`Class_Status`,`Graduation_Year`, `Tutor_Hours`, `Hire_Date`, `Subject_Taught_1`, `Subject_Taught_2`, `Subject_Taught_3`, `Subject_Taught_4`, `Subject_Taught_5`, `Subject_Taught_6`, `Active`, `Pay_Rate`, `Tutor_Status`) VALUES ('$Tpid', '$Tfn', '$Tln', '$Tmi', '$Temail', '$Tphone','$Sclassstatus','$Sgradyear','$Tutor_hours', '$hiredate', '$Tsub1', '$Tsub2', '$Tsub3', '$Tsub4', '$Tsub5', '$Tsub6', '$active', '$payrate', '$tutorstatus')");
			if($insert){
				$B = $Tfn." ".$Tln." has been inserted. Please enter another or exit"; 
			}else{
				$A = $Tfn." ".$Tln." has NOT been inserted.";
			}
		}
	
	}	
}elseif(isset($_POST["back"]) ){
	$url = "Selectfunction.php";
	header("Location:$url");
}		
?>


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
	<div id="text2"><p>&nbsp &nbsp Input Tutor Information</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<div id="mainbody"></div>
	<div id="inputboxbackground"></div>
	<form name = "myForm" action = "CreateT.php" onsubmit="return validateForm()" method = "post">
		<br>
		<label for="name">University ID :</label>
		<input type="text" maxlength="8" name="TPid" placeholder="University ID" value="<?php print $tpid; ?>" required></input>
		<br>
		<label for="name">Tutor Last Name :</label>
		<input type="text" name="Tln" placeholder="Last Name" value="<?php print $tln; ?>" required></input>
		<br>
		<label for="name">Tutor First Name :</label>
		<input type="text" name="Tfn" placeholder="First Name" value="<?php print $tfn; ?>" required> </input>
		</br>
		<label for="name">Tutor Middle Name :</label>
		<input type="text" name="Tmi" placeholder="Middle Name" value="<?php print $tmi; ?>" </input>
		</br>
		<label for="name">Tutor Email :</label>
		<input type="text" name="Temail" placeholder="Email" value="<?php print $temail; ?>" required> </input>
		</br>
		<label for="name">Tutor Phone Number :</label>
		<input type="text" maxlength="10" name="Tphone" placeholder="Phone Number" value="<?php print $tphone; ?>" > </input>
		</br>
		<label for="name">Tutor Class Status :</label>
		<select placeholder="Class Status" name = "Sclassstatus" value="<?php print $Sclassstatus; ?>" required>
			<option value="">---SELECT---</option>
			<option value="Freshmen">Freshmen</option>
			<option value='Sophmore'>Sophmore</option>
			<option value="Junior">Junior</option>
			<option value="Senior">Senior</option>
			<option value="Graduate">Graduate</option>
			<option value="Alumni">Alumni</option>
		</select>
		</br>
		<label for="name">Tutor Graduation Year :</label>
		<select name="Sgradyear" value="<?php print $Sgradyear; ?>" required>
			<Option value="">---SELECT---</option>
		</select>
		</br> 
		 <label for="name">Number of Employed Hour :</label>
		 <input type="text" name="Tutor_hours" placeholder="Hours" value="<?php print $Tutor_hours; ?>" ></input> 
		 </br>
		 <label for="name">Date Of Hire :</label>
		 <input type="text" id="datepicker" name="hiredate" placeholder="Select A Date" > </input> 
		 </br>
		 <label for="name">Pay Rate :</label>
		 <input type="text" name = "payrate" placeholder="Pay Rate" value="<?php print $payrate; ?>" > </input> 
		 </br>	
		<label for="name">Is the tutor currently active :</label>
		<input type = "radio" name = "active" value = "YES">Yes</input>
		<input type = "radio" name = "active" value = "NO">No</input>
		</br>
		<label for="name">Tutor Status :</label>
		<input type = "radio" name = "tutorstatus" value = "NEW">New</input>
		<input type = "radio" name = "tutorstatus" value = "RETURNING">Returning</input>
		</br>
		<label for="name">Select Subject :</label>
        <?php
			$tutor_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
			while ($tutor_subjects2 = mysql_fetch_array($tutor_subjects1)){
				$tutor_subjects[] = $tutor_subjects2[Subject];
				$tutor_subjectid[] = $tutor_subjects2[Subject_Id];
			}
			$subjectcount = count($tutor_subjectid);
			echo "<select name='Tsub[]'> ";
			echo "<option>---SELECT---</option>";
			for ($i=0; $i<$subjectcount; $i++){
				echo "<option value = $tutor_subjectid[$i]>$tutor_subjects[$i]</option>";
			}
			echo "</select>";
		?>	
		</br></br>	  
		<center> <button type="submit" name="enter"><img src="../images/save.png"  width="102" height="28" border="none"/></a></button></center>
		<div class = "mesg1"> <?php  echo "$A" ;?> </div>
		<div class = "mesg2"> <?php  echo "$B" ;?> </div>
		<div class = "mesg3"> <?php  echo "$C" ;?> </div>
	</form> 
</div>
</body>
</html>
