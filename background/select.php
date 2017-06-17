<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/12
 * Time: 20:24
 */
require_once 'database_inc.php';

//header('Content-Type: application/json');
$arr = array();
if(empty($_GET['table']) || empty($_GET['id'])){
    $arr['result'] = 0;
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    return false;
}
$table = $_GET['table'];
$id = $_GET['id'];
$r = $database->select($table, '*', ['id' => $id]);
if(!empty($r)){
    $arr['result'] = 1;
    switch ($table){
        case 'notice':
            foreach ($r as $value){
                $arr['title'] = $value['title'];
                $arr['content'] = $value['content'];
            }
            break;
        case 'grade':
            foreach ($r as $value){
                $arr['dormitory'] = $value['dormitory'];
                $arr['points'] = $value['points'];
                $arr['weekly'] = $value['weekly'];
            }
            break;
        case 'message':
            foreach ($r as $value){
                $arr['content'] = $value['content'];
                $arr['title'] = $value['title'];
            }
            break;
        default:
            break;
    }
}
else{
    $arr['result'] = 0;
}

echo json_encode($arr,JSON_UNESCAPED_UNICODE);