<?php
require '/PHPMailer-master/PHPMailerAutoload.php';
include 'LoginCheck.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  
$mail = new PHPMailer;
echo "inside file";
$mail->SMTPDebug = 3;                               // Enable verbose debug output
/* try {
$mail->isSMTP(); 
//$mail->SMTPDebug = 2;                                     // Set mailer to use SMTP
$mail->Host = 'localhost';  // Specify main and backup SMTP servers
//$mail->SMTPAuth = true;                               // Enable SMTP authentication
//$mail->Username = 'user@example.com';                 // SMTP username
//$mail->Password = 'secret';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('shyamrjoshi', 'shyam');
$mail->addAddress('srj295@nyu.edu', 'shyam joshi');     // Add a recipient
$mail->addReplyTo('shyamrjoshi@gmail.com', 'shyam joshi');


$mail->addAttachment('test.csv');         // Add attachments
$mail->addAttachment('AttendanceReport_08012016.csv');    // Optional name
//$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body ';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
} catch (phpmailerException $e) {
echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
echo $e->getMessage(); //Boring error messages from anything else!
} */