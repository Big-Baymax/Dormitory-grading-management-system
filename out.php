<?php
/**
 * Created by PhpStorm.
 * User: 10367
 * Date: 2017/3/20
 * Time: 22:09
 */
session_start();
session_destroy();
header('location:index.php');