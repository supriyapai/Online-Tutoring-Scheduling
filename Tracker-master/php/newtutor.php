<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../css/mainmenu.css" />
	</head>
<body>
<?php 
//include '../Rules/jQueryPlugins.php';
	$id = $_GET["var1"];
	$day = $_GET["var2"];
	$allocateid = $_GET["var3"];
	$time = $_GET["var4"];
 ?>
 <?php
	include '../Rules/dbconfig.php';		
	$d = mysql_query("SELECT DAYOFWEEK(`Current_Date`)FROM Sign_In WHERE Poly_Id = '$id'");
	$d1 = mysql_fetch_array($d);
	$d2 = $d1[0];	
	$TutorId1 = mysql_query("SELECT `Tutor_First_Name`, `Tutor_Last_Name`, `Block` FROM Tutor WHERE Tutor_Poly_Id = '$id' ");
	$TutorId2 = mysql_fetch_array($TutorId1);
	$Tutorfn = $TutorId2[Tutor_First_Name];
	$Tutorln = $TutorId2[Tutor_Last_Name];
	$Tutorname = $Tutorfn." ".$Tutorln;
	$block = $TutorId2[Block];
	$currentDate = date("Y-m-d");
?>
 <p>
 <div id="container">
       <div id="inputboxbackground_tut"></div>

		<div id="banner"><img src="../images/banner2.png"  width="1022" height="150" border="none"/></div>
	    <div id="line"></div> 
        </p>
	<div id="tutor">
		<h4>
		<?php 
			echo "<center><h3>$Tutorname</h3></center>"; 
		?>
		</h4>
	</div>
