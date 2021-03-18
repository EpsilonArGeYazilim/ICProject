<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){
    
    $postdata = file_get_contents("php://input");


    if (isset($postdata)) {
        $request = json_decode($postdata);

        $category_id = $request->category_id;
        $product = new Product();
        echo json_encode($product->getAllCategoryProducts($category_id), JSON_UNESCAPED_UNICODE);
  
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
    



