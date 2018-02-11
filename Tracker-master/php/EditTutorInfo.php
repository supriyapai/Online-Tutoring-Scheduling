<!-- This page displays the details of the tutor that is selected on the EditTutor page and allows to edit these
details and update the database -->

<?php 
	include 'LoginCheck.php';
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
	include '../Rules/days.php';
?>
<html>
<head>
<title>Edit Tutor Information</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/edittutorinfo.css" />
<script type = "text/javascript">
function validateForm() {
    var tln = document.forms["myForm"]["Tln"].value;
    if (tln == null || tln == "---SELECT---") {
        alert("Please Enter Tutor Last Name");
        return false;

    }
    var tfn = document.forms["myForm"]["Tfn"].value;
    if (tfn == null || tfn == "---SELECT---") {
        alert("Please Enter Tutor First Name");
        return false;

    }
    var tphone = document.forms["myForm"]["Tphone"].value;
    if (tphone == null || tphone == "---SELECT---") {
        alert("Please Enter Tutor Phone Number");
        return false;

    }
    var temail = document.forms["myForm"]["Temail"].value;
    if (temail == null || temail == "---SELECT---") {
        alert("Please Enter Tutor Email");
        return false;

    }
    var thours = document.forms["myForm"]["Thours"].value;
    if (thours == null || thours == "---SELECT---") {
        alert("Please Enter Tutor Hours");
        return false;

    }
    var hdate = document.forms["myForm"]["hiredate"].value;
    if (hdate == null || hdate == "---SELECT---") {
        alert("Please Enter Tutor Hire Date");
        return false;

    }
    var s1 = document.forms["myForm"]["Tsub1"].value;
    var s2 = document.forms["myForm"]["Tsub2"].value;
    var s3 = document.forms["myForm"]["Tsub3"].value;
    var s4 = document.forms["myForm"]["Tsub4"].value;
    var s5 = document.forms["myForm"]["Tsub5"].value;
    var s6 = document.forms["myForm"]["Tsub6"].value;
    if (s1 == null && s2 == null && s3 == null && s4 == null && s5 == null && s6 == null) {
        alert("Please Select Atleast one Subject");
        return false;
    }
    var prate = document.forms["myForm"]["payrate"].value;
    if (prate == null || prate == "---SELECT---") {
        alert("Please Enter Tutor Pay Rate");
        return false;
    }
}
</script>
<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script id="jsbin-javascript">
/* Edited By: Parul Joshi Dated: 08/17/2015
			Task - to delete the subject related session from student_tutor_allocation_main table */
