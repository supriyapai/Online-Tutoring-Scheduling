<!-- This page gives you the UI where you can make selections to generate reports by subject -->
<?php
include 'LoginCheck.php';

?>
<?php
	//Establishing a connection with the host
		include '../Rules/dbconfig.php';
?>
<?php
date_default_timezone_set('America/New_York');
$query_selected = -1;
if(isset($_POST["generate"]))
{
$show_table = 0;	

$from_date = date("Ymd",strtotime($_POST["from_date"]));
$file_app_from_date = date("mdY",strtotime($_POST["from_date"]));
$to_date = date("Ymd",strtotime($_POST["to_date"]));
$to_date_1 = date_create($to_date);
$to_date_1 = date_sub($to_date_1, date_interval_create_from_date_string('1 days'));
$to_date_1 = date_format($to_date_1, 'Ymd');
/* if($to_date_1 <= $from_date){
	$to_date_1 = $to_date;
} */
$report_generate = $_POST["report"];
$current_date = date("Ymd");

if($report_generate == 1){

$query = "
		select t.full_name, a.total_session,
		CASE b.total_present
		when b.total_present then b.total_present ELSE 0 End as total_present, 
		CASE c.total_cancel
		when c.total_cancel  then c.total_cancel ELSE 0 End as total_cancel,
		CASE d.total_no_show
		when d.total_no_show then d.total_no_show ELSE 0 End as total_no_show,
		CASE e.total_late
		when e.total_late then e.total_late ELSE 0 End as total_late,
		CASE f.missing_info
		when f.missing_info then f.missing_info ELSE 0 End as missing_info
		from 
		(select Tutor_Poly_Id,
		count(*) as 'total_session' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		GROUP BY  Tutor_Poly_Id
        
		) a left join 
		(select Tutor_Poly_Id,
		count(*) as 'total_present' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Tutor_Type = 'P'
		GROUP BY  Tutor_Poly_Id 
      
        ) b  on a.Tutor_Poly_Id = b.Tutor_Poly_Id
		left join (
        select Tutor_Poly_Id,
		count(*) as 'total_cancel' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Tutor_Type = 'C'
		GROUP BY  Tutor_Poly_Id
       
        ) c on c.Tutor_Poly_Id=a.Tutor_Poly_Id
		left join (
        select Tutor_Poly_Id,
		count(*) as 'total_no_show' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Tutor_Type = 'N/S'
		GROUP BY  Tutor_Poly_Id
       
        )d on d.Tutor_Poly_Id=a.Tutor_Poly_Id
		left join (
        select Tutor_Poly_Id,
		count(*) as 'total_late' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Tutor_Type = 'L'
		GROUP BY  Tutor_Poly_Id
       
        )e on e.Tutor_Poly_Id=a.Tutor_Poly_Id
		left join (
        select Tutor_Poly_Id, 
		count(*) as 'missing_info' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Tutor_Type not in ('L','P','C','N/S')
		GROUP BY  Tutor_Poly_Id
        
        )f on f.Tutor_Poly_Id=a.Tutor_Poly_Id,
		(SELECT CONCAT_WS(' ', `Tutor_First_Name`, `Tutor_Last_Name`) AS `full_name`,Tutor_Poly_Id FROM Tutor )t
		where a.Tutor_Poly_id = t.Tutor_Poly_id
		group by a.Tutor_Poly_Id
        order by t.full_name
		;
		;
	";
	
	$check_query_result = mysql_query($query);
	$row_count = mysql_num_rows($check_query_result);	
	if($row_count <= 0){
		$show_table = 0;
		$query_selected = -1;
		$A = "No Data found for the selected filter criteria";
	}
	else{
	$query_selected = 1;
	$show_table = 1;
	}
}

if($report_generate == 2){
		$query = "
     select s.full_name, a.total_session,
		CASE b.total_present
		when b.total_present  then b.total_present ELSE 0 End as total_present, 
		CASE c.total_cancel
		when c.total_cancel  then c.total_cancel ELSE 0 End as total_cancel,
		CASE d.total_no_show
		when d.total_no_show then d.total_no_show ELSE 0 End as total_no_show,
		CASE e.total_late
		when e.total_late then e.total_late ELSE 0 End as total_late,
		CASE f.missing_info
		when f.missing_info then f.missing_info ELSE 0 End as missing_info
		from 
		(select Student_Poly_Id ,
		count(*) as 'total_session' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		GROUP BY  Student_Poly_Id 
      
		) a left join 
		(select Student_Poly_Id ,
		count(*) as 'total_present' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'P'
		GROUP BY  Student_Poly_Id  
       
        ) b  on a.Student_Poly_Id  = b.Student_Poly_Id 
		left join (
        select Student_Poly_Id ,
		count(*) as 'total_cancel' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'C'
		GROUP BY  Student_Poly_Id
       
        ) c on c.Student_Poly_Id =a.Student_Poly_Id 
		left join (
        select Student_Poly_Id ,
		count(*) as 'total_no_show' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'N/S'
		GROUP BY  Student_Poly_Id
       
        )d on d.Student_Poly_Id =a.Student_Poly_Id 
		left join (
        select Student_Poly_Id ,
		count(*) as 'total_late' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'L'
		GROUP BY  Student_Poly_Id
       
        )e on e.Student_Poly_Id =a.Student_Poly_Id 
		left join (
        select Student_Poly_Id , 
		count(*) as 'missing_info' from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type not in ('L','P','C','N/S')
		GROUP BY  Student_Poly_Id 
        
        )f on f.Student_Poly_Id =a.Student_Poly_Id ,
		(SELECT CONCAT_WS(' ', `Student_First_Name`, `Student_Last_Name`) AS `full_name`,Student_Poly_Id FROM Student )s
		where a.Student_Poly_Id  = s.Student_Poly_Id 
		group by a.Student_Poly_Id
        order by s.full_name
		
	";
	$check_query_result = mysql_query($query);
	$row_count = mysql_num_rows($check_query_result);	
	if($row_count <= 0){
		$show_table = 0;
		$query_selected = -1;
		$A = "No Data found for the selected filter criteria";
	}
	else{
	$query_selected = 2;
	$show_table = 1;
	}
}	
if($report_generate == 0){
	
		$query_tutor = "
			select total_present  as total_present,
        total_cancel  as total_cancel,
        total_late  as total_late,
        total_no_show  as total_no_show,
        missing_info  as missing_info
        from
		(select count(*) as total_present from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'P'
        )a1,(
		select count(*) as total_cancel from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'C'
        )b1,(
		select count(*) as total_late from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'L'
        )c1,(
		select count(*) as total_no_show from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'N/S'
        )d1,(
		select count(*) as missing_info  from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type not in ('N/S','L','C','P')
        )e1;
	";
	$result_tutor = mysql_query($query_tutor);
	$row_count_tutor = mysql_num_rows($result_tutor);
	
	while(($row = mysql_fetch_assoc($result_tutor))) {
    	$result_tutor_data[] = $row;
	}
	
	$query_student = "
						select total_present  as total_present,
        total_cancel  as total_cancel,
        total_late  as total_late,
        total_no_show  as total_no_show,
        missing_info as missing_info
        from
		(select count(*) as total_present from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'P'
        )a1,(
		select count(*) as total_cancel from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'C'
        )b1,(
		select count(*) as total_late from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'L'
        )c1,(
		select count(*) as total_no_show from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type = 'N/S'
        )d1,(
		select count(*) as missing_info  from Student_Tutor_Assignment
		where date between '$from_date' and '$to_date'
		and Student_Type not in ('N/S','L','C','P')
        )e1;
	";
	$result_student = mysql_query($query_student);
	$row_count_student = mysql_num_rows($result_student);
	while(($row = mysql_fetch_assoc($result_student))) {
    	$result_student_data[] = $row;
	}
	$query_selected = 3;
	$show_table = 1;
	
}
}

