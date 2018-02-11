<?php include 'LoginCheck.php'; ?>
<?php
include '../Rules/dbconfig.php';
include '../Rules/datepicker.php';
?>

<html>

<head>
    <title>Tutor Block/UnBlock </title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/studentblock.css" />
</head>
<body>

 <script type = "text/javascript">
function validateForm(){
	var x=document.forms["myForm"]["Tname"].value;
	if (x==null || x=="---SELECT---"){
		alert("Select a tutor from the drop down");
		return false;
	}
}
</script>
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
	<div id="text2"><p>Tutor Block/Unblock</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<center>
<?php
	$tutorDetails1 = mysql_query(" SELECT `Tutor_First_Name`, `Tutor_Last_Name`, `Tutor_Poly_Id` FROM Tutor ORDER BY Tutor_Last_Name ");
	while($tutorDetails2 = mysql_fetch_array($tutorDetails1) ){
		$tutorFirstName[] = $tutorDetails2[Tutor_First_Name];
		$tutorLastName[] = $tutorDetails2[Tutor_Last_Name];
		$tutorPolyId[]       = $tutorDetails2[Tutor_Poly_Id];
	}
	$no1 = count($tutorPolyId);
	for($a=0; $a<$no1; $a++){
		$tutorName[] = $tutorLastName[$a]." ".$tutorFirstName[$a];
	}
?>

<?php
if(isset($_POST["unblock"])){
    $id = $_POST["Tname"];	 
    if($id == '---SELECT---'){
		$A = 'Select a tutor from the drop down';
    }else{
		 $c_tutorn1 = mysql_query("SELECT Tutor_First_Name , Tutor_Last_Name FROM Tutor WHERE Tutor_Poly_Id = '$id' ");
		 $c_tutorn2 = mysql_fetch_array($c_tutorn1);
		 $c_tutorfirstn = $c_tutorn2[Tutor_First_Name];                       
		 $c_tutorlastn = $c_tutorn2[Tutor_Last_Name];
		 $c_tutorname = $c_tutorfirstn." ".$c_tutorlastn;

		$check3 = mysql_query("UPDATE Tutor SET `Block`='0' WHERE `Tutor_Poly_Id`='$id' ");
        if($check3){
            $tutoremail1 = mysql_query("SELECT Tutor_Email FROM Tutor WHERE Tutor_Poly_Id = '$id'");
            $tutoremail2 = mysql_fetch_array($tutoremail1);
            $tutoremail = $tutoremail2[0];
            
            $to = $tutoremail.","."fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu".","."pj649@nyu.edu";
            $sub = "TRIO - Tutor UnBlocked";
            $message = "You ($c_tutorname) have been UnBlocked.";
            $headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
			mail($to, $sub, $message, implode("\r\n", $headers));
            $B = "Tutor successfully unblocked";
        }else{
            $A = "There was an Error in blocking or unblocking";
        }
    }
}elseif(isset($_POST["block"])){
    $id = $_POST["Tname"];
    if($id == '---SELECT---'){
		$A = 'Select a tutor from the drop down';
    }else{
        $check3 = mysql_query("UPDATE Tutor SET `Block`='1' WHERE `Tutor_Poly_Id`='$id' ");
        if($check3){
            $tutoremail1 = mysql_query("SELECT Tutor_Email FROM Tutor WHERE Tutor_Poly_Id = '$id'");
            $tutoremail2 = mysql_fetch_array($tutoremail1);
            $tutoremail = $tutoremail2[0];            
			$c_tutorn1 = mysql_query("SELECT Tutor_First_Name , Tutor_Last_Name FROM Tutor WHERE Tutor_Poly_Id = '$id' ");
			$c_tutorn2 = mysql_fetch_array($c_tutorn1);
			$c_tutorfirstn = $c_tutorn2[Tutor_First_Name];                       
			$c_tutorlastn = $c_tutorn2[Tutor_Last_Name];
			$c_tutorname = $c_tutorfirstn." ".$c_tutorlastn;
            $to = $tutoremail.","."fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu".","."pj649@nyu.edu";
            $sub = "TRIO - Tutor Blocked";
            $message = "You($c_tutorname) have been Blocked as a tutor in the TRIO Department. Please meet a staff member.";
            $headers[] = "From: TRIO Program <trionyupoly@gmail.com>";
			mail($to, $sub, $message, implode("\r\n", $headers));
			
            $B = "Tutor is successfully blocked";
            
        }else{
            $A = "There was an Error in blocking or unblocking";
        }
    }
}
?>

<form name = "myForm"action = "TutorBlock.php" onsubmit="return validateForm()"  method = "post">
 <br><br><br> 
   <center>
    <div class="ex">
	<div class="back">
<table>
<br><br>
    <tr>
	<td> <label for="name">Tutor's Name :</label></td>
	<td>
		<select name = "Tname">
			<option>---SELECT---</option>
		<?php
			for($b=0;$b<$no1;$b++)
			{
				echo "<option value=$tutorPolyId[$b]>$tutorName[$b]</option>";
			}
		?>
		</select>
	</td>
	</tr>
    
</table>
<br>
<button type="submit" name="unblock"><img src="../images/unblock.png"  width="102" height="28" border="none"/></a></button>
<div class = "mesg"> <?php  echo "$A" ; ?> </div>
<div class = "mesg2"> <?php  echo "$B" ; ?> </div>
<button type="submit" name="block"><img src="../images/block.png"  width="102" height="28" border="none"/></a></button>
<div class = "mesg"> <?php  echo "$A" ; ?> </div>

        
    </div>
</form>
</center>
</center>
</div>
</body>
</html>