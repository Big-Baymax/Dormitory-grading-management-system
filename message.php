<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/10
 * Time: 16:34
 */
require_once 'returntable.php';

session_start();
//留言区
$s = ['ORDER' => ['create_time' => 'DESC'], 'LIMIT' => [0,20]];
$c = '*';
$t = new returntable('message', $c, $s, 1);
$arr = $t->getArr();
for($i = 0; $i < count($arr); $i++){
    $r = rand(1,3);
    switch ($r){
        case 1:
            $arr[$i]['class'] = 'panel panel-info';
            break;
        case 2:
            $arr[$i]['class'] = 'panel panel-success';
            break;
        default:
            $arr[$i]['class'] = 'panel panel-warning';
    }
}

//公告区
$s = ['ORDER' => ['create_time' => 'DESC'], 'LIMIT' => [1,4]];
$c = '*';
$t2 = new returntable('notice', $c, $s, 1);
$arr2 = $t2->getArr();

if(!empty($_SESSION['user'])) {
    $smarty->assign('user', $_SESSION['user']);
}
$smarty->assign('arr2', $arr2);
$smarty->assign('arr', $arr);
$smarty->display('message.html');
