<?php
	session_start();
   // $_SESSION['userid'] = $_POST["userid"];
	//include "../Rules/datepicker.php";
?>
<html>
    <head>
        <title>Tracker</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../css/adminlogin.css" />
    </head>
<body>

<?php include '../Rules/dbconfig.php'; ?>
    
<?php
/* if(isset($_POST["submit"]) ){
	
	$user = $_POST["userid"];
	$pass = md5($_POST["password"]);	//computing MD5 of the password provided by the user
	$username1 = mysql_query("SELECT Username, `Password` FROM Admin_LogIn ");
	$username2 = mysql_fetch_array($username1);
	$username = $username2[Username];
	$password = $username2[Password];
	
	if($username == $user){
		if($password == $pass){
			$url = "Selectfunction.php";
			header("Location:$url");
		}else{
			$A = "Incorrect Username/Password";
		}
	}
	else{
		$A = "Incorrect Username/Password";
	}	
} */


//new code


if(isset($_POST["submit"]) ){
	echo "psot";
	$user = $_POST["userid"];
	$pass = md5($_POST["password"]);	//computing MD5 of the password provided by the user
	
	
	$user = (string)$_POST["userid"];
	//echo strlen($user);
	$query = "SELECT * FROM Admin_LogIn
			  where Username = '$user'";
	$result = mysql_query($query);
	//echo $query;
	if(mysql_num_rows($result)==0)
	{
		$A = "Incorrect Username/Password".$user;
		
	}
	else{
		$user_details = mysql_fetch_array($result);
		$username = $user_details['Username'];
		$password = $user_details['Password'];
		print_r($user_details);
		if($username == $user)
		{
			if($password == $pass)
			{
				$_SESSION['userid'] = $user;
				$url = "Selectfunction.php";
				header("Location:$url");
			}
			else
			{
				$A = "Incorrect Username/Password";
			}
		}
		else
		{
			$A = "Incorrect Username/Password";
		}
	}
}


//new code ends

?>

<div id="container">	
	<div id="banner">
		<img src="../images/banner2.png"  width="1022" height="150" border="none"/>
	</div>    
    <div id="line"></div>    
	<div id="adminlogin">
		<a href="StudentSelectFunction.php"><img src="../images/adminlogin.png"  width="17" height="15" border="none"/></a>
	</div>
	    
	<div id="mainbody"></div>
	<div id="inputboxbackground"></div>
        
    <form action="" method="post">      
        <label for="name">Username : </label>
		<input type="text" id="name" name="userid" placeholder="username" />
		</br>
		<label for="name">Password : </label>
		<input type="password" id="name" name="password" placeholder="password" />
        <br><br>
		<center>
			<button type="submit" name="submit" value="Log In"><img src="../images/login.png"  width="102" height="28" style="border:0" /></button>
		</center> 
		<center><?php echo $A; ?></center>
    </form>
    <div id="text2"><p>Admin Login</p></div>
	<div id="text3">
	    <a href="StudentSelectFunction.php"><p>Main Page</p></a>
	</div>
</div>
</body>
</html>