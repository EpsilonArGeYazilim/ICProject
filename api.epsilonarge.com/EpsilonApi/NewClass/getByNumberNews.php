<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){

    $postdata = file_get_contents("php://input");

    if (isset($postdata)) {
        $request = json_decode($postdata);
        
        if(!empty($request->number))
        {
            $number=$request->number;
            $new = new NewClass();
            echo json_encode($new->getByNumberNews($number), JSON_UNESCAPED_UNICODE);
        }
        else
        {
                 $result["result"] = false;
     $result["code"] = 5005;
     $result["data"] ="error number value";
     echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }



 } else {
     $result["result"] = false;
     $result["code"] = 2002;
     $result["data"] ="error post data";
     echo json_encode($result, JSON_UNESCAPED_UNICODE);
 }
 
 } 
 else {
     $result["result"] = false;
     $result["code"] = 3003;
     $result["data"] ="error key value";
     echo json_encode($result, JSON_UNESCAPED_UNICODE);
 }




