<html>
 <head>
        <title>Tutor Sign In</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="../css/studentblock.css" />
</head>
<body>
<div id="container">
	<div id="banner"><img src="../images/banner2.png"  width="1022" height="150" border="none"/></div>
	<div id="signout"><img src="../images/adminlogin.png" width="17" height="15" border="none" /></div>
	<div id="text2"><p>&nbsp &nbsp &nbsp Tutor Sign In</p></div>
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div> 
	<br><br><br>
	<center>
	<div class="ex">
	<div class="back">
	<form action ="<?php $PHP_SELF; ?>" method = "post">
	<br><br><br>
<?php
	include '../Rules/dbconfig.php';
	$tutorid = $_GET["var1"];
 	$day = $_GET["var2"];
 	$sessiontime = $_GET["var3"];
 	$allocateid = $_GET["var4"];
 	$currentdate=date("Y-m-d");    
      
	$presence1 = mysql_query("SELECT Presence FROM Tutor WHERE Tutor_Poly_Id = '$tutorid' ");
	$presence2 = mysql_fetch_array($presence1);
	$presence = $presence2[0];
	
 	$sessiondetails1 = mysql_query("SELECT Student_Poly_Id, `Subject` FROM Student_Tutor_Allocation_Main WHERE Allocate_Id = '$allocateid' ");
 	$sessiondetails2 = mysql_fetch_array($sessiondetails1);
 	
 	$studentid = $sessiondetails2[Student_Poly_Id];
 	$subjectid = $sessiondetails2[Subject];
 	
 	$check1 = mysql_query("SELECT Assignment_Id, `Session_Type` FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' AND Session_Time = '$sessiontime' ");
 	$check2 = mysql_fetch_array($check1);
 	$check = $check2[Assignment_Id];
 	$sessioncheck = $check2[Session_Type];
 	
 	if($check1){
 		$presentcheck1 = mysql_query("SELECT Tutor_Type FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' ");
 		$presentcheck2 = mysql_fetch_array($presentcheck1);
 		$presentcheck = $presentcheck2[0];
 		//Code change begin C1: Done by Shyam Joshi, Condition modified to consider empty and null values for the Session_Type entry in the database.  
 		if($sessioncheck != ' ' and (!(empty($sessioncheck))) and  (!(is_null($sessioncheck))) ){ 
        //Code change End C1: Shyam Joshi		
		//Added By: Kishan
					if($presentcheck == 'N/S'){
                        $Confirm = "You Can Not Sign In, because you are a No Show";
                    }
					//Added By: Kishan
                    elseif($sessioncheck == 'E' AND $presentcheck != 'N/S') {
						$addpresence = $presence+1;
						$tutorupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'P', `Current_Date` = CURDATE(), `Tutor_Current_Time` = CURTIME() WHERE Tutor_Poly_Id = '$tutorid' AND Session_Time = '$sessiontime' AND Date = '$currentdate' ");
						//$tutorupdate1 = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'P', `Current_Date` = CURDATE(), `Tutor_Current_Time` = CURTIME() WHERE Allocate_Id = '$allocateid1' AND Date = '$currentdate' ");
						if($tutorupdate){
							$presenceupdate = mysql_query("UPDATE Tutor SET Presence = '$addpresence' WHERE Tutor_Poly_Id = '$tutorid' ");
							if($presenceupdate)
							{
								$url1 = "StudentSelectFunction.php";
								header("Location:$url1");
							}
							else
							{
								$A = "error";
							}	
						}
					}
					//Added By: Kishan
					elseif($sessioncheck == 'R' AND $presentcheck != 'N/S') 
                    {
						$addpresence = $presence+1;
						$tutorupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'P', `Current_Date` = CURDATE(), `Tutor_Current_Time` = CURTIME() WHERE Tutor_Poly_Id = '$tutorid' AND Session_Time = '$sessiontime' AND Date = '$currentdate' ");
						//$tutorupdate1 = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'P', `Current_Date` = CURDATE(), `Tutor_Current_Time` = CURTIME() WHERE Allocate_Id = '$allocateid1' AND Date = '$currentdate' ");
						if($tutorupdate)
						{
							$presenceupdate = mysql_query("UPDATE Tutor SET Presence = '$addpresence' WHERE Tutor_Poly_Id = '$tutorid' ");
							if($presenceupdate)
							{
								$url1 = "StudentSelectFunction.php";
								header("Location:$url1");
							}
							else
							{
								$A = "error";
							}	
						}
                    }    
			
 		}
 		
 		elseif($presentcheck == 'P')
 		{
 			$Confirm =  "You are already present";
 		}
		else
 		{
 			$addpresence = $presence+1;
			$tutorupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'P', `Current_Date` = CURDATE(), `Tutor_Current_Time` = CURTIME() WHERE Tutor_Poly_Id = '$tutorid' AND Session_Time = '$sessiontime' AND Date = '$currentdate' ");
            //$tutorupdate1 = mysql_query("UPDATE `Student_Tutor_Assignment` SET `Tutor_Type` = 'P', `Current_Date` = CURDATE(), `Tutor_Current_Time` = CURTIME() WHERE Allocate_Id = '$allocateid1' AND Date = '$currentdate' ");
 			if($tutorupdate)
 			{
 				$presenceupdate = mysql_query("UPDATE Tutor SET Presence = '$addpresence' WHERE Tutor_Poly_Id = '$tutorid' ");
 				if($presenceupdate)
 				{
 					$url1 = "StudentSelectFunction.php";
					header("Location:$url1");
 				}
 				else
 				{
 					$A = "error";
 				}
 			}
 		}
 	}

	else
 	{
 		$tutorinsert = mysql_query("INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`, `Student_Poly_Id`,`Tutor_Poly_Id`, `Subject_Id`, `Session_Time`,`Current_Date`, `Student_Current_Time`, `Day`, `Tutor_Type`)  VALUES ('$allocateid', '$studentid', '$tutorid', '$subjectid','$sessiontime', CURDATE(), CURTIME(), '$day', 'P') ");
 		if($tutorinsert)
 		{
 		
 			$presenceupdate = mysql_query("UPDATE Tutor SET Presence = '$addpresence' WHERE Tutor_Poly_Id = '$tutorid' ");
 				if($presenceupdate)
 				{
 					$url1 = "StudentSelectFunction.php";
					header("Location:$url1");
 				}
 				else
 				{
 					$A =  "error";
 				}

 		}
  	}

 	
?>

<?php echo "$Confirm"?>
<br><br>
<input type="submit" value="Done" name="done">
 
<?php
	if(isset($_POST["done"]))
	{
		$url1 = "StudentSelectFunction.php?var1=$tutorid&var2=$day";
		header("Location:$url1");
	}
	
?>	
<div class = "mesg"><?php echo "$err"; ?></div>
	<div class = "mesg2"><?php echo "$A"; ?></div>
 </center>
 </form>
 </body>
 </html>