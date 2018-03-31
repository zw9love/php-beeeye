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
require("../service/Host.php");
$query = $_SERVER['QUERY_STRING'];
$host = new Host();
switch ($query) {
    case "get":
        $host->get();
        break;
    case "post":
        $host->post();
        break;
    case "put":
        $host->put();
        break;
    case "delete":
        $host->delete();
        break;
}


