<?php include '../Rules/dbconfig.php'; ?>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../css/listing.css" />
</head>
<body>
<div id="container">
	<div id="banner"><img src="../images/banner2.png"  width="1022" height="150" border="none"/></div>
	<div id="line"></div> 
	<div id="inputboxbackground"></div>
	<div id="ex">
	<form action = "<?php $PHP_SELF; ?>" method = "post" >
	<br><br>
	<div id="ptitle" style="z-index:800; position: relative;">
<?php
	$polyid = $_GET["var1"];
	$currentdate=date("Y-m-d");
	$studentfullname1 = mysql_query("SELECT Student_First_Name, `Student_Last_Name` FROM Student WHERE Student_Poly_Id = '$polyid' ");
	$studentfullname2 = mysql_fetch_array($studentfullname1);
	$studentfirstname[] = $studentfullname2[Student_First_Name];
	$studentlastname[] = $studentfullname2[Student_Last_Name];
	$studentfullname = $studentfirstname[0]." ".$studentlastname[0];
		
	$tutorfullname1 = mysql_query("SELECT Tutor_First_Name, `Tutor_Last_Name` FROM Tutor WHERE `Tutor_Poly_Id` = '$polyid' ");
	$tutorfullname2 = mysql_fetch_array($tutorfullname1);
	$tutorfirstname[] = $tutorfullname2[Tutor_First_Name];
	$tutorlastname[] = $tutorfullname2[Tutor_Last_Name];
	$tutorfullname = $tutorfirstname[0]." ".$tutorlastname[0];
        
        if($studentfullname != " ")
        {
            echo "<center><h4>$studentfullname</h4></center>";
        }
        elseif($tutorfullname != " ")
        {
            echo "<center><h4>$tutorfullname</h4></center>";
            
        }

	if($studentfullname != " ")
	{
		
		//echo "$studentfullname<br>";
		$studentlisting1 = mysql_query("SELECT *  FROM Student_Tutor_Assignment WHERE Date = '$currentdate' AND Student_Poly_Id = '$polyid' ");
		while($studentlisting2 = mysql_fetch_array($studentlisting1))
		{
	
			$tutorid[] = $studentlisting2[Tutor_Poly_Id];
			$Ssubjectid[] = $studentlisting2[Subject_Id];
			$Ssessiontime[] = $studentlisting2[Session_Time];
			$Sassignmentid[] = $studentlisting2[Assignment_Id];
		
		}
		
		
		$count = count($Sassignmentid);
		
		
		if($count==0)
		{?></div><br><br>
		
		<div id="listing" style="z-index:800; position: relative;">
		<?php
			echo "<center>You don't have any sessions as a student today!!!</center>";
		}
		
		else
		{
			$no = count($Sassignmentid);
			
			for ($a=0; $a<$no; $a++)
			{
				
				$tutorname1 = mysql_query("SELECT `Tutor_First_Name`, `Tutor_Last_Name` FROM Tutor WHERE Tutor_Poly_Id = '$tutorid[$a]' ");
				while($tutorname2 = mysql_fetch_array($tutorname1))
				{
					$tutorfn[] = $tutorname2[Tutor_First_Name];
					$tutorln[] = $tutorname2[Tutor_Last_Name];
				}
				$tutorname[] = $tutorfn[$a]." ".$tutorln[$a];
				
				$subjectname1 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$Ssubjectid[$a]' ");
				while($subjectname2 = mysql_fetch_array($subjectname1))
				{
					$Ssubjectname[] = $subjectname2[Subject];
				}
			}

			
			echo "<br><br><br><br><br><center>Your Sessions as a student today </center>";
			echo "<center><table border='0'>";
			echo "<tr>";
			echo "<td>";
			echo "<select>";
		
			for($i=0; $i<$no;$i++)
			{
				echo "<option><center>$tutorname[$i], $Ssubjectname[$i], $Ssessiontime[$i]</center></option>";
			}
		
			echo "</select>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
		}
			
	}
	
	
	if($tutorfullname != " ")
	{
	
		//echo "$tutorfullname<br><br>";
		
			$tutorlisting1 = mysql_query("SELECT Student_Poly_Id, `Subject_Id`, `Session_Time`, `Assignment_Id`  FROM Student_Tutor_Assignment WHERE Date = '$currentdate' AND Tutor_Poly_Id = '$polyid' ");
			while($tutorlisting2 = mysql_fetch_array($tutorlisting1))
			{
	
				$studentid[] = $tutorlisting2[Student_Poly_Id];
				$Tsubjectid[] = $tutorlisting2[Subject_Id];
				$Tsessiontime[] = $tutorlisting2[Session_Time];
				$Tassignmentid[] = $tutorlisting2[Assignment_Id];
	
			}
			
			$count2 = count($Tassignmentid);
			
			if($count2 == 0)
			{
				echo "<br><br><br><br><br><center>You don't have any sessions as a tutor today!!!</center>";
			}
	
			else
			{
			
				$no1 = count($Tassignmentid);
				
				
				for($b=0; $b<$no1; $b++)
				{
					
					$studentname1 = mysql_query("Select Student_First_Name, `Student_Last_Name` FROM Student WHERE Student_Poly_Id = '$studentid[$b]' ");
					while($studentname2 = mysql_fetch_array($studentname1))
					{
						
						$studentfn[] = $studentname2[Student_First_Name];
						$studentln[] = $studentname2[Student_Last_Name];
					}
					
					$name[] = $studentfn[$b]." ".$studentln[$b];
					
		
					$subjectname1 = mysql_query("Select Subject FROM Subject WHERE Subject_Id = '$Tsubjectid[$b]' ");
					while($subjectname2 = mysql_fetch_array($subjectname1))
					{
						$Tsubjectname[] = $subjectname2[Subject];
					}

				}
			
				echo "<br><br><br><br><br><center>Your Sessions as a tutor Today</center>";
				echo "<center><table border='0'>";
				echo "<tr>";
				echo "<td>";
				echo "<select>";
			
				for($j=0; $j<$no1; $j++)
				{
					echo "<option><center>$name[$j], $Tsubjectname[$j], $Tsessiontime[$j]</center></option>";
				}
		
				echo "</select>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";


			}
	}

?>	
</div>

</div>
		
<br><br>		
<div id="back">
<button type="submit" name="done" value="Done"><img src="../images/mainpage.png"  width="102" height="28" border="none"/></button></div>

<?php
	if(isset($_POST["done"]))
	{
		$url1 = "StudentSelectFunction.php";
		header("Location:$url1");
	 }

?>
</div>
</body>
</html>
