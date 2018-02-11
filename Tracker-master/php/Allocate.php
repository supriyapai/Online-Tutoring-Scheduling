<!-- This page allows you to allocate sesions for a student and tutor. -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	include 'LoginCheck.php'; ?>
<?php	
	//session_start(); // start up your PHP session! 
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
	include '../Rules/days.php';
	date_default_timezone_set('America/New_York');
	
?>

<html>   
<head>
	<title>Session Allocate</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/allocate.css" />
	<!-- datepicker Jquery function-->
	<link rel="stylesheet" href="../css/datepicker.css" />
	
	<!-- Two datepicker, another script function-->
	<script>
/* 	$(function() { 
	  $("#datepicker, #datepicker2").datepicker({
		onSelect: function(dateText, inst) { 
		  $(this).prev()[0].value = dateText;
		}
	});
});
	$(function() {
		$("#datepicker, #datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
	}); */
	</script>
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
    xmlhttp.open("GET", "searchCourse.php?q=" + str, true);
    xmlhttp.send();
}
function validateForm() {
	<!--Added By : Parul Task : to add alert if no session type is selected, Dated:10/29/2015-->
    var sType = document.forms["myForm"]["SessionType"].value;
    if (sType == null || sType == "---SELECT---") {
        alert("Please Select A Session Type");
        return false;
    }
	
    var sname = document.forms["myForm"]["Sname"].value;
    if (sname == null || sname == "---SELECT---") {
        alert("Please Select A Student");
        return false;
    }

    var tname = document.forms["myForm"]["Tname"].value;
    if (tname == null || tname == "---SELECT---") {
        alert("Please Select A Tutor");
        return false;
    }

    var stime = document.forms["myForm"]["SessionTime"].value;
    if (stime == null || stime == "---SELECT---") {
        alert("Please Select A Session Time");
        return false;
    }

    var sdate = document.forms["myForm"]["startdate"].value;
    if (sdate == null || sdate == "---SELECT---" || sdate == "") {
        alert("Please Select The Session Start Date");
        return false;
    }

    var edate = document.forms["myForm"]["enddate"].value;
    if (edate == null || edate == "---SELECT---" || edate == "") {
        alert("Please Select The Session End Date");
        return false;
    }
	//Added By :Parul Joshi Dated:08/28/2015 Task : to add a check on start and end date which cannot be less than the current date.
	if (sdate){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
				dd='0'+dd
		} 

		if(mm<10) {
				mm='0'+mm
		} 

		todayDate = mm+'/'+dd+'/'+yyyy;
		var currentDate = new Date(todayDate);
		var startDate = new Date(sdate);
		var endDate = new Date(edate);
	//Dated: 10/30/2015 Task: No past sessions can be added in Regular and Extra Session Type.
		if(sType == " " || sType == "E" ){
			if(startDate < currentDate){
				alert("Start Date cannot be less than Current Date!!");
				return false;
			}	
			if(endDate < currentDate){
				alert("End Date cannot be less than Current Date!!");
				return false;
			}
		}
		//Dated: 10/30/2015 Task: To add only past sessions in Add On Session Type.
		if(sType == "A"){
			if(startDate > currentDate){
				alert("Add-On is for past sessions. So, Start Date cannot be greater than Current Date!!");
				return false;
			}	
			if(endDate > currentDate){
					alert("Add-On is for past sessions.So, End Date cannot be greater than Current Date!!");
					return false;
			}
		}
		if (endDate < startDate){
				alert("End Date cannot be less than Start Date!!");
				return false;
		}	
	}
}
</script>

 <script>
 function closedialog() {  
    var dialog = document.getElementById('login_dialog');  
  
        dialog.close();  
   
 } 
  function addSession() {  
		window.location.replace("Allocate_login.php");
   
 } 

  </script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/inputallocation.css" />
</head>

<?php
$show_warning = false;
$studentdetails1 = mysql_query(" SELECT Student_First_Name, Student_Last_Name, Student_Poly_Id FROM Student ORDER BY Student_Last_Name");
while ($studentdetails2 = mysql_fetch_array($studentdetails1)) {
    $studentFirstName[] = $studentdetails2[Student_First_Name];
    $studentLastName[] = $studentdetails2[Student_Last_Name];
    $studentPolyId[] = $studentdetails2[Student_Poly_Id];
}

