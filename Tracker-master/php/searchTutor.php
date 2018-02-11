
<!-- this page retrieves the list of tutors or student based on you selection made on the UI . For e.g. there is an option to choose 
student or tutor on Reports pages, so this is the script which populates the list of student or tutor based on runtime 
selections you make -->


<?php
	include 'LoginCheck.php';
?>
<?php include '../Rules/dbconfig.php'; ?>

<html>
    <body>
<?php

$polyid = $_GET["q"];

if($polyid == 'T')
{
    $tutor1 = mysql_query("SELECT * FROM Tutor Order By Tutor_Last_Name");
    while($tutor2 = mysql_fetch_array($tutor1))
    {
        $tutorFirstName[] = $tutor2[Tutor_First_Name];
        $tutorLastName[]  = $tutor2[Tutor_Last_Name];
		$tutorPolyId[]    = $tutor2[Tutor_Poly_Id];
    }
    
    $no1 = count($tutorPolyId);

    for($a=0; $a<$no1; $a++)
    {
	$tutorName[] = $tutorLastName[$a]." ".$tutorFirstName[$a];
    }
    echo '<select name="Tname" class="required">';
    echo "<option value='---SELECT---'>---SELECT---</option>";
    for($b=0; $b<$no1; $b++)
    {
        echo "<option value='$tutorPolyId[$b]'>$tutorName[$b]</option>";
    }
    echo "</select>";
}
elseif($polyid == 'S')
{
    $student1 = mysql_query("SELECT * FROM Student Order By Student_Last_Name");
    while($student2 = mysql_fetch_array($student1))
    {
        $studentFirstName[] = $student2[Student_First_Name];
	$studentLastName[] = $student2[Student_Last_Name];
	$studentPolyId[] = $student2[Student_Poly_Id];	
    }
    
    $no2 = count($studentPolyId);
    
    for($i=0; $i<$no2;$i++)
    {
	$studentName[] = $studentLastName[$i]." ".$studentFirstName[$i];
			
    }
    echo '<select name="Sname" class="required">';
    echo "<option value='---SELECT---'>---SELECT---</option>";
    for($j=0; $j<$no2; $j++)
    {
        echo "<option value=$studentPolyId[$j]>$studentName[$j]</option>";
    }
    echo '</select>';
}


?>

</td>       
        
</body>
</html>


 