$(document).ready(function(){
	var sel = $("#Tsub1");
	sel.data("prev",sel.val());
	sel.change(function(data){
		var jqThis = $(this);
		var subID = jqThis.data("prev");
		var tutorID=document.getElementById("id").innerHTML;
			if(subID !=0){
				if(confirm("Are you Sure you want to remove this subject? All Sessions related to this subject will be deleted")){
					delete_subject(subID,tutorID);
				}else{
				 jqThis.data("prev",jqThis.val());
				 }
			}	  
    });
});
$(document).ready(function(){
	var sel = $("#Tsub2");
	sel.data("prev",sel.val());
	sel.change(function(data){
		var jqThis = $(this);
		var subID = jqThis.data("prev");
		var tutorID=document.getElementById("id").innerHTML;
			if(subID !=0){
				if(confirm("Are you Sure you want to remove this subject? All Sessions related to this subject will be deleted")){
					delete_subject(subID,tutorID);
				}else{
				 jqThis.data("prev",jqThis.val());
				 }
			}	  
    });
});
$(document).ready(function(){
	var sel = $("#Tsub3");
	sel.data("prev",sel.val());
	sel.change(function(data){
		var jqThis = $(this);
		var subID = jqThis.data("prev");
		var tutorID=document.getElementById("id").innerHTML;
			if(subID !=0){
				if(confirm("Are you Sure you want to remove this subject? All Sessions related to this subject will be deleted")){
					delete_subject(subID,tutorID);
				}else{
				 jqThis.data("prev",jqThis.val());
				 }
			}	  
    });
});
$(document).ready(function(){
	var sel = $("#Tsub4");
	sel.data("prev",sel.val());
	sel.change(function(data){
		var jqThis = $(this);
		var subID = jqThis.data("prev");
		var tutorID=document.getElementById("id").innerHTML;
			if(subID !=0){
				if(confirm("Are you Sure you want to remove this subject? All Sessions related to this subject will be deleted")){
					delete_subject(subID,tutorID);
				}else{
				 jqThis.data("prev",jqThis.val());
				 }
			}	  
    });
});
$(document).ready(function(){
	var sel = $("#Tsub5");
	sel.data("prev",sel.val());
	sel.change(function(data){
		var jqThis = $(this);
		var subID = jqThis.data("prev");
		var tutorID=document.getElementById("id").innerHTML;
			if(subID !=0){
				if(confirm("Are you Sure you want to remove this subject? All Sessions related to this subject will be deleted")){
					delete_subject(subID,tutorID);
				}else{
				 jqThis.data("prev",jqThis.val());
				 }
			}	  
    });
});
$(document).ready(function(){
	var sel = $("#Tsub6");
	sel.data("prev",sel.val());
	sel.change(function(data){
		var jqThis = $(this);
		var subID = jqThis.data("prev");
		var tutorID=document.getElementById("id").innerHTML;
			if(subID !=0){
				if(confirm("Are you Sure you want to remove this subject? All Sessions related to this subject will be deleted")){
					delete_subject(subID,tutorID);
				}else{
				 jqThis.data("prev",jqThis.val());
				 }
			}	  
    });
});

function delete_subject(subID,tutorID){
	var data = { 'subID': subID , 'tutorID': tutorID};
	$.ajax({
			type: 'post',
			url: '../php/delSubjectRelatedSession.php',
			data: data,
			cache: false,
			success: function(response){
				console.log(response);
			},
			error: function() {
				console.log('error');
			}
			});
}

</script>
<script type="text/javascript" src="../js/inputyear.js"></script>

</head>
<body onLoad="addOption_list()";>
<center>
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
	<div id="text2"><p>Edit Tutor Information</p></div>
	<form name = "myForm" action = "EditTutorInfo.php" onsubmit="return validateForm()" method = "post">
	<br>
	<p align="right" style="padding-left:150px"><i>You are here: </i>Edit >> Tutor Information </p>
<?php
	$polyid = $_POST["poly_id"];
	if(!$polyid){
		$polyid = $_POST["nyuid"];
	}
	$query1 = mysql_query("SELECT * FROM Tutor WHERE Tutor_Poly_Id = '$polyid' ");
	$query2 = mysql_fetch_array($query1);
	$Tln = $query2[Tutor_Last_Name];
	$Tfn = $query2[Tutor_First_Name];
	$Tmi = $query2[Tutor_MI];
	$Tphone = $query2[Tutor_Phone_No];
	$Temail = $query2[Tutor_Email];
	$Sclassstatus= $_POST[Class_Status];
	$Sgradyear= $_POST[Graduation_Year];
	$Thours = $query2[Tutor_Hours];
	$Thiredate = $query2[Hire_Date];
	$Tsub1 = $query2[Subject_Taught_1];
	$Tsub2 = $query2[Subject_Taught_2];
	$Tsub3 = $query2[Subject_Taught_3];
	$Tsub4 = $query2[Subject_Taught_4];
	$Tsub5 = $query2[Subject_Taught_5];
	$Tsub6 = $query2[Subject_Taught_6];
	$Tactive = $query2[Active];
	$Tpayrate = $query2[Pay_Rate];
	$Tstatus = $query2[Tutor_Status];

	$subject11 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Tsub1' ");
	$subject12 = mysql_fetch_array($subject11);
	$subject1 = $subject12[0];

	$subject21 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Tsub2' ");
	$subject22 = mysql_fetch_array($subject21);
	$subject2 = $subject22[0];

	$subject31 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Tsub3' ");
	$subject32 = mysql_fetch_array($subject31);
	$subject3 = $subject32[0];

	$subject41 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Tsub4' ");
	$subject42 = mysql_fetch_array($subject41);
	$subject4 = $subject42[0];

	$subject51 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Tsub5' ");
	$subject52 = mysql_fetch_array($subject51);
	$subject5 = $subject52[0];

	$subject61 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Tsub6' ");
	$subject62 = mysql_fetch_array($subject61);
	$subject6 = $subject62[0];
	
