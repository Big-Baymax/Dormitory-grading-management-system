<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/12
 * Time: 19:13
 */
require_once 'database_inc.php';
//删除

if(empty($_GET['table']) || empty($_GET['id'])){
    echo '请将信息填写完整';
    return false;
}
$table = $_GET['table'];
$id = $_GET['id'];
if($database->delete($table, ['id' => $id])){
    echo 1;
}
else{
    echo '删除失败';
}