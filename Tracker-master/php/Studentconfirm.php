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
	<center>
<form action ="<?php $PHP_SELF; ?>" method = "post">
<br><br><br><br><br><br>

<?php
	$studentid = $_GET["var1"];
 	$day = $_GET["var2"];
 	$sessiontime = $_GET["var3"];
 	$allocateid = $_GET["var4"];
 	
 	include '../Rules/dbconfig.php';
	
	$currentdate=date("Y-m-d");

	$sessiondetails1 = mysql_query("SELECT Tutor_Poly_Id, `Subject`, `Student_Late_Count` FROM Student_Tutor_Allocation_Main WHERE Allocate_Id = '$allocateid' ");
 	$sessiondetails2 = mysql_fetch_array($sessiondetails1);
 	
 	
 	$tutorid = $sessiondetails2[Tutor_Poly_Id];
 	$subjectid = $sessiondetails2[Subject];
 	$allocatedstudentlatecount = $sessiondetails2[Student_Late_Count];
 	
 	$studentlateness1 = mysql_query("SELECT Lateness, `Student_Email` FROM Student WHERE Student_Poly_Id = '$studentid'");
 	$studentlateness2 = mysql_fetch_array($studentlateness1);
 	$studentlateness = $studentlateness2[Lateness];
        $studentemail    = $studentlateness2[Student_Email];
 	
 	$assignmentcheck1 = mysql_query("SELECT Assignment_Id FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' ");
 	$assignmentcheck2 = mysql_fetch_array($assignmentcheck1);
 	$assignmentcheck = $assignmentcheck2[0];
 	
 	if($assignmentcheck)
	{
		$check1 = mysql_query("SELECT Tutor_Type, `Student_Type`, `Session_Type` FROM Student_Tutor_Assignment WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' Session_Time = '$sessiontime' ");
		$check2 = mysql_fetch_array($check1);
		$studentcheck = $check2[Student_Type];
		$tutorcheck = $check2[Tutor_Type];
		$sessioncheck = $check2[Session_Type];
		
		if($sessioncheck !='')
		{
                    if($studentcheck == 'N/S')
                    {
                        $A= "You Can Not Sign In, because you are a No Show";
                    }
                    else
                    {
 			$A= "You Can Not sign In, becaue your Session Type is: $sessioncheck";
                    }    
			//echo "Your Session Has Been $sessioncheck";
			//echo "<td><br><br><input type='submit' name='ok' value='Done'></td>";
			if(isset($_POST["done"]))
			{
				$url1 = "StudentSelectFunction.php?var1=$studentid&var2=$day";
				header("Location:$url1");
			}

		}
	
		elseif($studentcheck == 'P' || $studentcheck == 'L')
		{
			$A= "You have already been signed In<br><br>";
			//echo "<td><br><br><input type='submit' name='done' value='Done'></td>";
			if(isset($_POST["done"]))
			{
				$url1 = "StudentSelectFunction.php";
				header("Location:$url1");
			}
		
		}
		
		elseif($studentcheck == 'N/S')
		{
			$A= "The Tutor Has Signed Out";
			//echo "<td><br><br><input type='submit' name='done' value='Done'></td>";
			if(isset($_POST["done"]))
			{
				$url1 = "StudentSelectFunction.php";
				header("Location:$url1");
			}
		}
				
		else
		{
				$studentupdate = mysql_query("UPDATE `Student_Tutor_Assignment` SET Student_Type = 'L', `Current_Date` = CURDATE(), `Student_Current_Time` = CURTIME() WHERE Allocate_Id = '$allocateid' AND Date = '$currentdate' ");
				if($studentupdate)
				{
					$addallocatedstudentlatecount = $allocatedstudentlatecount+1;
					$addstudentlateness = $studentlateness+1;
					
					$latemod = $addallocatedstudentlatecount%4;
                                        if($latemod == 0)
                                        {
                                            $blockstudent = mysql_query("UPDATE Student SET Block='1' WHERE Student_Poly_Id = '$studentid' ");
                                            if($blockstudent)
                                            {
                                                $to = "trionyupoly@gmail.com".","."amehta02@students.poly.edu".","."$studentemail" ;
                                                $mailsub = "Student Block - Excessive Lateness";
                                                $mailbody = "You are receiving this email because you attempted to Sign In/Cancel - Reschedule for a tutoring session and were blocked due to problematic attendance. Please speak to a TRIO Staff member as soon as possible to get this problem resolved and return to tutoring.";
                                                mail($to, $mailsub, $mailbody);
                                            }
                                        }
					
					$mainallocationupdate = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Late_Count = '$addallocatedstudentlatecount' WHERE Allocate_Id = '$allocateid' ");
					if($mainallocationupdate)
					{
						$studentlatecount = mysql_query("UPDATE Student SET Lateness = '$addstudentlateness' WHERE Student_Poly_Id = '$studentid' ");
					
						if($studentlatecount)
						{	 
							$url1 = "StudentSelectFunction.php";
							header("Location:$url1");
						}
						else 
						{
							$A= "Error";	
						}
					}
					else 
					{
						$A= "Lateness Count Error";	
					}
					
				}
				else 
				{
					$A= "Database Update Error";	
				}
		}
	}
				
			
	else
		{
			$studentinsert = mysql_query("INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`, `Student_Poly_Id`,`Tutor_Poly_Id`, `Subject_Id`, `Session_Time`,`Current_Date`, `Tutor_Current_Time`, `Day`, `Student_Type`)  VALUES ('$allocateid', '$studentid','$tutorid', '$subjectid','$sessiontime', CURDATE(), CURTIME(), '$day', 'L') ");
	 		if($Studentinsert)
	 		{
	 			$addallocatedstudentlatecount = $allocatedstudentlatecount+1;
	 			$addstudentlateness = $studentlateness+1;
	 			$mainallocationupdate = mysql_query("UPDATE Student_Tutor_Allocation_Main SET Student_Late_Count = '$addallocatedstudentlatecount' WHERE Allocate_Id = '$allocateid' ");
	 			if($mainallocationupdate)
	 			{
	 				$studentlatecount = mysql_query("UPDATE Student SET Lateness = '$addstudentlateness' WHERE Student_Poly_Id = '$studentid' ");
	 			
	 				if($studentlatecount)
	 				{	 
	 					$url1 = "StudentSelectFunction.php";
	 					header("Location:$url1");
	 				}
	 				else 
	 				{
	 					$A= "Error";	
	 				}
	 			}
	 			
	 		}
	 		
	
	 	}
	
?>
	 <input type="submit" value="Done" name="done">
	 
	<div class = "mesg"><?php echo "$err"; ?></div>
	<div class = "mesg2"><?php echo "$A"; ?></div>
</center>
</body>
</html>