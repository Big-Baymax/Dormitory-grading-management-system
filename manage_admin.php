<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/3/20
 * Time: 16:47
 */
require_once 'smarty_inc.php';
require_once 'background/Pages.class.php';

session_start();
if(empty($_SESSION['power']) || $_SESSION['power'] < 1){
    header('location:index.php');
    return false;
}

if(!empty($_GET['active'])){
    $active = $_GET['active'];
}
else{
    $active = 1;
}

//公告区
if(!empty($_GET['page1'])){
    $page1 = $_GET['page1'];
}
else{
    $page1 = 1;
}
$s1 = [ 'ORDER' => ['create_time' => 'DESC'], 'LIMIT' =>[($page1-1)*15,15]];
$c1 = '*';
if(!empty($_GET['search1'])){
    $search1 = $_GET['search1'];
    $smarty->assign('search1',$search1);
    $s1['OR'] = ['title[~]' => $search1, 'name[~]' => $search1];
    $c1 = ['OR' => ['title[~]' => $search1, 'name[~]' => $search1]];
}
$p1 = new Pages('notice', '*', $s1);
$count1 = $p1->count($c1);
$notice = $p1->select();
if($page1 > $count1){
    if(!empty($search1)){
        header('location:?page1='.$count1.'&search1='.$search1.'');
    }
    else{
        header('location:?page1='.$count1.'');
    }
}
$pages1 = $p1->pages($page1);
$upPage1 = $p1->upPage();
$t1 = ($page1-1)*15+1;
for($i = 0; $i < count($notice); $i++){
    $notice[$i]['top'] = $t1+$i;
}
$smarty->assign('notice',$notice);
$smarty->assign('pages1',$pages1);
$smarty->assign('upPage1',$upPage1);
$smarty->assign('page1',$page1);

//报修处理
if(!empty($_GET['page2'])){
    $page2 = $_GET['page2'];
}
else{
    $page2 = 1;
}
$s2 = ['ORDER' => ['create_time' => 'DESC'], 'LIMIT' =>[($page2-1)*15,15]];
$c2 = array();
if(!empty($_GET['need'])){
    $smarty->assign('need',$_GET['need']);
    if(!empty($_GET['search2'])){
        $search2 = $_GET['search2'];
        $smarty->assign('search2', $search2);
        echo 1;
        $s2['AND'] = ['yon' => 0];
        $c2['AND'] = ['yon' => 0];
        $s2['AND']['OR'] = ['dormitory[~]' => $search2, 'phone[~]' => $search2, 'content[~]' => $search2];
        $c2['AND']['OR'] = ['dormitory[~]' => $search2, 'phone[~]' => $search2, 'content[~]' => $search2];
    }
    else {
        $s2['yon'] = 0;
        $c2['yon'] = 0;
    }
    $active = 2;
}
else{
    if(!empty($_GET['search2'])) {
        $active = 2;
        $search2 = $_GET['search2'];
        $smarty->assign('search2', $search2);
        $s2['OR'] = ['dormitory[~]' => $search2, 'phone[~]' => $search2, 'content[~]' => $search2];
        $c2['OR'] = ['dormitory[~]' => $search2, 'phone[~]' => $search2, 'content[~]' => $search2];
    }
}
//print_r($s2);
$p2 = new Pages('repair', '*', $s2);
$count2 = $p2->count($c2);
$repair = $p2->select();
if($page2 > $count2) {
    if ($count2 == 0) {
        echo '<script>alert("搜索为空")</script>';
        header("refresh:1;url=?active=2");
    } else {

        $h = 'location:?page2=' . $count2 . '&active=2';
        if (!empty($_GET['need'])) {
            $h .= '&need=' . $_GET['need'];
        }
        if (!empty($search2)) {
            $h .= '&search2=' . $search2;
        }
        header($h);
    }
}
$pages2 = $p2->pages($page2);
$upPage2 = $p2->upPage();
$t2 = ($page2-1)*15+1;
for($i = 0; $i < count($repair); $i++){
    $repair[$i]['top'] = $t2+$i;
}
$smarty->assign('repair',$repair);
$smarty->assign('pages2',$pages2);
$smarty->assign('upPage2',$upPage2);
$smarty->assign('page2',$page2);

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

