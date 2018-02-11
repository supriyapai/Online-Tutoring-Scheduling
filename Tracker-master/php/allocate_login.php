<!-- This page displays livereport based on the time -->
<!--Author: Kishan -->
<?php
            include '../Rules/dbconfig.php';
?>
<?php
session_start(); // start up your PHP session! 
?>
<?php
if(isset($_POST["submit"]) )
	{
            $user = $_POST["userid"];
            $pass = md5($_POST["password"]);//computing MD5 of the password provided by the user
           
			$username1 = mysql_query("SELECT Username, `Password`, SemRefreshAccess FROM Admin_LogIn where Username='$user'");
            $username2 = mysql_fetch_array($username1);
            $username = $username2["Username"];
            $password = $username2["Password"];
			$semRefreshAccess = $username2["SemRefreshAccess"];
            $E=$username;
            
            //echo "<br>".$semRefreshAccess."</br>";
             if($username == $user AND $semRefreshAccess==1)
            {
				$_SESSION["username"] = $user;
				$_SESSION["password"] = $pass;
				header("Location: Allocate_entry.php");
				exit;
			}
			else{
				$A = 'Unauthorized. Please login using super username and password';
				//exit;
			} 
	}
	
?>
<html>
<head>
<!-- The information of the title -->
    <title>Allocate Session</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	
<!-- Refresh the page in 60 seconds -->
	<meta http-equiv="refresh" content="60">
	
<!-- CSS stylesheet -->
<link rel="stylesheet" type="text/css" href="../css/reports.css" />
</head>

<!-- The Page will refresh in every 60 seconds -->
<body>

<!-- The outline of the tracker -->
    <div id="container" class =" scroll">
    <div class="menu">
         <ul>
             <li><a class="hide" href="">INPUT</a>
                 <ul>
                     <li><a href="CreateT.php" >Tutor Information</a></li>
                     <li><a href="CreateS.php" >Student Information</a></li>
                     <li><a href="Allocate.php" >Student-Tutor Allocation</a></li>
                     <li><a href="Course.php" >Course Information</a></li>
                 </ul>
             </li>

             <li><a class="hide" href="">EDIT</a>
                 <ul>
                     <li><a href="EditTutor.php" >Tutor Information</a></li>
                     <li><a href="EditStudent.php" >Student Information</a></li>
                     <li><a class="EditSession.php" >Student-Tutor Allocation ></a>
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
                     <li><a href="EditCourse.php" >Course Information</a></li>
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
                     <li><a href="StudentBlock.php" >Student Block/Unblock</a></li>
                     <li><a href="TutorBlock.php" >Tutor Block/Unblock</a></li>
                     <li><a href="SessionDrop.php" >Drop Session</a></li>
                 </ul>
             </li>

              <li><a class="hide" href="">DATA MANAGEMENT</a>
			     <ul>
                        <li><a href="#" >Save ></a>
                        <ul>
						      <li><a href="SaveStudent.php" >Student</a></li>
                              <li><a href="SaveTutor.php">Tutor</a></li>
						</ul>
						</li>
                        
                        <li><a href="#" >Bulk Changes > </a>
					    <ul>
                     	      <li><a href="bulkstudent.php" >Student</a></li>
                              <li><a href="bulktutor.php">Tutor</a></li>
                         </ul>
					    </li>
                      
					    <li><a href="refresh.php" >New Semester Refresh</a></li>
                     <li><a href="#" >Delete ></a>
					 <ul>
					        <li><a href="DeleteS_Nav.php" >Student</a></li>
                            <li><a href="DeleteT_Nav.php">Tutor</a></li>
					 </ul>
					 </li>
                 </ul>
             </li>

             <li><a class="hide" href=" ">ACCOUNT MANAGEMENT</a>
                 <ul>
                     <li><a class="hide">Email ></a>
                         <ul>
                             <li><a href="EditEmail.php" >Change Email Address</a></li>
                             <li><a href="EditSubject.php">Change Email Subject</a></li>
                             <li><a href="EditContext.php">Change Email Content</a></li>
                         </ul>
                     </li>
                     <li><a href="AccountManagement.php" >Password</a></li>
                 </ul>
             </li>

            <li><a class="hide" href="livereport.php">LIVE REPORT</a></li>

           </ul>
        </div>

		<div id="banner">
        <img src="../images/banner2.png"  width="1022" height="150" border="none"/>
	    </div>
	    
        <div id="signout">
        <img src="../images/adminlogin.png"  width="17" height="15" border="none"/>
		</div>
		<div id="text2">
		
		<!-- The report title -->
		<center>
	    <!--<p>Login for New Semester Refresh</p>-->
	    </div>
        <div id="text3">
		</center>
		<!-- Sign out button -->
		<a href="Adminlogon.php"><p>Sign Out</p></a>
		</div> 

    <center>
		<div id="mainbody">
	    </div>
		<div id="inputboxbackground">
			</br></br>
			<h2><b>Login</b></h2>
			</br>
			<form  method="post">      
				
				<label for="name">Username : </label>
				<input type="text" id="name" name="userid" placeholder="username" />
				</br>
		
				<label for="name">Password : </label>
				<input type="password" id="name" name="password" placeholder="password" />
				<br><br>
                <center><button type="submit" name="submit" value="Log In"><img src="../images/submit.png"  width="102" height="28" style="border:0" /></button></center><br> 
				<!-- <font size="2"><a href="RefreshChangePassword.php">Change Password</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="RefreshForgotPassword.php">Forgot Password?</a></font> -->
                <center><?php echo $A; ?></center>
			</form>
	    </div>
	</center>
	</div>
	</div>
</body>
</html>