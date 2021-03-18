<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){
    $postdata = file_get_contents("php://input");

    
    if(isset($postdata)){
        $request = json_decode($postdata);


        $site_email = $request->site_email;
        $site_email2 = $request->site_email2;
        $phone = $request->phone;
        $fax = $request->fax;
        $phone2 = $request->phone2;
        $fax2 =$request->fax2;
        $address = $request->address;
        $google_map_location = $request->google_map_location;
        $facebook = $request->facebook;
        $instagram = $request->instagram;
        $twitter = $request->twitter;
        $whatsapp = $request->whatsapp;
        $youtube = $request->youtube;
        $linkedin = $request->linkedin;


        if (!empty($request->user_id) && !empty($request->user_token)) {
            $user_id = $request->user_id;
            $user_token = $request->user_token;
            $contact = new Contact();
            echo json_encode($contact->updateContact($site_email , $site_email2 ,$phone, $fax , $phone2 , $fax2 , $address , $google_map_location , $facebook , $instagram , $twitter , $whatsapp , $youtube , $linkedin,$user_id, null, $user_token, null), JSON_UNESCAPED_UNICODE);
    } else if (!empty($request->admin_id) && !empty($request->admin_token)) {
            $admin_id = $request->admin_id;
            $admin_token = $request->admin_token;
            $contact = new Contact();
            echo json_encode($contact->updateContact($site_email , $site_email2 ,$phone, $fax , $phone2 , $fax2 , $address , $google_map_location , $facebook , $instagram , $twitter , $whatsapp , $youtube , $linkedin,null, $admin_id, null, $admin_token), JSON_UNESCAPED_UNICODE);
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