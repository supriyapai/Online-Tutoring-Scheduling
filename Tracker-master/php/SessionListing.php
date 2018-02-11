<html>
<head>
   <?php
       include '../Rules/jQueryPlugins.php';
    ?> 
	<title>Session Listing</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/sessionlisting.css" />
</head>
<body>
    
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
<div id="top_t">
   <h4>Please enter your University ID</h4>
</div>
<div id="inputboxbackground">
</div>
<?php
if (isset($_POST["listing"])) {
	    //Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
	    if (preg_match("/^\d{8}$/", $_POST["polyid"]) === 0) {
	        //Modified by Kishan: To change The poly ID 7 digit to 8 digit Univ N Number
	        //Actual Code: $A='Poly ID must be 7 digits';
	        $A = 'University N Number must be 8 digits';
	        //echo $polyid;
	    } else {
	        $polyid = $_POST["polyid"];

	        $url1 = "listing.php?var1=$polyid";
	        header("Location:$url1");
	    }
	}elseif(isset($_POST["mainpage"])) {
	    $url1 = "StudentSelectFunction.php";
	    header("Location:$url1");
}
?>
<div id="text2"><p>Please enter your University ID</p><br></div>

<table border="0">
	<tr>
	<td>
	<center>
		<form action="<?php $PHP_SELF; ?>" method="post">
		<table>
			<tr>
			<td><font size="4">University Id :</td>
			<td><input type="text" maxlength="8" name="polyid" value=<?php echo "$polyid"; ?> ></td>
			</tr>
		</table>
		<br/>
		<div class = "mesg"><?php echo $A; ?></div>
		<br></br>
		<button type="submit" name="listing" value="Session Listing"><img src="../images/listing.png"  width="102" height="28" border="none"/></button>
		<button type="submit" name="mainpage" value="Main Page"><img src="../images/mainpage.png"  width="102" height="28" border="none"/></button>
		</form>
	</center>
	</td>
	</tr>
</table>
</body>
</html>