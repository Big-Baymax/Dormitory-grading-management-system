<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/4/15
 * Time: 20:53
 */
require_once 'libs/Smarty.class.php';

session_start();
$smarty = new Smarty();
if(!empty($_SESSION['user'])) {
    $smarty->assign('user', $_SESSION['user']);
}
$smarty->display('about.html');