<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/31
 * Time: 21:53
 */
require(__DIR__."/../util/Tool.php");
class LoginController
{
    public $sqlData = null;

    public function __construct()
    {
        $this->sqlData = Tool::getSqlInfo();
    }

//    public $sqlData = Tool::getSqlInfo();

    function dologin()
    {
        $sqlInfo = $this->sqlData;
        $data = Tool::getRequestData();
        try {
//        echo md5($data["login_pwd"]);
            $pdo = new PDO("mysql:host=" . $sqlInfo["serverName"] . ";dbname=beeeyehced", $sqlInfo["username"], $sqlInfo["password"]);

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
                $token = Tool::getRandomString();
                $login_name = $res['login_name'];
                $_SESSION[$token] = $login_name;
                $_SESSION[$login_name] = $token;
//            $postData = $res;
                header("token:" . $token);
                echo Tool::getJsonData(200, "成功", null);
            } else {
                echo Tool::getJsonData(606, "失败", null);
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
        $data = Tool::getRequestData();
        $login_name = $_SESSION[$data["token"]];
        $postData = array(
            "role_name" => $login_name,
            "token" => $data["token"]
        );
        echo Tool::getJsonData(200, "成功", $postData);
    }
}