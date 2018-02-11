function warning(){
	alert("Please make sure your file is saved as a csv");
}


function ExtensionsOkay() {
var extension = new Array();

// Step 1 of 2:
// Replace MyForm with the name of your form and 
//    replace FieldName with the upload field name.

var fieldvalue = document.form1.csv.value;


// Step 2 of 2:
// Add the file name extensions that are okay (with 
//    the period), for the variables with their numbers 
//    in sequential order, as many or as few as needed, 
//    starting with 0. (These are case sensitive.)

extension[0] = ".csv";



// No other customization needed.
var thisext = fieldvalue.substr(fieldvalue.lastIndexOf('.'));
for(var i = 0; i < extension.length; i++) {
	if(thisext == extension[i]) { 
	//document.getElementById("confirm").innerHTML="<center>File Uploaded</center>";
	return true; 
	}
	}
alert("Your upload contains an unapproved file extension. Please choose a csv file.");
return false;
}
