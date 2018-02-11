<!--Edited By: Parul Joshi Dated: 08/27/2015 Task : to add the HTML code in this page and correctly place the confirmation msg -->
<html>
 <head>
        <title>Student Sign In</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/studentblock.css" />
</head>
<body>
<div id="container">
	<div id="banner"><img src="../images/banner2.png"  width="1022" height="150" border="none"/></div>
	<div id="signout"><img src="../images/adminlogin.png" width="17" height="15" border="none" /></div>
	
	<div id="text2"><p>&nbsp &nbsp &nbsp Student Sign In</p></div>
	<div id="text3"><a href="StudentSelectFunction.php"><p>Main Page</p></a></div> 
	
	<br><br><br>
	<center>
	<div class="ex">
	<div class="back">
	<form action ="<?php $PHP_SELF; ?>" method = "post">
	<br><br><br>
	<?php
		include '../Rules/dbconfig.php';
		$studentid = $_GET["var1"];
		$day = $_GET["var2"];
		$sessiontime = $_GET["var3"];
		$allocateid = $_GET["var4"]; 	
		$currentdate=date("Y-m-d");
		
		$presence1 = mysql_query("SELECT Presence FROM Student WHERE Student_Poly_Id = '$studentid' ");
		$presence2 = mysql_fetch_array($presence1);
		$presence = $presence2[0];
		
		$sessiondetails1 = mysql_query("SELECT Tutor_Poly_Id, `Subject` FROM Student_Tutor_Allocation_Main WHERE Allocate_Id = '$allocateid' ");
		$sessiondetails2 = mysql_fetch_array($sessiondetails1);
		
		$tutorid = $sessiondetails2[Tutor_Poly_Id];
		$subjectid = $sessiondetails2[Subject];
		
		$check1 = mysql_query("SELECT Assignment_Id, `Session_Type` FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' AND Session_Time = '$sessiontime' ");
		$check2 = mysql_fetch_array($check1);
		$check = $check2[Assignment_Id];
		$sessioncheck = $check2[Session_Type];
		
		if($check){
			$presentcheck1 = mysql_query("SELECT Student_Type FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' ");
			$presentcheck2 = mysql_fetch_array($presentcheck1);
			$presentcheck = $presentcheck2[0];
		    //Code change begin C1: Done by Shyam Joshi, Condition modified to consider empty and null values for the Session_Type entry in the database.  
			if($sessioncheck != ' ' and (!(empty($sessioncheck))) and  (!(is_null($sessioncheck))) ){
			//Code change End C1: Shyam Joshi	
						if($presentcheck == 'N/S'){
							$Confirm= "Sorry!! You Can Not Sign In, because you are a No Show";
						}
						//Added By: Kishan
						elseif($sessioncheck == 'E' AND $presentcheck != 'N/S') {
							$addpresence = $presence+1;
				
							//Edited By: Parul Joshi Task: Students were unable to sign into their rescheduled sessions. 
							//$studentupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Student_Type` = 'P', `Current_Date` = CURDATE(), `Student_Current_Time` = CURTIME() WHERE Student_Poly_Id='$studentid' AND Session_Time='$sessiontime' AND Date = '$currentdate' ");
							$studentupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Student_Type` = 'P', `Current_Date` = CURDATE(), `Student_Current_Time` = CURTIME() WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' AND Student_Poly_Id='$studentid' AND Session_Time='$sessiontime'");
							if($studentupdate){
								$presenceupdate = mysql_query("UPDATE Student SET Presence = '$addpresence' WHERE Student_Poly_Id = '$studentid' ");
								if($presenceupdate){
									$url1 = "StudentSelectFunction.php";
									header("Location:$url1");
								}else{
									$A= "Error";
								}
							}
						}
						//Added By: Kishan
						elseif($sessioncheck == 'R' AND $presentcheck != 'N/S') {
							$addpresence = $presence+1;
				
							$studentupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Student_Type` = 'P', `Current_Date` = CURDATE(), `Student_Current_Time` = CURTIME() WHERE Allocate_Id = '$allocateid' 										AND Date = '$currentdate' ");
							if($studentupdate){
								$presenceupdate = mysql_query("UPDATE Student SET Presence = '$addpresence' WHERE Student_Poly_Id = '$studentid' ");
								if($presenceupdate){
									$url1 = "StudentSelectFunction.php";
									header("Location:$url1");
								}else{
									 $A="Error";
								}
							}else
							{	
								$A = "Sorry!! Not updated";
							}
						}    
			}
		
			elseif($presentcheck == 'P')
			{
				$A = "You are already present!!";
			}
			else
			{
				$addpresence = $presence+1;
				
				$studentupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Student_Type` = 'P', `Current_Date` = CURDATE(), `Student_Current_Time` = CURTIME() WHERE Allocate_Id = '$allocateid' 										AND Date = '$currentdate' ");
				if($studentupdate)
				{
					$presenceupdate = mysql_query("UPDATE Student SET Presence = '$addpresence' WHERE Student_Poly_Id = '$studentid' ");
					if($presenceupdate)
					{
						$url1 = "StudentSelectFunction.php";
						header("Location:$url1");
					}
					else
					{
						$A = "Error";
					}
				}
				else
				{
					$A = "Not updated";
				}
			}
		}
		
		else
		{
			$Confirm = "Sorry!! no Session found";
		}

		
	 ?>
	 <?php echo "$Confirm"; ?>
	 <br><br>
	 <input type="submit" value="Done" name="done">
	 
	<?php
		if(isset($_POST["done"]))
		{
			$url1 = "StudentSelectFunction.php?var1=$studentid&var2=$day";
			header("Location:$url1");
		}
		
	?>	
	<div class = "mesg"><?php echo "$err"; ?></div>
	<div class = "mesg2"><?php echo "$A"; ?></div>

</center>
</div>
</div>
</form>
</div>

</body>
</html>