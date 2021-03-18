<?php



use PHPMailer\PHPMailer\PHPMailer;
    
use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';

require 'PHPMailer/src/PHPMailer.php';

require 'PHPMailer/src/SMTP.php';

class Activation{
//private $databaseHost = 'localhost';
//private $databaseName = 'epsilon2_demo';
//private $databaseUsername = 'epsilon2_demo';
//private $databasePassword = "9~*X)!GpFl7B";


 


<div><a href="https://epsilonarge.com/checkactivation.php?email= "'.$email.'&activation_code="'.$activation.'>Onaylamak İçin Buraya Tıklayınız</a></div>
function ActivationGet($email, $activation ){
    

   
        $mail = new PHPMailer();
    
    
        $mail->isSMTP();
        $mail->SMTPKeepAlive = true;
    
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; //ssl
    
    
        $mail->Port = 587;
        $mail->Host = "mail.epsilonarge.com";
    
        $mail->Username = "admin@epsilonarge.com";
        $mail->Password = "c_T?3442226";
    
    
        $mail->setFrom("contact@gmail.com"); // kimden gittiği
        $mail->addAddress($email); // ulaşacak mail adresi
    
    
    
    
        $mail->isHTML(true);
    
        $mail->Subject = "Epsilon Arge"  ;
    
        $mail->Body ='<a href="https://epsilonarge.com/checkactivation.php?email= " '.$email.'&activation_code="'.$activation.'></a> '; //dönülecek
    
    
        echo $mail->send();
    
}

}