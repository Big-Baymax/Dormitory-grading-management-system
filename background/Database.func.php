<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/2/25
 * Time: 15:51
 */
require_once 'libs/medoo.php';

function Database()
{
    $database = new medoo([
        // 必须配置项
        'database_type' => 'mysql',
        'database_name' => 'dormitory',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8']);
    return $database;
}