?>
<?php
if($query_selected == 1){
$filename='SessionType_'.$file_app_from_date.'.csv'; 
$fp=fopen("../csv/" .$filename,"w");
$seperator="Tutor Name,Total Session,Total Present,Total Cancel,Total No Show,Total Late,Missing Info \n";
if(!empty($query)){
   
$result = mysql_query($query);	
if($result){
 while($result_data = mysql_fetch_assoc($result)){	
//$comma="";

		 //$tutor_name = $result_data["Tutor_First_Name"]." ".$result_data["Tutor_Last_Name"];
		 $seperator.= $result_data["full_name"].",".$result_data["total_session"].",".$result_data["total_present"].",".$result_data["total_cancel"].
		 ",".$result_data["total_no_show"].",".$result_data["total_late"].",".$result_data["missing_info"]."\n";
		//$comma = ",";
		//echo $seperator;
	
	}
	fputs($fp,$seperator);
fclose($fp); 
}
}}

if($query_selected == 2){
$filename='SessionType_'.$file_app_from_date.'.csv'; 
$fp=fopen("../csv/" .$filename,"w");
$seperator="Student Name,Total Session,Total Present,Total Cancel,Total No Show,Total Late,Missing Info \n";
if(!empty($query)){
   
$result = mysql_query($query);	
if($result){
 while($result_data = mysql_fetch_assoc($result)){	
//$comma="";

		 //$student_name = $result_data["Student_First_Name"]." ".$result_data["Student_Last_Name"];
		 $seperator.= $result_data["full_name"].",".$result_data["total_session"].",".$result_data["total_present"].",".$result_data["total_cancel"].
		 ",".$result_data["total_no_show"].",".$result_data["total_late"].",".$result_data["missing_info"]."\n";
		//$comma = ",";
		//echo $seperator;
	
	}
	fputs($fp,$seperator);
fclose($fp); 
}
}}


