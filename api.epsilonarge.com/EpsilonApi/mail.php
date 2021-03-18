<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");


$databaseHost = 'localhost';
$databaseName = 'epsilon2_demo';
$databaseUsername = 'epsilon2_demo';
$databasePassword = "9~*X)!GpFl7B";

$data = "";


try {
    $mysql_connection = "mysql:host=$databaseHost;dbname=$databaseName";
    $db = new PDO($mysql_connection, $databaseUsername, $databasePassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $db->query("Select * from contact");
    $data = $query->fetch(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "Bağlantı Hatası: " . $e->getMessage() . "<br/>";
}

$object = json_decode(json_encode($data));

$email_address = $object->site_email;




use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\SMTP;


require 'PHPMailer/src/Exception.php';

require 'PHPMailer/src/PHPMailer.php';

require 'PHPMailer/src/SMTP.php';



$postdata = file_get_contents("php://input");


if (isset($postdata)) {
    $request = json_decode($postdata);



    $name = $request->name;
    $email = $request->email;
    $subject = $request->subject;
    $message = $request->message;



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
    $mail->addAddress($email_address); // ulaşacak mail adresi




    $mail->isHTML(true);

    $mail->Subject = $subject . ' ' . $email . ' ip:' . $_SERVER["REMOTE_ADDR"];

    $mail->Body = $name . ' ' . $message;


    echo $mail->send();
} else {

    echo json_encode('{"result":false}');
}
