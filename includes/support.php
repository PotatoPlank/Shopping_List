<?php
function sendMail($submitFrom,$msg){
require_once "vendor/autoload.php";
//PHPMailer Object
$mail = new PHPMailer;

//From email address and name
$mail->From = "no-reply@hamradiotime.com";
$mail->FromName = "HAMRadioTime Support";

//To address and name
$mail->addAddress("hamradiotime@sugarbombed.com", "HAM Support");
//$mail->addAddress("recepient1@example.com"); //Recipient name is optional

//Address to which recipient will reply
$mail->addReplyTo($submitFrom, "Reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "HAM Support Submited - $submitFrom";
$mail->Body = "<i>$msg</i>";
$mail->AltBody = "$msg";

if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
    return false;
}
else
{
    //echo "Message has been sent successfully";
    return true;
}
}
?>
