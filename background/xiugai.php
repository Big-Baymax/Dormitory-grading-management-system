<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/6
 * Time: 21:10
 */
require_once 'database_inc.php';

session_start();
$user = $_SESSION['user'];
$id = $_SESSION['id'];
$oldpw = $_POST['oldpw'];
$newpw = $_POST['newpw'];
if(!empty($_POST['newpw2']) && $newpw != $_POST['newpw2']){
    echo '密码不一致';
    exit();
}
$s = $database->select('users', 'id', ['AND' => ['username' => $user, 'password' => $oldpw]]);
if(!empty($s)) {
    if($database->update('users', ['password' => $newpw], ['id' => $id])){
        echo 1;
    }
    else{
        echo '修改失败';
    }
}
else{
    echo '密码错误';
}

