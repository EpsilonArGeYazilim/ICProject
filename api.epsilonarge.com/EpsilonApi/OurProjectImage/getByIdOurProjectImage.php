<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){

    $postdata = file_get_contents("php://input");

    if (isset($postdata)) {
        $request = json_decode($postdata);

    $img_id = $request->id;
    $ourProjectImage = new OurProjectImage();
    echo json_encode($ourProjectImage->getByIdOurProjectImage($img_id), JSON_UNESCAPED_UNICODE);

/*
    if (!empty($request->user_id) && !empty($request->user_token)) {
        $user_id = $request->user_id;
        $user_token = $request->user_token;
        
        $ourProjectImage = new OurProjectImage();
        echo json_encode($ourProjectImage->getByIdOurProjectImage($img_id,$user_id, null, $user_token, null), JSON_UNESCAPED_UNICODE);
} else if (!empty($request->admin_id) && !empty($request->admin_token)) {
        $admin_id = $request->admin_id;
        $admin_token = $request->admin_token;
        
        $ourProjectImage = new OurProjectImage();
        echo json_encode($ourProjectImage->getByIdOurProjectImage($img_id,null, $admin_id, null, $admin_token), JSON_UNESCAPED_UNICODE);
} else {
        $result["result"] = false;
        $result["code"] = 1001;
        $result["data"] ="access denied";
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
 }
 */

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

