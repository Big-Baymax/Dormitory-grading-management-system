<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/3/19
 * Time: 19:59
 */
require_once 'smarty_inc.php';
require_once 'background/Pages.class.php';

session_start();
if(isset($_SESSION['power'])){
    if($_SESSION['power'] >= 1){
        header('location:manage_admin.php');
    }
    if($_SESSION['power'] == 0){
        header('location:manage_user.php');
    }
}
if(!empty($_GET['page'])){
    $page = $_GET['page'];
}
else{
    $page = 1;
}
//公告
$p1 = new Pages('notice', '*', ['state' => 0,'ORDER' => ['create_time' => 'DESC'], 'LIMIT' =>[0,8]]);
$notice = $p1->select();
$smarty->assign('notice',$notice);

//宿舍分数排名
$p2 = new Pages('grade', '*', ['ORDER' => ['weekly' => 'DESC', 'points'], 'LIMIT' => [($page-1)*15,15]]);
$grade = $p2->select();
$count = $p2->count('*');
if($page > $count){
    header('location:?page='.$count.'');
}
$pages = $p2->pages($page);
$upPage = $p2->upPage();
$t = ($page-1)*15+1;
for($i = 0; $i < count($grade); $i++){
    $grade[$i]['top'] = $t+$i;
    $grade[$i]['num'] = 100-$grade[$i]['points'];
}
$smarty->assign('page',$page);
$smarty->assign('grade',$grade);
$smarty->assign('pages',$pages);
$smarty->assign('count',$count);
$smarty->assign('upPage',$upPage);

//最新维修情况
$p3 = new Pages('repair', '*', ['ORDER' => ['create_time' => 'DESC'], 'LIMIT' => [0,9]]);
$repair1 = $p3->select();
$p4 = new Pages('repair', '*', ['ORDER' => ['create_time' => 'DESC'], 'LIMIT' => [9,9]]);
$repair2 = $p4->select();
$p5 = new Pages('repair', '*', ['ORDER' => ['create_time' => 'DESC'], 'LIMIT' => [18,9]]);
$repair3 = $p5->select();
$smarty->assign('repair1',$repair1);
$smarty->assign('repair2',$repair2);
$smarty->assign('repair3',$repair3);
$smarty->display('index.html');