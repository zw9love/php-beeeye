<?php
/**
 * Created by PhpStorm.
 * User: zw9love
 * Date: 2018/3/29
 * Time: 10:01
 */
header('Content-Type:application/json;Charset=utf-8');
//$data = array(
//    "name" => $obj["login_name"],
//    "password" => $obj["login_pwd"],
//);
//var_dump($_SERVER);
//var_dump($_SERVER['QUERY_STRING']);
//echo getJsonData(200, null, $data);
session_start();
function getRandomString($length = 32)
{
// 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
// 这里提供两种字符获取方式
// 第一种是使用 substr 截取$chars中的任意一位字符；
// 第二种是取字符数组 $chars 的任意元素
// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $password;
}


function getJsonData($status, $msg, $data)
{
    $postData = array(
        "data" => $data,
        "msg" => $msg,
        "status" => $status
    );
    return json_encode($postData);
}

function dologin()
{
    $final = file_get_contents('php://input');
    $data = json_decode($final, true);
    try {
//        echo md5($data["login_pwd"]);
        $servername = "localhost";
        $username = "root";
        $password = "159357";
        $pdo = new PDO("mysql:host=$servername;dbname=beeeyehced", $username, $password);
        //查询
        $sql = "select * from common_user where login_name = ? and login_pwd = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $data["login_name"]);
        $stmt->bindValue(2, md5($data["login_pwd"]));
        $stmt->execute();
        $res = $stmt->fetch();
//        $res = $stmt->fetchAll();
        $row_count = $stmt->rowCount();
        if ($row_count > 0) {
            $token = getRandomString();
            $login_name = $res['login_name'];
            $_SESSION[$token] = $login_name;
            $_SESSION[$login_name] = $token;
//            $postData = $res;
            header("token:" . $token);
            echo getJsonData(200, "成功", null);
        } else {
            echo getJsonData(606, "失败", null);
        }
//        foreach ($res as $row) {
//            echo $row['username'] . '<br/>';
//        }
        $pdo = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

function loged()
{
    $final = file_get_contents('php://input');
    $data = json_decode($final, true);
//    echo $data["token"];
    $login_name = $_SESSION[$data["token"]];
    $postData = array(
        "role_name" => $login_name,
        "token" => $data["token"]
    );
    echo getJsonData(200, "成功", $postData);
}

$query = $_SERVER['QUERY_STRING'];
switch ($query) {
    // 登录接口
    case "dologin":
        dologin();
        break;
    case "loged":
        loged();
        break;
}

