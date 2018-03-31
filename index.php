<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 11:01
 */

session_start();
function getJsonData($status, $msg, $data)
{
    $postData = array(
        "data" => $data,
        "msg" => $msg,
        "status" => $status
    );
    return json_encode($postData);
}

$arr = array(
    "role_name" => $_SESSION[$_POST['token']],
    "token" => $_POST['token'],
);

echo "<pre>" . json_encode($arr) . "</pre>";