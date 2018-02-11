<!--Edited By: Parul Joshi Dated: 09/02/2015 Task : to add the HTML code in this page and correctly place the confirmation msg -->
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
	<div id="text3"><a href="Adminlogon.php"><p>Sign Out</p></a></div> 
	<br><br><br>
	<center>
	<div class="ex">
	<div class="back">
<form action ="<?php $PHP_SELF; ?>" method = "post">
<table border="1">
<tr>
<?php

	$tutorid = $_GET["var1"];
 	$day = $_GET["var2"];
 	$sessiontime = $_GET["var3"];
 	$allocateid = $_GET["var4"];
 	
 	include '../Rules/dbconfig.php';
 	
 	$currentdate=date("Y-m-d");

 	$sessiondetails1 = mysql_query("SELECT Student_Poly_Id, `Subject`, `Tutor_Late_Count` FROM Student_Tutor_Allocation_Main WHERE Allocate_Id = '$allocateid' ");
 	$sessiondetails2 = mysql_fetch_array($sessiondetails1);
 	
 	$studentid = $sessiondetails2[Student_Poly_Id];
 	$subjectid = $sessiondetails2[Subject];
 	$allocatedtutorlatecount = $sessiondetails2[Tutor_Late_Count];
	
	$tutorlateness1 = mysql_query("SELECT Lateness, `Tutor_Email` FROM Tutor WHERE Tutor_Poly_Id = '$tutorid'");
	$tutorlateness2 = mysql_fetch_array($tutorlateness1);
	$tutorlateness = $tutorlateness2[Lateness];
        $tutoremail = $tutorlateness2[Tutor_Email];
	
	$assignmentcheck1 = mysql_query("SELECT Assignment_Id FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' ");
 	$assignmentcheck2 = mysql_fetch_array($assignmentcheck1);
 	$assignmentcheck = $assignmentcheck2[0];
        
        
 	
 	if($assignmentcheck)
	{
		$check1 = mysql_query("SELECT Tutor_Type, `Student_Type`, `Session_Type` FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' Session_Time = '$sessiontime' ");
		$check2 = mysql_fetch_array($check1);
		$check = $check2[Student_Type];
		$checktutor = $check2[Tutor_Type];
		$sessioncheck = $check2[Session_Type];
		
				
		if($checktutor == 'P' || $checktutor == 'L')
		{
			$A= "You have allready been signed In<br><br>";
			//echo "<td><br><br><input type='submit' name='done' value='Done'></td>";
			if(isset($_POST["done"]))
			{
				$url1 = "StudentSelectFunction.php";
				header("Location:$url1");
			}
		
		}
		
		elseif($checktutor == 'N/S')
		{
			$A= "The Student Has Signed Out";
			//echo "<td><br><br><input type='submit' name='done' value='Done'></td>";
			if(isset($_POST["done"]))
			{
				$url1 = "StudentSelectFunction.php";
				header("Location:$url1");
			}
		}
		
		else
		{
				$tutorupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET Tutor_Type = 'L', `Current_Date` = CURDATE(), `Tutor_Current_Time` = CURTIME() WHERE Tutor_Poly_Id = '$tutorid' AND Session_Time = '$sessiontime' AND Date 	= '$currentdate' ");
				
				if($tutorupdate)
				{
				
					$addallocatedtutorlatecount = $allocatedtutorlatecount+1;
					$addtutorlateness = $tutorlateness+1;
                                        
                                        $latemod = $addallocatedtutorlatecount%4;
                                        if($latemod==0)
                                        {
                                            $blocktutor = mysql_query("UPDATE Tutor SET Block='1' WHERE Tutor_Poly_Id = '$tutorid' ");
                                            if($blocktutor)
                                            {
                                            $to = "trionyupoly@gmail.com".","."amehta02@students.poly.edu".","."$tutoremail" ;
                                            $mailsub = "Tutor Block - Excessive Lateness";
                                            $mailbody = "You are receiving this email because you attempted to Sign In/Cancel - Reschedule for a tutoring session and were blocked due to problematic attendance. Please speak to a TRIO Staff member as soon as possible to get this problem resolved and return to tutoring.";
                                            mail($to, $mailsub, $mailbody);
                                            }
                                        }
					
					$mainallocation = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Late_Count = '$addallocatedtutorlatecount' WHERE Allocate_Id = '$allocateid' ");
					
					if($mainallocation)
					{
						$tutorlatecount = mysql_query("UPDATE Tutor SET Lateness = '$addtutorlateness' WHERE Tutor_Poly_Id = '$tutorid' ");
						
						if($tutorlatecount)
						{ 
							$url1 = "StudentSelectFunction.php";
							header("Location:$url1");
						}
						
						else 
						{
							$err= "Error";	
						}
						
					}
					else 
					{
						$err="Lateness Count error";	
					}
					
					
				}
				else 
				{
					$err="Database Error";	
				}

	}
	}
	

	else
	{
		$tutorinsert = mysql_query("INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`, `Student_Poly_Id`,`Tutor_Poly_Id`, `Subject_Id`, `Session_Time`,`Current_Date`, `Tutor_Current_Time`, `Day`, `Tutor_Type`)  VALUES ('$allocateid', '$studentid','$tutorid', '$subjectid','$sessiontime', CURDATE(), CURTIME(), '$day', 'L') ");
 		if($tutorinsert)
 		{
 			$addallocatedtutorlatecount = $allocatedtutorlatecount+1;
 			$addtutorlateness = $tutorlateness+1;
 			$mainallocation = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Tutor_Late_Count = '$addallocatedtutorlatecount' WHERE Allocate_Id = '$allocateid' ");
 			if($mainallocation)
 			{
 				$tutorlatecount = mysql_query("UPDATE Tutor SET Lateness = '$addtutorlateness' WHERE Tutor_Poly_Id = '$tutorid' ");
 				
 				if($tutorlatecount)
 				{ 
 					$url1 = "StudentSelectFunction.php";
 					header("Location:$url1");
 				}
 				
 				else 
 				{
 					$err= "Error";	
 				}
 				
 			}
 			else 
 			{
 				$err= "Lateness Count error";	
 			}
 		}

 	}

?>
</tr>
</table>
	<input type="submit" value="Done" name="done">
	<div class = "mesg"><?php echo "$err"; ?></div>
	<div class = "mesg2"><?php echo "$A"; ?></div>
</center>
</body>
</html>