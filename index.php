<?php
/**
 * Created by PhpStorm.
 * User: zw9love
 * Date: 2018/3/29
 * Time: 11:01
 */
//var_dump($_SERVER);


// header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Origin: http://localhost:9090');
session_start();
define('APPPATH', trim(__DIR__ . '/'));
if ($_SERVER["REQUEST_URI"] == $_SERVER["SCRIPT_NAME"]) {
    header('Content-Type:text/html;Charset=utf-8');
    require("index.html");
} else {
    header('Content-Type:application/json;Charset=utf-8');
    $path = explode("/", $_SERVER['PATH_INFO']);
    $controllerName = $path[1];
    $functionName = $path[2];
    $params = null;
    if (count($path) > 3) {
        if (!($path[3] == ''))
            $params = $path[3];
    }
    $upperControllerName = ucfirst($controllerName);
    require(APPPATH . "src/controller/" . $upperControllerName . "Controller.php");
    $className = $upperControllerName . "Controller";
    $obj = new $className();
    if (is_null($params)) {
        $obj->$functionName(null);
    } else {
        $obj->$functionName($params);
    }
}

//echo md5("6350238"); //80956299e1d4c26fce49101852134a4a
