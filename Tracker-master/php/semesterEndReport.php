<!-- This page gives you the UI where you can make selections to generate reports by subject -->
<?php
/* include 'LoginCheck.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  */
?>
<?php
	//Establishing a connection with the host
		include '../Rules/dbconfig.php';
?>
<?php

$show_table = 0;
date_default_timezone_set('America/New_York');
$query_selected = -1;
if(isset($_POST["generate"]))
{
$from_date = date("Ymd",strtotime($_POST["from_date"]));
$to_date = date("Ymd",strtotime($_POST["to_date"]));
$next_month = date('Y-m-d',strtotime('+1 months', strtotime($from_date)));
$next_month_monday = date("Y-m-d", strtotime('monday this week', strtotime($next_month)));
$next_month_monday = date("m/d",strtotime($next_month_monday));

$current_date = date("Ymd");
$from_date_monday = date("Y-m-d", strtotime('monday this week', strtotime($from_date)));
$stop_date = date('Y-m-d', strtotime($to_date . ' +1 day'));
//echo $next_month_monday, "<br>";
	
	
	
	//Query to fetch all students
	$query_student = "
	select st.Student_Poly_Id,st.Student_First_Name,st.Student_Last_Name,st.Class_Status,s.Subject_Id,s.Subject 
	from Student st, Student_Tutor_Assignment sa,Subject s
	where st.Student_Poly_Id = sa.Student_Poly_Id and sa.Subject_Id = s.Subject_Id	
	group by st.Student_Poly_Id, s.Subject_Id
	";
	$student_data = array();
    $result_student = mysql_query($query_student);
	
	//echo "<br>".$datetest."</br>";  
	$p = new DatePeriod(
		new DateTime(date("Y-m-d",strtotime($from_date_monday))), 
		new DateInterval('P1W'), 
		new DateTime(date("Y-m-d",strtotime($stop_date)))
		);
	while($result_data = mysql_fetch_assoc($result_student)){
        $student_data1 = array();
		$student_data1["Student_Poly_Id"] = $result_data["Student_Poly_Id"];
        $student_data1["Student_Last_Name"] = $result_data["Student_Last_Name"];
        $student_data1["Student_First_Name"] = $result_data["Student_First_Name"];
		if($result_data["Class_Status"] == '0'){
			$student_data1["Class_Status"] = '-';
		}else{
			$student_data1["Class_Status"] = $result_data["Class_Status"];
		}
        
        $student_data1["Subject_Id"] = $result_data["Subject_Id"];
        $student_data1["Subject"] = $result_data["Subject"];
		
			foreach ($p as $w) {
				$date = $w->format('m/d');
				$student_data1[$date] = '0';
			}		
        array_push($student_data,$student_data1);
 }

	
$query = "
		select w.year,w.week,
        DATE_FORMAT(w.WeekStart,'%m/%d') as WeekStart,
        DATE_FORMAT(w.WeekEnd,'%m/%d') as WeekEnd,
        w.Student_Poly_Id,st.Student_First_Name,st.Student_Last_Name,w.Subject_Id,
		s.Subject, st.Class_Status, w.WeekCount
		from
		(
		SELECT
		year(date) year, 
		week(date) week,
		adddate(date, INTERVAL 2-DAYOFWEEK(date) DAY) WeekStart,
		adddate(date, INTERVAL 6-DAYOFWEEK(date) DAY) WeekEnd,
		Student_Poly_Id,Subject_Id,Session_Time,count(*) as WeekCount
		FROM 
		Student_Tutor_Assignment st
		where 
		st.date between '$from_date' and '$to_date' and
		st.Student_type in ('P','L') and st.Tutor_Type in ('P','L')	
		group by WeekStart,WeekEnd,Student_Poly_Id,Subject_Id,Session_Time
		order by WeekStart,WeekEnd,Student_Poly_Id,Subject_Id,Session_Time
		)as w,Student st,Subject s 
		where w.Student_Poly_Id = st.Student_Poly_Id and w.Subject_Id = s.Subject_Id   
		group by w.WeekStart,w.WeekEnd,w.Student_Poly_Id,w.Subject_Id,Session_Time
		order by w.WeekStart,w.WeekEnd,w.Student_Poly_Id,w.Subject_Id,Session_Time
		;
	";

	$result_query = mysql_query($query);
    
  while($result = mysql_fetch_assoc($result_query)){
	   
	//	 echo "<br>".$result["WeekEnd"]."<br>";
		 foreach($student_data as $key => $var){
		
		  if($student_data[$key]['Student_Poly_Id'] == $result["Student_Poly_Id"] && $student_data[$key]['Subject_Id'] == $result["Subject_Id"]){	
			  $student_data[$key][$result["WeekStart"]] = $result["WeekCount"];		
			}	 
		  
		 }

  }
foreach($student_data as $key => $var){
unset($student_data[$key]['Subject_Id']);	
}

//print_r($student_data);
?>


<?php 
// %%%%%%%%%%%%%%%%%%%%%%%%%************************************############################################################%%%%%%%$$$$$$$$$%%%%%%%%%^^^^^&&&&&&&*******


/** PHPExcel */
include '../js/PHPExcel/Classes/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include '../js/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
require_once dirname(__FILE__) . '/../js/PHPExcel/Classes/PHPExcel/IOFactory.php';
// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Tracker");
$objPHPExcel->getProperties()->setLastModifiedBy("System");
$objPHPExcel->getProperties()->setTitle("Semester End Report");
$objPHPExcel->getProperties()->setSubject("Student Weekly Report");
$objPHPExcel->getProperties()->setDescription("Final Semester End Report");


// Add some data
//echo date('H:i:s') . " Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Student N Number');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Student Last Name');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Student First Name');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Class Status');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Subject');

	$p = new DatePeriod(
		new DateTime(date("Y-m-d",strtotime($from_date_monday))), 
		new DateInterval('P1W'), 
		new DateTime(date("Y-m-d",strtotime($stop_date)))
		);
	
		$array_date = array();
			foreach ($p as $w) {
				$date = $w->format('m/d');
				//echo "<br>".$date."<br>";
				array_push($array_date,$date);
			}
$objPHPExcel->getActiveSheet()->fromArray($array_date,NULL,'F1');
$row = $objPHPExcel->getActiveSheet()->getHighestRow()+1;
$column = $objPHPExcel->getActiveSheet()->getHighestColumn(); 
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($column);
//echo $highestColumnIndex + 1;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($highestColumnIndex, $row-1, 'Total');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($highestColumnIndex + 1, $row-1, 'Grand Total');
//$objPHPExcel->getActiveSheet()->SetCellValue($highestColumnIndex, 'Total');
$curr_student_id = "";
$pre_student_id = "";
$count = 0;
$r = $objPHPExcel->getActiveSheet()->getHighestRow();
foreach($student_data as $key => $var){
	
	$objPHPExcel->getActiveSheet()->fromArray($var,NULL,'A'.$row);
	
	$row = $objPHPExcel->getActiveSheet()->getHighestRow()+1;
	
}

//$objPHPExcel->getActiveSheet()->mergeCells('E1:E3');
//$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Shyam');
//getting the rows to mergedata
$rowstart1 = 2;
$rowend1 = 2;
$merge_cells = "";
$sum_cells = "";
$merge_array = [];
$formula_array = [];
 $count = 0;
$c = $objPHPExcel->getActiveSheet()->getHighestColumn();
$pre_student_id = "";
$c = $objPHPExcel->getActiveSheet()->getHighestColumn();


$colNumber = PHPExcel_Cell::columnIndexFromString($c);
//echo "<br>colNumber  = ".$colNumber."<br>";
$colNumber = $colNumber - 1;
//echo "<br>colNumber  = ".$colNumber."<br>";
$colString = PHPExcel_Cell::stringFromColumnIndex($colNumber - 1);
$colString2 = PHPExcel_Cell::stringFromColumnIndex($colNumber - 2);
//echo "<br>previous column = ".$colString."<br>";
$i = 2;
foreach($student_data as $key => $var){
	
	$insert_row_column = $colString.$i;
	$sum_start_row_column = "F".$i;
	$sum_end_row_column = $colString2.$i;
	$formula_total = "=sum($sum_start_row_column:$sum_end_row_column)";
	$objPHPExcel->getActiveSheet()
       ->setCellValue($insert_row_column,$formula_total);
	$i = $i + 1;
}

for($i=0;$i<count($student_data);$i++){
	$merge_flag = False;
	for($j=$i;$j<count($student_data);$j++){
		 
		if( $student_data[$i]["Student_Poly_Id"] == $student_data[$j]["Student_Poly_Id"]  ){
			
			$rowstart1 = $i + 2;
			$rowend1 = $j + 2;
			$merge_flag = True;
		//	echo $student_data[$i]["Student_Poly_Id"] ; 
		}else{
			$rowstart2 = $i + 2;
			$rowend2 = $j + 2;
			break;
			
		}
		
	}
	if($merge_flag == True){
			$merge_cells = $c.$rowstart1.":".$c.$rowend1;
			$sum_start = $colString.$rowstart1;
			$sum_end = $colString.$rowend1;
			$row_sum = $c.$rowstart1;
			$sum_cells = "$row_sum,=SUM($sum_start:$sum_end)";			
			array_push($merge_array,$merge_cells);
			array_push($formula_array,$sum_cells);
			$i = $j - 1;
			
		}
		else{
			//$merge_cells = $c.$rowstart1.":".$c.$rowend1;
			//$sum_start1 = $colString.$rowstart2;
			//$sum_end1 = $colString.$rowend2;
			$row_sum1 = $c.$rowstart2;
			$cell_insert = $colString.$rowstart2;
			//echo "<br>".$row_sum1;
			$sum_cells = "$row_sum1,=$cell_insert";			
		//	array_push($merge_array,$merge_cells);
			array_push($formula_array,$sum_cells);
		}
	
} 
//print_r($formula_array);
/* //$merge_array = array_slice($merge_array, 1);
foreach($merge_array as $var){
	//echo "<br>".$var;
	
	$objPHPExcel->getActiveSheet()->mergeCells($var);
} */
foreach($merge_array as $var){
	//echo "<br>".$var;
	$element = explode(':',$var);
	$start = (string)$element[0];
	$end = (string)$element[1];
	$merge_value = $start.":".$end;
	
	if($start != $end){
		//echo "<br>".$merge_value;
		$objPHPExcel->getActiveSheet()->mergeCells("$start:$end");
	}
	
}
foreach($formula_array as $var){
	
	//echo "<br>".$var;
	$element = explode(',',$var);
	//print($element[1]);
	$objPHPExcel->getActiveSheet()
       ->setCellValue($element[0],$element[1]);
}
//$merge_array = array_slice($merge_array, 1);

$filename='SemesterEndReport_'.$from_date_monday.'.xlsx'; 
$filepath = "../csv/".$filename;
$objPHPExcel->setActiveSheetIndex(0);
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Sheet1');

		
// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', $filename));
$objWriter->save(str_replace(__FILE__,$filepath,__FILE__));
//exit();
// Echo done
//echo date('H:i:s') . " Done writing file.\r\n";

//%%%%%%%%%%%%%%%%%%%%%%%%%************************************############################################################%%%%%%%$$$$$$$$$%%%%%%%%%^^^^^&&&&&&&*******
$show_table = 1;



}
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
	<div id="text2"><p>Semester End Report</p>
	<?php
	if(isset($_POST["generate"])){
	?>
	<!-- <a id= "download" name = "download" href="../csv/<?php echo $filename;?>">Download Link</a> -->
	<a id= "download" name = "download" href="<?php echo $filepath;?>">Download Link</a>
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
<!--		<td> <label for="tutor">Select Report</label></td> -->
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
	<button type="submit" id = "generate" name="generate"><img src="../images/generate.png"  width="102" height="28" border="none"/></a></button>
	</td>	
	</tr>	
	</table>
	</form>
	</center>
	</div>
<?php
if($show_table == 1){
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
	
<div id = "scroll" class = "scroll">
	<center>
	<?php
/* 	include 'PHPExcel/IOFactory.php';
	$inputFileType = 'Excel2007';
	$inputFileName = $filepath;

	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel = $objReader->load($inputFileName);

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
	$objWriter->save('php://output'); 
	//exit; */
/* 	 foreach ($student_data as $a_var){
		print_r($a_var);
	}  */
/* 	        $count_week = 1;
			if(!empty($array_date)){
			foreach ($array_date as $a_var){
				
				if(($count_week <= 4))
					echo "TRUE<br>";
				$count_week = $count_week  + 1;
			}
		} */
	?>
	
	<table id="myTable" name = "myTable" class="tablesorter" border="1" bordercolor="#52981a" bgcolor="white" style="text-align:center" > 
	<thead class = "mytableheader"> 
	<tr bgcolor="e4e4e4"> 
    
		<th style = "width : 100px;">N Number</th> 
		<th style = "width : 120px;">Last Name</th> 
		<th style = "width : 120px;">First Name</th> 
		<th style = "width : 100px;">Class Status</th> 
		<th style = "width : 100px;">Subject</th> 
		<?php
		$count_week = 1;
		if(!empty($array_date)){
			foreach ($array_date as $a_var){
				if($count_week <= 4){
				?>
				
				<th><?php echo $a_var  ?></th>
				
				<?php
			}
			$count_week = $count_week  + 1;
			}
		}
		?>
		<th>Total</th>
			
	</tr> 
	</thead>
	<tbody>
	<?php
	
	foreach ($student_data as $a_var){
		
    ?>
	
	<tr>     
    <td ><?php echo $a_var["Student_Poly_Id"];?></td> 
    <td ><?php echo $a_var["Student_Last_Name"];?></td> 
    <td ><?php echo $a_var["Student_First_Name"];?></td> 
    <td ><?php echo $a_var["Class_Status"];?></td> 
    <td ><?php echo $a_var["Subject"];?></td> 
	<?php
	$sum = 0;
	$count_week = 1;
	foreach ($array_date as $a_var1){
	    
		
		if($count_week <= 4){
			$sum = $sum + $a_var[$a_var1] ;
				?>
				
				<td><?php echo $a_var[$a_var1];  ?></td>
				
				<?php
			}
			$count_week = $count_week  + 1;
	}
			?>
   
    <td ><?php echo $sum;?></td> 
   
	</tr> 
	
	
	<?php	
	//print_r($a_var);
	
	
	}
	?>
	
	
    </tbody> 	
	</table>
	
	
	
	</center>
	
</div>
<?php } ?>
<div class = "mesg3"> <?php  if(isset($A))echo $A ;?> </div>

</div>

</div>
</center>
</body>
</html>