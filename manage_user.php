<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/10
 * Time: 17:25
 */
require_once 'returntable.php';
session_start();

if(!isset($_SESSION['power']) || $_SESSION['power'] != 0){
    header('location:index.php');
    return false;
}

$id = $_SESSION['id'];
$t = new returntable('users', '*', ['id' => $id], 1);
$user = $t->getArr();
$smarty->assign('info', $user);
$active = 0;
//评分管理
if(!empty($_GET['page3'])){
    $page3 = $_GET['page3'];
}
else{
    $page3 = 1;
}
$s3 = ['ORDER' => ['points'], 'LIMIT' => [($page3-1)*15,15]];
$c3 = array();
$h3 = 'location:?active=3';
if(!empty($_GET['week'])){
    $s3['AND']['weekly'] = $_GET['week'];
    $c3['AND']['weekly'] = $_GET['week'];
    $smarty->assign('week',$_GET['week']);
    $h3.= '&week='.$_GET['week'];
    $active = 3;
}
if(!empty($_GET['department'])){
    $s3['AND']['department'] = $_GET['department'];
    $c3['AND']['department'] = $_GET['department'];
    $smarty->assign('department', $_GET['department']);
    $h3.= '&department='.$_GET['department'];
    $active = 3;
}
if(!empty($_GET['year'])){
    $s3['AND']['year'] = $_GET['year'];
    $c3['AND']['year'] = $_GET['year'];
    $smarty->assign('year', $_GET['year']);
    $h3.= '&year='.$_GET['year'];
    $active = 3;
}
if(!empty($_GET['sex'])){
    $s3['AND']['sex'] = $_GET['sex'];
    $c3['AND']['sex'] = $_GET['sex'];
    $smarty->assign('sex', $_GET['sex']);
    $h3.= '&sex='.$_GET['sex'];
    $active = 3;
}
if(!empty($_GET['sort'])){
    if($_GET['sort'] == 2){
        $s3['ORDER'] = ['weekly' => 'DESC'];
        $smarty->assign('sort', $_GET['sort']);
        $h3.= '&sort='.$_GET['sort'];
    }
    $active = 3;
}
if(!empty($_GET['search3'])){
    $search3 = $_GET['search3'];
    $s3['AND']['OR'] = ['weekly[~]' => $search3, 'dormitory[~]' => $search3, 'year[~]' => $search3, 'department[~]' => $search3, 'sex[~]' => $search3, 'points[~]' => $search3];
    $c3['AND']['OR'] = ['weekly[~]' => $search3, 'dormitory[~]' => $search3, 'year[~]' => $search3, 'department[~]' => $search3, 'sex[~]' => $search3, 'points[~]' => $search3];
    $active = 3;
    $h3.= '$search3='.$search3;
    $smarty->assign('search3',$search3);
}
$s3['AND']['id[!]'] = 0;
$c3['AND']['id[!]'] = 0;
$_SESSION['s3'] = $s3;
$p3 = new Pages('grade','*',$s3);
$count3 = $p3->count($c3);
$grade = $p3->select();
if($page3 > $count3){
    if ($count3 == 0) {
        echo '<script>alert("搜索为空")</script>';
        header("refresh:1;url=?active=3");
    } else {

        $h3.= '&page3='.$count3;
        if (!empty($search3)) {
            $h3 .= '&search3=' . $search3;
        }
        header($h3);
    }
    //header('location:?page3='.$count3.'&active=3');
}
$pages3 = $p3->pages($page3);
$upPage3 = $p3->upPage();
$t3 = ($page3-1)*15+1;
for($i = 0; $i < count($grade); $i++){
    $grade[$i]['top'] = $t3+$i;
    $grade[$i]['num'] = 100-$grade[$i]['points'];
}
$smarty->assign('grade',$grade);
$smarty->assign('pages3',$pages3);
$smarty->assign('upPage3',$upPage3);
$smarty->assign('page3',$page3);
$smarty->assign('active',$active);

$smarty->assign('user', $_SESSION['user']);
$smarty->display('manage_user.html');