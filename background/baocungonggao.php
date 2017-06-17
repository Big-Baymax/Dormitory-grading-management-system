<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/8
 * Time: 10:07
 */
require_once 'database_inc.php';

session_start();
$title = $_POST['title'];
$content = $_POST['content'];
$state = $_POST['state'];
$user = $_SESSION['user'];
//$user = 'test';
if($database->insert('notice', ['title' => $title, 'content' => $content, 'state' => $state, 'name' => $user])){
    echo 1;
}
else{
    echo 0;
}