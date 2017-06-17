<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/6
 * Time: 21:12
 */
require_once '../libs/medoo.php';

$database = new medoo([
    // 必须配置项
    'database_type' => 'mysql',
    'database_name' => 'dormitory',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8']);