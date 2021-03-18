<?php
include "./sendactivation.php";
class Config extends Activation
{
    private $databaseHost = 'localhost';
    private $databaseName = 'epsilon2_demo';
    private $databaseUsername = 'epsilon2_demo';
    private $databasePassword = "9~*X)!GpFl7B";

    function db()
    {
        try {
            $mysql_connection = "mysql:host=$this->databaseHost;dbname=$this->databaseName";
            $dbconnection = new PDO($mysql_connection, $this->databaseUsername, $this->databasePassword);
            $dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbconnection;
        } catch (PDOException $e) {
            //echo "Bağlantı Hatası: " . $e->getMessage() . "<br/>";
        }
    }
}



class Crud extends Config
{
    function delete($sql)
    {
        $db = $this->db();
        $sql=$db->exec($sql);
        return $sql;
    }

    function insertAndUpdate($sql,$data){
        $db = $this->db();
        $sql=$db->prepare($sql);
        $sql->execute($data);
        $return = true;
        return $return;
    }

    function get($sql){
        try {
            $db = $this->db();
            $query = $db->query($sql);
            $data = $query->fetch(PDO::FETCH_OBJ); #PDO::FETCH_ASSOC
            $db=null;
            $return = false;
            
            if(!empty($data)){

                $return = $data;
            }

            return $return;

        } catch (PDOException $ex) {
            return $ex;
        }
    }

    function getAll($sql){
        try {
            $db = $this->db();
            $query = $db->query($sql);
            $data = $query->fetchAll(PDO::FETCH_OBJ); #PDO::FETCH_ASSOC
            $db=null;
            $return = false;
            
            if(!empty($data)){

                $return = $data;
            }

            return $return;

        } catch (PDOException $ex) {
            return $ex;
        }

    }

    function checkAccessForUser($user_id,$admin_id,$user_token,$admin_token){
        $result=false;


            if($admin_id != null && $admin_token != null){
                $result =$this->checkTokenForAdmin($admin_id,$admin_token);

            }
            else if($user_id != null && $user_token != null){
                $result =$this->checkTokenForUser($user_id,$user_token);

            }

        return $result;
    }

    function checkAccessForAdmin($admin_id,$admin_token){
        $result=false;


            if($admin_id != null && $admin_token != null){
                $result =$this->checkTokenForAdmin($admin_id,$admin_token);

            }

        return $result;
    }

    function checkTokenForUser($id,$token){
        $sql = "Select id from users WHERE id='$id' AND token = '$token' ";
        $result=$this->get($sql);
        $return=false;
        if($result){
            $return=true;
        }

        return $return;
    }

    function checkTokenForAdmin($id,$token){
        $sql = "Select id from admins WHERE id='$id' AND token = '$token' ";
        $result=$this->get($sql);
        $return=false;
        if($result){
            $return=true;
        }

        return $return;
    }

    
}

class Admin extends Crud
{

