function addOption(selectbox,text,value )
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	selectbox.options.add(optn);
}

function addOption_list(selectbox){
var currentyear=new Date().getFullYear();
var year2=currentyear+1;
var year3=currentyear+2;
var year4=currentyear+3;
var year5=currentyear+4;
var year6=currentyear+5;
var year = new Array("May "+currentyear,"Dec "+currentyear,"May "+year2,"Dec "+year2,"May "+year3,"Dec "+year3,"May "+year4,"Dec "+year4,"May "+year5,"Dec "+year5,"May "+year6,"Dec "+year6);
for (var i=0; i < year.length;++i){

addOption(document.drop_list.Year_list, year[i], year[i]);
}
}

function validateForm()
{
var x=document.forms["drop_list"]["polyid"].value;
if (x=="" || x=="---SELECT---")
  {
  alert("Please Select a Graduation Year");
  return false;

  }
  
  else{
  	warning();
  }
}

function delete_tutor()
{

if($('#polyid').val() === '---Select---'){ 
	console.log("Please select a tutor to delete.");
	return false;
	
}else{
	var tutorID=$('#polyid').val();
	//call php delete file
	console.log(tutorID);
	$.ajax({
 		type: 'post',
	 	url: '../php/delete_yearb.php',
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

function warning(){
	var choice=confirm("You are about to DELETE Tutors from the database.  Do you want to continue?");

if (choice===true){
	delete_tutor();
	document.getElementById("confirm").innerHTML="<center>Tutors Deleted</center>";
}

else{
	 console.log("Try Again");
}
}