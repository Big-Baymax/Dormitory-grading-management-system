<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/3/20
 * Time: 12:18
 */
require_once 'background/ds_inc.php';

session_start();
//判断信息是否填写完整
if(!empty($_POST['username']) && !empty($_POST['no']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['phone']) && !empty($_POST['CAPTCHA'])){
    //验证码是否正确
    if(!empty($_SESSION['CAPTCHA']) && strcasecmp($_POST['CAPTCHA'],$_SESSION['CAPTCHA'])==0){
        $username = $_POST['username'];
        $no = $_POST['no'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $phone = $_POST['phone'];
        //两次输入的密码是否一致
        if($password == $password2){
            //判断用户是否存在
            $s = $database->select('users', 'username', [ 'no' => $no]);
            if(!empty($s)){
                echo '<script>alert("学号/教师号已存在");window.location.href="register.php";</script>';
                //header('location:register.php');
                return false;
            }
            //插入数据库，判断是否插入成功
            if($database->insert('users',['username' => $username,
            'no' => $no,
            'password' => $password,
            'phone' => $phone])){
                echo '<script>alert("注册成功");window.location.href="login.php";</script>';
                //header('location:login.php');
            }
            else{
                echo '<script>alert("注册失败");</script>';
            }
        }
        else{
            echo '<script>alert("两次密码必须输入一致");</script>';
        }
    }
    else{
        echo '<script>alert("验证码错误");</script>';
    }
}
$smarty->display('register.html');