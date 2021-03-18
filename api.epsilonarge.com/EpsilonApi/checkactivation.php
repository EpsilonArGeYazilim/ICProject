<?php

include "../class.php";

$email = $_GET['email'];
$activation_code = $_GET['activation_code'];

$sql = "Select * from activation WHERE email='$email' AND activation_code = '$activation_code' ";
$result = $this->get($sql);
$return = false;
if ($result) {
    $return = true;
    $sql = "DELETE FROM activation WHERE email = '$email'";
    $return["result"] = $this->delete($sql);
}

echo json_encode($return);

