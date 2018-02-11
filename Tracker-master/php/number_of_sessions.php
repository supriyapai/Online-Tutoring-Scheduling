<!-- This page gives you the UI where you can make selections to generate reports by subject -->
<?php
include 'LoginCheck.php';

?>
<?php
	//Establishing a connection with the host
		include '../Rules/dbconfig.php';
 
?>
<html>
<head>
    <title>Report - Subject</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/number_of_sessions.css" />
<link rel="stylesheet" href="../css/datepicker.css"/>
<script src="../js/jQuery 1.9.1.js"></script>
<script src="../js/jQuery UI.js"></script>
  <script>   
 $(function($) {
    $( "#datepicker" ).datepicker();

  });
 </script>

<script type="text/javascript" src="../js/jquery_sort/jquery.tablesorter.js"></script> 
 <script type="text/javascript">

$(document).ready(function($) 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
    
</script>
<script type="text/javascript">
function validateForm(){
	var x=document.forms["form_filter"]["from_date"].value;
	//if (x==null || x==""){
	//alert("Select From Date");
	//return false;
	//}
	var y=document.forms["form_filter"]["from_time"].value;
	var z=document.forms["form_filter"]["to_time"].value;
if(x=="" && y=="blank" && z=="blank"){
	alert("Please select the Date");
	return false;
}	
if(y!="blank" && x==""){
	alert("Please enter the date");
	return false;
}
if(z!="blank" && x==""){
	alert("Please enter the date");
	return false;
}
if(z!="blank" && y=="blank"){
	alert("Please enter the from time in time range");
	return false;
}
if(z < y ){
	alert("Endtime is before the start time. Please select end time after start time");
	return false;
}
}
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
</script>
</head>
<?php
$show_table = 0;
$query_selected = -1;

$local_array2 = array();
date_default_timezone_set('America/New_York');
if(isset($_POST["generate"]))
{
$show_table = 1;	
$date = date("Y-m-d",strtotime($_POST["from_date"]));
$file_app_from_date = date("mdY",strtotime($_POST["from_date"]));
if($_POST["from_time"] != 'blank'){
$from_time = date('H:i:s',strtotime($_POST["from_time"]));
}
else
	$from_time = $_POST["from_time"];
if($_POST["to_time"] != 'blank'){
$to_time = date('H:i:s',strtotime($_POST["to_time"]));
}
else
	$to_time = $_POST["to_time"];

$to_time = strtotime("+30 minutes", strtotime($to_time));

if($_POST["to_time"] != 'blank'){
$to_time = date('H:i:s',$to_time);
}

//$to_time  = new DateTime('H:i:s', strtotime($to_time)); // create today 10 o'clock
//$to_time ->add(new DateInterval('PT30M'));              // add 30 minutes

if( (empty($date)) && ($_POST["from_time"] == "blank") && ($_POST["to_time"] == "blank") ){
	
$A = "No filters selected";

}

if( (!(empty($date))) && ($_POST["from_time"] == "blank") && ($_POST["to_time"] == "blank") ){

	$query = "

		 SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
			count(Assignment_Id) as c1
			from 

		(    	SELECT *
				FROM Student_Tutor_Assignment
				where Date='$date' 
				group by Tutor_Poly_Id,Session_Time
		) assigned
		where Date = '$date'
		group by Session_time
		order by Session_Time 
		;
	";
	
	$query_active = "
	 SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
	count(Assignment_Id) as active_session 
		from 

		(    	SELECT *
				FROM Student_Tutor_Assignment
				where Date='$date' 
				and Student_Type <> 'C' and Tutor_Type <> 'C'  
				and Student_Type <> 'N/S' and Tutor_Type <> 'N/S'
				group by Tutor_Poly_Id,Session_Time
		) active
	where Date = '$date'
	group by Session_time
	order by Session_Time 
	";
	
$start    = new DateTime('09:00:00');
$end      = new DateTime('20:00:01'); // add 1 second because last one is not included in the loop
$interval = new DateInterval('PT30M');
$period   = new DatePeriod($start, $interval, $end);


$query_selected = 1;	
}
if( (!(empty($date))) && ($_POST["from_time"] != "blank") && ($_POST["to_time"] == "blank") ){
	
	
/* 	$query = "
	SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
	count(Assignment_Id) as c1
	FROM Student_Tutor_Assignment
	where Date='$date' and Session_Time between '$from_time' and '20:00:00'
	and Student_Type <> 'C' and Tutor_Type <> 'C' 
    group by Session_time
	order by Session_Time 
; */
$query = "
		 SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
			count(Assignment_Id) as c1
			from 

		(    	SELECT *
				FROM Student_Tutor_Assignment
				where Date='$date' and Session_Time between subtime('$from_time','00:30:00') and '20:00:00'
				group by Tutor_Poly_Id,Session_Time
		) assigned
		where Date='$date' and Session_Time between subtime('$from_time','00:30:00') and '20:00:00'
		group by Session_time
	    order by Session_Time 
		;
	";
	
	$query_active = "
	 SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
	count(Assignment_Id) as active_session 
		from 

		(    	SELECT *
				FROM Student_Tutor_Assignment
				where Date='$date' and Session_Time between subtime('$from_time','00:30:00') and '20:00:00'
				and Student_Type <> 'C' and Tutor_Type <> 'C'  
				and Student_Type <> 'N/S' and Tutor_Type <> 'N/S'
				group by Tutor_Poly_Id,Session_Time
		) active
	where Date='$date' and Session_Time between subtime('$from_time','00:30:00') and '20:00:00'
	group by Session_time
	order by Session_Time 
	";
	
$start    = new DateTime($from_time);
$end      = new DateTime('20:00:01'); // add 1 second because last one is not included in the loop
$interval = new DateInterval('PT30M');
$period   = new DatePeriod($start, $interval, $end);
	
$query_selected = 2;	
}
if( (!(empty($date))) && ($_POST["from_time"] != "blank") && ($_POST["to_time"] != "blank") ){
	//echo "test";
	
/* 	$query = "
	SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
	count(Assignment_Id) as c1
	FROM Student_Tutor_Assignment
	where Date='$date' and Session_Time between '$from_time' and '$to_time' 
	and Student_Type <> 'C' and Tutor_Type <> 'C' 
    group by Session_time
	order by Session_Time 
;
	"; */
	
	$query = "
		 SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
			count(Assignment_Id) as c1
			from 

		(    	SELECT *
				FROM Student_Tutor_Assignment
				where Date='$date' and Session_Time between subtime('$from_time','00:30:00') and '$to_time' 
				group by Tutor_Poly_Id,Session_Time
		) assigned
		where Date='$date' and Session_Time between subtime('$from_time','00:30:00')and '$to_time' 
		group by Session_time
	    order by Session_Time 
		;
	";
	
	$query_active = "
	 SELECT Session_time as 'start_time',addtime(Session_time , '01:00:00') as 'end_time',
	count(Assignment_Id) as active_session 
		from 

		(    	SELECT *
				FROM Student_Tutor_Assignment
				where Date='$date' and Session_Time between subtime('$from_time','00:30:00') and '$to_time' 
				and Student_Type <> 'C' and Tutor_Type <> 'C'  
				and Student_Type <> 'N/S' and Tutor_Type <> 'N/S'
				group by Tutor_Poly_Id,Session_Time
		) active
	where Date='$date' and Session_Time between subtime('$from_time','00:30:00') and '$to_time' 
	group by Session_time
	order by Session_Time 
	";
$start    = new DateTime($from_time);
$end      = new DateTime($to_time); // add 1 second because last one is not included in the loop
$add_1 = new DateInterval("PT1M");
$end->add($add_1);
$interval = new DateInterval('PT30M');
$period   = new DatePeriod($start, $interval, $end);

$query_selected = 3;		
}	


if($query_selected != -1){

$result = mysql_query($query);
if($result){
$array_query = array();
    while($result_data = mysql_fetch_assoc($result)){
	   $result_data["start_time"] = date('H:i',strtotime($result_data["start_time"]));		
	   $result_data["end_time"] = date('H:i',strtotime($result_data["end_time"]));
	   $array_query[$result_data["start_time"]] = array($result_data["end_time"],$result_data["c1"]);   
	}

$result_active = mysql_query($query_active);
if($result_active){
$array_query_active = array();
    while($result_data_active = mysql_fetch_assoc($result_active)){
	   $result_data_active["start_time"] = date('H:i',strtotime($result_data_active["start_time"]));		
	   $result_data_active["end_time"] = date('H:i',strtotime($result_data_active["end_time"]));
	   $array_query_active[$result_data_active["start_time"]] = array($result_data_active["end_time"],$result_data_active["active_session"]);   
	}
}
if(!(empty($array_query))){
$i=0;
foreach ($period as $dt) {
    $current = $dt->format("H:i");
 //local array contains assigned session,available session,active session in the same order
   $local_array2[$current] = array(0,11,0);
}

$previous_value = 0;
$previous_key= "09:00";
$previous_value_query = 0;
//print_r($local_array2);
foreach ($local_array2 as $key => $value){
	
	//echo "<br>$next_key</br>";
	
	
 	//	if(array_key_exists($key, $array_query)){
			$previous_key = date($key);
			$time = strtotime($key);
			$time = $time - (30 * 60);
			$previous_key = date("H:i", $time);
			
			$next_key = date($key);
			$time = strtotime($key);
			$time = $time + (30 * 60);
			$next_key = date("H:i", $time);
			
			if(array_key_exists($previous_key, $array_query)){	
			$no_of_session_previous = (int)$array_query[$previous_key][1];
			}else{
				$no_of_session_previous = 0;
			}
			if(array_key_exists($key, $array_query)){	
			$no_of_session_current = (int)$array_query[$key][1];
			}else{
				$no_of_session_current = 0;
			}
			if(array_key_exists($next_key, $array_query)){	
			$no_of_session_after = (int)$array_query[$next_key][1] ;
			}else{
				$no_of_session_after = 0;
			}
			
			$total_previous = $no_of_session_current + $no_of_session_previous;
			$total_after = $no_of_session_current + $no_of_session_after;
			
			
			$local_array2[$key][1] = $local_array2[$key][1] - ( max( $total_previous , $total_after )   );	
			//echo "<br>".$array_query[$key][1]." ".$a." ".$b. " " . $local_array2[$key][1]. " ". max( $total_after , $total_after );
			if(array_key_exists($key, $array_query_active)){					
				$local_array2[$key][2] = $array_query_active[$key][1];
			
				}
			if(array_key_exists($key, $array_query)){					
				$local_array2[$key][0] = $array_query[$key][1];
			
				}
		//	} 
	
/* 	if($key == "09:00"){
		
		if(array_key_exists($key, $array_query)){
			$local_array2[$key][0] = $array_query[$key][1];
	$local_array2[$key][1] = $local_array2[$key][1] - $local_array2[$key][0];
	if(array_key_exists($key, $array_query_active)){
			
	$local_array2[$key][2] = $array_query_active[$key][1];
	
		}
		}		
	} */

}
}
else{
	$A = "No Data found for the selected filter criteria";
	$show_table = 0;
		$query_selected = -1;
}
}
}
$filename='AvailableSpace_'.$file_app_from_date.'.csv'; 
$fp=fopen("../csv/" .$filename,"w");
$seperator="Time,Active sessions,Assigned sessions,Available spaces \n";
	foreach($local_array2 as $key => $value){		
		 $seperator.= date('g:i a', strtotime($key)).",".$value[2].",".$value[0].",".$value[1]."\n";	
	}
	fputs($fp,$seperator);
fclose($fp); 
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
	<div id="signout"><img src="../images/adminlogin.png" width="17" height="15" border="none" /></div>                
<center>	
	<div id="text2"><p>Report By Available Spaces</p>
	<?php
	if(isset($_POST["generate"])){
	?>
	<a href="../csv/<?php echo$filename;?>">Download Link</a>
	<?php } ?>
	</div> 
    
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<div class="filter">
	<form id="form_filter" name="form_filter" method="post" onsubmit="return validateForm()">
	<table>	
	<tr>
		<td> <label for="date">Date</label></td>
		<td> <label for="start_time">Start Time</label></td>
		<td> <label for="end_time">End Time</label></td>
    </tr>		
	<tr>
	    <td> <input type="text" id="datepicker" name="from_date" value="<?php 
		if(!(empty($_POST["from_date"]))){
			echo $_POST["from_date"];
		}
		else{
			echo date("m/d/Y");
		}
			?>" required></td>
		<td> <select name="from_time" onChange="showUser(this.value);">	
		<option value ="blank">---SELECT---</option>
			<option value = "09:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "09:00:00") echo 'selected = "selected"'?> >09:00 AM</option>
			<option value = "09:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "09:30:00") echo 'selected = "selected"'?> >09:30 AM</option>
			<option value = "10:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "10:00:00") echo 'selected = "selected"'?> >10:00 AM</option>
			<option value = "10:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "10:30:00") echo 'selected = "selected"'?> >10:30 AM</option>
			<option value = "11:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "11:00:00") echo 'selected = "selected"'?> >11:00 AM</option>
			<option value = "11:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "11:30:00") echo 'selected = "selected"'?> >11:30 AM</option>
			<option value = "12:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "12:00:00") echo 'selected = "selected"'?> >12:00 PM</option>
			<option value = "12:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "12:30:00") echo 'selected = "selected"'?> >12:30 PM</option>
			<option value = "13:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "13:00:00") echo 'selected = "selected"'?> >1:00 PM</option>
			<option value = "13:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "13:30:00") echo 'selected = "selected"'?> >1:30 PM</option>
			<option value = "14:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "14:00:00") echo 'selected = "selected"'?> >2:00 PM</option>
			<option value = "14:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "14:30:00") echo 'selected = "selected"'?> >2:30 PM</option>
			<option value = "15:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "15:00:00") echo 'selected = "selected"'?> >3:00 PM</option>
			<option value = "15:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "15:30:00") echo 'selected = "selected"'?> >3:30 PM</option>
			<option value = "16:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "16:00:00") echo 'selected = "selected"'?> >4:00 PM</option>
			<option value = "16:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "16:30:00") echo 'selected = "selected"'?> >4:30 PM</option>
			<option value = "17:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "17:00:00") echo 'selected = "selected"'?> >5:00 PM</option>
			<option value = "17:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "17:30:00") echo 'selected = "selected"'?> >5:30 PM</option>
			<option value = "18:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "18:00:00") echo 'selected = "selected"'?> >6:00 PM</option>
			<option value = "18:30:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "18:30:00") echo 'selected = "selected"'?> >6:30 PM</option>
			<option value = "19:00:00"
			<?php if(isset($_POST["from_time"]) && $_POST["from_time"] == "19:00:00") echo 'selected = "selected"'?> >7:00 PM</option>
	</select>
		</td>
			<td> <select name="to_time" onChange="showUser(this.value);">	
		<option value ="blank">---SELECT---</option>
			<option value = "09:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "09:00:00") echo 'selected = "selected"'?> >09:00 AM</option>
			<option value = "09:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "09:30:00") echo 'selected = "selected"'?> >09:30 AM</option>
			<option value = "10:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "10:00:00") echo 'selected = "selected"'?> >10:00 AM</option>
			<option value = "10:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "10:30:00") echo 'selected = "selected"'?> >10:30 AM</option>
			<option value = "11:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "11:00:00") echo 'selected = "selected"'?>>11:00 AM</option>
			<option value = "11:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "11:30:00") echo 'selected = "selected"'?>>11:30 AM</option>
			<option value = "12:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "12:00:00") echo 'selected = "selected"'?>>12:00 PM</option>
			<option value = "12:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "12:30:00") echo 'selected = "selected"'?>>12:30 PM</option>
			<option value = "13:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "13:00:00") echo 'selected = "selected"'?>>1:00 PM</option>
			<option value = "13:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "13:30:00") echo 'selected = "selected"'?>>1:30 PM</option>
			<option value = "14:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "14:00:00") echo 'selected = "selected"'?>>2:00 PM</option>
			<option value = "14:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "14:30:00") echo 'selected = "selected"'?>>2:30 PM</option>
			<option value = "15:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "15:00:00") echo 'selected = "selected"'?>>3:00 PM</option>
			<option value = "15:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "15:30:00") echo 'selected = "selected"'?>>3:30 PM</option>
			<option value = "16:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "16:00:00") echo 'selected = "selected"'?>>4:00 PM</option>
			<option value = "16:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "16:30:00") echo 'selected = "selected"'?>>4:30 PM</option>
			<option value = "17:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "17:00:00") echo 'selected = "selected"'?>>5:00 PM</option>
			<option value = "17:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "17:30:00") echo 'selected = "selected"'?>>5:30 PM</option>
			<option value = "18:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "18:00:00") echo 'selected = "selected"'?>>6:00 PM</option>
			<option value = "18:30:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "18:30:00") echo 'selected = "selected"'?>>6:30 PM</option>
			<option value = "19:00:00"
			<?php if(isset($_POST["to_time"]) && $_POST["to_time"] == "19:00:00") echo 'selected = "selected"'?>>7:00 PM</option>
	</select>
		</td>
		<td>
		<button type="submit" id = "generate" name="generate"><img src="../images/generate.png"  width="102" height="28" border="none"/></a></button>
		</td>
	
	</tr>
	<tr><td></td><td></td><td></td></tr>
	</table>
	</form>
	
	</div>
	
<?php 
if($show_table == 1)
{
 ?>
<center>	
<div id = "scroll" class = "scroll">
<table id="myTable" name = "myTable" class="tablesorter" border="1" bordercolor="#52981a" bgcolor="white" style="text-align:center" width = "550px"> 
<thead class = "mytableheader"> 
<tr bgcolor="e4e4e4"> 
    
    <th>Time</th> 
 <!--   <th>Active sessions</th> -->
 <!--   <th>Assigned sessions</th> -->
    <th>Available spaces</th> 
</tr> 
</thead> 
<tbody> 
<?php
if(!(empty($query)))
{
	if(!empty($local_array2)){
	foreach ($local_array2 as $key => $value){
		
?>
<tr> 
    
   	<td><?php echo date('g:i a', strtotime($key)) ?></td>
  <!--  <td><?php //echo $value[2];?></td> -->
  <!--  <td><?php //echo $value[0];?></td> -->
    <td><?php echo $value[1];?></td> 
    
</tr> 
	 
	 
	 
	 <?php } } ?>

</tbody> 
</table> 
</div>
</center>
<?php 

}
}	
?>
<div class = "mesg3"> <?php  if(isset($A))echo $A ;?> </div>
</div>
</div>
</center>
</body>
</html>