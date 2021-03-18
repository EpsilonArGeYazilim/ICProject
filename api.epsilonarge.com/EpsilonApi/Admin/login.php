<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){
    $postdata = file_get_contents("php://input");

    if(isset($postdata)){
        $request = json_decode($postdata);

        $email = $request->email;
        $password = $request->password;

        
        $admin = new Admin();
        echo json_encode($admin->login($email,$password), JSON_UNESCAPED_UNICODE);
    }
    else{
        echo '{"sonuc" : "hatalı"}';
    }
   
}

?>