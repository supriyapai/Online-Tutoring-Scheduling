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
		

<link rel="stylesheet" type="text/css" href="../css/number_of_subject.css" />
<link rel="stylesheet" href="../css/datepicker.css"/>
<script src="../js/jQuery 1.9.1.js"></script>
<script src="../js/jQuery UI.js"></script> 
 <script type="text/javascript">
   $(function($){
    
	$( "#from_date" ).datepicker();
    $( "#to_date" ).datepicker();

  });
 </script>

 <script type="text/javascript" src="../js/jquery_sort/jquery.tablesorter.js"></script> 
<script type="text/javascript" src="../js/jquery_sort/addons/pager/jquery.tablesorter.pager.js"></script> 
 <script type="text/javascript">
jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();
$(document).ready(function() { 
    $("#myTable") 
    .tablesorter({sortList: [[0,0]]}) 
    .tablesorterPager({container: $("#pager"),size: 20}); 
});  

   
</script>
<script type="text/javascript">
function validateForm(){
	var today_date = new Date();

	
	var x=document.forms["form_filter"]["from_date"].value;
	var from_date = new Date(x);
	if (from_date > today_date){
		alert("Start date must be less than today's date");
		return false;
	} 
	if (x==null || x==""){
	alert("Select From Date");
	return false;
	}
	var y=document.forms["form_filter"]["to_date"].value;
	var end_date = new Date(y);
	if(from_date > end_date){
		alert("End date must be after start date");
		return false;
	}
	var z=document.forms["form_filter"]["report"].value;

if(z=="blank"){
	alert("Please select a report");
	return false;
}



}


</script>
</head>
<?php
date_default_timezone_set('America/New_York');

$query_selected = -1;
if(isset($_POST["generate"]))
{
$show_table = 0;	

$from_date = date("Ymd",strtotime($_POST["from_date"]));

$file_app_from_date = date("mdY",strtotime($_POST["from_date"]));


$to_date = date("Ymd",strtotime($_POST["to_date"]));


if((!empty($from_date)) and (!empty($to_date))){

$query = "
	SELECT s.Subject as Subject, 
	count(distinct st.Student_Poly_Id) as No_Of_Students, 
	count(distinct st.Tutor_Poly_Id) as No_Of_Tutors,
	count(st.Session_Time) as No_of_Hours_Tutored 
	FROM Student_Tutor_Assignment st, Subject s 
	where s.Subject_Id = st.Subject_Id 
	and st.date between '$from_date' and '$to_date'
	group by st.Subject_Id;
	";
	$query_selected = 1;
	$show_table = 1;
}
	
$result = mysql_query($query);
$row_count = mysql_num_rows($result);	
if($row_count <= 0){
	$show_table = 0;
	$A = "No Data found for the selected filter criteria";
}

}

?>
<?php
if($query_selected != -1){
$filename='SubjectNumber_'.$file_app_from_date.'.csv'; 
$fp=fopen("../csv/" .$filename,"w");
$seperator="Subject,No_Of_Students,No_Of_Tutors,No_of_Hours_Tutored\n";
if(!empty($query)){
   
$result = mysql_query($query);	

if($result){
 while($result_data = mysql_fetch_assoc($result)){	
//$comma="";

		 //$tutor_name = $result_data["Tutor_First_Name"]." ".$result_data["Tutor_Last_Name"];
		 $seperator.= $result_data["Subject"].",".$result_data["No_Of_Students"].",".$result_data["No_Of_Tutors"].",".$result_data["No_of_Hours_Tutored"]."\n";
		//$comma = ",";
		//echo $seperator;
	
	}
	fputs($fp,$seperator);
fclose($fp); 
}
}}

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
	<div id="text2"><p>Data Overview</p>
	<?php
	if(isset($_POST["generate"])){
	?>
	<a id= "download" name = "download" href="../csv/<?php echo $filename;?>">Download Link</a>
	<?php } ?>
	</div> 
    
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div>
	<div class="filter">
	<center>
	<form id="form_filter" name="form_filter" method="post" onsubmit="return validateForm()">
	<table style="align:center">	
	<tr>
		<td> <label for="start_date">Start Date</label></td>
		<td> <label for="end_date">End Date</label></td>
	
    </tr>		
	<tr>
	    <td> <input type="text" id="from_date" name="from_date" value="<?php 
		if(!(empty($_POST["from_date"]))){
			echo $_POST["from_date"];
		}
		else{
			echo date("m/d/Y");
		}
			?>" required></td>
		 <td> <input type="text" id="to_date" name="to_date" value="<?php 
		if(!(empty($_POST["to_date"]))){
			echo $_POST["to_date"];
		}
		else{
			echo date("m/d/Y");
		}
			?>" required></td>	
		
	<td>
	<button type="submit" id = "generate" name="generate"><img src="../images/generate.png"  width="102" height="28" border="none"/></a></button>
	</td>	
	</tr>	
	</table>
	</form>
	</center>
	</div>

<?php
if ($show_table == 1 and $query_selected == 1) {
 ?>
<div id="pager" class="pager">
	<form>
		<img src="../js/jquery_sort/addons/pager/icons/first.png" class="first">
		<img src="../js/jquery_sort/addons/pager/icons/prev.png" class="prev">
		<input type="text" class="pagedisplay">
		<img src="../js/jquery_sort/addons/pager/icons/next.png" class="next">
		<img src="../js/jquery_sort/addons/pager/icons/last.png" class="last">
		<select class="pagesize">
			<option selected="selected" value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="50">50</option>
			<option value="60">60</option>
			<option value="100">100</option>
		</select>
	</form>
</div> 	 
<?php } ?>	
<?php 

$result = mysql_query($query);

if ($show_table == 1) {

 ?>
<center>	
<div id = "scroll" class = "scroll">

<?php
 if ($query_selected == 2)
echo '
<table id="myTable1" name = "myTable1" border="1" bordercolor="#52981a" bgcolor="white" style="text-align:center" > 		 
';
else 
echo '
<table id="myTable" name = "myTable" class="tablesorter" border="1" bordercolor="#52981a" bgcolor="white" style="text-align:center" > 
';?>
<thead class = "mytableheader"> 

<tr bgcolor="e4e4e4"> 
    
    <th style = "width : 100px;">Subject</th> 
    <th style = "width : 180px;">Students</th> 
    <th style = "width : 180px;">Tutors</th> 
    <th style = "width : 180px;">Hours Tutored</th> 
    
</tr> 
</thead> 
<tbody> 
<?php

 while($result_data = mysql_fetch_assoc($result)){		
?>
<tr>     
    <td><?php echo $result_data["Subject"];?></td> 
    <td><?php echo $result_data["No_Of_Students"];?></td> 
    <td><?php echo $result_data["No_Of_Tutors"];?></td> 
    <td><?php echo $result_data["No_of_Hours_Tutored"];?></td> 
    </tr> 
<?php  }?>
</tbody> 
</table>
</div>
</center>
<?php
}
?>
<div class = "mesg3"> <?php if(isset($A))echo $A ;?> </div>
</div>
</center>
</body>
</html>