if($query_selected == 3){
$filename='SessionType_'.$file_app_from_date.'.csv'; 
$fp=fopen("../csv/" .$filename,"w");
$seperator="Type,Tutor,Student \n";
if(!empty($result_tutor_data) && (!empty($result_student_data)) ){
   
 foreach($result_tutor_data as $value){
	 
foreach($result_student_data as $value1){
//$comma="";

		 //$student_name = $result_data["Student_First_Name"]." ".$result_data["Student_Last_Name"];
		 $seperator.= "Present".",".$value["total_present"].",".$value1["total_present"]."\n";
		 $seperator.= "Cancel".",".$value["total_cancel"].",".$value1["total_cancel"]."\n";
		 $seperator.= "Late".",".$value["total_late"].",".$value1["total_late"]."\n";
		 $seperator.= "No Show".",".$value["total_no_show"].",".$value1["total_no_show"]."\n";
		 $seperator.= "Missing Info".",".$value["missing_info"].",".$value1["missing_info"]."\n";
	
		//$comma = ",";
		//echo $seperator;
	
	}
	fputs($fp,$seperator);
fclose($fp); 
}
}}
?>
<html>
<head>
    <title>Report - Subject</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		

<link rel="stylesheet" type="text/css" href="../css/number_of_session_type.css" />
<link rel="stylesheet" href="../css/datepicker.css"/>
<script src="../js/jQuery 1.9.1.js"></script>
<script src="../js/jQuery UI.js"></script> 
 <script type="text/javascript">
   $(function($){
    
	$( "#from_date" ).datepicker( {maxDate: '0d'});
    $( "#to_date" ).datepicker({maxDate: '0d'});

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
	<div id="text2"><p>Report By Number Of Session Types</p>
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
		<td> <label for="tutor">Select Report</label></td>
    </tr>		
	<tr>
	    <td> <input type="text" id="from_date" name="from_date" value="<?php 
		if(!(empty($_POST["from_date"]))){
			echo $_POST["from_date"];
		}
		else{
			$date = new DateTime();			
			echo $date->format('m/d/Y');
		}
			?>" required></input>
			</td>
		 <td> <input type="text" id="to_date" name="to_date" value="<?php 
		if(!(empty($_POST["to_date"]))){
			echo $_POST["to_date"];
		}
		else{
			$date = new DateTime();			
			echo $date->format('m/d/Y');
			
		}
			?>" required></input>
			</td>	
		
	<td>
	<select name = "report" id = "report" onChange="showUser(this.value);">
	<option value = 0
	<?php if(isset($_POST["report"]) && $_POST["report"] == 0) echo 'selected = "selected"'?>>General Attendance</option>
	<option value = 1
	<?php if(isset($_POST["report"]) && $_POST["report"] == 1) echo 'selected = "selected"'?>>Tutor Attendance</option>
	<option value = 2
	<?php if(isset($_POST["report"]) && $_POST["report"] == 2) echo 'selected = "selected"'?>>Student Attendance</option>
	
	</select>
	</td>
	<td>
	<button type="submit" id = "generate" name="generate"><img src="../images/generate.png"  width="102" height="28" border="none"/></a></button>
	</td>	
	</tr>	
	</table>
	</form>
	</center>
	</div>
<?php if($query_selected == 1 or $query_selected == 2){?>	
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
<?php }
if ($show_table == 1) {
	
 ?>
<?php
if($query_selected == 1){
?> 
<center>	
<div id = "scroll" class = "scroll">

<table id="myTable" name = "myTable" class="tablesorter" border="1" bordercolor="#52981a" bgcolor="white" style="text-align:center" > 
<thead class = "mytableheader"> 

<tr bgcolor="e4e4e4"> 
    
    <th style = "width : 180px;">Tutor Name</th> 
    <th style = "width : 150px;">Scheduled Session</th> 
    <th style = "width : 80px;">Present</th> 
    <th style = "width : 80px;">Cancel</th> 
    <th style = "width : 80px;">No-Show</th> 
    <th style = "width : 80px;">Late</th> 
    <th style = "width : 100px;">Missing Info</th> 
</tr> 
</thead> 
<tbody> 
<?php
if(!empty($query)){
   
$result = mysql_query($query);	
if($result){
 while($result_data = mysql_fetch_assoc($result)){		
?>
<tr>     
    <td "width : 180px;"><?php echo $result_data["full_name"];?></td> 
    <td><?php echo $result_data["total_session"];?></td> 
    <td><?php echo $result_data["total_present"];?></td> 
    <td><?php echo $result_data["total_cancel"];?></td> 
    <td><?php echo $result_data["total_no_show"];?></td> 
    <td><?php echo $result_data["total_late"];?></td> 
    <td><?php echo $result_data["missing_info"];?></td>     
</tr> 
 <?php  }?>
</tbody> 
</table>
</div>
</center>
<?php 
}}}
?>
<?php
if($query_selected == 2){
?>
<center>	
<div id = "scroll" class = "scroll">

<table id="myTable" name = "myTable" class="tablesorter" border="1" bordercolor="#52981a" bgcolor="white" style="text-align:center" > 
<thead class = "mytableheader"> 

<tr bgcolor="e4e4e4"> 
    
    <th style = "width : 180px;">Student Name</th> 
    <th style = "width : 150px;">Scheduled Session</th> 
    <th style = "width : 80px;">Present</th> 
    <th style = "width : 80px;">Cancel</th> 
    <th style = "width : 80px;">No-Show</th> 
    <th style = "width : 80px;">Late</th> 
    <th style = "width : 100px;">Missing Info</th> 
</tr> 
</thead> 
<tbody> 
<?php
if(!empty($query)){
   
$result = mysql_query($query);	
if($result){
 while($result_data = mysql_fetch_assoc($result)){

 
	
		
?>
<tr> 
    
    <td "width : 180px;"><?php echo $result_data["full_name"];?></td> 
    <td><?php echo $result_data["total_session"];?></td> 
    <td><?php echo $result_data["total_present"];?></td> 
    <td><?php echo $result_data["total_cancel"];?></td> 
    <td><?php echo $result_data["total_no_show"];?></td> 
    <td><?php echo $result_data["total_late"];?></td> 
    <td><?php echo $result_data["missing_info"];?></td> 


    
</tr> 
 <?php  }?>

</tbody> 
</table>

</div>
</center>
<?php 
}}}
?>
<?php
if($query_selected == 3){
?>
<center>


	
<div id = "scroll" class = "scroll">

<table id="myTable1" name = "myTable1" border="1" bordercolor="#52981a" bgcolor="white" style="text-align:center;width: 755px;"> 
<thead class = "mytableheader1"> 

<tr bgcolor="e4e4e4"> 
    
    <th>Type</th> 
    <th>Tutor Session</th> 
    <th>Student Session</th> 

</tr> 
</thead> 
<tbody> 
<?php
if(!empty($result_tutor_data)){
 foreach($result_tutor_data as $value){
		if(!empty($result_student_data)){
 foreach($result_student_data as $value1){
?>
<tr> 
    
    <td>Present</td> 
    <td><?php echo $value["total_present"];?></td>     
    <td><?php echo $value1["total_present"];?></td>     
</tr> 
<tr> 
    
    <td>Cancel</td> 
    <td><?php echo $value["total_cancel"];?></td>     
    <td><?php echo $value1["total_cancel"];?></td>     
</tr> 
<tr> 
    
    <td>Late</td> 
    <td><?php echo $value["total_late"];?></td>     
    <td><?php echo $value1["total_late"];?></td>     
</tr> 
<tr> 
    
    <td>No-Show</td> 
    <td><?php echo $value["total_no_show"];?></td>     
    <td><?php echo $value1["total_no_show"];?></td>     
</tr> 

<tr> 
    
    <td>Missing Info</td> 
    <td><?php echo $value["missing_info"];?></td>     
    <td><?php echo $value1["missing_info"];?></td>     
</tr> 
<?php  }}}}?>
</tbody> 
</table>

</div>
</center>
<?php 
}
?>


<?php
	}
?>
<div class = "mesg3"> <?php  if(isset($A))echo $A ;?> </div>

</div>

</div>
</center>
</body>
</html>