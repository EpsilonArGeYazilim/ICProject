<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){
    $postdata = file_get_contents("php://input");

    if(isset($postdata)){
        $request = json_decode($postdata);

        $product_id = $request->product_id;
        $imgUrl = $request->imgUrl;




        if (!empty($request->user_id) && !empty($request->user_token)) {
            $user_id = $request->user_id;
            $user_token = $request->user_token;
            
            $product_img = new ProductImage();
            echo json_encode($product_img->createProductImage($product_id,$imgUrl,$user_id, null, $user_token, null), JSON_UNESCAPED_UNICODE);
    } else if (!empty($request->admin_id) && !empty($request->admin_token)) {
            $admin_id = $request->admin_id;
            $admin_token = $request->admin_token;
            
            $product_img = new ProductImage();
            echo json_encode($product_img->createProductImage($product_id,$imgUrl,null, $admin_id, null, $admin_token), JSON_UNESCAPED_UNICODE);
    } else {
        $result["result"] = false;
        $result["code"] = 1001;
        $result["data"] ="access denied";
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

    
    