<?php
	include '../Rules/dbconfig.php';      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Sign In</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/signin.css" />
    </head>
<body>
<?php				
if (isset($_POST["myschedule"])) {
    $id = $_POST["poly_id"];
    $flag = 0;
    //Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
    if (preg_match("/^\d{8}$/", $_POST["poly_id"]) === 0) {
        //Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
        //Actual code: $A = 'Poly ID must be 7 digits</p>';
        $A = 'University N Number must be 8 digits</p>';
        //echo "$error";
    } else {
        $delete = mysql_query("DELETE FROM Sign_In WHERE Poly_Id = '$id' ");
        $result = mysql_query(" INSERT INTO `Sign_In`(Poly_Id, `Current_Time`, `Current_Date`) VALUES ('$id', CURTIME(), CURDATE()) ");
        $currentdate1 = mysql_query(" SELECT Current_Date FROM Sign_In WHERE Poly_Id = '$id' ");
        $currentdate2 = mysql_fetch_array($currentdate1);
        $currentdate = $currentdate2[0];
        $d = mysql_query("SELECT DAYOFWEEK(`Current_Date`)FROM Sign_In WHERE Poly_Id = '$id'");
        $d1 = mysql_fetch_array($d);
        $d2 = $d1[0];
        $b = mysql_query("SELECT ADDTIME(`Current_Time`, '00:29:00') FROM Sign_In WHERE Poly_Id = '$id'");
        $b1 = mysql_fetch_array($b);
        $b2 = $b1[0];
        $c = mysql_query("SELECT SUBTIME(`Current_Time`, '00:29:00') FROM Sign_In WHERE Poly_Id = '$id' ");
        $c1 = mysql_fetch_array($c);
        $c2 = $c1[0];
        $records1 = mysql_query(" SELECT * FROM Student_Tutor_Allocation_Main WHERE Day='$d2' AND (Time > '$c2' AND Time < '$b2') ");
        while ($records2 = mysql_fetch_array($records1)) {
            $record1[] = $records2[Student_Poly_Id];
            $record2[] = $records2[Tutor_Poly_Id];
            $record3[] = $records2[Allocate_Id];
            $record4[] = $records2[Time];
        }
        $count1 = count($record1);
        $count2 = count($record2);
        if ($count1 == 0) {
            $B = "There are no sessions at this time!!";
        } else {
            for ($i = 0; $i < $count1; $i++) {
                if ($record1[$i] == $id) {
                    $flag = 1;
                    $present1 = mysql_query("SELECT `Student_Type` FROM Student_Tutor_Assignment WHERE `Allocate_Id` = '$record3[$i]' AND `Student_Poly_Id` = '$id' AND `Date` = '$currentdate' AND `Session_Time` = '$record4[$i]' ");
                    $present2 = mysql_fetch_array($present1);
                    $present = $present2[0];
                    $url1 = "newstudent.php?var1=$id&var2=$d2";
                    header("Location:$url1");
                } else if ($record2[$i] == $id) {
                    $flag = 1;
                    $present1 = mysql_query("SELECT `Tutor_Type` FROM Student_Tutor_Assignment WHERE `Allocate_Id` = '$record3[$i]' AND `Tutor_Poly_Id` = '$id' AND `Date` = '$currentdate' AND `Session_Time` = '$record4[$i]' ");
                    $present2 = mysql_fetch_array($present1);
                    $present = $present2[0];
                    $url2 = "newtutor.php?var1=$id&var2=$d2&var3=$record3[$i]&var4=$record4[$i]";
                    header("Location:$url2");
                }
            }
            $B = "There Is no session listed for you at this time.";
        }
    }
}
elseif(isset($_POST["mainpage"])) {
    $url1 = "StudentSelectFunction.php";
    header("Location:$url1");
}
?>	

   
<div id="container">
   <div id="banner">
      <img src="../images/banner2.png"  width="1022" height="150" border="none"/>
   </div>
   <div id="line">
   </div>
   <div id="login">
      <a href="Adminlogon.php" ><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></a>
   </div>
   <div id="body">
   </div>
   <div id="signin">
   </div>
   <div id="mainpage">   
   </div>
   <div id="inputboxbackground">
   </div>
   <form action="<?php $PHP_SELF; ?>" method="post">
      <table>
         <tr>
            <td>
               University ID : <input id="polyid" type="text" maxlength="8" name="poly_id" size=25 style="width:150px; height:18px;">
            </td>
         </tr>
         <tr>
            <td><br></td>
         </tr>
         <tr>
            <td>
               <button type="submit" name="myschedule" value="My Session"><img src="../images/signin.png"  width="102" height="28" border="none"/></button>
               <a href="StudentSelectFunction.php" ><img src="../images/mainpage.png"  width="102" height="28" border="none"/></a>
            </td>
         </tr>
         <tr>
            <td>
               <div class = "mesg"><?php echo $A; ?></div>
               <div class = "mesg2"><?php echo $B; ?></div>
            </td>
         </tr>
      </table>
   </form>
   <div id="text1">
      <p>Welcome to TRIO</p>
   </div>
   <div id="text2">
      <p>Please enter your University ID (8 digit number only)</p>
   </div>
   <div id="signout">
      <img src="../images/adminlogin.png"  width="17" height="15" border="none"/>
   </div>
   <div id="text3">
      <a href="Adminlogon.php">
         <p>Admin Login</p>
      </a>
   </div>
</div>
</body>
</html>