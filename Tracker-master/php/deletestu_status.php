﻿<?php
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
?>

<!DOCTYPE HTML>

<html>
<head>
    <title>Delete Students by class status</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/inputallocation.css" />
	<script type="text/javascript">
	
function validateForm(){
	var x=document.forms["myForm"]["poly_id"].value;
	if (x=="" || x==0)
	  {
	  alert("Please Select Student Status");
	  return false;
	  }
	  else{
		warning();
	  }
	}
function delete_person()
	{
	if($('#poly_id').val() === '---SELECT---'){ 
		console.log("Please select a category.");
		return false;
	}else{
		var studentID=$('#poly_id').val();
		//call php delete file
		console.log(studentID);
		$.ajax({
			type: 'post',
			url: '../php/delete_status.php',
			data: 'studentID='+studentID,
			cache: false,
			success: function(response){
				console.log(response);
			},
			error: function() {
				console.log('error');
			}
		});
	}
}
function warning(){
	var choice=confirm("You are about to DELETE Students from the database.  Do you want to continue?");
if (choice===true){
	delete_person();
	//alert("Students Deleted");
	document.getElementById("confirm").innerHTML="<center>Student(s) Deleted</center>";
}
else{
	 console.log("Try Again");
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
                     <li><a href="CreateT.php" >Tutor Information</a></li>
                     <li><a href="CreateS.php" >Student Information</a></li>
                     <li><a href="Allocate.php" >Student-Tutor Allocation</a></li>
                     <li><a href="Course.php" >Course Information</a></li>
                 </ul>
             </li>

             <li><a class="hide" href="">EDIT</a>
                 <ul>
                     <li><a href="EditTutor.php" >Tutor Information</a></li>
                     <li><a href="EditStudent.php" >Student Information</a></li>
                     <li><a class="EditSession.php" >Student-Tutor Allocation ></a>
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
                     <li><a href="EditCourse.php" >Course Information</a></li>
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
                     <li><a href="StudentBlock.php" >Student Block/Unblock</a></li>
                     <li><a href="TutorBlock.php" >Tutor Block/Unblock</a></li>
                     <li><a href="SessionDrop.php" >Drop Session</a></li>
                 </ul>
             </li>

             <li><a class="hide" href="">DATA MANAGEMENT</a>
			     <ul>
                        <li><a href="#" >Save ></a>
                        <ul>
						      <li><a href="SaveStudent.php" >Student</a></li>
                              <li><a href="SaveTutor.php">Tutor</a></li>
						</ul>
						</li>
                        
                        <li><a href="#" >Bulk Changes > </a>
					    <ul>
                     	      <li><a href="bulkstudent.php" >Student</a></li>
                              <li><a href="bulktutor.php">Tutor</a></li>
                         </ul>
					    </li>
                      
					    <li><a href="refresh.php" >New Semester Refresh</a></li>
                     <li><a href="#" >Delete ></a>
					 <ul>
					        <li><a href="DeleteS_Nav.php" >Student</a></li>
                            <li><a href="DeleteT_Nav.php">Tutor</a></li>
					 </ul>
					 </li>
                 </ul>
             </li>

             <li><a class="hide" href=" ">ACCOUNT MANAGEMENT</a>
                 <ul>
                     <li><a class="hide">Email ></a>
                         <ul>
                             <li><a href="EditEmail.php" >Change Email Address</a></li>
                             <li><a href="EditSubject.php">Change Email Subject</a></li>
                             <li><a href="EditContext.php">Change Email Content</a></li>
                         </ul>
                     </li>
                     <li><a href="AccountManagement.php" >Password</a></li>
                 </ul>
             </li>

            <li><a class="hide" href="livereport.php">LIVE REPORT</a></li>

           </ul>
        </div>

		<div id="banner">
        <img src="../images/banner2.png"  width="1022" height="150" border="none"/>
	    </div>
	    
	<div id="signout">
        <img src="../images/adminlogin.png"  width="17" height="15" border="none"/>
		</div>
	    
	     <div id="inputboxbackground">
	    </div>

	     <div id="text3">
		<a href="Adminlogon.php"><p>Sign Out</p></a>
		</div>
		
		<center>
		<div id="text2">
	<p>Delete Student Information</p>
	</div>
	
	<div id="confirm" style="z-index:800; position: relative;">
	</div>
	
<br><br>
<div id="dropdown" style="z-index:800; position: relative;">
<table>
<form name="myForm" action = "<?php $PHP_SELF; ?>" method = "post">
    <tr>
        <td>Class Status:</td> 
		  
		  <br>
	<td>
		<select name = "poly_id" id="poly_id">
			<option value="0">---SELECT---</option>
			<option value="Freshmen">Freshmen</option>
			<option value='Sophmore'>Sophmore</option>
			<option value="Junior">Junior</option>
			<option value="Senior">Senior</option>
			<option value="Graduate">Graduate</option>
			
		
		</select>
	</td>
    </tr>
        
        <tr></tr>
		
        <tr>
	<br><br>
            <td></td>
            
            
        </tr>
        <tr>
       
        </tr>
</form>
</table>


</div>

</center>
<div id="deletebut" style="z-index:800; position: relative;">
<center>
<button type="submit" name="delete" onclick="validateForm();" value="Delete"><img src="../images/delete.png"  width="102" height="28" border="none"/></button></center>
</div>

</body>
</html>