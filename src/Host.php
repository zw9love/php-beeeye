<?php
/**
 * Created by PhpStorm.
 * User: zw9love
 * Date: 2018/3/31
 * Time: 13:59
 */

header('Content-Type:application/json;Charset=utf-8');
// header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Origin: http://localhost:8000');
//$arr = array(
//    "login_name" => $_POST['login_name'],
//    "login_pwd" => $_POST['login_pwd'],
//);

//echo json_encode($final);
// echo $_GET['jsoncallback'] . "(".json_encode($arr).")";
require("./Login.php");
$query = $_SERVER['QUERY_STRING'];
switch ($query) {
    case "get":
        get();
        break;
    case "post":
        post();
        break;
}

function get()
{
    $final = file_get_contents('php://input');
    $data = json_decode($final, true);
    $page = $data["page"];
    try {
//        echo md5($data["login_pwd"]);
        $servername = "localhost";
        $username = "root";
        $password = "159357";
        $pdo = new PDO("mysql:host=$servername;dbname=beeeyehced", $username, $password);
        //查询
        $sql = "";
        $pageNumber = 0;
        $pageSize = 30;
        if (count($page) > 0) {
            $pageNumber = $page['pageNumber'] - 1;
            $pageSize = $page["pageSize"];
        }
        $sql = "select * from beeeye_host limit $pageNumber, $pageSize";
        $countSql = "select count(*) as total from beeeye_host";
        $stmt = $pdo->prepare($sql);
        $stmtCount = $pdo->prepare($countSql);
//        $stmt->bindValue(1, $page["pageNumber"] - 1);
//        $stmt->bindValue(2, $page["pageSize"]);
        $stmt->execute();
        $stmtCount->execute();
//        $res = $stmt->fetch();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = array();
        $total = (int)($stmtCount->fetch(PDO::FETCH_ASSOC)["total"]);
        $i = 0;
        foreach ($res as $row) {
            $i++;
            array_push($list, $row);
//            echo $row['username'] . '<br/>';
        }
        $postData = array(
            "pageNumber" => $pageNumber,
            "pageSize" => $pageSize,
            "list" => $list,
            "totalRow" => $total
        );
        $pdo = null;
        echo getJsonData(200, "成功", $postData);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function post()
{

}

