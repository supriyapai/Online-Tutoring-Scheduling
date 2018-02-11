<?php
include 'LoginCheck.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  
include 'pearmail/pearmail/Mail/Mail.php';
include 'pearmail/pearmimemail/Mail_Mime/Mail/mime.php' ;

$text = 'Text version of email';
//$html = '<html><body>HTML version of email</body></html>';
$msg = 'test mail';
$file = 'testcsv_pear.csv';
$crlf = "\n";
$hdrs = array(
              'From'    => 'shyamrjoshi@gmail.com',
              'Subject' => 'Test mime message'
              );

$mime = new Mail_mime(array('eol' => $crlf));

$mime->setTXTBody($text);
//$mime->setHTMLBody($html);
$mime->addAttachment($file, 'text/csv');

$body = $mime->get();
$hdrs = $mime->headers($hdrs);

$mail =& Mail::factory('mail');
$mail->send('srj295@nyu.edu', $hdrs, $body);

?>