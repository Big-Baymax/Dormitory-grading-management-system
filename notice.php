<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/10
 * Time: 16:15
 */
require_once 'returntable.php';

session_start();
if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $s = ['id' => $id];
    $t = new returntable('notice', '*', $s, 1);
    $arr = $t->getArr();
    //print_r($arr);
    if(!empty($_SESSION['user'])) {
        $smarty->assign('user', $_SESSION['user']);
    }
    $smarty->assign('arr', $arr);
    $smarty->display('notice.html');
}
else{
    header('location:index.php');
}