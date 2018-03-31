<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 11:01
 */

session_start();
$arr = array(
    "role_name" => $_SESSION[$_POST['token']],
    "token" => $_POST['token'],
);
echo "<pre>" . json_encode($arr) . "</pre>";