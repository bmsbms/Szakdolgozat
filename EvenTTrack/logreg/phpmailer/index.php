<?php 
require 'phpmailer/PHPMailerAutoload.php';
$mail=new PHPMailer;
//$mail->isSMTP();

$mail->Host='smtp.gmail.com';
$mail->Port=587;
$mail->SMTPAuth=true;
$mail->SMTPSecure='tls';

$mail->Username='bmsbms.szakdoga@gmail.com';
$mail->Password='Szakdoga01';


$mail->setFrom('bmsbms.szakdoga@gmail.com','EvenTTrack'); //másik email, vagy meg tudok emléteni egy nevet vagy személyt vagy a céget, bármit amit emg akarok itt jeleniteni.
$mail->addAddress('EvenTTrack');
$mail->addReplyTo('bmsbms.szakdoga@gmail.com');

$mail->isHTML(true); // ha html tageket akarok használni ezt kell beirni
$mail->Subject='PHP Mailer Subject'; //tárgy
$mail->Body='<h1 align=center>Subscribe My Channel </h1><br><h4 align=center>Like This Video</h4>'; // mi legyen a mailben ugye.
if (!$mail->send()) {
	echo "Message could not be sent!";
}
else{
	echo "Message has been sent!";
}
 ?>}
