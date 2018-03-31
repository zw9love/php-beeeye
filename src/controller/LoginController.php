<?php
/**
 * Created by PhpStorm.
 * User: zw9love
 * Date: 2018/3/29
 * Time: 10:01
 */
require("../util/Tool.php");
require("../service/Login.php");
header('Content-Type:application/json;Charset=utf-8');
session_start();
$login = new Login();
$query = $_SERVER['QUERY_STRING'];
switch ($query) {
    // 登录接口
    case "dologin":
        $login->dologin();
        break;
    case "loged":
        $login->loged();
        break;
}