//查看留言
if(!empty($_GET['page4'])){
    $page4 = $_GET['page4'];
}
else{
    $page4 = 1;
}
$s4 = ['ORDER' => ['create_time' => 'DESC'], 'LIMIT' => [($page4-1)*15,15]];
$c4 = array();
if(!empty($_GET['need4'])){
    $need4 = $_GET['need4'];
    $smarty->assign('need4',$need4);
    $active = 4;
    $s4['AND'] = ['answer' => ''];
    $c4['AND'] = ['answer' => ''];
}
if(!empty($_GET['search4'])){
    $active = 4;
    $search4 = $_GET['search4'];
    $smarty->assign('search4',$search4);
    $s4['AND']['OR'] = ['username[~]' => $search4, 'phone[~]' => $search4, 'title[~]' => $search4];
    $c4['AND']['OR'] = ['username[~]' => $search4, 'phone[~]' => $search4, 'title[~]' => $search4];
}
$s4['AND']['id[!]'] = 0;
$c4['AND']['id[!]'] = 0;
$p4 = new Pages('message','*',$s4);
$count4 = $p4->count($c4);
$message = $p4->select();
if($page4 > $count4){
    if($count4 == 0){
        echo '<script>alert("搜索为空")</script>';
        header('refresh:1;url=?page4='.$count4.'&active=4');
    }
    else {
        $h = 'location:?page4=' . $count4 . '&active=4';
        if(!empty($need4)){
            $h.= '&need4='.$need4;
        }
        if(!empty($search4)){
            $h.= '&search4='.$search4;
        }
        header($h);
    }
}
$pages4 = $p4->pages($page4);
$upPage4 = $p4->upPage();
$t4 = ($page4-1)*15+1;
for($i = 0; $i < count($message); $i++){
    $message[$i]['top'] = $t4+$i;
}
$smarty->assign('message',$message);
$smarty->assign('pages4',$pages4);
$smarty->assign('upPage4',$upPage4);
$smarty->assign('page4',$page4);

//用户管理
if(!empty($_GET['page5'])){
    $page5 = $_GET['page5'];
}
else{
    $page5 = 1;
}
$s5 = [ 'LIMIT' => [($page5-1)*15,15]];
$c5 = array();
if(!empty($_GET['need5'])){
    $need5 = $_GET['need5'];
    $smarty->assign('need5',$need5);
    $active = 5;
    $s5['AND'] = ['power[>=]' => 1];
    $c5['AND'] = ['power[>=]' => 1];
}
if(!empty($_GET['search5'])){
    $active = 5;
    $search5 = $_GET['search5'];
    $smarty->assign('search5',$search5);
    $s5['AND']['OR'] = ['no[~]' => $search5, 'username[~]' => $search5, 'sex[~]' => $search5, 'class[~]' => $search5, 'dormitory[~]' => $search5, 'instructor[~]' => $search5, 'phone[~]' => $search5];
    $c5['AND']['OR'] = ['no[~]' => $search5, 'username[~]' => $search5, 'sex[~]' => $search5, 'class[~]' => $search5, 'dormitory[~]' => $search5, 'instructor[~]' => $search5, 'phone[~]' => $search5];
}
$s5['AND']['id[!]'] = 0;
$c5['AND']['id[!]'] = 0;
$p5 = new Pages('users','*',$s5);
$count5 = $p5->count($c5);
$users = $p5->select();
if($page5 > $count5){
    if($count5 == 0){
        echo '<script>alert("搜索为空")</script>';
        header('refresh:1;url=?active=5');
    }
    else {
        $h = 'location:?page5=' . $count5 . '&active=5';
        if (!empty($need5)) {
            $h .= '&need5=' . $need5;
        }
        if (!empty($search5)) {
            $h .= '&search5=' . $search5;
        }
        header($h);
    }
    //header('location:?page5='.$count5.'&active=5');
}
$t5 = ($page5-1)*15+1;
for($i = 0; $i < count($users); $i++){
    $users[$i]['top'] = $t5+$i;
}
$pages5 = $p5->pages($page5);
$upPage5 = $p5->upPage();
$smarty->assign('users',$users);
$smarty->assign('pages5',$pages5);
$smarty->assign('upPage5',$upPage5);
$smarty->assign('page5',$page5);

$smarty->assign('active',$active);
$smarty->assign('user',$_SESSION['user']);
$smarty->display('manage_admin.html');