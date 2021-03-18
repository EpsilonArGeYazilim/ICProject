<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){
    $postdata = file_get_contents("php://input");

    if(isset($postdata)){
        $request = json_decode($postdata);

        $notice_id = $request->notice_id;
        $img_url = $request->img_url;
        $header = $request->header;
        $content = $request->content;
        $link = $request->link;


        if (!empty($request->user_id) && !empty($request->user_token)) {
            $user_id = $request->user_id;
            $user_token = $request->user_token;
            $notice = new Notice();
            echo json_encode($notice->updateNotice($notice_id,$img_url, $header, $content, $link,$user_id, null, $user_token, null), JSON_UNESCAPED_UNICODE);
    } else if (!empty($request->admin_id) && !empty($request->admin_token)) {
            $admin_id = $request->admin_id;
            $admin_token = $request->admin_token;
            $notice = new Notice();
            echo json_encode($notice->updateNotice($notice_id,$img_url, $header, $content, $link,null, $admin_id, null, $admin_token), JSON_UNESCAPED_UNICODE);
    }else {
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