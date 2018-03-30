<?php
header('Content-Type:application/json;Charset=utf-8');
// header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Origin: http://localhost:8000');
//$arr = array(
//    "login_name" => $_POST['login_name'],
//    "login_pwd" => $_POST['login_pwd'],
//);
$final = file_get_contents('php://input');

echo $final;
//echo json_encode($final);
// echo $_GET['jsoncallback'] . "(".json_encode($arr).")";
