<html>
<head>
<title>Student Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="../css/mainpage.css" />
</head>
<body>

<?php
//Connecting to the Database
    include '../Rules/dbconfig.php';
    
?>
<div id="container">
	<div id="banner"><img src="../images/banner2.png"  width="1022" height="150" border="none"/></div>
	<div id="line"></div>
	<div id="login"><a href="Adminlogon.php" ><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></a></div>
	<div id="body"></div>
	<div id="button1"><a href="Signin.php"><img src="../images/button1.png"  width="288" height="78" border="none"/></a></div>
	<div id="button2"><a href="SessionModify.php"><img src="../images/button2.png"  width="288" height="78" border="none"/></a></div>
	<div id="button3"><a href="SessionListing.php"><img src="../images/button3.png"  width="288" height="78" border="none"/></a></div>
	<div id="text1"><p>Welcome to TRIO</p></div>
	<div id="text2"><p>Please select your section option</p></div>
	<div id="signout"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></div>    
	<div id="text3"><a href="Adminlogon.php"><p>Admin Login</p></a></div>
	<?php
	//If Session Sign In Is Selected
	if(isset($_POST["signin"]) ){
		$url1 = "Signin.php";
		header("Location:$url1");
	}elseif(isset($_POST["modify"]) ){
		$url2 = "SessionModify.php";
		header("Location:$url2");
	}elseif(isset($_POST["listing"]) ){
		$url3 = "SessionListing.php";
		header("Location:$url3");
	}
		
	?>
</div>
</body>
</html>