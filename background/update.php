<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/12
 * Time: 20:11
 */
require_once 'database_inc.php';
session_start();

if(empty($_GET['table']) || empty($_GET['id'])){
    $arr['result'] = 0;
    $arr['mes'] = '参数错误';
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    return false;
}

$table = $_GET['table'];
$id = $_GET['id'];
$s = array();
switch ($table){
    case 'grade':
        $s = ['points' => $_GET['points'], 'weekly' => $_GET['weekly']];
        break;
    case 'message':
        $s = ['answer' => $_GET['answer']];
        break;
    case 'users':
        if(!empty($_GET['no'])){
            if(!empty($_GET['username'])){
                $s['username'] = $_GET['username'];
            }
            if(!empty($_GET['class'])){
                $s['class'] = $_GET['class'];
            }
            if(!empty($_GET['dates'])){
                $s['dates'] = $_GET['dates'];
            }
            if(!empty($_GET['sex'])){
                $s['sex'] = $_GET['sex'];
            }
            if(!empty($_GET['phone'])){
                $s['phone'] = $_GET['phone'];
            }
            if(!empty($_GET['dormitory'])){
                $s['dormitory'] = $_GET['dormitory'];
            }
            if(!empty($_GET['instructor'])){
                $s['instructor'] = $_GET['instructor'];
            }
            if(!empty($_GET['power'])){
                $s['power'] = $_GET['power'];
                if($_GET['power'] >= 1 ){
                    if($_SESSION['power'] < 3 ){
                        $arr['result'] = 0;
                        $arr['mes'] = '你不是最高管理员';
                        echo json_encode($arr,JSON_UNESCAPED_UNICODE);
                        exit();
                    }
                }
            }
        }
        else {
            $s = ['password' => 123456];
        }
        break;
    case 'repair':
        $repair_time = date("Y-m-d");
        $s = ['yon' => 1, 'repair_time' => $repair_time];
        break;
    default:
        break;
}

if($database->update($table, $s, ['id' => $id])){
    $arr['result'] = 1;
}
else{
    $arr['result'] = 0;
    $arr['mes'] = '操作失败';
}
//print_r($s);
echo json_encode($arr,JSON_UNESCAPED_UNICODE);