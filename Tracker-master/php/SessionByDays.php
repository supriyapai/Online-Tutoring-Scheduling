<!-- This page gives the UI to make selections to generate reports based on time period -->

<?php
include 'LoginCheck.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';
?>
<?php
	//Establishing a connection with the host
    include '../Rules/dbconfig.php';            
?>

<html>
<head>
    <title>Report - Time Period</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/sessionbydays.css" />
	<link rel="stylesheet" href="../css/datepicker.css"/>
	<script src="jquery 1.9.1.js"></script>
	<script src="jQuery UI.js"></script>	
	<script>
    $(function() {  
      $("#datepicker, #datepicker2").datepicker({
        onSelect: function(dateText, inst) { 
          $(this).prev()[0].value = dateText;
        }
      });
  });
  </script>
  <script>
function myFunction(title){
	document.getElementById("demo").innerHTML=title;
}
</script>
</head>
<body>
<!-- This javascript populates the list of student or tutors based on selection and it calls searchTutor.php -->   
<script type="text/javascript">
var tutor = false;
var student = false;
function showUser(str){
	if(str=='T'){
		tutor = true;
	}
	if(str=='S'){
		student = true;
	}
	if (str==""){
		document.getElementById("txtHint").innerHTML="";
		return;
	}
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){           
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;        
		}
	  }
	xmlhttp.open("GET","searchTutor.php?q="+str,true);
	xmlhttp.send();
}
function validateForm(){
	var x=document.forms["myForm"]["fromdate"].value;
	if (x==null || x==""){
	alert("Select From Date");
	return false;
}
	var y=document.forms["myForm"]["todate"].value;
	if (y==null || y==""){
		alert("Select To Date");
		return false;
	}
	var z=document.forms["myForm"]["Tname"].value;
	if(tutor){
		if (z==null || z=="---SELECT---"){
			alert("Select Tutor Name");
			return false;
		}
	}
	var p=document.forms["myForm"]["Sname"].value;
	if(student){
	if (p==null || p=="---SELECT---"){
		alert("Select Student Name");
		return false;
	}
}
}

</script>
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
	<div id="text2"><p>Attendance Report</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<form name = "myForm" action = "ReportCardTimePeriod.php" onsubmit="return validateForm()" method = "post">
	<?php
		$studentdetails1 = mysql_query(" SELECT `Student_First_Name`, `Student_Last_Name`, `Student_Poly_Id` FROM Student ORDER BY Student_Last_Name");
		while($studentdetails2 = mysql_fetch_array($studentdetails1) ){
				$studentFirstName[] = $studentdetails2[Student_First_Name];
				$studentLastName[] = $studentdetails2[Student_Last_Name];
				$studentPolyId[] = $studentdetails2[Student_Poly_Id];                   
		}
		$no = count($studentPolyId);
		
		for($i=0; $i<$no;$i++){
				$studentName[] = $studentLastName[$i]." ".$studentFirstName[$i];
		}
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
	if(isset($_POST["go"])){              
		$sname = $_POST["Sname"];
		echo $sname;
}
 ?>
	<br><br><br>
	<center>
	<div class="ex">
	<div class = "back">
	<table>
	<br><br>
	<tr>
		<td> <label for="name">From :</label></td>
		<td> <input type="text" id="datepicker" name="fromdate" ></td>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
	</tr>
	<tr>
		<td> <label for="name">To:</label></td>
		<td> <input type="text" id="datepicker2" name="todate" ></td>
		<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
	</tr>
	<tr>
			<td><label for="name">Select Group:</label></td>
			<td><input type ="button" value="Tutor"  onClick="showUser('T'); myFunction('Tutor Name:');"></input>
			<input type ="button" value="Student" onClick="showUser('S'); myFunction('Student Name:');"></input></td>
			<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
	</tr>
	<tr>
	<td>
	<label id="demo"></label></td>
				<td><div id ="txtHint"></div></td>
	</tr>
	<tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
	</tr>
	<tr>
        <td><label for="name">Sort :</label></td>
        <td>
        <select name="sort" >
                <option value="Date">Date</option>
                <option value="Session_Time">Session Time</option>
            </select>
        </td>
        <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td>
	</tr>
</table>
    <br>
        <button type="submit" name="go" ><img src="../images/generate.png"  width="102" height="28" border="none"/></a></button>
    </div>
</div>
</center>
</div>    
</body>
</html>