function validateForm()
{
var x=document.forms["myForm"]["poly_id"].value;
if (x=="" || x=="---SELECT---")
  {
  alert("Select Student");
  return false;

  }
  
  else{
  	warning2();
  }
}

function validateForm2()
{
var x=document.forms["myForm"]["poly_id"].value;
if (x=="" || x=="---SELECT---")
  {
  alert("Select Tutor");
  return false;

  }
  
  else{
  	warning();
  }
}


function warning(){
	var choice=confirm("You are about to DELETE tutor(s) and ALL their session allocations from the database.  Do you want to continue?");

if (choice===true){
	delete_person();
	document.getElementById("confirm").innerHTML="<center>Tutor(s) Deleted</center>";
}

else{
	 console.log("Try Again");
}
}
function delete_person()
{

if($('#poly_id').val() === '---SELECT---'){ 
	console.log("Please select a tutor.");
	return false;
	
}else{
	var tutorID=$('#poly_id').val();
	//call php delete file
	console.log(tutorID);
	$.ajax({
 		type: 'post',
	 	url: '../php/deletetut.php',
	 	data: 'tutorID='+tutorID,
	 	cache: false,
	 	success: function(response){
	 		console.log(response);
		},
		error: function() {
			console.log('error');
		}
	});
	
	
}

}

function warning2(){

	
	var choice=confirm("You are about to DELETE student(s) and ALL their session allocations from the database.  Do you want to continue?");

if (choice===true){


	delete_student();
	document.getElementById("confirm").innerHTML="<center>Student(s) Deleted</center>";
	//history.go(0);
}

else{
	 console.log("Try Again");
}
}
function delete_student()
{

if($('#poly_id').val() === "null"){ 
	console.log("Please select a student.");
	return false;
	
}else{
	var studentID=$('#poly_id').val();
	//call php delete file
	console.log(studentID);
	$.ajax({
 		type: 'post',
	 	url: '../php/deletestud.php',
	 	data: 'studentID='+studentID,
	 	cache: false,
	 	success: function(response){
	 		console.log(response);
		},
		error: function() {
			console.log('error');
		}
	});
	}
}

function displaypage() {
document.forms[0].submit();
}

