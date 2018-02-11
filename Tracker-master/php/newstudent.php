<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../css/mainmenu.css" />
		
	</head>
<body>
<?php 
//Assigning the student id, current day, allocate id and the sessiontime
	$id = $_GET["var1"];
	$day = $_GET["var2"];
	$allocateid = $_GET["var3"];
	$time = $_GET["var4"];	  
 ?>
 
<?php
	include '../Rules/dbconfig.php';
	//include '../Rules/jQueryPlugins.php';
	//Select students first name last name and the block status from the student given the student poly id
	$StudentId1 = mysql_query("SELECT `Student_First_Name`, `Student_Last_Name`, `Block` FROM Student WHERE Student_Poly_Id = '$id' ");
	$StudentId2 = mysql_fetch_array($StudentId1);
	$Studentfn = $StudentId2[Student_First_Name];
	$Studentln = $StudentId2[Student_Last_Name];
	$Studentname = $Studentfn." ".$Studentln;
	$block = $StudentId2[Block];
	$currentDate = date("Y-m-d");
?>
<p>
<div id="container">
<br><br><br><br>
<div id="inputboxbackground"></div>
<div id="banner"><img src="../images/banner2.png"  width="1022" height="150" border="none"/></div>
<div id="line"></div> 
</p>
<div id="variable">
	<h4>
		<?php echo"<center>$Studentname</center>";	?>
	</h4>
</div>
<br><br><br>

<form action = "<?php $PHP_SELF; ?>" method = "post" >
<br><br>
<div style="z-index:800; position: relative;">
<?php
//If the Student Is blocked
if($block == 1){
    echo "<br><center><font size='3'>You Have Been Blocked. Please Contact A Staff Member</center.";
    echo '<center><a href="StudentSelectFunction.php"><br><br><br><br><button type="submit" name="done" value="Done"><img src="../images/mainpage.png"  width="102" height="28" border="none" /></button></a></center>';
    if( isset ($_POST['done'])){
        $page = "StudentSelectFunction.php";
        header("Location: $page");
    }    
}

