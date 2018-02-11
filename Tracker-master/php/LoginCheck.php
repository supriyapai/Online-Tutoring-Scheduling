<?php
session_start();

if(!isset($_SESSION['userid']))
{
	header("Location: Adminlogon.php");
	exit();
}

// for production 
/*if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);		//enable HTTPS
    exit();
}
 */
?>
