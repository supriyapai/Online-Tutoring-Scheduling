
<!-- This page populates the dropdown list to make selections of the course based on the tutor you have selected -->

<?php include 'LoginCheck.php'; ?>
<?php include '../Rules/dbconfig.php'; ?>

<html>
<body>
<?php
	$polyid = $_GET["q"];
	$subjectt1 = mysql_query("SELECT * FROM Tutor WHERE Tutor_Poly_Id = '$polyid'");
	$subjectt2 = mysql_fetch_array($subjectt1);
	$subject1 = $subjectt2[Subject_Taught_1];
	$subject2 = $subjectt2[Subject_Taught_2];
	$subject3 = $subjectt2[Subject_Taught_3];
	$subject4 = $subjectt2[Subject_Taught_4];
	$subject5 = $subjectt2[Subject_Taught_5];
	$subject6 = $subjectt2[Subject_Taught_6];

	$sub11 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subject1'");
	$sub12 = mysql_fetch_array($sub11);
	$sub1 = $sub12[Subject];

	$sub21 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subject2'");
	$sub22 = mysql_fetch_array($sub21);
	$sub2 = $sub22[Subject];

	$sub31 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subject3'");
	$sub32 = mysql_fetch_array($sub31);
	$sub3 = $sub32[Subject];

	$sub41 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subject4'");
	$sub42 = mysql_fetch_array($sub41);
	$sub4 = $sub42[Subject];

	$sub51 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subject5'");
	$sub52 = mysql_fetch_array($sub51);
	$sub5 = $sub52[Subject];

	$sub61 = mysql_query("SELECT Subject FROM Subject WHERE Subject_Id = '$subject6'");
	$sub62 = mysql_fetch_array($sub61);
	$sub6 = $sub62[Subject];

	echo "<select name='Sub'>";
	echo "<option value=''>---SELECT---</option>";
	echo "<option value='$subject1'>$sub1</option>";
	echo "<option value='$subject2'>$sub2</option>";
	echo "<option value='$subject3'>$sub3</option>";
	echo "<option value='$subject4'>$sub4</option>";
	echo "<option value='$subject5'>$sub5</option>";
	echo "<option value='$subject6'>$sub6</option>";
	echo "</select>";
?>
        
</body>
</html>


