<?php
include "./class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){


    $count = new Count();
    echo json_encode($count->getAllTablesCount(), JSON_UNESCAPED_UNICODE);

         
         } 
         else {
             $result["result"] = false;
             $result["code"] = 3003;
             $result["data"] ="error key value";
             echo json_encode($result, JSON_UNESCAPED_UNICODE);
         }
        
        
    