//If the student is not blocked
else{
    //Select all the tutor poly id's, subjects and times on a current day for a particular student
    //$sessiondetails1 = mysql_query("SELECT Tutor_Poly_Id, `Subject`, `Time` FROM Student_Tutor_Allocation_Main WHERE Student_Poly_Id = '$id' AND Day = '$day' ");
     $sessiondetails1 = mysql_query("SELECT `Tutor_Poly_Id`, `Subject_Id`, `Session_Time` FROM `Student_Tutor_Assignment` WHERE `Student_Poly_Id` = '$id' AND Day = '$day' AND `Date`= '$currentDate' AND `Student_Type` != 'C' AND `Tutor_Type`!= 'C' ");
	while($sessiondetails2 = mysql_fetch_array($sessiondetails1) ){
	$tutorId[] = $sessiondetails2[Tutor_Poly_Id];
	$subjectId[] = $sessiondetails2[Subject_Id];
	$sessionTime[] = $sessiondetails2[Session_Time];
	$allocateid[] =  $sessiondetails2[Allocate_Id];    
    }
    $count1 = count($allocateid);

    //for all the returned allocate id's
    for($a=0; $a<$count1; $a++){
	//Get all the tutor names.
	$tutorDetails1 = mysql_query("SELECT Tutor_First_Name, `Tutor_Last_Name` FROM Tutor WHERE Tutor_Poly_Id = '$tutorId[$a]' ");
	while($tutorDetails2 = mysql_fetch_array($tutorDetails1)){
            $tutorFn[] = $tutorDetails2[Tutor_First_Name];
            $tutorLn[] = $tutorDetails2[Tutor_Last_Name];
	}
	$tutorName[] = $tutorFn[$a]." ".$tutorLn[$a];
    }
		
    for($b=0; $b<$count1; $b++){   
        //Gt all the subject names
        $subjectNames1 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subjectId[$b]' ");
	while($subjectNames2 = mysql_fetch_array($subjectNames1)){
            $subject[] = $subjectNames2[Subject];
	}
}    
?>
<table border="0">
<tr>
<td>
<font size="4"> Session: </td>
	<td>
	<select name="sessiontime">
		<?php
				echo "<option>---SELECT---</option>";
				for($z=0; $z<$count1; $z++){
					echo "<option value='$sessionTime[$z]'> $sessionTime[$z], $tutorName[$z], $subject[$z] </option>";
				}
		?>
	</select>
	</td>
</tr>
</table><br/>
</font>
</form>

<div id="submit"><button type="submit" name="signin" value="Sign in"><img src="../images/signin.png"  width="102" height="28" border="none"/></button></div>

<div id="back"><button type="submit" name="done" value="Done"><img src="../images/mainpage.png"  width="102" height="28" border="none"/></button>
</div>
<?php

//If You press the Sign In button
if( isset ($_POST["signin"]) ){	
    $sessiontime = $_POST["sessiontime"];
    $currentdate=date("Y-m-d");
    
    //If no Session Is Selected
    if($sessiontime == "---SELECT---")
    {?><?php
	$error= '<p class="errText"><center>Please Select A Session</center>';
	echo "$error";
    }
    
    else
    {
/* Code change Begin: Shyam Joshi
// Commented below query since it was fetching wrong allocationid. Students were not able to sign in for rescheduled sessions				
	$allocationid1 = mysql_query("SELECT Allocate_Id FROM Student_Tutor_Allocation_Main WHERE Student_Poly_Id = '$id' AND Day='$day' AND Time = '$sessiontime' ");
	$allocationid2 = mysql_fetch_array($allocationid1);
	$allocationid = $allocationid2[0];
	
        //Check the student type for the current session
        $presentcheck1 = mysql_query("SELECT Student_Type FROM Student_Tutor_Assignment WHERE Allocate_Id='$allocationid' AND `Session_Time` = '$sessiontime' AND `Date` = '$currentdate' ");
        $presentcheck2 = mysql_fetch_array($presentcheck1);
        $presentcheck = $presentcheck2[0];
*/
        $presentcheck1 = mysql_query("
		SELECT * FROM Student_Tutor_Assignment 
		WHERE Student_Poly_Id = '$id' AND Day= '$day'
		AND `Session_Time` = '$sessiontime' AND `Date` = '$currentdate'  ;
		");
        $presentcheck2 = mysql_fetch_array($presentcheck1);
        $presentcheck = $presentcheck2[Student_Type];
		$allocationid = $presentcheck2[Allocate_Id];        
        //check if the student is allready signed in
        if($presentcheck == 'P' || $presentcheck == 'L')
        {
            $error= '<p class="errText"><center>You Have Already Signed In</center>';
          	echo "$error";
        }
        //if not
        else
        {
            //Add 15 minutes to the session
            $addsessiontime151 = mysql_query("SELECT ADDTIME('$sessiontime', '00:15:00')");
            $addsessiontime152 = mysql_fetch_array($addsessiontime151);
            $addsessiontime15 = $addsessiontime152[0];
				
            //Add 20 minutes to the session
            $addsessiontime201 = mysql_query("SELECT ADDTIME('$sessiontime', '00:20:00')");
            $addsessiontime202 = mysql_fetch_array($addsessiontime201);
            $addsessiontime20 = $addsessiontime202[0];
				
            //add 30 minutes to the session
            $addsessiontime301 = mysql_query("SELECT ADDTIME('$sessiontime', '00:30:00')");
            $addsessiontime302 = mysql_fetch_array($addsessiontime301);
            $addsessiontime30 = $addsessiontime302[0];
					
            //subtract 20 minutes from the session
            $subsessiontime201 = mysql_query("SELECT SUBTIME('$sessiontime', '00:20:00')");
            $subsessiontime202 = mysql_fetch_array($subsessiontime201);
            $subsessiontime20 = $subsessiontime202[0];
				
            //Select the current time stamp		
            $currenttime1 = mysql_query("SELECT Current_Time FROM Sign_In WHERE Poly_Id = '$id' ");
            $currenttime2 = mysql_fetch_array($currenttime1);
            $currenttime = $currenttime2[0];
			//echo "<br><br>ITS HERE $sessiontime";	
            //If the sign in time is between 20 minutes before and 15 minutes after the session time. then just update
            //Added By: Kishan
			//Previous Code: if($currenttime >= $subsessiontime20 AND  $currenttime <= $addsessiontime15)
			if($currenttime >= $subsessiontime20 AND  $currenttime <= $addsessiontime15)
            {	
            	$url1 = "Studentupdate.php?var1=$id&var2=$day&var3=$sessiontime&var4=$allocationid";
				header("Location:$url1");
				
            }	
            // Begin of code changes Shyam Rajendra Joshi 1st February 2017
			// Commented below code to remove lateness policy
			//As per new policy, It a No Show after 15 min and there is no more lateness policy
			//Old code comment starts
/*             
			//If the sign in time is between 15 to 20 minutes after the session time, then confirm and the sudent is late
            elseif($currenttime >=$addsessiontime15 AND $currenttime <= $addsessiontime20)
            {
				$url1 = "Studentconfirm.php?var1=$id&var2=$day&var3=$sessiontime&var4=$allocationid";
                header("Location:$url1");

            }
	    
            //If the Sign in time is between 20 to 30 minutes after the session time
            elseif($currenttime > $addsessiontime20 AND $currenttime <= $addsessiontime30)
            {
                $error= '<p class="errText"><center>Its too late to sign in for the session.</center>';
            	echo "$error";
            } */
            //Old Code comment ends
			//New code added
			elseif($currenttime > $addsessiontime15)
            {
                $error= '<p class="errText"><center>Its too late to sign in for the session. You are marked No Show (N/S)</center>';
            	echo "$error";
            } 
			//End of Code Changes Shyam Rajendra Joshi 1st February 2017
            //If the sign in time is greater than 30 minutes after the session time
            elseif($currenttime > $addsessiontime30)
            {
		         $error= '<p class="errText"><center>The session is over.</center>';
            	 echo "$error";
            }
				
            //If the sign in time is less than 20 minutes before the session time
            elseif($currenttime < $subsessiontime20)
            {
                $error= '<p class="errText"><center>The sign in period have not yet open.</center>';
            	echo "$error";
            }
	}
      }
    }
}
		
    if(isset($_POST["done"]) )
    {
	$url2 = "Signin.php";
	header("Location:$url2");
    }
				
				
?>
</center>
</body>
</html>
