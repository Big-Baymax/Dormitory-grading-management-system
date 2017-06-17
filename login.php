<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/3/20
 * Time: 11:01
 */
require_once 'background/ds_inc.php';

session_start();
if(!empty($_POST['no']) && !empty($_POST['password']) && !empty($_POST['CAPTCHA'])) {
    if (!empty($_SESSION['CAPTCHA'] && strcasecmp($_POST['CAPTCHA'],$_SESSION['CAPTCHA'])==0)) {
        $no = $_POST['no'];
        $password = $_POST['password'];
        $r = $database->select('users', '*', ['AND' =>['no' => $no, 'password' => $password]]);
        if(!empty($r)){
            switch ($r[0]['power']){
                case 0;
                    header('location:manage_user.php');
                    break;
                default:
                    header('location:manage_admin.php');
            }
            $_SESSION['id'] = $r[0]['id'];
            $_SESSION['user'] = $r[0]['username'];
            $_SESSION['power'] = $r[0]['power'];
        }
        else{
            echo '<script>alert("账号、密码错误");</script>';
        }
    } else {
        echo '<script>alert("验证码错误");</script>';
    }
}
$smarty->display('login.html');