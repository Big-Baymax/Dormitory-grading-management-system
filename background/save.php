<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/4/11
 * Time: 15:39
 */
require_once 'database_inc.php';
session_start();
date_default_timezone_set('PRC');
//获取用户名
$user = $_SESSION['user'];
//$user = 'test';
$create_time = date("Y-m-d");

//保存报修记录
if(empty($_GET['id'])){
    $phone = $_POST['phone'];
    $content = $_POST['content'];
    if($d = a($_POST['dormitory3'])){
        $dormitory = $_POST['dormitory1'].$_POST['dormitory2'].$d;
        if($database->insert('repair', ['dormitory' => $dormitory, 'content' => $content, 'phone' => $phone, 'create_time' => $create_time])){
            echo 1;
        }
        else{
            echo '提交失败';
        }
    }
    else{
        echo '宿舍号填写错误';
    }
}
//print_r($_POST);


else {

    //保存留言
    if ($_GET['id'] == 2) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $phone = $_POST['phone'];
        if ($database->insert('message', ['username' => $user, 'phone' => $phone, 'title' => $title, 'content' => $content, 'create_time' => $create_time])) {
            echo 1;
        } else {
            echo '提交失败';
        }
    }


    //保存公告
    //id=3保存公告,id=4保存草稿
    if($_GET['id'] == 3){
        $state = 0;
    }
    if($_GET['id'] == 4){
        $state = 1;
    }
    if(isset($state)) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $r = $database->select('notice', 'id', ['title' => $title]);
        if(!empty($r)){
            if($database->update('notice', ['title' => $title, 'content' => $content, 'state' => $state], ['id' => $r[0]])){
                echo 1;
                exit();
            }
            else{
                echo '修改失败';
                exit();
            }
        }
        else {
            if ($database->insert('notice', ['title' => $title, 'content' => $content, 'name' => $user, 'state' => $state])) {
                echo 1;
            } else {
                echo '提交失败';
            }
        }
    }

}

function a($str){
    return preg_match('/([0-9]{3})/',$str,$a) ? $a[0]: 0;
}