?>
    <div class="ex">
	<div class = "back">
	<br><br>
    <table>
        <tr>
            <td><label for="name">University ID :</label></td>
			<td><?php echo $polyid; ?><input type="hidden" name="nyuid" value="<?php echo $polyid;?>"</td>
		</tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Last Name :</label></td>
            <td><input type="text" name="Tln" value="<?php echo $Tln;?>"</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor First Name :</label></td>
            <td><input type="text" name="Tfn" value="<?php echo $Tfn;?>"</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Middle Initial :</label></td>
            <td><input type="text" name="Tmi" value="<?php echo $Tmi;?>"</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Phone Number :</label></td>
            <td><input type="text" name="Tphone" value="<?php echo $Tphone;?>"</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Email :</label></td>
            <td><input type="text" name="Temail" value="<?php echo $Temail;?>"</td>
        </tr>
        <tr>
        <td>Tutor Class Status:</td>
        <td><select placeholder="Class Status" name = "Sclassstatus" value="<?php print $Sclassstatus; ?>">
			<option value="0">---SELECT---</option>
			<option value="Freshmen">Freshmen</option>
			<option value='Sophmore'>Sophmore</option>
			<option value="Junior">Junior</option>
			<option value="Senior">Senior</option>
			<option value="Graduate">Graduate</option>
			<option value="Alumni">Alumni</option>
			
	</select></td>
        </tr>
        <tr>
        <td>Tutor Graduation Year:</td>
        <td><select name="Sgradyear" value="<?php print $Sgradyear; ?>">
	        <Option value="0">---SELECT---</option>
		</select></td>
        </tr>
        <tr></tr>
        <tr>
            <td><label for="name">Tutor Hours :</label></td>
            <td><input type="text" name="Thours" value="<?php echo $Thours;?>"</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Hire date :</label></td>
            <td><p><input type="text" class="datepicker" name="hiredate" value="<?php echo $Thiredate;?>"></p></td>
        </tr>
        <tr></tr>
        <tr></tr><tr></tr>
        <tr>
            <td><label for="name" >Tutor Subject 1 :</label></td>
            <td>
		<?php
			$tutor_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
			while ($tutor_subjects2 = mysql_fetch_array($tutor_subjects1)){
				$tutor_subjects[] = $tutor_subjects2[Subject];
				$tutor_subjectid[] = $tutor_subjects2[Subject_Id];
			}
			$subjectcount = count($tutor_subjectid);

			echo "<select id='Tsub1' name='Tsub1'> ";
			echo "<option value = $Tsub1>$subject1</option>";
                        echo "<option value = 0>None</option>";
			for ($i=0; $i<$subjectcount; $i++){
				echo "<option value = $tutor_subjectid[$i] >$tutor_subjects[$i]</option>";
			}
			echo "</select>";
		?>
	</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Subject 2 :</label></td>
            <td>
		<?php
			$tutor_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
			while ($tutor_subjects2 = mysql_fetch_array($tutor_subjects1)){
				$tutor_subjects[] = $tutor_subjects2[Subject];
				$tutor_subjectid[] = $tutor_subjects2[Subject_Id];
			}
	
			$subjectcount = count($tutor_subjectid);

			echo "<select id='Tsub2' name='Tsub2' > ";
			echo "<option value = $Tsub2>$subject2</option>";
                        echo "<option value = 0>None</option>";
			for ($i=0; $i<$subjectcount; $i++){
				echo "<option value = $tutor_subjectid[$i]>$tutor_subjects[$i]</option>";
			}
			echo "</select>";
		?>
		</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Subject 3 :</label></td>
            <td>
		<?php
			$tutor_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
			while ($tutor_subjects2 = mysql_fetch_array($tutor_subjects1)){
				$tutor_subjects[] = $tutor_subjects2[Subject];
				$tutor_subjectid[] = $tutor_subjects2[Subject_Id];
			}
			$subjectcount = count($tutor_subjectid);

			echo "<select id='Tsub3' name='Tsub3'> ";
			echo "<option value = $Tsub3>$subject3</option>";
                        echo "<option value = 0>None</option>";
			for ($i=0; $i<$subjectcount; $i++){
				echo "<option value = $tutor_subjectid[$i]>$tutor_subjects[$i]</option>";
			}
			echo "</select>";
		?>
	</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Subject 4 :</label></td>
            <td>
		<?php
			$tutor_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
			while ($tutor_subjects2 = mysql_fetch_array($tutor_subjects1)){
				$tutor_subjects[] = $tutor_subjects2[Subject];
				$tutor_subjectid[] = $tutor_subjects2[Subject_Id];
			}
			$subjectcount = count($tutor_subjectid);

			echo "<select id='Tsub4' name='Tsub4'> ";
			echo "<option value = $Tsub4>$subject4</option>";
                        echo "<option value = 0>None</option>";
			for ($i=0; $i<$subjectcount; $i++){
				echo "<option value = $tutor_subjectid[$i]>$tutor_subjects[$i]</option>";
			}
			echo "</select>";
		?>
	</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Subject 5 :</label></td>
            <td>
		<?php
			$tutor_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
		while ($tutor_subjects2 = mysql_fetch_array($tutor_subjects1)){
				$tutor_subjects[] = $tutor_subjects2[Subject];
				$tutor_subjectid[] = $tutor_subjects2[Subject_Id];
			}
	
			$subjectcount = count($tutor_subjectid);

			echo "<select id='Tsub5' name='Tsub5'> ";
			echo "<option value = $Tsub5>$subject5</option>";
                        echo "<option value = 0>None</option>";
			for ($i=0; $i<$subjectcount; $i++){
				echo "<option value = $tutor_subjectid[$i]>$tutor_subjects[$i]</option>";
			}
			echo "</select>";
		?>
	</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Subject 6 :</label></td>
            <td>
		<?php
			$tutor_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
			while ($tutor_subjects2 = mysql_fetch_array($tutor_subjects1)){
				$tutor_subjects[] = $tutor_subjects2[Subject];
				$tutor_subjectid[] = $tutor_subjects2[Subject_Id];
			}
			$subjectcount = count($tutor_subjectid);
			echo "<select id='Tsub6' name='Tsub6'> ";
			echo "<option value = $Tsub6>$subject6</option>";
                        echo "<option value = 0>None</option>";
			for ($i=0; $i<$subjectcount; $i++){
				echo "<option value = $tutor_subjectid[$i]>$tutor_subjects[$i]</option>";
			}
			echo "</select>";
		?>
	</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Active :<?php echo $Tactive; ?></label> </td>
            <td><input type = "radio" name = "active" value = "Yes" selected="selected">Yes
            <!--<br>--><input type = "radio" name = "active" value = "No">No</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Status :<?php echo $Tstatus; ?></label></td>
            <td><input type = "radio" name = "tutorstatus" value = "New">New
            <!-- <br>--><input type = "radio" name = "tutorstatus" value = "Returning">Returning</td>
        </tr>
        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td><label for="name">Tutor Pay Rate :</label></td>
            <td><p><input type="text" name="payrate" value="<?php echo $Tpayrate;?>"></p></td>
        </tr>
    </table>
   <br><br>
	<button type="submit" name="save"><img src="../images/save.png"  width="102" height="28" border="none"/></a></button>
	<?php
    if(isset($_POST["save"]))
    {
        $newTln = $_POST["Tln"];
        $newTfn = $_POST["Tfn"];
        $newTmi = $_POST["Tmi"];
        $newTphone = $_POST["Tphone"];
        $newTemail = $_POST["Temail"];
        $newSclassstatus= $_POST["Sclassstatus"];
		$newSgradyear= $_POST["Sgradyear"];
        $newThours = $_POST["Thours"];
        $hiredateconvo1 = $_POST["hiredate"];
        $hiredateconvo2 = strtotime($hiredateconvo1);
        $newThiredate = date('Y-m-d',$hiredateconvo2);
        $newTsub1 = $_POST["Tsub1"];
        $newTsub2 = $_POST["Tsub2"];
        $newTsub3 = $_POST["Tsub3"];
        $newTsub4 = $_POST["Tsub4"];
        $newTsub5 = $_POST["Tsub5"];
        $newTsub6 = $_POST["Tsub6"];
        $newactive = $_POST["active"];
        if ($newactive == '') {
		$newTactive = $Tactive;
		} else {
			$newTactive = $newactive;
		}
		$newstatus = $_POST["tutorstatus"];
		if ($newstatus == '') {
			$newTstatus = $Tstatus;
		} else {
			$newTstatus = $newstatus;
		}
		$newTpayrate = $_POST["payrate"];

		$subcount = 0;

		if ($newTsub1 != 0) {
			$subcount++;
		}
		if ($newTsub2 != 0) {
			$subcount++;
		}
		if ($newTsub3 != 0) {
			$subcount++;
		}
		if ($newTsub4 != 0) {
			$subcount++;
		}
		if ($newTsub5 != 0) {
			$subcount++;
		}
		if ($newTsub6 != 0) {
			$subcount++;
		}
		if (preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Tln"]) === 0) {
			$A = 'Last Name must be from letters, dashes, spaces and must not start with dash';
		}
		elseif(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["Tfn"]) === 0) {
			$A = 'First Name must be from letters, dashes, spaces and must not start with dash';

		}
	/* 	elseif(preg_match("/^[0-9a-zA-Z]\w+(\.\w+)*\@\w+(\.[0-9a-zA-Z]+)*\.[0-9a-zA-Z]{2,4}$/", $_POST["Temail"]) === 0) {
			$A = 'Email must comply with this mask: chars(.chars)@chars(.chars).chars(2-4)';
		} */
		elseif(!filter_var($_POST["Temail"], FILTER_VALIDATE_EMAIL)) {
		  $A = "Invalid email format"; 
		}
		else {
			$updateT = mysql_query("UPDATE `Tutor` SET `Tutor_Last_Name` = '$newTln', `Tutor_First_Name` = '$newTfn', `Tutor_MI` = '$newTmi', `Tutor_Phone_No` = '$newTphone', `Tutor_Email` = '$newTemail',`Class_Status`='$newSclassstatus',`Graduation_Year`='$newSgradyear', `No_Of_Subjects` = '$subcount', `Subject_Taught_1` = '$newTsub1', `Subject_Taught_2` = '$newTsub2', `Subject_Taught_3` = '$newTsub3', `Subject_Taught_4` = '$newTsub4', `Subject_Taught_5` = '$newTsub5', `Subject_Taught_6` = '$newTsub6', `Active` = '$newTactive', `Tutor_Status` = '$newTstatus', `Tutor_Hours` = '$newThours', `Hire_Date` = '$newThiredate', `Pay_Rate` = '$newTpayrate' WHERE Tutor_Poly_Id = '$polyid' ");
			if ($updateT) {
				/* Edited By: Parul Joshi Dated: 08/17/2015
			Task - to update the tutor info in student_tutor_allocation_main table */
			$updateSTA = mysql_query("UPDATE `Student_Tutor_Allocation_Main` SET `Tutor_Last_Name` = '$newTln', `Tutor_First_Name` = '$newTfn' WHERE Tutor_Poly_Id = '$polyid' ");
			if ($updateSTA) {
				$B = 'Tutor Info Updated';
			} else {
				$C = 'Tutor Info NOT Updated';
			}
			}else {
				$C = 'Tutor Info NOT Updated';
			}
		}
	}elseif(isset($_POST["exit"])) {
			$url1 = "Selectfunction.php";
			header("Location:$url1");
	}
?>
	<div id="log" class="mesg"><?php echo $A; ?></div>
	<div id="log" class="mesg2"><?php echo $B; ?></div>
	<div id="log" class="mesg3"><?php echo $C; ?></div>
    </div>
</div>
</form>
</center>
</body>
</html>
