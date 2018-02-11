<!-- This page gives you page to make selection to drop a scheduled session -->

<?php
include 'LoginCheck.php';
include '../Rules/datepicker.php';
include '../Rules/days.php';
?>
<?php
include '../Rules/dbconfig.php';
include '../Rules/datepicker.php';
?>


<html>
    <head>
        <title>Session Drop</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/studentblock.css" />
	<link rel="stylesheet" href="../css/datepicker.css"/>
</head>
<body>

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
<script type = "text/javascript">
function validateForm()
{
var s = document.forms["myForm"]["Sname"].value;
if (s==null || s=="---SELECT---")
  {
  alert("Please Select a Student");
  return false;
  }
var t=document.forms["myForm"]["Tname"].value;
if (t==null || t=="---SELECT---")
  {
  alert("Please Select a Tutor");
  return false;
  }
var sub = document.forms["myForm"]["Esub"].value;
if (sub==null || sub=="---SELECT---")
  {
  alert("Please Select a Subject");
  return false;
  }
var stime = document.forms["myForm"]["SessionTime"].value;
if (stime==null || stime=="---SELECT---")
  {
  alert("Please Select a Session Time");
  return false;
  }
var fdate = document.forms["myForm"]["fromdate"].value;
if (fdate==null || fdate=="---SELECT---" || fdate =="")
  {
  alert("Please Select the Session Start Date");
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
	<div id="text2"><p>&nbsp &nbsp &nbsp Drop A Session</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div> 
	
<?php
	$studentdetails1 = mysql_query(" SELECT `Student_First_Name`, `Student_Last_Name`, `Student_Poly_Id` FROM Student ORDER BY Student_Last_Name");
	while($studentdetails2 = mysql_fetch_array($studentdetails1) ){
		$studentFirstName[] = $studentdetails2[Student_First_Name];
		$studentLastName[] = $studentdetails2[Student_Last_Name];
		$studentPolyId[]       = $studentdetails2[Student_Poly_Id];			
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
if(isset($_POST["drop"]))
{
    $Sname = $_POST["Sname"];
    $Tname = $_POST["Tname"];
    $Esub = $_POST["Esub"];
    $SessionTime = $_POST["SessionTime"];
    $fromconvo1 = $_POST["fromdate"];
    $fromconvo2 = strtotime($fromconvo1);
    $SessionFrom = date('Y-m-d',$fromconvo2);
    if($Sname == "---SELECT---"){
		$err = "Please Select A Student";
    }elseif($Tname == "---SELECT---"){
		$err = "Please Select A Tutor";
    }elseif($Esub == "---SELECT---"){   
		$err = "Please Select A Subject";
    }elseif($SessionTime == "---SELECT---"){
		$err = "Please Select A Session Time";
    }elseif($fromconvo1 == ""){
		$err = "Please Select The Session Start Date";
    }else{
        $checksession1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$Sname' AND `Tutor_Poly_Id` = '$Tname' AND `Session_Time` = '$SessionTime' AND `Date` = '$SessionFrom' ");
        while($checksession2 = mysql_fetch_array($checksession1)){
            $checksession[] = $checksession2[Assignment_Id];
            $allocateid[] = $checksession2[Allocate_Id];
        }
        $checkstudentsession1 = mysql_query("SELECT DISTINCT Allocate_Id FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$Sname' ");
        while($checkstudentsession2 = mysql_fetch_array($checkstudentsession1)){
            $checkstudentsession[] = $checkstudentsession2[Allocate_Id];
        }
        
        $checktutorsession1 = mysql_query("SELECT DISTINCT Allocate_Id FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id` = '$Tname' ");
        while($checktutorsession2 = mysql_fetch_array($checktutorsession1)){
            $checktutorsession[] = $checktutorsession2[Allocate_Id];
        }
        
        $count = count($checksession);
        $count2 = count($checkstudentsession);
        $count3 = count($checktutorsession);
        if($count == 0){
            $err = "The Session you entered does not exist";
        }elseif($count2 == 1){
				//Added by : Parul, Task: Header was not redirecting here, so changed to 'document.location' Dated: 12/03/2015
			echo "<script type='text/javascript'> document.location = 'SessionDropConfirm.php?var1=$SessionFrom&var2=$allocateid[0]&var3=$count3&var4=$count2&var5=$Sname&var6=$Tname&var7=$SessionTime&var8=$Esub';</script>";
			//$url1 = "SessionDropConfirm.php";
            //header("Location:$url1?var1=$SessionFrom&var2=$allocateid[0]&var3=$count3&var4=$count2&var5=$Sname&var6=$Tname&var7=$SessionTime&var8=$Esub");
        }elseif($count3==1){
			echo "<script type='text/javascript'> document.location = 'SessionDropConfirm.php?var1=$SessionFrom&var2=$allocateid[0]&var3=$count3&var4=$count2&var5=$Sname&var6=$Tname&var7=$SessionTime&var8=$Esub';</script>";
			//$A = "SessionDropConfirm2";
            //$url1 = "SessionDropConfirm.php";
            //header("Location:$url1?var1=$SessionFrom&var2=$allocateid[0]&var3=$count3&var4=$count2&var5=$Sname&var6=$Tname&var7=$SessionTime&var8=$Esub");
        }else
        {
			//Added By: Parul Joshi Dated: 09/15/2015 Task: When a session was dropped, those sessions were not deleted from Student_Tutor_Allocation_Main 
			//table due to which allocating new sessions created problem.So, I deleted the sessions which did not occur and updated the session end date
			 $editDate1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$Sname' AND `Tutor_Poly_Id` = '$Tname' AND `Session_Time` = '$SessionTime' AND `Date`> CURDATE() AND `Date` < '$SessionFrom' ORDER BY `Date` Desc ");
			while($editDate2 = mysql_fetch_array($editDate1)){
            $edit[] = $editDate2[Assignment_Id];
            $PreviousSession[] = $editDate2[Date];
			}
			$countNew= count($edit);
			if($countNew==0){
				$drop1 = mysql_query("DELETE FROM Student_Tutor_Allocation_Main WHERE `Allocate_Id`='$allocateid[0]'");
				$drop2 = mysql_query("DELETE FROM Student_Tutor_Assignment WHERE `Allocate_Id`='$allocateid[0]' AND `Date` >= '$SessionFrom '");
			}else{
				$drop1 = mysql_query("UPDATE Student_Tutor_Allocation_Main SET 'Session_End_Date'='$PreviousSession[0]' WHERE `Allocate_Id`='$allocateid[0]'");
				$drop2 = mysql_query("DELETE FROM Student_Tutor_Assignment WHERE `Allocate_Id`='$allocateid[0]' AND `Date` >= '$SessionFrom '");
			}
            if($drop1&&$drop2)
            {
				//Added By: Parul Joshi Dated: 09/03/2015 Task: To send email when a session is dropped
				$studentemail1 = mysql_query("SELECT Student_Email FROM Student WHERE Student_Poly_Id = '$Sname'");
				$studentemail2 = mysql_fetch_array($studentemail1);
				$studentemail = $studentemail2[0];
				$c_studentn1 = mysql_query("SELECT Student_First_Name , Student_Last_Name FROM Student WHERE Student_Poly_Id = '$Sname' ");
				$c_studentn2 = mysql_fetch_array($c_studentn1);
				$c_studentfirstn = $c_studentn2[Student_First_Name];
				$c_studentlastn = $c_studentn2[Student_Last_Name];
				$c_studentname = $c_studentfirstn." ".$c_studentlastn;
				//Shyam Joshi Code Change Begin. Fetch Tutor Email Id to send email to tutors also. Added Tutor_Email
				 $c_tutorn1 = mysql_query("SELECT Tutor_First_Name , Tutor_Last_Name , Tutor_Email FROM Tutor WHERE Tutor_Poly_Id = '$Tname' ");
				//Shyam Joshi Code Change End. Fetch Tutor Email Id to send email to tutors also. Added Tutor_Email
				 $c_tutorn2 = mysql_fetch_array($c_tutorn1);
				 $c_tutorfirstn = $c_tutorn2[Tutor_First_Name];                       
				 $c_tutorlastn = $c_tutorn2[Tutor_Last_Name];
				 //Shyam Joshi Code Change Begin. Fetch Tutor Email Id to send email to tutors also
				 $c_tutoremail = $c_tutorn2[Tutor_Email];
				 //Shyam Joshi Code Change End. Fetch Tutor Email Id to send email to tutors also
				 $c_tutorname = $c_tutorfirstn." ".$c_tutorlastn;
				 $subjectName= mysql_query("SELECT `Subject` FROM Subject WHERE `Subject_Id`= $Esub");
				$subjectName1 = mysql_fetch_array($subjectName);
				$subjectName2 =$subjectName1[Subject];
				$getMailSubject = mysql_query("SELECT `DropSession` FROM `Email_Content` WHERE `Type`='Subject'");
				$mailSubject1 = mysql_fetch_array($getMailSubject);
				$mailSubject = $mailSubject1[DropSession];
				$getMailContent = mysql_query("SELECT `DropSession` FROM `Email_Content` WHERE `Type`='Content'");
				$mailContent1 = mysql_fetch_array($getMailContent);
				$mailContent=$mailContent1[DropSession];
				$time =date("Y-m-d H:i:s");
				//Shyam Joshi Code Change Begin. Fetch Tutor Email Id to send email to tutors also. Added tutor email id
				$to1 = $c_tutoremail.",".$studentemail.","."fitltech@nyu.edu".","."jb3372@nyu.edu".","."trionyupoly@gmail.com".","."pb494@nyu.edu".","."srl446@nyu.edu";
				//Shyam Joshi Code Change End. Fetch Tutor Email Id to send email to tutors also. Added tutor email id
				$headers[] = "From: TRIO Program <trionyupoly@gmail.com>\r\n";
				$subject1 = $mailSubject;
				//Edited By:Parul Joshi Dated:09/23/2015 Task: to add new drop session message with details
				$message1="	
				Tutor Name: $c_tutorname
				Student Name: $c_studentname
				Course: $subjectName2
				Day and Time of Session: $SessionFrom at $SessionTime
";
				$message1.= $mailContent;
				$message1.="
Sent on : ";			
				$message1.=$time;
				mail($to1, $subject1, $message1, implode("\r\n", $headers)); 
				$A = "Session Dropped";
            }
            else
            {
                $A = "Session Not Dropped";
            }
            }
        
        }
    
}


?>
	<br><br><br>
<center>
 <!--   <br><br><br> -->
<div class="ex">
<div class="back">
<form name = "myForm" action = "<?php $PHP_SELF; ?>" onsubmit="return validateForm()" method = "post">
<table>
<br><br>
	<tr>
	<td><label for="name">Student Name :</label></td>
	<td>
		<select name = "Sname">
			<option>---SELECT---</option>
		<?php
			for($j=0;$j<$no; $j++)
			{
				
				echo "<option value=$studentPolyId[$j]>$studentName[$j]</option>";
			}
		?>
		</select>
	</td>
	</tr>
	 <tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
        <tr>
	<td><label for="name">Tutor Name  : </label></td>
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
	 <tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
	<tr>
	</tr>
        <tr>
            <td><label for="name">Subject :</label> </td>
	<td>
		<?php
			$allocate_subjects1 = mysql_query("SELECT `Subject_Id`, `Subject` FROM Subject ORDER BY Subject");
			while ($allocate_subjects2 = mysql_fetch_array($allocate_subjects1))
			{
				$allocate_subjects[] = $allocate_subjects2[Subject];
				$allocate_subjectid[] = $allocate_subjects2[Subject_Id];
			}
	
			$subjectcount = count($allocate_subjectid);

			echo "<select name='Esub' > ";
			echo "<option>---SELECT---</option>";
			for ($i=0; $i<$subjectcount; $i++)
			{
				
				echo "<option value = $allocate_subjectid[$i]>$allocate_subjects[$i]</option>";
			}
			echo "</select>";
	
		?>
	</td>
	</tr>
	 <tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
	<tr>
	</tr>
        <tr>
	<td><label for="name">Session Time : </label></td>
	<td>
		<select name="SessionTime">
			
			<option>---SELECT---</option>
			<option value = "09:00:00">09:00 AM</option>
                        <option value = "09:30:00">09:30 AM</option>
			<option value = "10:00:00">10:00 AM</option>
                        <option value = "10:30:00">10:30 AM</option>
			<option value = "11:00:00">11:00 AM</option>
                        <option value = "11:30:00">11:30 AM</option>
			<option value = "12:00:00">12:00 PM</option>
                        <option value = "12:30:00">12:30 PM</option>
			<option value = "13:00:00">1:00 PM</option>
                        <option value = "13:30:00">1:30 PM</option>
			<option value = "14:00:00">2:00 PM</option>
                        <option value = "14:30:00">2:30 PM</option>
			<option value = "15:00:00">3:00 PM</option>
                        <option value = "15:30:00">3:30 PM</option>
			<option value = "16:00:00">4:00 PM</option>
                        <option value = "16:30:00">4:30 PM</option>
			<option value = "17:00:00">5:00 PM</option>
                        <option value = "17:30:00">5:30 PM</option>
			<option value = "18:00:00">6:00 PM</option>
                        <option value = "18:30:00">6:30 PM</option>
                        <option value = "19:00:00">7:00 PM</option>
		</select>
	</td>	
	</tr>
	 <tr><td></tr></td> <tr><td></tr></td>  <tr><td></tr></td> <tr><td></tr></td>  
	<tr>
	
        
        <td><label for="name">From Date :</label></td>
		
        <td> <input type="text" id="datepicker" name="fromdate" ></td>
        <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> <tr><td></tr></td> 
    </tr>
	
	 
</table>
<!-- <input type = "Submit" name="drop" value="Drop"> -->
<br>
<button type="submit" name="drop"><img src="../images/drop.png"  width="102" height="28" border="none"/></a></button>

<div class = "mesg"><?php echo "$err"; ?></div>
<div class = "mesg2"><?php echo "$A"; ?></div>

</div>
</form>
</div>
 </center>   

</div>
</body>
</html>