    function createAdmin($firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $token=md5(uniqid(rand(), true));
            $password=md5($password);
        $sql="INSERT INTO admins (firstname,lastname,email,token,phone,password) VALUES (?,?,?,?,?,?)";
        $data=[$firstname,$lastname,$email,$token,$phone,$password];
        $result["result"] = $this->insertAndUpdate($sql,$data);

        }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }

        return $result;
    }

    function deleteByMyIdAdmin($admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM admins WHERE id = '$admin_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }


    function deleteByIdAdmin($delete_id,$admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM admins WHERE id = '$delete_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }



    function getByIdAdmin($get_id,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $sql = "Select * from admins WHERE id='$get_id' ";
            $result["data"]=$this->get($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByMyIdAdmin($admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $sql = "Select * from admins WHERE id='$admin_id' ";
            $result["data"]=$this->get($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;

    }

    function getAllAdmin($admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "Select * from admins";
        $result["data"]=$this->getAll($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function updateByMyIdAdmin($firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $password=md5($password);
        $sql = "UPDATE admins SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$admin_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }

        return $result;
    }

    function updateByIdAdmin($update_id,$firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $password=md5($password);

        $sql = "UPDATE admins SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$update_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }

        return $result;
    }

    function login($email, $password)
    {
        $password=md5($password);
        $sql = "Select id from admins WHERE email='$email' AND password='$password' ";
        $result["data"]=$this->get($sql);


        if($result["data"]){

            $array_result = json_decode(json_encode($result), true);
            $id= $array_result["data"]["id"];

            $token=md5(uniqid(rand(), true));
            $result["token"]= $token;
            $sql = "UPDATE admins SET token = ? WHERE id = '$id' ";
            
            $data = [$token];
            $result["result"]=$this->insertAndUpdate($sql,$data);
            
        }
       
        return $result;
    }
    
    function checkToken($admin_id, $admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);
        
        return $result;
    }
    

}

class User extends Crud
{
    function createUser($firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $token=md5(uniqid(rand(), true));
            $password=md5($password);
        $sql="INSERT INTO users (firstname,lastname,email,phone,password,token,is_activation) VALUES (?,?,?,?,?,?,?)";
        $data=[$firstname,$lastname,$email,$phone,$password,$token,0];
        $result["result"] = $this->insertAndUpdate($sql,$data);


        $activation_code=md5(uniqid(rand(), true));
        $sql="INSERT INTO activation (email,activation_code) VALUES (?,?)";
        $data=[$email,$activation_code];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        
     $this->ActivationGet($email , $activation_code);
     
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

  

    function deleteByMyIdUser($user_id,$admin_id,$user_token,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM users WHERE id = '$user_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }


    function deleteByIdUser($delete_id,$admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM users WHERE id = '$delete_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }



    function getByIdUser($get_id,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $sql = "Select * from users WHERE id='$get_id' ";
            $result["data"]=$this->get($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByMyIdUser($user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
            $sql = "Select * from users WHERE id='$user_id' ";
            $result["data"]=$this->get($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;

    }

    function getAllUser($admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "Select * from users";
        $result["data"]=$this->getAll($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function updateByMyIdUser($firstname,$lastname,$email,$phone,$password,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
            $password=md5($password);
        $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$user_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function updateByIdUser($update_id,$firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {
        

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            
            $password=md5($password);
        $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$update_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function login($email, $password)
    {
        $password=md5($password);
        $sql = "Select id from users WHERE email='$email' AND password='$password' ";
        $result["data"]=$this->get($sql);


        if($result["data"]){

            $array_result = json_decode(json_encode($result), true);
            $id= $array_result["data"]["id"];

            $token=md5(uniqid(rand(), true));
            $result["token"]= $token;
            $sql = "UPDATE users SET token = ? WHERE id = '$id' ";
            
            $data = [$token];
            $result["result"]=$this->insertAndUpdate($sql,$data);
            
        }

        return $result;
    }
    
    

    


}

class CompanyReference extends Crud
{
    function createReference($company_name,	$logo_url, $img_url, $header, $content,$link, $user_id,$admin_id, $user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO company_references (company_name,logo_url,img_url,header,content,link) VALUES (?,?,?,?,?,?)";
        $data=[$company_name, $logo_url, $img_url, $header, $content,$link];
        $query["result"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $query;
    }
    
    function updateReference($reference_id,$company_name,	$logo_url, $img_url, $header, $content,$link, $user_id,$admin_id, $user_token,$admin_token)
    {
        
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="UPDATE company_references SET company_name = ?, logo_url = ?, img_url = ?, header = ?, content = ?, link = ?  WHERE id = '$reference_id'";
        $data=[$company_name, $logo_url, $img_url, $header, $content,$link];
        $query["result"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $query;
    }

    function deleteReference($reference_id,$user_id,$admin_id,$user_token,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){

        $sql = "DELETE FROM company_references WHERE id = '$reference_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByIdReference($reference_id)
    {
/*
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
            */
        $sql = "Select * from company_references WHERE id='$reference_id' ";
        $result["data"]=$this->get($sql);

    /*    }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        */
        return $result;
    }

    function getAllReferences()
    {
      /*  $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){ */
        $sql = "Select * from company_references";
        $result["data"]=$this->getAll($sql);
/*
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }

}

class Contact extends Crud
{
    function updateContact($site_email , $site_email2 , $phone, $fax , $phone2 , $fax2 , $address , $google_map_location , $facebook , $instagram , $twitter , $whatsapp , $youtube , $linkedin,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE contact SET site_email = ?, site_email2 = ?, phone = ?, fax = ?, phone2 = ?, fax2 = ?, address = ?, google_map_location = ?, facebook = ?, instagram = ?, twitter = ?, whatsapp = ?, youtube = ?, linkedin = ?  WHERE id = 1";
        $data = [$site_email , $site_email2 , $phone, $fax , $phone2 , $fax2 , $address , $google_map_location , $facebook , $instagram , $twitter , $whatsapp , $youtube , $linkedin];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getContactAllColumn()
    {
      /*  $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from contact WHERE id= 1";
        $result["data"]=$this->get($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }

}

class General extends Crud
{
    function updateGeneral($site_name, $logo_url, $slogan,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE general_setting SET site_name = ?, logo_url = ?, slogan = ?  WHERE id = 1";
        $data = [$site_name, $logo_url, $slogan];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getAllColumnGeneral()
    {/*
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from general_setting WHERE id= 1";
        $result["data"]=$this->get($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }
    
}

class NewClass extends Crud
{
    function createNew($img_url, $header, $content, $link,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO news (img_url, header, content, link) VALUES (?,?,?,?)";
        $data=[$img_url, $header, $content, $link];
        $result["result"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function updateNew($new_id,$img_url, $header, $content, $link,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE news SET img_url = ?, header = ?, content = ?, link = ? WHERE id = '$new_id'";
        $data = [$img_url, $header, $content, $link];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteNew($new_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM news WHERE id = '$new_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByIdNew($new_id)
    {/*
        $result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from news WHERE id='$new_id' ";
        $result["data"]=$this->get($sql);
      /*  }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }

    function getAllNews()
    {
        /*$result["result"]=false;

        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from news";
        $result["data"]=$this->getAll($sql);

       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }
    
    function getByNumberNews($number)
    {
        
        $sql = "Select * from news
        ORDER BY id DESC LIMIT $number
        ";
        $result["data"]=$this->getAll($sql);
        
        return $result;
    }

}

class Notice extends Crud
{
    function createNotice($img_url, $header, $content, $link,$user_id,$admin_id,$user_token,$admin_token)
    {
        
            $result["result"]=false;
    
            $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);
    
            if($result["result"] == true){
        $sql="INSERT INTO notices (img_url, header, content, link) VALUES (?,?,?,?)";
        $data=[$img_url, $header, $content, $link];
        $result["result"] = $this->insertAndUpdate($sql,$data);
            }
            else{
                $result["result"] = false;
                $result["code"] = 4004;
                $result["data"] ="error wrong token or id";
            }
        return $result;
    }

    function updateNotice($notice_id,$img_url, $header, $content, $link,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE notices SET img_url = ?, header = ?, content = ?, link = ? WHERE id = '$notice_id'";
        $data = [$img_url, $header, $content, $link];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteNotice($notice_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM notices WHERE id = '$notice_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;

    }

    function getByIdNotice($notice_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from notices WHERE id='$notice_id' ";
        $result["data"]=$this->get($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }

    function getAllNotices()
    {
       /* $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from notices";
        $result["data"]=$this->getAll($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }
       
    function getByNumberNotices($number)
    {
        
        $sql = "Select * from notices
        ORDER BY id DESC LIMIT $number
        ";
        $result["data"]=$this->getAll($sql);
        
        return $result;
    }
    
}

class Product extends Crud
{             
    function createProduct($product_name, $content,	$title, $category_id,	$type ,$user_id,$admin_id,$user_token,$admin_token)
    {
               $result["result"]=false;
    
            $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);
    
            if($result["result"] == true){
                
        $sql="INSERT INTO products (product_name, content, title, category_id, type) VALUES (?,?,?,?,?)";
        $data=[$product_name, $content,	$title,$category_id, $type];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        
            }
            else{
                $result["result"] = false;
                $result["code"] = 4004;
                $result["data"] ="error wrong token or id";
            }
        return $result;

    }

    function updateProduct($product_id,$product_name, $content,	$title,$category_id,	$type,$user_id,$admin_id,$user_token,$admin_token)
    {

        $result["result"]=false;
    
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
            
            $sql = "UPDATE products SET product_name = ?, content = ?, title = ?,category_id =?, type = ? WHERE id = '$product_id'";
            $data = [$product_name, $content,	$title,$category_id,	$type];

            $result["data"] = $this->insertAndUpdate($sql,$data);
        
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteProduct($product_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM products WHERE id = '$product_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByIdProduct($product_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from products INNER JOIN categories ON products.category_id= categories.category_id WHERE products.id='$product_id'";
        $result["data"]=$this->get($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }

    function getAllProducts()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from products ";

        $result["data"]=$this->getAll($sql);
        

	foreach ($result["data"] as $key => $value) {
		if($key != 0)
		{
		$product_id.=",";
		}

		$product_id.=$value->id;
        }


   	 $sql_images = "Select * from product_images WHERE product_id IN (".$product_id.") ";
        $result["product_images"]=$this->getAll($sql_images);
        
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }
    function getAllCategoryProducts($category_id){
        
        $sql = "Select * from products INNER JOIN categories ON products.category_id= categories.category_id WHERE products.category_id='$category_id' ";

        $result["data"]=$this->getAll($sql);
        

	foreach ($result["data"] as $key => $value) {
		if($key != 0)
		{
		$product_id.=",";
		}

		$product_id.=$value->id;
        }


   	 $sql_images = "Select * from product_images WHERE product_id IN (".$product_id.") ";
        $result["product_images"]=$this->getAll($sql_images);
        
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }
        
        
        
    function getByNumberProducts($number)
    {
        
          $sql = "Select * from products 
              ORDER BY products.id DESC LIMIT $number
              ";

        $result["data"]=$this->getAll($sql);
        

	foreach ($result["data"] as $key => $value) {
		if($key != 0)
		{
	        	$product_id.=",";
	   
	    	}

	    	$product_id.=$value->id;
        }


   	 $sql_images = "Select * from product_images WHERE product_id IN (".$product_id.") ";
        $result["product_images"]=$this->getAll($sql_images);
        

        return $result;
    }
    
    
    

}

class ProductImage extends Crud
{
    function createProductImage($productId,$imgUrl,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO product_images (img_url, product_id) VALUES (?,?)";
        $data=[$imgUrl,$productId];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteProductImage($image_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM product_images WHERE id = '$image_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteForProductImage($productId,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM product_images WHERE  product_id= '$productId'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getForProductImage($productId)
    {

    
    /*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from product_images WHERE product_id = '$productId'";
        $result["data"]=$this->getAll($sql);

        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }

    function getByIdProductImage($image_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from product_images Where id = '$image_id'";
        $result["data"]=$this->get($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }

    function getAllProductImage()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from product_images ";
        $result["data"]=$this->getAll($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }


}

class Slider extends Crud
{
    function createSlider($title,$content,$img_url,$link,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO slider (title, content, img_url, link) VALUES (?,?,?,?)";
        $data=[$title,$content,$img_url,$link];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;

    }
    
    function updateSlider($slider_id,$title,$content,$img_url,$link,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="UPDATE slider SET title = ?, content = ?, img_url = ?, link = ? WHERE id = '$slider_id' ";
        $data=[$title,$content,$img_url,$link];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
        
    }

    function deleteSlider($slider_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM slider WHERE id = '$slider_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByIdSlider($slider_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from slider WHERE id='$slider_id' ";
        $result["data"]=$this->get($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }

    function getAllSlider()
    {
/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $result["result"] = true;
        $sql = "Select * from slider";
        $result["data"]=$this->getAll($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    
    }

}

class Team extends Crud
{
    function createTeam($name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO team (name,position,about,facebook,instagram,twitter,whatsapp,youtube,linkedin,phone,img_url) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $data=[$name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;

    }
    
    function deleteTeam($team_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM team WHERE id = '$team_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }
    function updateTeam($team_id,$name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE team SET name = ?, position = ?, about = ?, facebook = ?, instagram = ?, twitter = ?, whatsapp = ?, youtube = ?, linkedin = ?, phone = ?, img_url = ? WHERE id = '$team_id'";
        $data = [$name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url];
        $result["data"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }

        return $result;
    }

    function getByIdTeam($team_id)
    {
        /*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from team WHERE id='$team_id' ";
        $result["data"]=$this->get($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;

    }

    function getAllTeam()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from team ";
        $result["data"]=$this->getAll($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;

    }

}

class Mission extends Crud
{
    function updateMission($title,$img_url,$content,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE about SET title = ?, img_url = ?, content = ?  WHERE id = 1";
        $data = [$title,$img_url,$content];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getAllColoumnMission()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from about Where id = 1 ";
        $result["data"]=$this->get($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;

    }


}

class Vision extends Crud
{
    function updateVision($title,$img_url,$content,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE about SET title = ?, img_url = ?, content = ?  WHERE id = 2";
        $data = [$title,$img_url,$content];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getAllColoumnVision()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from about Where id = 2 ";
        $result["data"]=$this->get($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }


}

class Gallery extends Crud
{
    function createGallery($img_url,$title,$content,$type,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO gallery (img_url,title,content,type) VALUES (?,?,?,?)";
        $data=[$img_url,$title,$content,$type];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        
        return $result;
    }
    
    function deleteGallery($gallery_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM gallery WHERE id = '$gallery_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function updateGallery($gallery_id,$img_url,$title, $content, $type,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE gallery SET img_url = ?, title = ?, content= ?, type = ?  WHERE id = '$gallery_id'";
        $data = [$img_url,$title, $content, $type];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByIdGallery($gallery_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from gallery WHERE id='$gallery_id' ";
        $result["data"]=$this->get($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }

    function getAllGallery()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from gallery ";
        $result["data"]=$this->getall($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }

}


class OurProject extends Crud
{
    function createOurProject($project_name, $content,	$title,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO our_projects (project_name, content, title) VALUES (?,?,?)";
        $data=[$project_name, $content,	$title];
        $query["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $query;

    }

    function updateOurProject($project_id,$project_name, $content,	$title,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE our_projects SET project_name = ?, content = ?, title = ?  WHERE id = '$project_id'";
        $data = [$project_name, $content,	$title];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteOurProject($project_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM our_projects WHERE id = '$project_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByIdOurProject($project_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from our_projects WHERE id='$project_id' ";
        $result["data"]=$this->get($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
    return $result;
    }

    function getAllOurProjects()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "Select * from our_projects";

        $result["data"]=$this->getAll($sql);

	    foreach ($result["data"] as $key => $value) {
		if($key != 0)
		{
		    $project_id.=",";
		}

		    $project_id.=$value->id;
        }


   	    $sql_images = "Select * from our_projects_images WHERE project_id IN (".$project_id.") ";
        $result["project_images"]=$this->getAll($sql_images);
        
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        return $result;
    }
    
        
    function getByNumberOurProjects($number)
    {
        
        
        $sql = "Select * from our_projects
        ORDER BY id DESC LIMIT $number
        ";

        $result["data"]=$this->getAll($sql);

	    foreach ($result["data"] as $key => $value) {
		if($key != 0)
		{
		    $project_id.=",";
		}

		    $project_id.=$value->id;
        }


   	    $sql_images = "Select * from our_projects_images WHERE project_id IN (".$project_id.") ";
        $result["project_images"]=$this->getAll($sql_images);


        return $result;
    }

}

class OurProjectImage extends Crud
{
    function createOurProjectImage($project_id,$img_url,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO our_projects_images (img_url, project_id) VALUES (?,?)";
        $data=[$img_url, $project_id];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteOurProjectImage($image_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM our_projects_images WHERE id = '$image_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function deleteForOurProjectImage($projectId,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM our_projects_images WHERE  project_id= '$projectId'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getForOurProjectImage($projectId)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from our_projects_images Where project_id = '$projectId'";
        $result["data"]=$this->getAll($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/

        return $result;
    }

    function getByIdOurProjectImage($image_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from our_projects_images Where id = '$image_id'";
        $result["data"]=$this->get($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/

        return $result;
    }

    function getAllOurProjectImage()
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from our_projects_images ";
        $result["data"]=$this->getAll($sql);
       /* }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/
        
        return $result;
    }


}


class Category extends Crud
{
    function createCategory($category_name,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO categories (category_name) VALUES (?)";
        $data=[$category_name];
        $result["result"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
        
    }
    
    function updateCategory($category_id,$category_name,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "UPDATE categories SET category_name = ? WHERE category_id = '$category_id'";
        $data = [$category_name];

        $result["data"] = $this->insertAndUpdate($sql,$data);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }
    
    function getCategory($category_id)
    {/*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from categories Where category_id = '$category_id'";
        $result["data"]=$this->getAll($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/

        return $result;
    }
    
    function getAllCategories()
    {
    /*
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){*/
        $sql = "SELECT * from categories";
        $result["data"]=$this->getAll($sql);
        /*}
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }*/

        return $result;
    }
    
    function deleteCategory($category_id,$user_id,$admin_id,$user_token,$admin_token)
    {
        $result["result"]=false;
    
        $result["result"]= $this->checkAccessForUser($user_id,$admin_id,$user_token,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM categories WHERE  category_id= '$category_id'";
        $result["data"] = $this->delete($sql);
        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }
}

class Count extends Crud
{
    function getAllTablesCount()
    {
        $sql = "Select count(*) as count from categories";
        $result["categories"] = $this->get($sql);
        
        $sql = "Select count(*) as count from company_references";
        $result["company_references"] = $this->get($sql);
        
        $sql = "Select count(*) as count from gallery";
        $result["gallery"] = $this->get($sql);
        
        $sql = "Select count(*) as count from news";
        $result["news"] = $this->get($sql);
        
        $sql = "Select count(*) as count from notices";
        $result["notices"] = $this->get($sql);
        
        $sql = "Select count(*) as count from our_projects";
        $result["our_projects"] = $this->get($sql);
        
        $sql = "Select count(*) as count from our_projects_images";
        $result["our_projects_images"] = $this->get($sql);
        
        $sql = "Select count(*) as count from products";
        $result["products"] = $this->get($sql);
        
        $sql = "Select count(*) as count from product_images";
        $result["product_images"] = $this->get($sql);
        
        $sql = "Select count(*) as count from slider";
        $result["slider"] = $this->get($sql);
        
        
        $sql = "Select count(*) as count from team";
        $result["team"] = $this->get($sql);
        
        $sql = "Select count(*) as count from users";
        $result["users"] = $this->get($sql);
        
        return $result;
    }
    
}