$no = count($studentPolyId);

for ($i = 0; $i < $no; $i++) {
    $studentName[] = $studentLastName[$i].
    " ".$studentFirstName[$i];

}

$tutorDetails1 = mysql_query(" SELECT `Tutor_First_Name`, `Tutor_Last_Name`, `Tutor_Poly_Id` FROM Tutor ORDER BY Tutor_Last_Name ");
while ($tutorDetails2 = mysql_fetch_array($tutorDetails1)) {
    $tutorFirstName[] = $tutorDetails2[Tutor_First_Name];
    $tutorLastName[] = $tutorDetails2[Tutor_Last_Name];
    $tutorPolyId[] = $tutorDetails2[Tutor_Poly_Id];
}
$no1 = count($tutorPolyId);

for ($a = 0; $a < $no1; $a++) {
    $tutorName[] = $tutorLastName[$a].
    " ".$tutorFirstName[$a];
}
?>  

<?php

if (isset($_POST["Submit"])) {
    
    $query = mysql_Query("DELETE FROM `Student_Tutor_Assignment` WHERE Date='0000-00-00'");
    $Sname = $_POST["Sname"];
    $SSname = $_POST["SSname"];
    $Tname = $_POST["Tname"];
    $Esub = $_POST["Esub"];
    $SessionTime = $_POST["SessionTime"];
	$SessionType = $_POST["SessionType"];
    $startconvo1 = $_POST["startdate"];
    $startconvo2 = strtotime($startconvo1);
    $SessionStart = date('Y-m-d', $startconvo2);
    $endconvo1 = $_POST["enddate"];
    $endconvo2 = strtotime($endconvo1);
    $SessionEnd = date('Y-m-d', $endconvo2);
    $subject = $_POST["Sub"];
	$dateToday =date("Y-m-d");

    $studentnames1 = mysql_query("SELECT `Student_First_Name`, `Student_Last_Name`, Student_Email FROM Student WHERE Student_Poly_Id = '$Sname' ");
    $studentnames2 = mysql_fetch_array($studentnames1);
    $studentnamesfn = $studentnames2[Student_First_Name];
    $studentnamesln = $studentnames2[Student_Last_Name];

    $tutornames1 = mysql_query("SELECT `Tutor_First_Name`, `Tutor_Last_Name`,`Tutor_Hours` , Tutor_Email FROM Tutor WHERE Tutor_Poly_Id = '$Tname' ");
    $tutornames2 = mysql_fetch_array($tutornames1);
    $tutornamesfn = $tutornames2[Tutor_First_Name];
    $tutornamesln = $tutornames2[Tutor_Last_Name];
    $tutorhours = $tutornames2[Tutor_Hours];


    $d = mysql_query("SELECT DAYOFWEEK('$SessionStart')");
    $d1 = mysql_fetch_array($d);
    $d2 = $d1[0];

    $diffweek = abs(strtotime($SessionStart) - strtotime($SessionEnd)) / 604800;
    $number = intval($diffweek);
	//echo $number;

    if ($Sname == "---SELECT---") {
        $A = "Please Select A Student";
    }
    elseif($Tname == "---SELECT---") {
        $A = "Please Select A Tutor";
    }

    elseif($SessionTime == "---SELECT---") {
        $A = "Please Select A Session Time";
    }
    elseif($SessionStart == "") {
        $A = "Please Select The Session Start Date";
    }
    elseif($SessionEnd == "") {
        $A = "Please Select The Session End Date";
    } else {

        //$checksession1 = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id` = '$Sname' AND `Tutor_Poly_Id`='$Tname' AND `Subject`='$subject' AND `Session_End_Date`>= '$SessionStart' AND(Time = '$SessionTime' AND Day = '$d2') ");
        $checksession1 = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$Sname' AND `Tutor_Poly_Id`='$Tname' AND `Subject_Id`= '$subject' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND `Session_Time` = '$SessionTime' AND `Day` = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C' ");
		$checksession2 = mysql_fetch_array($checksession1);
        $checksession = $checksession2[Allocate_Id];

        //$checksessionTutor = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Tname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
        $checksessionTutor = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$Tname' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND `Session_Time` = '$SessionTime' AND Day = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
		$checksessionTutorArr = mysql_fetch_array($checksessionTutor);
        $checksessionTutorFlag = $checksessionTutorArr[Allocate_Id];

        //$checksessionStudent = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id` = '$Sname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
        $checksessionStudent = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$Sname' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND `Session_Time` = '$SessionTime' AND Day = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
		$checksessionStudentArr = mysql_fetch_array($checksessionStudent);
        $checksessionStudentFlag = $checksessionStudentArr[Allocate_Id];

        //$checksessionTutorSt = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Tutor_Poly_Id`='$Sname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
        $checksessionTutorSt = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$Sname' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND Session_Time = '$SessionTime' AND Day = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
		$checksessionTutorStArr = mysql_fetch_array($checksessionTutorSt);
        $checksessionTutorStFlag = $checksessionTutorStArr[Allocate_Id];

        //$checksessionStudentTu = mysql_query("SELECT * FROM Student_Tutor_Allocation_Main WHERE `Student_Poly_Id` = '$Tname' AND `Session_End_Date`>= '$SessionStart' AND (Time = '$SessionTime' AND Day = '$d2')");
        $checksessionStudentTu = mysql_query("SELECT * FROM Student_Tutor_Assignment WHERE `Student_Poly_Id` = '$Tname' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND Session_Time = '$SessionTime' AND Day = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C' ");
		$checksessionStudentTuArr = mysql_fetch_array($checksessionStudentTu);
        $checksessionStudentTuFlag = $checksessionStudentTuArr[Allocate_Id];
		
		$flag = true;
		
        if ($checksession != 0) {
		    $A = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspThis Session Already Exists";
			$flag =false;
        }
        elseif($checksessionTutorFlag != 0) {
            //$A = "Another session exists for selected Tutor on the same day and time";
			
			//To add double session feature
			$doubleSession = mysql_query("SELECT COUNT(DISTINCT Student_Poly_Id) AS studentCount FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$Tname' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND `Session_Time` = '$SessionTime' AND Day = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
			$doubleSessionArr = mysql_fetch_array($doubleSession);
			$doubleSessionFlag = $doubleSessionArr[studentCount];
			//to check the count of students in this session
			if ($doubleSessionFlag>1){
				       $A = "Sorry, this session already has two students";
					   $flag =false;
			}else{
				$confirmSubject = mysql_query("SELECT Subject_Id FROM Student_Tutor_Assignment WHERE `Tutor_Poly_Id`='$Tname' AND `Date` BETWEEN '$SessionStart' AND '$SessionEnd' AND `Session_Time` = '$SessionTime' AND Day = '$d2' AND `Student_Type` !='C' AND `Tutor_Type`!='C'");
				$confirmSubjectArr = mysql_fetch_array($confirmSubject);
				$confirmSubjectFlag = $confirmSubjectArr[Subject_Id];
				if($subject != $confirmSubjectFlag){
					$A = "Tutor teaches another subject on the same day and time";				
					$flag =false;
				}else{
					echo "<script type='text/javascript'>
							var answer = confirm('Session entered by you will be a Double Session.Please confirm if you want this session');
							if (answer == false){	
								window.location('Allocate.php');
							}
							</script>";
					$flag = true;
				}
			}	
        }
        elseif($checksessionStudentFlag != 0) {
            $A = "Another session exists for selected Student on the same day and time";
			$flag =false;
        }
        elseif($checksessionTutorStFlag != 0) {
            $A = "Another session exists for selected Student as Tutor on the same day and time";
			$flag =false;
        }
        elseif($checksessionStudentTuFlag != 0) {
            $A = "Another session exists for selected Tutor as Student on the same day and time";
			$flag =false;
        }
/* Begin of Code Change : Shyam Rajendra Joshi September 21,2016
Code added to check the available space. 
If the total no of sessions on the selected time slot is more than or equal to 11.
*/		
		else{
				if($SessionType != 'A')
				{
					//check for the available space 
					//$previous_key = date($key);
					$time = strtotime($SessionTime);
					$time = $time - (30 * 60);
					$previous_key = date("H:i:s", $time);
					
					//$next_key = date($key);
					$time = strtotime($SessionTime);
					$time = $time + (30 * 60);
					$next_key = date("H:i:s", $time);

					$spacequery = "
					select  current_session,previous_session,next_session
					from (

					select count(*) as current_session
					from 
					( select * from Student_Tutor_Assignment
					 where  date between '$SessionStart' and '$SessionEnd' 
					 and day = $d2
					 and Session_Time = '$SessionTime'
					 group by Tutor_Poly_Id,Session_Time
					 )a
					
					)b,
					
					
					(
					select count(*) as previous_session
					from 
					( select * from Student_Tutor_Assignment
					 where  date between '$SessionStart' and '$SessionEnd' 
					 and day = $d2
					 and Session_Time = '$previous_key'
					 group by Tutor_Poly_Id,Session_Time
					 )a
					)c,
					
					
					(
					select count(*) as next_session
					from 
					( select * from Student_Tutor_Assignment
					 where  date between '$SessionStart' and '$SessionEnd' 
					 and day = $d2
					 and Session_Time = '$next_key'
					 group by Tutor_Poly_Id,Session_Time
					 )a
					 
					)d
					;
					
					";
					$availablespace = mysql_query($spacequery);	
					//print_r($availablespace);
					$result_data = mysql_fetch_assoc($availablespace);
					//print_r($result_data);
					if($result_data["current_session"]){
						$current_session = $result_data["current_session"];
					}else{
						$current_session = 0;
					}
					if($result_data["previous_session"]){
						$previous_session = $result_data["previous_session"];
					}else{
						$previous_session = 0;
					}
					if($result_data["next_session"]){
						$next_session = $result_data["next_session"];
					}else{
						$next_session = 0;
					}	
					$total_previous = $current_session + $previous_session;
					$total_after = $current_session + $next_session;
					$availablespacecount = 11;
					$max_count = max( $total_previous , $total_after ); 
					$availablespacecount = $availablespacecount - ( max( $total_previous , $total_after )   );
					//echo "<br>".$availablespacecount;            
					//echo "<br> max_count ".$max_count;  
					
					if($availablespacecount <= 0)
					{
						//new code
						//Override the Maximum Space Capacity Reached if the login user has semester refresh access
						//Fetch the access for the login user
						$login_user_id = $_SESSION['userid'];
						$accessquery = "SELECT * FROM Admin_LogIn where Username = '$login_user_id' and SemRefreshAccess = 1";
						$result_accessquery = mysql_query($accessquery);	
						if (mysql_num_rows($result_accessquery)==0) 
						{ 
							$A = "Maximum space capacity reached. Please select another time slot";
							$show_warning = true;
							$flag = false;
							
						}
						else
						{
							
							$access_detail = mysql_fetch_assoc($result_accessquery);
							$show_override_dialog = False;
							if($access_detail['SemRefreshAccess'] == 1)
							{
								$show_override_dialog = True;
								
								$flag = false;
							}
						}
						
						
						
						// new code
					
						
					?>				
					
					<?php
					}
				
			}
		}
/* End of Code Change : Shyam Rajendra Joshi September 21,2016
*/		
		if ($flag == true){
            $insert = mysql_query("INSERT INTO `Student_Tutor_Allocation_Main`(`Student_Poly_Id`, `Student_First_Name`, `Student_Last_Name`, `Tutor_Poly_Id`, `Tutor_First_Name`, `Tutor_Last_Name`,  `Subject`, `Time`, `Day`, `Session_Start_Date`, `Session_End_Date`) VALUES ('$Sname', '$studentnamesfn', '$studentnamesln', '$Tname', '$tutornamesfn', '$tutornamesln',  '$subject', '$SessionTime', '$d2', '$SessionStart', '$SessionEnd' )");

            $allocateid1 = mysql_query("SELECT Allocate_Id FROM Student_Tutor_Allocation_Main WHERE Student_Poly_Id = '$Sname' AND (Time = '$SessionTime' AND Day = '$d2') ");
            $allocateid2 = mysql_fetch_array($allocateid1);
            $allocateid = $allocateid2[0];

            if ($insert) {
                $query2 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$Sname'");
                $query3 = mysql_fetch_array($query2);
                $sub1 = $query3[Subject_1];
                $sub2 = $query3[Subject_2];
                $sub3 = $query3[Subject_3];
                $sub4 = $query3[Subject_4];
                $sub5 = $query3[Subject_5];
                $sub6 = $query3[Subject_6];
                if ($sub1 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_1 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub2 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_2 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub3 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_3 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub4 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_4 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub5 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_5 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub6 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_6 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                } else {
                    //$A = "The student is allocated to 6 subjects";
                    //break;
                }

                $r = get_days($SessionStart, $SessionEnd);
				$emailflag = false;
                for ($i = 0; $i <= $number + 1; $i++) {
                    $newday1 = mysql_query("SELECT DAYOFWEEK('$r[$i]')");
                    $newday2 = mysql_fetch_array($newday1);
                    $newday = $newday2[0];
                    $query = mysql_query("INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`,`Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`,`Session_Type`) VALUES	('$allocateid', '$Sname', '$Tname', '$subject', '$SessionTime', '$r[$i]', '$newday','$SessionType') ");
   
                if ($query) {
					$emailflag = true;
                    $B = "Session Allocated and Assigned. Please enter another or exit";

                } else {
					$A = "Session Allocated But Not Assigned. Please enter another or exit";
                }
				}
				/* Begin of Code Change : Shyam Rajendra Joshi September 20,2016
Code added to send a mail when allocation is done.
*/
                    if($emailflag == true){
						$subjectquery = mysql_query("select Subject from Subject where Subject_Id = $subject");
						$subjectname = mysql_fetch_array($subjectquery);
						$mailtimestamp = date("F j, Y, g:i a");
                        
						$to = $tutornames2[Tutor_Email].",".$studentnames2[Student_Email].",".'fitltech@nyu.edu,jb3372@nyu.edu,trionyupoly@gmail.com,pb494@nyu.edu,srl446@nyu.edu';
						
						$subjectEmail = 'TRIO​ Scholars​ Tutoring ​Schedule​ for '. $subjectname[Subject];
						$sessionbegindate = date('l,F j, Y', $startconvo2);
						$sessionenddate = date('l,F j, Y', $endconvo2);
						
						$sessionemailtime = date('g:i a', strtotime($SessionTime));
						$message = "Below please find your tutoring schedule for ". $subjectname[Subject]." \r\n Tutor : $tutornames2[Tutor_First_Name]  $tutornames2[Tutor_Last_Name] \r\n Student : $studentnames2[Student_First_Name] $studentnames2[Student_Last_Name] \r\n Subject : $subjectname[Subject] \r\n Time  : $sessionemailtime \r\n Start Date : $sessionbegindate \r\n End Date : $sessionenddate \r\nAll tutoring sessions will take place in the TRIO Scholars Office (LC253).  If you have any questions about your tutoring schedule, please contact the TRIO Scholars Office at 646-997-3560.\r\n​Thank you,\r\nTRIO Scholars Program\r\n​[$mailtimestamp]\r\n";
						$headers = 'From: TRIO Program <trionyupoly@gmail.com>' . "\r\n";					
						mail($to, $subjectEmail, $message, $headers, '-f trionyupoly@gmail.com');
					}
/* End of Code Change : Shyam Rajendra Joshi September 20,2016
*/
            } else {
                $A = "Session not Allocated";
            }
        }
    }

}

if (isset($_POST["back"])) {
    $url = "Selectfunction.php";
    header("Location:$url");
}
?>


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
	<div id="line"></div>
	<div id="signout"><img src="../images/adminlogin.png" width="17" height="15" border="none" /></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<div id="text2"><p>Input Student-Tutor Allocation</p></div>
	<div id="mainbody"></div>
	<div id="save"></div>
	<div id="inputboxbackground"></div>
	<form id = "myForm" name = "myForm" action = "Allocate.php" onsubmit="return validateForm()" method = "post">
		<br>
		<label for="name">Session Type :</label>
		<!--Added By : Parul Task : to add Addon and Flexible options, Dated:10/29/2015-->
		<select name = "SessionType">
			<option>---SELECT---</option>
			<option value= " ">Regular</option>
			<option value= "E">Extra</option>
			<option value = "F">Flexible</option>
			<option value = "A">Add-On</option>
		</select>
		<br>
		<label for="name">Student Name :</label>
		<select name = "Sname">
			<option>---SELECT---</option>
			<?php
				for($j=0;$j<$no; $j++){	
				echo "<option value=$studentPolyId[$j]>$studentName[$j]</option>";
				}
			?>
		</select>
		</br>	
		<label for="name">Tutor Name :</label>
		<select name = "Tname" onChange="showUser(this.value)">
		<option>---SELECT---</option>
		<?php
		for($b=0;$b<$no1;$b++){
			echo "<option value=$tutorPolyId[$b]>$tutorName[$b]</option>";
		}
	?>
		</select>
		</br>
		<table border="0" style="width:100%">
			<tr>
				<td>Subject:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>		
				<td><div id ="txtHint"></div></td>
			</tr>
		</table>	
		<label for="name">Session Time :</label>
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
		</br>                
		<!-- change class to ID, use the Jquery , Two datepicker(one is datepicker, the other is datepicker2--> 
		<label for="name">Session Start Date :</label>
		<input type="text" placeholder="Start date" id="datepicker" name="startdate">
		</br>		  
		<label for="name">Session End Date :</label>
		<input type="text" id="datepicker2" name="enddate" placeholder ="End Date">
		</br>
		</br>
		<center> <button type="submit" name="Submit"><img src="../images/save.png"  width="102" height="28" border="none"/></a></button></center>
		  <div class = "mesg1"><span width='100px' id="mesg1_span"><center><?php  echo "$A";?></center></span></div>
		  <div class = "mesg2">  <?php  echo "$B" ;?> </div>
		</br>
	</form>
	
	


<?php

if($show_override_dialog)
{
	?>


 <script type='text/javascript'>
 

	if (confirm("Sorry, no cubicles are available at that time.\nClick Cancel to select another time, or click OK to Continue Allocation.") == true) {
			
	
			var data = {
				Student_Poly_Id : "<?php echo (string)$Sname;?>",
						 Student_First_Name : "<?php echo (string)$studentnamesfn;?>",
						 Student_Last_Name : "<?php echo (string)$studentnamesln;?>",
						 Tutor_Poly_Id : "<?php echo (string)$Tname;?>",
						 Tutor_First_Name : "<?php echo (string)$tutornamesfn;?>",
						 Tutor_Last_Name : "<?php echo (string)$tutornamesln;?>",
						 Subject : "<?php echo (string)$subject;?>",
						 Time : "<?php echo (string)$SessionTime;?>",
						 Day : "<?php echo (string)$d2;?>",
						 Session_Start_Date : "<?php echo (string)$SessionStart;?>",
						 Session_End_Date : "<?php echo (string)$SessionEnd;?>",	
						 SessionType : "<?php echo (string)$SessionType;?>",
						 override : true
			}
	
			
			
			$.ajax({
				  type: 'POST',
				  url: "allocation_override.php",
				  data: data,
				  success: function(data, status){
						
						document.getElementById("mesg1_span").textContent="Session Allocated and Assigned. Please enter another or exit";
					    document.getElementById("mesg1_span").style.color = "#0000FF";
					
					},
				  
				  async:false
				});
		}
		else{
			document.getElementById("mesg1_span").textContent="Session Allocation has been cancelled. Please enter another or exit";
		} 
 
</script>
<?php

}
?>

</body>
</html>