<br><br><br>
    <form action = "<?php $PHP_SELF; ?>" method = "post" > 
	<br><br>
	<div style="z-index:800; position: relative;">
	<?php
	if($block == 1){
    echo "<br><center><font size='3'>You Have Been Blocked. Please Contact A Staff Member</center>";
    echo '<center><a href="StudentSelectFunction.php"><br><br><br><br><button type="submit" name="done" value="Done"><img src="../images/mainpage.png"  width="102" height="28" border="none" /></button></a></center>';
    if( isset ($_POST['done'])){
        $page = "StudentSelectFunction.php";
        header("Location: $page");
    }    
}else{
	//$sessiondetails1 = mysql_query("SELECT Student_Poly_Id, `Subject`, `Time` FROM Student_Tutor_Allocation_Main WHERE Tutor_Poly_Id = '$id' AND Day = '$day' ");
	$sessiondetails1 = mysql_query("SELECT `Student_Poly_Id`, `Subject_Id`, `Session_Time` FROM `Student_Tutor_Assignment` WHERE `Tutor_Poly_Id` = '$id' AND Day = '$day' AND `Date`= '$currentDate' AND `Student_Type` != 'C' AND `Tutor_Type`!= 'C' ");
	while($sessiondetails2 = mysql_fetch_array($sessiondetails1) ){
		$studentId[] = $sessiondetails2[Student_Poly_Id];
		$subjectId[] = $sessiondetails2[Subject_Id];
		$sessionTime[] = $sessiondetails2[Session_Time];
	}

	$count1 = count($studentId);

	for($a=0; $a<$count1; $a++){
		$studentDetails1 = mysql_query("SELECT Student_First_Name, `Student_Last_Name` FROM Student WHERE Student_Poly_Id = '$studentId[$a]' ");
		while($studentDetails2 = mysql_fetch_array($studentDetails1)){
			$studentFn[] = $studentDetails2[Student_First_Name];
			$studentLn[] = $studentDetails2[Student_Last_Name];
		}
		$studentName[] = $studentFn[$a]." ".$studentLn[$a];
	}
	
	for($b=0; $b<$count1; $b++){
		$subjectNames1 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subjectId[$b]' ");
		while($subjectNames2 = mysql_fetch_array($subjectNames1)){
			$subject[] = $subjectNames2[Subject];
		}
	}
?>

<table border="0">
<tr>
<td><font size="4">Session: </td>
<td><select name="sessiontime">
<?php
	echo "<option>---SELECT---</option>";
	for($z=0; $z<$count1; $z++){
		echo "<option value='$sessionTime[$z]'> $sessionTime[$z], $studentName[$z], $subject[$z] </option>";
	}
?>

</select>
</td>
</tr>
</table>
<br/>
</font>
</form>
<div id="submit">
<button type="submit" name="signin" value="Sign in"><img src="../images/signin.png"  width="102" height="28" border="none"/></button></div>

<div id="back">
<button type="submit" name="done" value="Done"><img src="../images/mainpage.png"  width="102" height="28" border="none"/></button>

</div>

<?php

		if( isset ($_POST["signin"]) )
		{	
				$sessiontime = $_POST["sessiontime"];
				
			if($sessiontime == "---SELECT---")
			{?><?php
				echo"<center>Please Select A Session</center>";
			}
			else
			{
				
				$allocationid1 = mysql_query("SELECT Allocate_Id FROM Student_Tutor_Allocation_Main WHERE Tutor_Poly_Id = '$id'
				 						  AND Time = '$sessiontime' ");
				$allocationid2 = mysql_fetch_array($allocationid1);
				$allocationid = $allocationid2[0];
				//echo "$allocationid";
				
				//Added By : Parul Joshi Dated: 02/09/2015 Task: to check if the tutor has already signed in otherwise it was signing in again and changed the time of sign in
				$presentcheck1 = mysql_query("SELECT Tutor_Type FROM Student_Tutor_Assignment WHERE Allocate_Id='$allocationid' AND `Session_Time` = '$sessiontime' AND `Date` = '$currentdate' AND `Student_Type` = 'C' AND `Tutor_Type` = 'C' ");
				$presentcheck2 = mysql_fetch_array($presentcheck1);
				$presentcheck = $presentcheck2[0];
				//check if the tutor is allready signed in
				if($presentcheck == 'P' || $presentcheck == 'L')
				{
					$error= '<p class="errText"><center>You Have Already Signed In</center>';
					echo "$error";
				}
				//if not
				else{			
				$addsessiontime151 = mysql_query("SELECT ADDTIME('$sessiontime', '00:15:00')");
				$addsessiontime152 = mysql_fetch_array($addsessiontime151);
				$addsessiontime15 = $addsessiontime152[0];
				//echo "$addsessiontime15";

				$addsessiontime201 = mysql_query("SELECT ADDTIME('$sessiontime', '00:20:00')");
				$addsessiontime202 = mysql_fetch_array($addsessiontime201);
				$addsessiontime20 = $addsessiontime202[0];
				//echo "$addsessiontime20";

				$addsessiontime301 = mysql_query("SELECT ADDTIME('$sessiontime', '00:30:00')");
				$addsessiontime302 = mysql_fetch_array($addsessiontime301);
				$addsessiontime30 = $addsessiontime302[0];
				//echo "$addsessiontime30";	
		
				$subsessiontime201 = mysql_query("SELECT SUBTIME('$sessiontime', '00:20:00')");
				$subsessiontime202 = mysql_fetch_array($subsessiontime201);
				$subsessiontime20 = $subsessiontime202[0];
				//echo "$subsessiontime20";
                        
			
				$currenttime1 = mysql_query("SELECT Current_Time FROM Sign_In WHERE Poly_Id = '$id' ");
				$currenttime2 = mysql_fetch_array($currenttime1);
				$currenttime = $currenttime2[0];
				//echo "$currenttime";	
				//Added By: Kishan
				//Previous Code: if($currenttime >= $subsessiontime20 AND  $currenttime <= $addsessiontime15)
				if($currenttime >= $subsessiontime20 AND  $currenttime <= $addsessiontime15)
				{
                    $url1 = "Tutorupdate.php?var1=$id&var2=$d2&var3=$sessiontime&var4=$allocateid";
                    header("Location:$url1");
				
				}	
				// Begin of code changes Shyam Rajendra Joshi 1st February 2017
				// Commented below code to remove lateness policy
				//As per new policy, It a No Show after 15 min and there is no more lateness policy
				//Old code comment starts
/* 				elseif($currenttime >$addsessiontime15 AND $currenttime <= $addsessiontime20)
				{	
					
					$url1 = "Tutorconfirm.php?var1=$id&var2=$d2&var3=$sessiontime&var4=$allocateid";
					header("Location:$url1");

				} */
                            //    elseif($currenttime > $addsessiontime20 AND $currenttime <= $addsessiontime30)
                           //    {
									/* Edited By: Parul Joshi Dated: 08/14/2015
										Task - to direct this page to SaveTutorTypeb.php instead of Status--> */
                          //          echo "<center>Its too late to sign in for the session!!</center>";
                           //     }
				//Old Code comment ends
				//New code added
				elseif($currenttime > $addsessiontime15 )
                               {
									
                                   echo "<center>Its too late to sign in for the session!! You are marked No Show (N/S)</center>";
                               }
				//End of Code Changes Shyam Rajendra Joshi 1st February 2017
				elseif($currenttime > $addsessiontime30)
				{
					echo "<center>The session Is over</center>";
				}
				
				elseif($currenttime < $subsessiontime20)
				{
					echo "<center>There is time for you to sign in</center>";
				}
			}
			}	
				
		}	

		elseif(isset($_POST["done"]) )
			{
				$url2 = "Signin.php";
				header("Location:$url2");
			}
		
}
  
 					
				
?>


</center>
</body>
</html>


