<?php	include 'LoginCheck.php'; ?>
<?php	
	//session_start(); // start up your PHP session! 
	include '../Rules/dbconfig.php';
	include '../Rules/datepicker.php';
	include '../Rules/days.php';
	date_default_timezone_set('America/New_York');
	
?>

<?php
if (isset($_POST["override"])){
	echo "Inside override";
/* 	var url = "Allocate.php?Student_Poly_Id="+Student_Poly_Id+"&Student_First_Name="+Student_First_Name+"&Student_Last_Name="
											+Student_Last_Name+"&Tutor_Poly_Id="+Tutor_Poly_Id+"&Tutor_First_Name="+Tutor_First_Name+"&Tutor_Last_Name="+Tutor_Last_Name+
											"&Subject="+Subject+"&Time="+Time+"&Day="+Day+"&Session_Start_Date="+Session_Start_Date+"&Session_End_Date="+Session_End_Date+"&override="+override
											;
	 */
	//mysql_query("VALUES ('$Sname', '$studentnamesfn', '$studentnamesln', '$Tname', '$tutornamesfn', '$tutornamesln',  '$subject', '$SessionTime', '$d2', '$SessionStart', '$SessionEnd' )");
	$Sname = $_POST['Student_Poly_Id'];
	$studentnamesfn = $_POST['Student_First_Name'];
	$studentnamesln = $_POST['Student_Last_Name'];
	$Tname = $_POST['Tutor_Poly_Id'];
	$tutornamesfn = $_POST['Tutor_First_Name'];
	$tutornamesln = $_POST['Tutor_Last_Name'];
	$SessionType = $_POST['SessionType'];
	$subject = $_POST['Subject'];
	$SessionTime = $_POST['Time'];
	$d2 = $_POST['Day'];
	$SessionStart = $_POST['Session_Start_Date'];
	$SessionEnd = $_POST['Session_End_Date'];
	$diffweek = abs(strtotime($SessionStart) - strtotime($SessionEnd)) / 604800;
    $number = intval($diffweek);
	           $insert = mysql_query("INSERT INTO `Student_Tutor_Allocation_Main`(`Student_Poly_Id`, `Student_First_Name`, `Student_Last_Name`, `Tutor_Poly_Id`, `Tutor_First_Name`, `Tutor_Last_Name`,  `Subject`, `Time`, `Day`, `Session_Start_Date`, `Session_End_Date`) VALUES ('$Sname', '$studentnamesfn', '$studentnamesln', '$Tname', '$tutornamesfn', '$tutornamesln',  '$subject', '$SessionTime', '$d2', '$SessionStart', '$SessionEnd' )");

            $allocateid1 = mysql_query("SELECT Allocate_Id FROM Student_Tutor_Allocation_Main WHERE Student_Poly_Id = '$Sname' AND (Time = '$SessionTime' AND Day = '$d2') ");
            $allocateid2 = mysql_fetch_array($allocateid1);
            $allocateid = $allocateid2[0];

            if ($insert) {
                $query2 = mysql_query("SELECT * FROM Student WHERE Student_Poly_Id = '$Sname'");
                $query3 = mysql_fetch_array($query2);
                $sub1 = $query3['Subject_1'];
                $sub2 = $query3['Subject_2'];
                $sub3 = $query3['Subject_3'];
                $sub4 = $query3['Subject_4'];
                $sub5 = $query3['Subject_5'];
                $sub6 = $query3['Subject_6'];
                if ($sub1 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_1 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub2 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_2 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub3 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_3 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub4 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_4 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub5 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_5 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                }
                elseif($sub6 == 0) {
                    $subinsert = mysql_query("UPDATE Student SET Subject_6 = '$subject' WHERE Student_Poly_Id = '$Sname'");
                    //break;
                } else {
                    //$A = "The student is allocated to 6 subjects";
                    //break;
                }

                $r = get_days($SessionStart, $SessionEnd);
				$emailflag = false;
                for ($i = 0; $i <= $number + 1; $i++) {
                    $newday1 = mysql_query("SELECT DAYOFWEEK('$r[$i]')");
                    $newday2 = mysql_fetch_array($newday1);
                    $newday = $newday2[0];
                    $query = mysql_query("INSERT INTO `Student_Tutor_Assignment`(`Allocate_Id`,`Student_Poly_Id`, `Tutor_Poly_Id`, `Subject_Id`, `Session_Time`, `Date`, `Day`,`Session_Type`) VALUES	('$allocateid', '$Sname', '$Tname', '$subject', '$SessionTime', '$r[$i]', '$newday','$SessionType') ");
   
                if ($query) {
					$emailflag = true;
                    $B = "Session Allocated and Assigned. Please enter another or exit";

                } else {
					$A = "Session Allocated But Not Assigned. Please enter another or exit";
                }
				}
				/* Begin of Code Change : Shyam Rajendra Joshi September 20,2016
Code added to send a mail when allocation is done.
*/
                    if($emailflag == true){
						
						$startconvo1 = $_POST['Session_Start_Date'];
						$startconvo2 = strtotime($startconvo1);
						$SessionStart = date('Y-m-d', $startconvo2);
						$endconvo1 = $_POST['Session_End_Date'];
						$endconvo2 = strtotime($endconvo1);
						$SessionEnd = date('Y-m-d', $endconvo2);
						
						$studentnames1 = mysql_query("SELECT `Student_First_Name`, `Student_Last_Name`, Student_Email FROM Student WHERE Student_Poly_Id = '$Sname' ");
						$studentnames2 = mysql_fetch_array($studentnames1);
						$studentnamesfn = $studentnames2['Student_First_Name'];
						$studentnamesln = $studentnames2['Student_Last_Name'];

						$tutornames1 = mysql_query("SELECT `Tutor_First_Name`, `Tutor_Last_Name`,`Tutor_Hours` , Tutor_Email FROM Tutor WHERE Tutor_Poly_Id = '$Tname' ");
						$tutornames2 = mysql_fetch_array($tutornames1);
						$tutornamesfn = $tutornames2['Tutor_First_Name'];
						$tutornamesln = $tutornames2['Tutor_Last_Name'];
						$tutorhours = $tutornames2['Tutor_Hours'];
						
						
						
						$subjectquery = mysql_query("select Subject from Subject where Subject_Id = $subject");
						$subjectname = mysql_fetch_array($subjectquery);
						$mailtimestamp = date("F j, Y, g:i a");
                        print_r($tutornames2);
						print_r($studentnames2);
						print_r($startconvo2);
						print_r($endconvo2);
						print_r($SessionTime);
						$to = $tutornames2['Tutor_Email'].",".$studentnames2['Student_Email'].",".'fitltech@nyu.edu,jb3372@nyu.edu,trionyupoly@gmail.com,pb494@nyu.edu,srl446@nyu.edu';
						
						$subjectEmail = 'TRIO​ Scholars​ Tutoring ​Schedule​ for '. $subjectname['Subject'];
						$sessionbegindate = date('l,F j, Y', $startconvo2);
						$sessionenddate = date('l,F j, Y', $endconvo2);
						
						$sessionemailtime = date('g:i a', strtotime($SessionTime));
						$message = "Below please find your tutoring schedule for ". $subjectname['Subject']." \r\n Tutor : $tutornames2[Tutor_First_Name]  $tutornames2[Tutor_Last_Name] \r\n Student : $studentnames2[Student_First_Name] $studentnames2[Student_Last_Name] \r\n Subject : $subjectname[Subject] \r\n Time  : $sessionemailtime \r\n Start Date : $sessionbegindate \r\n End Date : $sessionenddate \r\nAll tutoring sessions will take place in the TRIO Scholars Office (LC253).  If you have any questions about your tutoring schedule, please contact the TRIO Scholars Office at 646-997-3560.\r\n​Thank you,\r\nTRIO Scholars Program\r\n​[$mailtimestamp]\r\n";
						$headers = 'From: TRIO Program <trionyupoly@gmail.com>' . "\r\n";					
						mail($to, $subjectEmail, $message, $headers, '-f trionyupoly@gmail.com');
					}
/* End of Code Change : Shyam Rajendra Joshi September 20,2016
*/
            } else {
                $A = "Session not Allocated";
            }
}

?>